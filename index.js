var lastrow; //define global var for later use
var check_login; //global var
var chatname = null;

function loadpageJS(){ //events at page load, Event listners
	var tabr = document.getElementsByTagName("tr"); 
	var lir = document.getElementsByClassName("fr");
	document.getElementById("buybut").addEventListener("click", buybuttonclick);
	document.getElementById("chatform").addEventListener("submit", sendchat);

	for(var i = 0; i < lir.length; i++){
		lir[i].addEventListener("click", frclick);
	}


	for (var i = 1; i < tabr.length; i++){					//add event listeners for all rows
		tabr[i].addEventListener("click", rowclick);
		//console.log("Listener added for table row");		//debug check
	}
}

function frclick(){ //remmember who you are chatting with 
	chatname = this.innerText;
	getchat();
}

function scrollbot(){ //function to keep the scroll at the bottom
	document.getElementById("recievedchat").scrollTop = document.getElementById("recievedchat").scrollHeight;
}

function sendchat(){ //send a chat message
	var g = document.getElementById("sendtext").value;
	document.getElementById("sendtext").value = null;
	var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			chatupdate();
			//recievedata(this.responseText);				response from writing message(sent)
		}
	};
	xhttp.open("POST", "/sendmessage.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("message="+g+"&name="+chatname);
	//console.log("sent:"+g);
	
}

function chatupdate(){ //update the chat box with new chat FILE MOVED
	getchat();
}



function getchat(){	// ajax request for chat data
		document.getElementById("chat").style.display = "block";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			recievedata(this.responseText);
		}
	};
	xhttp.open("POST", "/chat.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name="+chatname);
	scrollbot();
}

function recievedata(r){ //put the data into the div element	FILE MOVED
	var t = document.getElementById("recievedchat");
	t.innerText = r;
	scrollbot();
}

function rowclick() {  
  var selrow = document.getElementsByClassName("selectedrow"); //store newly clicked row
  for (i = 0; i < selrow.length; i++){ //make sure that not more than 1 rows are clicked
	  selrow[i].className = "unselectedrow"; // change class to unselected
  }
  this.className = "selectedrow"; //highlight the selected row
  lastrow = this.innerText; //get data from selected row
  //console.log(lastrow);			//debug
  //console.log(typeof lastrow);		//debug
}

function buybuttonclick(){
	//console.log(lastrow);			//debug
	//console.log(typeof lastrow);	//debug
	var arr = lastrow.split('	'); //split string at tabs
	//console.log(arr[1]);			//debug
	document.getElementById("browserow").value = arr[1]; //set hidden form data
}
