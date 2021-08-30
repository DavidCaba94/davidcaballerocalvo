var darkMode = false;

$(document).ready(function(){
    $('.btn-cambio-fondo').on('click', function() {
	    if (!darkMode) {
            $('#link-css').attr('href', 'css/index-dark.css');
            $('.btn-cambio-fondo img').attr('src', 'img/light-icon.png');
            $('#icono-header').attr('src', 'img/fav-white.png');
            $('#icono-header-movil').attr('src', 'img/fav-white.png');
            $('.email img').attr('src', 'img/email-white.png');
            $('.footer img').attr('src', 'img/fav-white.png');
        } else {
            $('#link-css').attr('href', 'css/index.css');
            $('.btn-cambio-fondo img').attr('src', 'img/dark-icon.png');
            $('#icono-header').attr('src', 'img/fav.png');
            $('#icono-header-movil').attr('src', 'img/fav.png');
            $('.email img').attr('src', 'img/email.png');
            $('.footer img').attr('src', 'img/fav.png');
        }
        darkMode = !darkMode;
	});

    $('.hamburger-menu').on('click', function() {
	    $('.bar').toggleClass('animate');
	});

	$('#btn-menu').on('click', function() {
	    $('.menu-desplegable').slideToggle();
	});

    $('.menu-desplegable').on('click', function() {
        $('.bar').toggleClass('animate');
	    $('.menu-desplegable').slideToggle();
	});

    $('.btn-enviar').on('click', function() {
        enviarEmailContacto();
	});
});

function enviarEmailContacto() {
    $('.msg-success').css("display", "none");
    if($('#email').val() !== '' && $('#mensaje').val() !== '') {
        $('.msg-error').css("display", "none");
        $.ajax({
            url: '../email/mail.php',
            dataType: 'json',
            data: ({email: $('#email').val(), mensaje: $('#mensaje').val()}),
            success: function(data) {
                if(data.status == 200){
                    console.log("Email enviado");
                    $('.msg-success').css("display", "block");
                    $('#email').val('');
                    $('#mensaje').val('');
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    } else {
        $('.msg-error').css("display", "block");
    }
}