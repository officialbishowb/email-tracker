function validateToken(){
    let inputToken = $('#api_tok').val()
    
    if(inputToken == '') {
        setModalMessage("Empty token","An empty token was provided","Ok","") 
        $('#msgModal').modal('show')
        return false
    }

    setLoading(true);
    $.ajax({
        url: '/api/validateToken',
        type: 'POST',
        data: {
            api_token: inputToken,
            _token: $('#_token').val()
        },
        success: function(data){
            data = data[0];
            if(data.success == true){
                setModalMessage("Validated",data.message,"Start generating","") 
                // Set an id for the modal to start the generating proccess
                $('.cancel').attr('id','genImage')
                $('#msgModal').modal('show')
            } else {
                setModalMessage("Error",data.message,"Ok","") 
                $('#msgModal').modal('show')
            }
            setLoading(false);
        },
        error: function(data){
            setModalMessage("Error","A server error has encountered. Please try again later!","Ok","") 
            $('#msgModal').modal('show')
            setLoading(false);
        }


    });

}
/**************** MAIN FUNCTIONS ****************/
// Generate the image when clicked on #genImage
$('#genImage').click(function(){
    generateImage()
})

function generateImage(){
    $('.out').hide();
    setLoading(true);
    resetOutputs();
    setStatusMsg("Generating an Image ID...");
    generateImgId();
}

function startTracking(){
    $('.tracking_btn').html("Resetting the counter..");
    let image_id = $('#out_image img')[0].src.split('=')[1];
    $.ajax({
        url: '/api/startTracking',
        type: 'POST',
        data: {
            _token: $('#_token').val(),
            imageID: image_id
        },
        success: function(data){
            $('.tracking_btn').html(data);
        },
        error: function(){
            setStatusMsg("A server error has encountered. Please try again later!")
            setLoading(false);
        }
    })
}
/**************** HELPER FUNCTIONS ****************/

function generateImgId(){
    $.ajax({
        url: '/api/generateImgId',
        type: 'POST',
        data: {
            _token: $('#_token').val()
        },
        success: function(data){
            data = data[0];
            if(data.success == true){
                setStatusMsg(data.message);
                generateFinalImage(data.image_id)
            } else {
                setStatusMsg(data.message)
                setLoading(false);
            }
        },
        error: function(){
            setStatusMsg("A server error has encountered. Please try again later!")
            setLoading(false);
        }
    })
}

function generateFinalImage(image_id){
    let hostName = location.hostname; 
    let image = `
        <img src='http://${hostName}:8000/image?imageID=${image_id}' />
    `;
    
    $('#out_image').html(image);
    setStatusMsg("Done!");
    $('.out').show();

    // Wait till the image #out_image height is >= 60px and then remove disabled from copy button
    let out_image = $('#out_image')[0];
    let copyBtn = $('.copy');
    let interval = setInterval(function(){
        if(out_image.clientHeight >= 60){
            copyBtn.removeClass('disabled');
            copyBtn[0].innerHTML = "Copy image";
            clearInterval(interval);
        }
    }, 1000);

    setLoading(false);
}
function setLoading(show){
    if(show){
        $('#loading').show()
        return 
    }
    $('#loading').hide()
    return 
}


function setStatusMsg(message){
    $('#status').html(message)
}

function setModalMessage(title,body_msg,cancel_msg,accept_msg){
    $('.modal-title').html(title)
    $('.modal-body').html(body_msg)

    // Only show buttons with value
    if(cancel_msg != ''){
        $('.cancel').html(cancel_msg)
    }else{
        $('.cancel').hide()
    }

    if(accept_msg != ''){
        $('.accept').html(accept_msg)
    }else{
        $('.accept').hide()
    }
}

// Copy the image 
function copyImage(){
    let output = $('#out_image')[0];
    var range = document.createRange();
    range.selectNode(output);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();

    let copyBtn = $('.copy')[0];

    copyBtn.innerHTML = "Copied!";
    setTimeout(function(){
        copyBtn.innerHTML = 'Copy image';
    }, 1000);

}

function resetOutputs(){
    $('#out_image').html('')
    $('.copy').addClass('disabled')
    $('.copy').html('Wait')
    $('.tracking_btn').html('Start tracking')
}