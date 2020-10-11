
const reader = new FileReader();
const messaudio = new Audio('http://79.100.137.201/sounds/newmessage.mp3');
reader.onload = function(){

}

function loadpageJS(){
	 var chatexpwin = document.getElementsByClassName("openchat");
	 var chatclose = document.getElementsByClassName("closechat");
	 var chatforms = document.getElementsByClassName("typing");
	 var messagebox = document.getElementsByClassName("messagebox");
	 var chatdivs = getchatdivs();
	 
	var cf = chatforms.length;
	var cexpw = chatexpwin.length;
	var ccl = chatclose.length;
	var mbox = messagebox.length;
	for (var i = 0; i < cf; i++){
		chatforms[i].addEventListener("submit", submitchat);
	}
	for (var i = 0; i < ccl; i++){
		chatclose[i].addEventListener("click", hidechat);
	}
	for (var i = 0; i < mbox; i++){
		messagebox[i].addEventListener("drop", dropfile);
	}
	for (var i = 0; i < cexpw; i++){
		chatexpwin[i].addEventListener("click", showchat);
	}
	setTimeout(startws, 500); //RLY FUCKING STUPID FIX IT
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

function chatdivexist(s){
	for(var i = 0;i<chatdivs.length;i++){
		if(chatdivs[i].id == s){
			return chatdivs[i];
		}
	}
	getnewchat(s);
	chatdivs = getchatdivs();
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
	var c1 = this.nextElementSibling.nextElementSibling;
	//if (c1.style.display == "block"){
	//c1.style.display = "none";
	//}else{

	c1.style.display = "block";
	scrollbot(c1.firstElementChild);
	//}
}

function recievemessage(s){
	var user = s.substring(0, s.indexOf(":"));
	var mess = s.substring(s.indexOf(":")+1);
	if(mess[0])//?
	var chatbox = document.getElementById(user).lastElementChild.firstElementChild;
	var element = document.createElement("DIV");
	chatbox.appendChild(element);
	element.outerHTML = mess;
	if(chatbox.lastElementChild.previousElementSibling.className == "recmes"){
		var promise = messaudio.play();
	}
	console.log(chatbox.lastElementChild.className);
	//chatbox.insertAdjacentHTML('beforeend', mess[1]);
	scrollbot(chatbox);

	
}

function startws(){
		ws = new WebSocket("ws://79.100.137.201:9999");
		ws.onopen = function(){
			
			ws.send("/"+document.getElementById("loginbut").innerText);
			console.log("connected");
		};
		ws.onmessage = function(event){

			console.log(event.data);
			recievemessage(event.data);
		};

		ws.onping = function(){
			console.log(ws);
			
				
		};
		
		ws.onclose = function(){
			console.log("closing");
			
		};
	}

function getnewchat(s){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('chatmain').insertAdjacentHTML('beforeend', this.responseText);
			
			
		}
	};
	
	xhttp.open("POST", "/test/addchatwindow.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("names="+s);
}
