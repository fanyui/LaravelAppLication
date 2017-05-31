<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Photo;
use App\Http\Requests;
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
    	$this->validate ($request, [
        'email' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:128000',
      ]);
    	 //create a new image object and extract the content of the request to be populated into the table
    	$img = new Image();
 		$input = $request->all();
        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $input['image']);

        //extract the email and file name to store in the database
        $img->email=$input['email'];
        $img->img =$request->image->getClientOriginalName();

        //create a new copy of the uploaded image and then changes the dimension 50x50 using the intervention package and save it inthe images/avater directory

        File::copy('images/'.$input['image'] , 'images/avatar/'.$input['image']);
		$resizedImage = Photo::make('images/avatar/'.$input['image'])->resize(50, 50);
		$resizedImage->save();
	    
        $img->save();//save the image in the database
        return " Ajax has finished successfull";

    }

}
