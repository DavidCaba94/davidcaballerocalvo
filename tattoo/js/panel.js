$(document).ready(function(){
	$(".btn-image").on('click', function() {
        var formData = new FormData();
        var files = $('#imagen')[0].files[0];
        formData.append('file',files);
        $.ajax({
            url: '../tattoo/rest/upload_image.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0 && response != 1) {
                    $(".upload-image").attr("src", "rest/" + response);
                } else {
                    alert('Error en la subida');
                }
            },
			error: function(error) {
				console.log(error);
			}
        });
        return false;
    });
});