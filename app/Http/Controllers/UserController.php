<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Channel;
use App\Model\Media;
use App\Model\Advert;
use App\Model\Playlist;
use App\Model\Subscription;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $searchVal;
    public function register(Request $request){
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|confirmed',
            'dob' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => 'viewer',
            'dob' => $validatedData['dob'],
            'gender' => $validatedData['gender'],
            'country' => $validatedData['country'],
            'state' => $validatedData['state'],
        ]);
            
            if($user == null){
                return $this->redirectPage("viewer.register", "Error Registering User");
            }

            $playlist = new Playlist();
            $playlist->title = $user->firstname ."_".$user->lastname;
            $playlist->user_id = $user->id;
            $playlist->medias = json_encode([]);
            $resp = $playlist->save();
            
            if($resp == false){
                return $this->redirectPage("viewer.register", "Error Registering User");
            }

            $subcription = new Subscription();
            $subcription->user_id = $user->id;
            $subcription->isSubscribed = "false";
            $resp = $subcription->save();

            if($resp == false){
                return $this->redirectPage("viewer.register", "Error Registering User");
            }
        
        return redirect('/viewer_login');
    }

    public function login(Request $request){
        
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if(Auth::guard('viewer')->attempt($login)){
            $this->updateSubscription($login['email']);
            return redirect('/viewer/index');
        } else{
            return $this->loginRedirect("Invalid Login Details");
        }

    }

    public function logout(){

        Auth::logout();
        return redirect('/viewer_login');
    }

    public function loginRedirect($err_msg){
        return view('viewer.login',['err_msg' => $err_msg]);
    }

    public function index($videos = null){
        
        $videos = Media::orderBy('created_at', 'desc')->get();
        if($videos == null || count($videos) == 0){
            return view('viewer.index');
        }
        return view('viewer.index', ['videos' => $videos]);
        
    }

    public function viewMedia($id){
        if(!$this->checkSubscription()){
            return redirect('/viewer/payment/'.$id);
        }
        $media = Media::findOrFail($id);
        $vid_tags = explode(",", $media->tags);
        $views = json_decode($media->views);
        //dd($views);
        $user_id = Auth::id();
        if(!in_array($user_id,$views)){
            array_push($views,$user_id);
            $media->views = json_encode($views);
            $media->save();
        }

        $num_views = count($views);

        if($num_views == 0 || $num_views == 1){
            $num_views = $num_views ." view";
        } else{
            $num_views = $num_views ." views";
        }

        $adverts = Advert::orderBy('created_at', 'desc')
                                    ->where("type","image")
                                    ->where("active",1)
                                    ->limit(2)
                                    ->get();
        $upNexts = Media::orderBy('created_at', 'desc')
                    ->where('id','<>',$media->id)
                    ->inRandomOrder()
                    ->limit(6)
                    ->get();       
                            
        return view("viewer.video-page", ['media' => $media, 'vid_tags' => $vid_tags, 'num_views' => $num_views, 'adverts' => $adverts, 'upNexts' => $upNexts]);
    }

    public function searchVideo(Request $request){
        $data = $request->validate([
            'search' => 'required|string',
        ]);
        $this->searchVal = $data['search'];
        $videos = Media::orderBy('created_at', 'desc')
                        ->where(function($query){
                            $query->where("tags",'LIKE', '%'.$this->searchVal.'%')
                            ->orWhere("title",'LIKE', '%'.$this->searchVal.'%')
                            ->orWhere("description",'LIKE', '%'.$this->searchVal.'%');
                        })
                        ->limit(6)
                        ->get();

        
        //dd($videos);
        if(count($videos) > 0){
            return $this->renderSearch($videos);
        }else{
            return $this->renderSearch();
        }
    }

    public function renderSearch($videos = null){
        if(isset($videos)){
            return view('viewer.index', ['videos' => $videos]);
        }else{
            return view('viewer.index');
        }
    }

    public function loadAdPage($id){
        $media = Media::findOrFail($id);
        $video_advert = Advert::where("type","video")
                                ->where("active",1)
                                ->orWhere("tags",'LIKE', '%'.$media->tags.'%')  
                                ->limit(1)
                                ->get();
        $img_adverts = Advert::orderBy('created_at', 'desc')
                        ->where("type","image")
                        ->where("active",1)
                        ->limit(2)
                        ->get();
        $upNexts = Media::orderBy('created_at', 'desc')
                    ->where('id','<>',$media->id)
                    ->inRandomOrder()
                    ->limit(6)
                    ->get();

        if($video_advert == null || count($video_advert) == 0){
            return redirect("/viewer/video/".$id);
        } else if($img_adverts == null || count($img_adverts) == 0){
            //dd($img_adverts);
            return view("viewer.ad-page", ['video_advert' => $video_advert, 'id' => $id, 'upNexts' => $upNexts]);
            
        }else {
            return view("viewer.ad-page", ['video_advert' => $video_advert, 'img_adverts' => $img_adverts, 'id' => $id, 'upNexts' => $upNexts]);
        }
    }

    public function addToPlaylist($id){
        $media = Media::find($id);
        $playlist = Playlist::where('user_id',Auth::id())->first();
        if($media == null || $playlist == null){
            echo json_encode("Error Adding Video");
            exit;
            // return $this->viewMedia($id, "Error Adding Song");
        }
        $medias = json_decode($playlist->medias);
        if(!in_array($media->id,$medias)){
            $media_id = intval($media->id);
            array_push($medias, $media_id);
            $playlist->medias = json_encode($medias);
            $playlist->save();
            echo json_encode("Video Added to Playlist");
            exit;
            // return $this->viewMedia($id, "Song Added to Playlist");
        }
        echo json_encode("Video exists in Playlist");
        exit;
        // return $this->viewMedia($id, "Song Exists in Playlist");

    }

    public function user_playlist(){
        $playlist = Playlist::where('user_id',Auth::id())->firstOrFail();
        $media_ids = json_decode($playlist->medias);
        $medias = array();
        foreach($media_ids as $media_id){
            $media = Media::findOrFail($media_id);
            array_push($medias, $media);
        }

        if($medias == null || count($medias) == 0){
            return $this->redirectPage('viewer.playlist', "No Video Added To Playlist");
        }

        return view('viewer.playlist', ['medias' => $medias]);

    }

    public function redirectPage($view, $err_msg = null){
        if($err_msg == null){
            return view($view);
        }
        return view($view, ['err_msg' => $err_msg]);
    }

    public function paymentPage($id){
        return view('viewer.payment', ['media_id' => $id]);
    }

    public function delete_media($id){
        $user_id = Auth::id();
        $playlist = Playlist::where('user_id', $user_id)->firstOrFail();
        if($playlist == null){
            return $this->user_playlist();
        }
        $medias = json_decode($playlist->medias);
        
        if($medias != null){
            if(($key = array_search($id, $medias)) !== false){
                unset($medias[$key]);
                $playlist->medias = json_encode($medias);
                $playlist->save();
            }
        }
        
        return $this->user_playlist();
    }

    public function updateSubscription($email){
        $user = User::where('email',$email)->first();
        if($user == null){
            return;
        }
        $today = Carbon::now();
        if($user != null && $user->subscription->expiry_date != null){
            if($user->subscription->expiry_date->lte($today)){
                $subscription = Subscription::where('user_id',$user->id)->first();
                //dd($user->subscription->expiry_date);
                if($subscription != null){
                    $subscription->isSubscribed = "false";
                    $subscription->save();
                }   
            }
        }
    }

    public function confirmPayment(Request $request){

        Stripe::setApiKey('sk_test_FuqZwDxhAMTzH8s91qwxh6A2');

        try {
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source'  => $request->stripeToken
            ));

            Charge::create (array(
                    "amount" => 3 * 100,
                    "currency" => "usd",
                    'customer' => $customer->id, // obtained with Stripe.js
                    "description" => "Subscription fee." 
            ));
            $user_id = Auth::id();
            $current_date = Carbon::now();
            $subscription = Subscription::where('user_id', $user_id)->firstOrFail();
            $subscription->isSubscribed = "true";
            $subscription->expiry_date =  $current_date->addDays(30);
            $resp = $subscription->save();
            Session::flash ( 'success-message', 'Payment done successfully !' );
            $id = $request->media_id;
            if($id != null){
                return redirect('/viewer/video/'.$id);
            }
            return redirect('/viewer/index');
        } catch ( \Exception $e ) {
            Session::flash ( 'fail-message', $e->getMessage());
            return Redirect::back();
        }

        
        if($resp){
            return $this->index();
        }
    }

    public function checkSubscription(){
        $user = Auth::user();
        $today = Carbon::now();
        //dd($user->subscription->expiry_date->gt($today));
        if((strcmp($user->subscription->isSubscribed,"true") == 0) && ($user->subscription->expiry_date->gt($today))){
            return true;
        }

        return false;    

    }

    public function addLikes($id){
        $media = Media::find($id);
        $user_id = Auth::id();
        $likes = json_decode($media->likes);
        if(!in_array($user_id,$likes)){
            array_push($likes,$user_id);
            $media->likes = json_encode($likes);
        } else if(($key = array_search($user_id, $likes)) !== false){
            unset($likes[$key]);
            $media->likes = json_encode($likes);
        }
        $media->save();
        $count = count($likes);
        
        echo json_encode($count);
    }
}
