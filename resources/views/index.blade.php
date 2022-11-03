<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Email-Tracker</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{url('css/app.css')}}" rel="stylesheet">

    </head>
    <body class="antialiased">
        
        @php
            $sessionExist = session()->get('api_token') == "" ? false : true;

            if($sessionExist){
                $onClickMethod = "generateImage()";
                $innerHTML = "Generate Image";
            }
            else{
                $onClickMethod = "validateToken()";
                $innerHTML = "Validate";
            }
        @endphp

        <div class="container">
            <input type="hidden" name="csrf_token" id="_token" value="{{csrf_token()}}">
            <input class="form-control mb-3" id="api_tok" placeholder="Your API token" value="{{session()->get('api_token')}}"></input>
            <button class="btn btn-custom mt-3" onclick="{{$onClickMethod}}">{{$innerHTML}}</button>

            <div class="d-flex justify-content-center">
                <div class="spinner-border text-loading mt-3" id="loading" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

        </div>

        <div class="current-status text-center mt-5">
            <p id="status"></p>

            <div class="out m-auto">
                <p id="out_image">Image</p>
                <button class="btn btn-custom copy disabled" onclick="copyImage()">Wait</button>
                <p class="m-3">Click on "Start tracking" after sending the email with the image.</p>
                <button class="btn btn-custom tracking_btn" onclick="startTracking()">Start tracking</button>
            </div>
        </div>

        <!-- Message Modal -->
<div class="modal fade text-dark" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="msgModalLabel"></h5>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cancel" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary accept">Save changes</button>

          
        </div>
      </div>
    </div>
  </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
         <script src="{{ url('js/app.js')}}" type="text/javascript"></script>
         <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    </body>
</html>
