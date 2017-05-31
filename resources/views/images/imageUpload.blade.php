@extends("layouts.app")
@section("content")
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" id="cropUploadImg" role="form" method="POST" action="{{ url('/profile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
						    <label for="imageInput">File input</label>
						    <input type="file" id="image" name="image" class="form-control" onchange="readURL(this);">
						    <p class="help-block">choose a file.</p>
							    @if ($errors->has('image'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('image') }}</strong>
	                                </span>
	                             @endif
	                             <div class="row">
		                            <div class="col-xs-12">
			                             <div class="image_container" >
											<img id="blah" src="#" alt="your image" height ="400px" />
										 </div>
										<!-- <div id="cropped_result"></div> -->
									</div>
								</div>
						</div>

                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary upload-image" id="crop_button"
                                >
                                    <i class="fa fa-btn fa-sign-in"></i> submit
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

	<script type="text/javascript" defer>
		function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
                setTimeout(initCropper, 1000);
            }
        }
	    function initCropper(){
	    	console.log("Start here")
	    	var image = document.getElementById('blah');
			var cropper = new Cropper(image, {
			  aspectRatio: 1 / 1,
			  crop: function(e) {
			    console.log(e.detail.x);
			    console.log(e.detail.y);
			  }
			});

			// On crop button clicked
			document.getElementById('crop_button').addEventListener('click', function(e){
	    		var imgurl =  cropper.getCroppedCanvas().toDataURL();
	    		var img = document.createElement("img");
	    		img.src = imgurl;
	    		document.getElementById("cropped_result").appendChild(img);

	    			//SEND IMAGE TO THE SERVER-------------------------

					cropper.getCroppedCanvas().toBlob(function (blob) {
						  var formData = new FormData();
						  formData.append('croppedImage', blob);
						  var path = $('#cropUploadImg').attr('action'); 
						  
						  // Use `jQuery.ajax` method
						  $.ajax(path, {
						    method: "POST",
						    data: formData,
						    processData: false,
						    contentType: false,
						    success: function () {
						      console.log('Upload success');
						    },
						    error: function () {
						      console.log('Upload error');
						    }
						  });
						  blob.preventDefault();
					});
	    		e.preventDefault();
	    	})
	    }
	</script>
@endsection
