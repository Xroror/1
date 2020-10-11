<?php include $_SERVER['DOCUMENT_ROOT'] . '/code/topbar/topbar_html.php'; 
session_start();
?>
<html>
<head>
<style>
#chat1 {
	
}

.chatexp {
	display: none;
}

.chatdiv{
	position:static;
}

.typing {
	position: relative;
	width: 100%
	
}

.chathide {
	display: none;
}

#chatmain {
	position: absolute;
	right: 10px;
	top:35px;
	background-color: lightgray;
	height:90%;
	width: 250px;
	overflow: none;
}

.chattext {

	overflow-x:hidden;
	overflow-y:scroll;
	position: relative;
	background-color: gray;
	width: 99%;
	height: 200px;
	min-height: 200px;
}

.openchat{
	user-select: none;
	cursor: pointer;
}

.closechat{
	cursor: pointer;
	float: right;
	user-select: none;
}

.emotes{
	width: 30px;
	height: 30px;
}

.recmes{
	clear: both;
	word-warp:break-word;
	position: relative;
	float:right;
	right:5px;
	display:inline-block;
	color:white;
	max-width: 200px;
	word-break:break-all;
}

.mymes{
	clear:both;
	word-break:break-all;
	word-warp:break-word;
	position: relative;
	float:left;
	left:5px;
	max-width: 200px;
}


</style>
<script>

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


</script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';

	if(isset($_SESSION['login_id'])){
		$tablename = strtolower($_SESSION['login_nick']);
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = "SELECT accounts.acc_nick FROM accounts INNER JOIN friends ON friends.friend_id = accounts.acc_id 
		WHERE friends.acc_id = '" . $_SESSION['login_id'] . "'";
		$result = $conn->query($sql);
		echo "<div id = 'chatmain'>";
		while($row = $result->fetch_assoc()){
			$accnick = $row['acc_nick'];
			$sql = "SELECT * FROM message_db.`$tablename` WHERE sender = '$accnick' OR reciever = '$accnick' ORDER BY id DESC LIMIT 20";
			
			$resultinner = $conn->query($sql);
				echo "<div class = 'chatdiv' id ='$accnick'</div>";
				echo "<span class = 'openchat'>$accnick</span>";
				echo "<span class = 'closechat'>X</span>";
				echo "<div class = 'chathide'>";
				echo "<div class = 'chattext'>";
				while($rowin = $resultinner->fetch_assoc()){
					if($rowin['sender'] == $accnick)
					{
						echo "<div class = 'recmes'>" . $rowin['message'] . "</div></br>";
					}else if($rowin['reciever'] == $accnick){
						echo "<div class = 'mymes'>" . $rowin['message'] . "</div></br>";
					}
					
				}
				echo "</div>";
				echo "<form id = '$accnick' class = 'typing'>";
				echo "<input class = 'messagebox' type = 'text' placeholder = 'Your message'>";
				echo "<input type = 'submit' value = 'send'>";
				echo "</form>";
				echo "</div>";
				echo "</div>";
				echo "</br>";
			}
		echo "</div>";
	}
	?>
		
			
			
			
			
	

</body>
</html>
