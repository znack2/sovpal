<?php namespace App\Models\Traits;

use App\Models\_partials\Image;
use App\Models\_partials\Imagged;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{

//save image

	//setup info about ftp in config
	//create new disk
	//save filename = $request->input('image').$user->id.'.jpg'
	//Storage::disk('public')->put($filename,File::get($request->input('image')));
	// Storage::put('avatars/'.$request->route('user')->id, file_get_contents($request->file('url')->getRealPath()));
	// Storage::put($request->file('url'), $resource);

//display image

//function($filename)
	// $file = Storage::disk('public')->get($filename);
	// return Response($file,200)
	//src={{ route('image',['filename'=>$user->name.'-'.$user->id.'.jpg']) }}



	public function saveImage($type,$podtype = null,$data)
		{
		   $extension = $data->getClientOriginalExtension();
		   $file_name = strtotime(\Carbon\Carbon::now()).trim($data->getClientOriginalName());
		   $file_type = $data->getClientMimeType();
		   $name 	  = $data->getFilename();
		   // $path = '/img/';
		   // $name = sha1(Carbon::now()).'.'.$image->guessExtension();
		   // $image->move(getcwd().$path, $name);
		   $data->move(public_path().'/assets/images/'.$type.'/'.$podtype.'/', $file_name); 
	       return $data->getClientOriginalName();
	    }



	public function addImage($model,$request,$type=null,$alt=null)
	  {
	    // $path_parts = pathinfo(trim($data));
		$image          = new Image;
		$image->url     = strtotime(\Carbon\Carbon::now()).substr($request->getClientOriginalName(),0,-4);
		$image->file    = $request->getClientOriginalExtension();
		$image->alt     = $alt;
		$image->type    = $type;
		$image->save();

	    // $model->image_count = $model->images->count();
	    // $this->incrementImageCount($image);
	    return $model->images()->attach($image);
	  }  




	public function removeImage($model,$type)
	  {
	      $image = $model->images()->where('type',$type)->first();
    	  $image_path = getcwd().$image->url;
      	  unlink(realpath($image_path));
	      $model->images()->detach($image);
	      return true;
	      // $image = $model->images()->where('user_id', $this->currentUser->id)->first();
	      // if(!$image) return;
	      // $image->delete();
	  }
}