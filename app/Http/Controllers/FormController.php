<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Photo;
use App\Http\Requests;
use App\Events\FileUploadedEvent;
use App\Image;

class FormController extends Controller
{
	public function __construct(){
		$this->middleware("auth");
	}

    // display the form for uploading and image
    public function showForm(){
    	return view('images.imageUpload');
    }

    //Does the actually processing of the ajax form submission
    public function ajaxImagePost(Request $request)
    {
      $destinationPath = 'images/uploads/';

    $img = new Image();

    $blob = $request->croppedImage;     
    $img->img = $request->gabbage;
    $img->email = $request->email;

    //decode the sumitted image string 
    $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $blob));
      
      //give a name to the decoded image
        $fileName = "hari_".time().".png";
        //save the image at location 'images/uploads/imageName'
        $file = file_put_contents($destinationPath.$fileName, $file);

        //create a new copy of the uploaded image and then changes the dimension 50x50 using the intervention package and save it inthe images/avater directory

        File::copy($destinationPath.$fileName , 'images/avatar/'.$fileName);
         $resizedImage = Photo::make('images/avatar/'.$fileName)->resize(150, 150);
         $resizedImage->save();
        

         //save the remaining properties to the database
       $img->save();

       event(new FileUploadedEvent($img));
 

    }


    public function ajaxform(){
    	return view('images.form');
    }

    public function testAjax(Request $request){
    	return redirect('/');
    }

}
