function Update(p){
	
	var re = JSON.parse(p);

	var	user = re['user'];
	var email = re['email'];
	var message = re['message'];

	document.getElementById('user').value = user;
	document.getElementById('email').value = email;
	document.getElementById('mess').value = message;
}
