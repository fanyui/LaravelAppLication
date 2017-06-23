window.onload = function () {

  'use strict';

  var Cropper = window.Cropper;
  var console = window.console || { log: function () {} };
  var container = document.querySelector('.img-container');
  var image = container.getElementsByTagName('img').item(0);
  var download = document.getElementById('download');
  var actions = document.getElementById('actions');
  var dataX = document.getElementById('dataX');
  var dataY = document.getElementById('dataY');
  var dataHeight = document.getElementById('dataHeight');
  var dataWidth = document.getElementById('dataWidth');
  var dataRotate = document.getElementById('dataRotate');
  var dataScaleX = document.getElementById('dataScaleX');
  var dataScaleY = document.getElementById('dataScaleY');
  var isUndefined = function (obj) {
    return typeof obj === 'undefined';
  };
  var options = {
        aspectRatio: 16 / 9,
        preview: '.img-preview',
        ready: function (e) {
          console.log(e.type);
        },
        cropstart: function (e) {
          console.log(e.type, e.detail.action);
        },
        cropmove: function (e) {
          console.log(e.type, e.detail.action);
        },
        cropend: function (e) {
          console.log(e.type, e.detail.action);
        },
        crop: function (e) {
          var data = e.detail;

          console.log(e.type);
          dataX.value = Math.round(data.x);
          dataY.value = Math.round(data.y);
          dataHeight.value = Math.round(data.height);
          dataWidth.value = Math.round(data.width);
          dataRotate.value = !isUndefined(data.rotate) ? data.rotate : '';
          dataScaleX.value = !isUndefined(data.scaleX) ? data.scaleX : '';
          dataScaleY.value = !isUndefined(data.scaleY) ? data.scaleY : '';
        },
        zoom: function (e) {
          console.log(e.type, e.detail.ratio);
        }
      };
  var cropper = new Cropper(image, options);

  function preventDefault(e) {
    if (e) {
      if (e.preventDefault) {
        e.preventDefault();
      } else {
        e.returnValue = false;
      }
    }
  }


  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();


  // Buttons
  if (!document.createElement('canvas').getContext) {
    $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
  }

  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  }


  // Options
  actions.querySelector('.docs-toggles').onclick = function (event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var cropBoxData;
    var canvasData;
    var isCheckbox;
    var isRadio;

    if (!cropper) {
      return;
    }

    if (target.tagName.toLowerCase() === 'span') {
      target = target.parentNode;
    }

    if (target.tagName.toLowerCase() === 'label') {
      target = target.getElementsByTagName('input').item(0);
    }

    isCheckbox = target.type === 'checkbox';
    isRadio = target.type === 'radio';

    if (isCheckbox || isRadio) {
      if (isCheckbox) {
        options[target.name] = target.checked;
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();

        options.ready = function () {
          console.log('ready');
          cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        };
      } else {
        options[target.name] = target.value;
        options.ready = function () {
          console.log('ready');
        };
      }

      // Restart the cropper
      cropper.destroy();
      cropper = new Cropper(image, options);
    }
  };


  // Methods
  actions.querySelector('.docs-buttons').onclick = function (event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var result;
    var input;
    var data;

    if (!cropper) {
      return;
    }

    while (target !== this) {
      if (target.getAttribute('data-method')) {
        break;
      }

      target = target.parentNode;
    }

    if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
      return;
    }

    data = {
      method: target.getAttribute('data-method'),
      target: target.getAttribute('data-target'),
      option: target.getAttribute('data-option'),
      secondOption: target.getAttribute('data-second-option')
    };

    if (data.method) {
      if (typeof data.target !== 'undefined') {
        input = document.querySelector(data.target);

        if (!target.hasAttribute('data-option') && data.target && input) {
          try {
            data.option = JSON.parse(input.value);
          } catch (e) {
            console.log(e.message);
          }
        }
      }

      if (data.method === 'getCroppedCanvas') {
        data.option = JSON.parse(data.option);
      }

      result = cropper[data.method](data.option, data.secondOption);

      switch (data.method) {
        case 'scaleX':
        case 'scaleY':
          target.setAttribute('data-option', -data.option);
          break;

        case 'getCroppedCanvas':
          if (result) {
            // Bootstrap's Modal display the cropped image before submitting
            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

            $('#download').click(function(e){
               var crop = cropper.getCropBoxData();
               e.preventDefault(); 
              //SEND IMAGE TO THE SERVER-------------------------

              var name = result.toDataURL("image/png");
              var test = "hey just testing";

              var formData = new FormData();
              //gabbage and email are just dummy variables for test purporses
               
              formData.append("gabbage", test);
              formData.append('croppedImage',name );
             formData.append('email','harisugap@gmail.com');
              // Use `jQuery.ajax` method
              $.ajax({
                url: '/profile',
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                mimeType:"multipart/form-data",
                //destroy the modal when submit is successfulll
                success: function () {
                  $( '.modal' ).modal( 'hide' ).data( 'bs.modal', null );
                  alert("Upload success");
                  console.log("upload success");
                },
                //alert an error message asking the user to retry on failure
                error: function () {
                  alert("Eroor uploading Please try again");
                  console.log('Upload error');
                }
              });

            
         }) ;

              
          
        }
          break;

        case 'destroy':
          cropper = null;
          break;
      }

      if (typeof result === 'object' && result !== cropper && input) {
        try {
          input.value = JSON.stringify(result);
        } catch (e) {
          console.log(e.message);
        }
      }

    }
  };

  document.body.onkeydown = function (event) {
    var e = event || window.event;

    if (!cropper || this.scrollTop > 300) {
      return;
    }

    switch (e.keyCode) {
      case 37:
        preventDefault(e);
        cropper.move(-1, 0);
        break;

      case 38:
        preventDefault(e);
        cropper.move(0, -1);
        break;

      case 39:
        preventDefault(e);
        cropper.move(1, 0);
        break;

      case 40:
        preventDefault(e);
        cropper.move(0, 1);
        break;
    }
  };


  // Import image from system
  var inputImage = document.getElementById('inputImage');
  var URL = window.URL || window.webkitURL;
  var blobURL;

  if (URL) {
    inputImage.onchange = function () {
      var files = this.files;
      var file;

      if (cropper && files && files.length) {
        file = files[0];

        if (/^image\/\w+/.test(file.type)) {
          blobURL = URL.createObjectURL(file);
          cropper.reset().replace(blobURL);
          inputImage.value = null;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImage.disabled = true;
    inputImage.parentNode.className += ' disabled';
  }

$('#box').click(function(){
  var crop = cropper.getCropBoxData();
  alert(JSON.stringify(crop));
});

function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}

};
