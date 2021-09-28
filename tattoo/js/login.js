$(document).ready(function(){
	autoloadLogin();
    $('.btn-login').on('click', function() {
	    login();
	});
});

function login() {
    $.ajax({
	    type: 'GET',
	    url: '../tattoo/rest/obtener_all_users.php',
	    dataType: 'json',
        data: ({user: $("#user").val(), pass: $("#pass").val(), dominio: 'davidcaballerocalvo.es'}),
	    success: function(data) {
            if(data.users != undefined && data.users[0].user === $("#user").val()) {
				localStorage.setItem("user", $("#user").val());
				localStorage.setItem("pass", $("#pass").val());
				if($('#recordar').prop('checked')) {
					localStorage.setItem("check", "checked");
				} else {
					localStorage.setItem("check", "unchecked");
				}
                window.location.href = 'https://davidcaballerocalvo.es/tattoo/panel';
            } else {
				showErrorNotification('Login incorrecto');
			}
	    },
	    error: function(error) {
	        console.log(error);
	    }
	});
}

function autoloadLogin() {
	if(localStorage.getItem('user') != null && localStorage.getItem('pass') != null && localStorage.getItem('check') == 'checked') {
		$("#user").val(localStorage.getItem('user'));
		$("#pass").val(localStorage.getItem('pass'));
		$('#recordar').prop('checked', true);
	}
}

function showErrorNotification(texto) {
    $("#snackbar-error").text(texto);
    var x = document.getElementById("snackbar-error");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}