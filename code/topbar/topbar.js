window.onload = function(){ //events at page load, Event listners
checklogin();
document.getElementById("invbut").addEventListener("click", invredirect);
document.getElementById("loginbut").addEventListener("click", showloginmain);
document.getElementById("logincbut").addEventListener("click", showcreate);
document.getElementById("createlbut").addEventListener("click", showlogin);
document.getElementById("logoutbut").addEventListener("click", logout);
loadpageJS();
}

function invredirect(){
	location.href = "/showinv.php";
}

function myaccountbutton(r){
	if(r == "notlogged"){
		check_login = false;
	}else if(r != null) {
		check_login = true;
	}
	
}


function checklogin(){
	var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			myaccountbutton(this.responseText);
			
			
		}
	};
	
	xhttp.open("POST", "/checkacc.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function showloginmain(){
	if(check_login == true){
		document.getElementById("loggeddiv").classList.toggle("show");
	}else if(check_login == false){
		document.getElementById("creatediv").classList.remove("show");
		document.getElementById("logindiv").classList.toggle("show");
	}
}

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
