window.onload = function(){ //events at page load, Event listners
checklogin();
visit();
document.getElementById("loginbut").addEventListener("click", showloginmain);
document.getElementById("logincbut").addEventListener("click", showcreate);
document.getElementById("createlbut").addEventListener("click", showlogin);
document.getElementById("logoutbut").addEventListener("click", logout);
document.getElementById("mailbut").addEventListener("click", showmail);
document.getElementsByClassName("chatdivbut")[0].addEventListener("click", showchatwindow);
//getchat();
getmail();
loadpageJS();
loadChatJS();
}



window.onclick = function(event){
	if(document.getElementsByClassName("mailcontent")[0].style.display == "block"){
	}//? what is this
	
}

function visit(){ //record every visit
	var data = 'loc=' + location.pathname;
		var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
		}
	};
	
	xhttp.open("POST", "/code/account/getip.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(data);
}

function myaccountbutton(r){
	if(r == "notlogged"){
		check_login = false;
	}else if(r != null) {
		check_login = true;
		document.getElementById("loginbut").innerHTML = r;
	}
	
}

function showmail(){
	document.getElementsByClassName("mailcontent")[0].classList.toggle("show");
}

function showchatwindow(){
	document.getElementById("chatmain").classList.toggle("show");
}



function checklogin(){ //change to GET
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
			location.reload(true);
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
	xhttp.send(readydata);
}

/*function getchat(){
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('chatmain').innerHTML = this.responseText;
			loadChatJS();
			
		}
	};
	xhttp.open("GET", "/code/chat/index.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
	
}*/


function getmail(){
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementsByClassName('mailcontent')[0].innerHTML = this.responseText;
			
			
		}
	};
	xhttp.open("GET", "/code/account/getmail.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
	
}


function sendlogin(){
	var username = document.getElementById("username").value;
	var password = document.getElementById("passwd").value;

	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			
		}
	};
	var readydata = "username="+username+"&passwd="+password;
	xhttp.open("POST", "/workwork.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	console.log("sending: "+readydata);
	xhttp.send(readydata);
}


const reader = new FileReader();
const messaudio = new Audio('http://46.10.191.25/sounds/newmessage.mp3');


function loadChatJS(){
	chatdischtml = `<span id = 'chatdisconected'>You have been disconected from the chat server. Attempting to reconnect!</span>`;
	chatmain = document.getElementById("chatmain");
	startws();

}

function addeventListeners(){
	var chatexpwin = document.getElementsByClassName("openchat");
	var chatforms = document.getElementsByClassName("typing");
	var messagebox = document.getElementsByClassName("messagebox");
	var cf = chatforms.length;
	var cexpw = chatexpwin.length;
	var mbox = messagebox.length;
	for (var i = 0; i < cf; i++){
		chatforms[i].addEventListener("submit", submitchat);
	}
	for (var i = 0; i < mbox; i++){
		messagebox[i].addEventListener("drop", dropfile);
	}
	for (var i = 0; i < cexpw; i++){
		chatexpwin[i].addEventListener("click", showchat);
	}
}

reader.onload = function(){
	sendimage(reader.result);
}

function getchatdivs(){
	return document.getElementsByClassName('chatdiv');
}
function dropfile(e){
	e.preventDefault();
	imagetarget = this.parentElement.id;
	reader.readAsDataURL(e.dataTransfer.items[0].getAsFile());
}

function sendimage(data){
	var messagetosend = "`"+imagetarget+"`"+data;
	ws.send(messagetosend);
}

function scrollbot(s){ //function to keep the scroll at the bottom
	s.scrollTop = s.scrollHeight;
}

function submitchat(e){
	e.preventDefault();
	var messagetosend = "`" + this.id + "`" + this.firstElementChild.value;
	ws.send(messagetosend);
	//var message = "<div class = 'mymes'>"+this.firstElementChild.value+"</div></br>";
	//this.previousElementSibling.insertAdjacentHTML('beforeend', message);
	this.firstElementChild.value = "";
	scrollbot(this.previousElementSibling);
}

function hidechat(){
	this.nextElementSibling.style.display = "none";
}


function showchat(){
	var c1 = this.nextElementSibling;
	//if (c1.style.display == "block"){
	//c1.style.display = "none";
	//}else{

	c1.classList.toggle("show");
	scrollbot(c1.firstElementChild);
	//}
}

function recievemessage(s){
	//console.log(s);
	var users = s.substring(0, s.indexOf(":"));
	console.log(users);
	if(document.getElementById(users) === null){
		console.log("askingforHTML");
		ws.send(`$!getnewhtml:${users}`);
		
		return;
	}
	var mess = s.substring(s.indexOf(":")+1);
	var chatbox = document.getElementById(users).lastElementChild.firstElementChild;
	var element = document.createElement("DIV");
	chatbox.appendChild(element);
	element.outerHTML = mess;
	if(chatbox.lastElementChild.previousElementSibling.className == "recmes"){
		var promise = messaudio.play();
	}
	
	//chatbox.insertAdjacentHTML('beforeend', mess[1]);
	scrollbot(chatbox);

	
}

function startws(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var id = this.responseText;
			ws = new WebSocket("ws://46.10.191.25:9999");
			ws.onopen = function(){
				chatmain.innerHTML = "";
				ws.send("/" + id);
				if(typeof(reconnecttimeout) !== 'undefined'){
					clearTimeout(reconnecttimeout);
				}
			};
			ws.onmessage = function(event){
				
				if(event.data.startsWith("!newchat:")){
					let html = event.data.substr(event.data.indexOf(":")+1);
					document.getElementById("chatmain").insertAdjacentHTML("beforeend", html);
					addeventListeners();
				}else{
					recievemessage(event.data);
				}
			
			};
			ws.onping = function(){

			};
			ws.onclose = function(){
			closedchat();
			var reconnecttimeout = setTimeout(startws, 5000);
			};
		}
	};
	xhttp.open("POST", "/code/chat/getsessionid.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
	}

function closedchat(){
	chatmain.innerHTML = chatdischtml;
}
