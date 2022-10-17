<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: rgb(37, 37, 37);
            }
            #wrap{
                display: flex; 
                justify-content: center; 
                flex-direction: column;
                align-items: center; 
                height: 80vh;
            }
            #gen_btn{
                padding: 10px 20px; 
                font-size: 24px; 
                border-radius: 5px; 
                border: none;
                background-color: rgb(14, 14, 14);
                color: #fff;
                width: 600px;
                height: 70px;
            }
            #gen_btn:hover{
                transition: all 300ms;
                box-shadow: 0px 0px 10px 1px rgb(126, 126, 126);
            }
            #output{
                width: 580px;
                margin-top: 20px;
                border-radius: 5px; 
                padding: 10px;
                height: 80px;
                border: 1px solid rgb(156, 156, 156);
            }
            #output img{
                max-width: 10px;
            }
            #copy_btn{
                border-radius: 5px;
                border:none;
                margin: 20px 0px;
                width: 200px;
                height: 40px;
                font-size: 16px;
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="wrap">
            <button id="gen_btn" onclick="genImage()">Generate</button>
            <div id="output"></div>
            <button id="copy_btn">Copy</button>
        </div>


        <script>

            var copy_btn = document.getElementById('copy_btn');
            var output = document.getElementById('output');
            var gen_btn = document.getElementById('gen_btn');

            copy_btn.addEventListener('click', function(){
                if (output.innerHTML == '') {
                    alert("Nothing to copy");
                    return 
                }

                copy_btn.style.backgroundColor = 'green';
                var range = document.createRange();
                range.selectNode(output);
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
                copy_btn.innerHTML = 'Copied!';
                setTimeout(function(){
                    copy_btn.style.backgroundColor = 'white';
                    copy_btn.innerHTML = 'Copy';
                }, 1000);
            });


            function genImage(){
                var transparent_img = "<img src='/img/transparent.png'/>";
                output.innerHTML = transparent_img;
                output.style.display = 'block';
                copy_btn.style.display = 'block';

                gen_btn.innerHTML = 'Generated!';
                setTimeout(function(){
                    gen_btn.innerHTML="Generate";
                }, 1000);
            }

            function genUserToken(){
                var token = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                return token;
            }

        </script>
        </body>
</html>
