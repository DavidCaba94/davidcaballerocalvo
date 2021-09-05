$(document).ready(function(){
    $('.btn-login').on('click', function() {
	    login();
	});
});

function login() {
    $.ajax({
	    type: 'GET',
	    url: '../tattoo/rest/obtener_all_users.php',
	    dataType: 'json',
        data: ({user: $("#user").val(), pass: $("#pass").val()}),
	    success: function(data) {
            if(data.users != undefined && data.users[0].user === $("#user").val()) {
                window.location.href = 'https://davidcaballerocalvo.es/tattoo/panel';
            }
	    },
	    error: function(error) {
	        console.log(error);
	    }
	});
}