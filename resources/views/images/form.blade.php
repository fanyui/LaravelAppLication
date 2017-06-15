@extends('layouts.app')
@section('meta')
<meta name="csrf_token" content="{{ csrf_token() }}" method"post" />
@endsection
@section('content')

<form class="form-horizontal" role="form" action="/ajax" >
                        <!-- {{ csrf_field() }} -->

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button id="login" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

                               
                            </div>
                        </div>
                    </form>

          <script type="text/javascript">
               $(document).ready(function() {
  			$("#login").click(function(e) {
                   e.preventDefault();
                   var email = document.getElementById('email');
                   var password = document.getElementById('password');
                 
                   var data = new FormData();
                 
                       data.append("email", email);
                       data.append("password",password);
                   
                   $.ajax({
                   
                       url: '/ajax',
                       
                       data: data,
                       cache: false,
                       contentType: false,
                       processData: false,
                       type: 'POST',
                       // data: $('form').serialize(),
                       success: function () {
                           console.log("success")
                       }
                   });
                   return false;
               });
         });
    
</script>

@endsection