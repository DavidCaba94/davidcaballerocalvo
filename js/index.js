var darkMode = false;

$(document).ready(function(){
    $('.btn-cambio-fondo').on('click', function() {
	    if (!darkMode) {
            $('#link-css').attr('href', 'css/index-dark.css');
            $('.btn-cambio-fondo img').attr('src', 'img/light-icon.png');
            $('#icono-header').attr('src', 'img/fav-white.png');
            $('.email img').attr('src', 'img/email-white.png');
            $('.footer img').attr('src', 'img/fav-white.png');
        } else {
            $('#link-css').attr('href', 'css/index.css');
            $('.btn-cambio-fondo img').attr('src', 'img/dark-icon.png');
            $('#icono-header').attr('src', 'img/fav.png');
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
});