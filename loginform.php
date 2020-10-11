<?php  if(!isset($_SESSION)){session_start();} ?>
<html>
<head>
<script>

window.onload = function(){
	document.getElementById("homebut").addEventListener("click", function(){location.href = "/index.php";});
}

function logout(){
	console.log("logging out");
	var xhttp;
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
		}
	};
	xhttp.open("POST", "/logout.php", true);
	xhttp.send();
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

</script>
</head>
<body>


  <form action = "" onsubmit = "sendlogin()" method = "POST">
    <input type = "text" value = "Xror" id = "username" name = "username"/> </br>
	<input type = "password" id = "passwd" name = "passwd"/> </br>
	<input type = "submit" value = "Log in"/>
  </form>
  
  <form onsubmit = "logout()" method = "POST">
	<input type = "submit" value = "Logout"/>
  </form>
  
<?php
if(isset($_SESSION['login_nick'])){
	
	echo "Logged in as: " . $_SESSION['login_nick'] . " : " . $_SESSION['currency'] . " gold";

}
?>

	<form action = "" onsubmit = "sendnewacc()" method = "POST">
		<input type = "text" id = "newaccname" placeholder = "Username" /> </br>
		<input type = "password" id = "newaccpass" placeholder = "Password" /> </br>
		<input type = "text" id = "newaccnick" placeholder = "Nickname" /> </br>
		<input type = "submit" value = "Create Account" />
	</form>
	
<button id = "homebut">Go to Home</button>
</body>
</html>