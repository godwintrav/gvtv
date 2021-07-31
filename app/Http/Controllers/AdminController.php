<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Channel;
use App\Model\Media;
use App\Model\Advert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManager;


class AdminController extends Controller
{
    public function register(Request $request){
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => 'admin',
        ]);
        
        $channel = new Channel();
        $channel->title = $validatedData['firstname'] ."_". $validatedData['lastname'];
        $channel->user_id = $user->id;
        $channel->active = 1;

        $resp = $channel->save();

        if($resp == true){
           return redirect('/admin_login');
        }
    }

    public function login(Request $request){
        
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $login['email'];
        $password = $login['password'];

        if(Auth::guard('admin')->attempt(['email' => $email, 'password' => $password, 'user_type' => 'admin'])){
            return redirect('/admin/index');
        } else{
            $err_msg = "Invalid login Details";
            return view('admin.login', ['err_msg' => $err_msg]);
        }

    }

    public function logout(){

        Auth::logout();
        return redirect('/admin_login');
    }

    public function index(){
        $videos = Media::orderBy('created_at', 'desc')->get();
        if($videos == null  || count($videos) == 0){
            return view('admin.index');
        }
        return view('admin.index', ['videos' => $videos]);
    }

    public function redirectToSetUploadVideoView( $err_msg = null){
        return view('admin.upload-video', [ 'err_msg' => $err_msg]);
    }

    public function setUploadVideo(Request $request){

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'thumbnail' => 'required',
        ]);     


        $extension = $request->file('thumbnail')->getClientOriginalExtension();
        //dd($extension);

        if(!$this->validateImgExtension($extension)){

            $err_msg = "Unsupported Image Format";
            return $this->redirectToSetUploadVideoView($err_msg);

        }

        $path = $request->file('thumbnail')->store('images');

        $manager = new ImageManager();
        
        $image = $manager->make('storage/'.$path)->resize(255, 240);
        $image->save('storage/'.$path);

        

        $user_id = Auth::id();
        
        $channel = Channel::where('user_id', $user_id)->firstOrFail();
        $channel_id = $channel->id;

        $media = Media::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'tags' => $data['tags'],
            'channel_id' => $channel_id,
            'type' => 'video',
            'views' => json_encode([]),
            'thumbnail' => $path,
            'likes' => json_encode([]),
        ]);

        $media_id = $media->id;
        return redirect('/admin/upload/'.$media_id);
    }

    public function redirectToUploadView($id, $err_msg = null){
        return view('admin.upload', ['media_id' => $id, 'err_msg' => $err_msg]);
    }

    public function uploadVideo(Request $request){
        //dd($request->filename);
        $data = $request->validate([
            'filename' => 'required',
            'media_id' => 'required',
        ]);
        
        $media_id = $data['media_id'];
        $extension = $request->file('filename')->getClientOriginalExtension();
        //dd($extension);

        if(!$this->validateVideoExtension($extension)){

            $err_msg = "Unsupported File Format";
            return $this->redirectToUploadView($media_id, $err_msg);

        }
        
        $path = $request->file('filename')->store('videos');
        
        // $ffprobe = FFMpeg\FFProbe::create();
        // $time_seconds = $ffprobe
        //             ->format('storage/'.$path) // extracts file informations
        //             ->get('duration');
        // $duration = gmdate("H:i:s", $time_seconds);           
        $media = Media::findOrFail($media_id);
        $media->filename = $path;
        // $media->duration = $duration;
        $media->save();
        return redirect('/admin/index');
    }

    public function viewMedia($id){
        $media = Media::findOrFail($id);
        $vid_tags = explode(",", $media->tags);
        $views = json_decode($media->views);
        //dd($views);
        $num_views = count($views);

        if($num_views == 0 || $num_views == 1){
            $num_views = $num_views ." view";
        } else{
            $num_views = $num_views ." views";
        }
        $upNexts = Media::orderBy('created_at', 'desc')
                        ->where('id','<>',$media->id)
                        ->inRandomOrder()
                        ->limit(6)
                        ->get();
        return view("admin.video-page", ['media' => $media, 'vid_tags' => $vid_tags, 'num_views' => $num_views, 'upNexts' => $upNexts]);
    }

    public function validateVideoExtension($ext){
        $extensions = array("mp4", "m4a", "m4v", "f4v", "f4a", "m4b", "m4r", "f4b", "mov","ogg", "oga", "ogv", "ogx", "webm");
        foreach($extensions as $extension){
            if(strcmp($extension,strtolower($ext)) == 0){
                return true;
            }
        }                  
        return false;
    }

    public function validateImgExtension($ext){
        $extensions = array("jpg","jpeg", "gif", "png", "apng", "svg", "bmp", "ico", "png", "ico");
        foreach($extensions as $extension){
            if(strcmp($extension,strtolower($ext)) == 0){
                return true;
            }
        }                  
        return false;
    }

    public function searchVideo(Request $request){
        $data = $request->validate([
            'search' => 'required|string',
        ]);
        $searchVal = $data['search'];
        $videos = Media::orderBy('created_at', 'desc')
                    ->where('title','LIKE','%'.$searchVal.'%')
                    ->orWhere("tags",'LIKE', '%'.$searchVal.'%')
                    ->orWhere("description",'LIKE', '%'.$searchVal.'%')
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
            return view('admin.index', ['videos' => $videos]);
        }else{
            return view('admin.index');
        }
    }

    public function UploadAdvert(Request $request){

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'content' => 'required',
        ]);     


        $extension = $request->file('content')->getClientOriginalExtension();

        $type = null;
        //dd($type);
        
        if($this->validateImgExtension($extension) === true){
            $type = "image";
            $path = $request->file('content')->store('images');
            //dd($path."bb");

            $manager = new ImageManager();
            $image = $manager->make('storage/'.$path)->resize(335, 108);
            $image->save('storage/'.$path);
        } else if($this->validateVideoExtension($extension) === true){
            $type = "video";
            $path = $request->file('content')->store('videos');
            //dd($path);
        } else {
            $err_msg = "Unsupported File Format";
            return $this->redirectPage("admin.upload-advert",$err_msg);
        }


        $advert = Advert::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'tags' => $data['tags'],
            'owner' => $data['owner'],
            'type' => $type,
            'active' => 1,
            'content' => $path,
        ]);

        return redirect('/admin/index');
    }


    public function viewAdverts(){
        $adverts = Advert::orderBy('created_at', 'desc')->get();
        if($adverts == null){
            return view('admin.view-adverts');
        }
        return view('admin.view-adverts', ['adverts' => $adverts]);
    }


    public function activateAd($id){
        $advert = Advert::findOrFail($id);
        if($advert == null){
            return $this->viewAdverts();
        }

        $advert->active = 1;
        $advert->save();
        return $this->viewAdverts();
        
    }


    public function disableAd($id){
        $advert = Advert::findOrFail($id);
        if($advert == null){
            return $this->viewAdverts();
        }

        $advert->active = 0;
        $advert->save();
            return $this->viewAdverts();
    }
    
    public function allusers(){
        $users = User::orderBy('created_at', 'desc')
                        ->where('user_type', '<>', 'admin')
                        ->get();
        if($users == null){
            return view('admin.allusers');
        }
        return view('admin.allusers', ['users' => $users]);
    }

    public function deleteUser($id){
        $user = User::findOrFail($id);

        if($user == null){
            return $this->allusers();
        }

        $user->delete();
        return $this->allusers();
    }



    

    
}
