function logout(){
	document.getElementById("loggeddiv").classList.remove("show");
	document.getElementById("loginbut").innerHTML = "My Account";
	console.log("logging out");
	var xhttp;
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			checklogin();
		}
	};
	xhttp.open("POST", "/logout.php", true);
	xhttp.send();
}

function showlogin(){
	document.getElementById("logindiv").classList.toggle("show");
	document.getElementById("creatediv").classList.toggle("show");
}

function showcreate(){
	document.getElementById("logindiv").classList.toggle("show");
	document.getElementById("creatediv").classList.toggle("show");
}

function sendnewacc(){
	var username = document.getElementById("newaccname").value;
	var password = document.getElementById("newaccpass").value;
	var nick = document.getElementById("newaccnick").value;

	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			
			
		}
	};
	var readydata = "username="+username+"&passwd="+password+"&nick="+nick;
	xhttp.open("POST", "/createacc.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	console.log("sending: "+readydata);
	xhttp.send(readydata);
}




function sendlogin(){
	var username = document.getElementById("username").value;
	var password = document.getElementById("passwd").value;

	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
		}
	};
	var readydata = "username="+username+"&passwd="+password;
	xhttp.open("POST", "/workwork.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	console.log("sending: "+readydata);
	xhttp.send(readydata);
}