function loadpageJS(){
	document.getElementById("searchfield").addEventListener("input", searchfor);
	getinterests();
}
var temp;

function getinterests(){
	var shopdiv = document.getElementById("shoppinglist");
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			shopdiv.innerHTML = this.responseText;
			interestslisteners();
		}
	};
	xhttp.open("GET", "/ah/fillinterests.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(null);
}


function interestslisteners(){
	var interests = document.getElementsByClassName("interestname");
	
	for(var i = 0;i<interests.length;i++){
		interests[i].addEventListener("dblclick", removeinterest);

	}
}

function removeinterest(event){
	var data = "item_name="+event.target.innerText;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			getinterests();
			console.log(this.responseText);
		}
	};
	xhttp.open("POST", "/ah/removeinterest.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(data);
}


function searchfor(data){
	var data = document.getElementById("searchfield").value;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			fillresp(this.responseText);
			tooltip();
		}
	};
	xhttp.open("GET", "/ah/search.php?req="+data, true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(null);
}

function fillresp(r){
	document.getElementById("results").innerHTML = r;
}

function tooltip(){
	var lists = document.getElementsByClassName("itemlist");
	
	for(var i = 0;i<lists.length;i++){
		lists[i].addEventListener("mouseover", mouseon);
		lists[i].addEventListener("mouseout", mouseout);
		lists[i].addEventListener("dblclick", dbclick);

	}
}

function dbclick(event){
	var data = "item_interest="+event.target.innerText;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
		}
	};
	xhttp.open("POST", "/ah/ahinterests.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(data);
	getinterests();
}

function mouseon(event){
	document.getElementById('searchfield').blur();
	var tpdiv = document.getElementById("tooltip");
	tpdiv.style.display = "block";
	tpdiv.style.top = event.clientY + 20;
	tpdiv.style.left = event.clientX + 50;
	console.log(event.clientY);
	//tpdiv.style.top = e.clientY;
	//tpdiv.style.left = e.clientX;
	if (temp != event.target.innerText){
		temp = event.target.innerText;
		tooltipfor(temp);
	}

}

function mouseout(s){
	var tpdiv = document.getElementById("tooltip");
	tpdiv.style.display = "none";
}

function tooltipfor(data){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			filltooltip(this.responseText);
		}
	};
	xhttp.open("GET", "/ah/tooltip.php?req="+data, true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(null);
}

function filltooltip(r){
	document.getElementById("tooltip").innerHTML = r;
}