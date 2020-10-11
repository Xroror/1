function loadpageJS(){
	checkHERO();
	checkACT();
	document.getElementById('lmfight').addEventListener('click', openfightmenu);
	document.getElementById('lmtravel').addEventListener('click', opentravelmenu);
	document.getElementById('lmheal').addEventListener('click', openhealmenu);
	document.getElementById('lminv').addEventListener('click', openinvmenu);
	document.getElementById('lmcraft').addEventListener('click', opencraftmenu);
	document.getElementById('lmgather').addEventListener('click', opengathermenu);

	//let g = document.getElementsByClassName("lmbut");
	//for(var i = 0;i<g.length;i++){
	//	g[i].addEventListener("click", show);
	//}
}

function openinvmenu(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('censcreen').innerHTML = (this.responseText);
		}
	};
	xhttp.open("GET", "/games/at/inventory/index.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function opengathermenu(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('censcreen').innerHTML = (this.responseText);
			document.getElementById('startgather').addEventListener('click', gather);
		}
	};
	xhttp.open("GET", "/games/at/showgather.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function openhealmenu(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('censcreen').innerHTML = (this.responseText);
			document.getElementById('startheal').addEventListener('click', heal);
			document.getElementById('HEALslider').addEventListener('change', healdetails);
			document.getElementById('newhp').innerText = document.getElementById('hpcur').innerText;
		}
	};
	xhttp.open("GET", "/games/at/showheal.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function opentravelmenu(){
var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('censcreen').innerHTML = (this.responseText);
			document.getElementById('tselect').addEventListener('change', getdetails);
			document.getElementById('starttravel').addEventListener('click', travelto);
			//show default choice details
			let t = document.getElementById('tselect').selectedOptions[0].innerText;
			document.getElementById(t).className = 'showdetails';
		}
	};
	xhttp.open("GET", "/games/at/showtravel.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}


function openfightmenu(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('censcreen').innerHTML = (this.responseText);
			document.getElementById('fselect').addEventListener('change', getdetails);
			document.getElementById('startfight').addEventListener('click', fight);
			//show default choice details
			let f = document.getElementById('fselect').selectedOptions[0].innerText;
			document.getElementById(f).className = 'showdetails';
		}
	};
	xhttp.open("GET", "/games/at/showfight.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

function opencraftmenu(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('censcreen').innerHTML = (this.responseText);
			showcraftonload();
		}
	};
	xhttp.open("GET", "/games/at/showcraft.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
}

	function expcraftinfo(){ //from showcraft
		var target = this.nextElementSibling;
		target.classList.toggle('show');
	}

	function selectcraft(){ //from showcraft
		var allcinfo = document.getElementsByClassName('selectedcraft');
		for(var i = 0;i<allcinfo.length;i++){
			allcinfo[i].classList.remove('selectedcraft');
		}
		this.classList.add('selectedcraft');
	}

	function craftnumchange(){ //from showcraft
		var cq = document.getElementsByClassName('matquantity');
		for(var i = 0;i<cq.length;i++){
			var t = parseInt(cq[i].nextElementSibling.innerText);
			cq[i].innerText = t * this.value;
		}
	}

	function showcraftonload(){ //from showcraft
		document.getElementById('begincraft').addEventListener('click', craft);
		document.getElementById('craftnum').addEventListener('change', craftnumchange);
		var colb = document.getElementsByClassName('collapse');
		for(var i = 0;i<colb.length;i++){
			colb[i].addEventListener('click', expcraftinfo);
		}
		var colc = document.getElementsByClassName('collapseCont');
		for(var i = 0;i<colc.length;i++){
			colc[i].addEventListener('click', selectcraft)
		}
	}

function healdetails(){
	var sliderval = document.getElementById('HEALslider').value;
	var hpcur = parseInt(document.getElementById('hpcur').innerText);
	var hpmax = parseInt(document.getElementById('hpmax').innerText);
	var afterheal = hpcur + hpmax/60*sliderval;
	if(afterheal >= hpmax){afterheal = hpmax;}
	document.getElementById('newhp').innerText = Math.round(afterheal);

}

function getdetails(e){
	var fDetails = document.getElementsByClassName('showdetails');
	for(var i = 0;i<fDetails.length;i++){
		fDetails[i].className = 'hidedetails';
	}
	document.getElementById(e.target.selectedOptions[0].text).className = 'showdetails';
}

function cheatACT(acc){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			checkACT();
		}
	};
	xhttp.open("POST", "/games/at/cheatACT.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("target="+acc);
}


function checkACT(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			checkHERO();
			console.log(this.responseText);
			titleTimer(JSON.parse(this.responseText));

		}
	};
	xhttp.open("GET", "/games/at/checkACT.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(null);
}

function fight(){
	var fightid = document.getElementById('fselect').selectedOptions[0].value;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			checkACT();
		}
	};
	xhttp.open("POST", "/games/at/fight.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("fight_id="+fightid);
}

function heal(){
	var time = document.getElementById('HEALslider').value;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			checkACT();
		}
	};
	xhttp.open("POST", "/games/at/herbalist.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("healtime="+time);
}

function gather(){
	var time = document.getElementById('gathertime').value;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			checkACT();
		}
	};
	xhttp.open("POST", "/games/at/gather.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("gather_dur="+time);
}

function travelto(){
	var dest = document.getElementById('tselect').selectedOptions[0].value;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			checkACT();
			
		}
	};
	xhttp.open("POST", "/games/at/travel.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("end_point="+dest);
}

function craft(){
	var cnum = document.getElementById('craftnum').value;
	var cid = document.getElementsByClassName('selectedcraft')[0].id;
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			checkACT();
			
		}
	};
	xhttp.open("POST", "/games/at/craft.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("craft_id="+cid+"&craft_num="+cnum);
}


function checkHERO(){
	var xhttp;
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			fillherostats(JSON.parse(this.responseText));
		}
	};
	xhttp.open("GET", "/games/at/hero.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(null);
}

function fillherostats(s){
	console.log(s);
	document.getElementById("hpmax").innerHTML = s.hp_max;
	document.getElementById("hpcur").innerHTML = s.hp_cur;
	document.getElementById("location").innerHTML = s.location;
}

function titleTimer(o){
	if(typeof tcd !== 'undefined'){clearInterval(tcd);document.title = "Finished";}
	if(o.timeLeft === null) return 1;
	if(o.timeLeft <= 0) return 1;
	  tcd = setInterval(function(){
		let h = Math.floor(o.timeLeft/3600);
		let m = Math.floor((o.timeLeft%3600)/60);
		let s = Math.floor((o.timeLeft%3600)%60);
		if(m<10){m = "0"+m;}
		if(s<10){s = "0"+s;}
		document.title = o.activity+" "+h+":"+m+":"+s;
		o.timeLeft--;
		if(o.timeLeft <= 0){
			document.title = "Finished";
			checkACT();
			
			clearInterval(tcd);
		}
	}, 1000);
	
}

