$(document).ready(function(){
	//initial
	//$('#content').load('Home.html');

	//handle on menu click
	$('ul#nav li a').click(function(){
		var page = $(this).attr('href');
		$('#content').load(page);
		return false;
	})

	//handle on create click
	$('div#login-page div#form form#login-form p#message a').click(function(){
		var page = $(this).attr('href');
		$('#content').load(page);
		return false;
	})
});