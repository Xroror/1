window.onload = function(){
	var cellArray = document.getElementsByTagName("td");
	startGame();
}
var emptyCell = [];
var cellArray = document.getElementsByTagName("td");
var key = null;
var moveCheck1 = false;
var moveCheck2 = false;
var cantCombine;



window.addEventListener("keydown", function(e){
	if(key == false){
		key = e.keyCode;
		move();
	}
})
	
window.addEventListener("keyup", function(e){
		key = false;
})

function startGame(){
		styleItUp();
		score = 0;
		document.getElementById("1-2").innerHTML = 2;
		document.getElementById("2-1").innerHTML = 2;

}

function move(){
	if (key && key == 38){
		moveup(1, 1);
		styleItUp();
		
	}else if (key && key == 40){
		movedown(1, 4);
		styleItUp();
		
	}else if (key && key == 37){
		moveleft(1, 1);
		styleItUp();
	
	}else if (key && key == 39){
		moveright(4,1);
		styleItUp();
	
	}
}

function checkMove(f, s){
	//console.log(f, s);
	if(s.innerHTML > 0 && f.innerHTML == 0){ //move to empty cell
		f.innerHTML = s.innerHTML;
		s.innerHTML = 0;
		moveCheck1 = true;
		return 1;
	}else if (s.innerHTML > 0 && s.innerHTML == f.innerHTML && cantCombine != f){ //combine 
		f.innerHTML = f.innerHTML * 2;
		cantCombine = f;
		s.innerHTML = 0;
		console.log(f);
		setScore(f); //display the new current score
		moveCheck1 = true;
	}else{
		
	}
}
/* fi 4-1 se 3-1


*/

function moveup(x, y){

		if (y == 4 && x < 4){
			moveup(x+1, 1);
		}else if (y < 4 && y > 0){
			var se = y+1 + "-" + x;
			var fi = y + "-" + x;
		
			var f = document.getElementById(fi);
			var s = document.getElementById(se);
			if(checkMove(f, s)){
				moveup(x, y-1);
			}else{
				moveup(x, y+1);
			}
		
		}else if(y == 0){
			moveup(x, 1);
		}else{
				spawn();
				cantCombine = 0;
		}
}

function movedown(x, y){
		if (y == 1 && x < 4){
			movedown(x+1, 4);
		}else if (y < 5 && y > 1){
			var se = y-1 + "-" + x;
			var fi = y + "-" + x;
	
			var f = document.getElementById(fi);
			var s = document.getElementById(se);
			if(checkMove(f, s)){
				movedown(x, y+1);
			}else{
				movedown(x, y-1);
			}
		
		}else if(y == 5){
			movedown(x, 4);
		}
		else{
				spawn();
				cantCombine = 0;
		}
}

function moveleft(x, y){
		if (x == 4 && y < 4){
			moveleft(1, (y+1));
		}else if (x < 4 && x > 0){
			var se = y + "-" + (x+1);
			var fi = y + "-" + x;
	
			var f = document.getElementById(fi);
			var s = document.getElementById(se);
			if(checkMove(f, s)){
				moveleft(x-1, y);
			}else{
				moveleft(x+1, y);
			}
		
		}else if(x == 0){
			moveleft(1, y);
		}
		else{
				spawn();
				cantCombine = 0;
		}
}

function moveright(x, y){
		if (x == 1 && y < 4){
			moveright(4, (y+1));
		}else if (x < 5 && x > 1){
			var se = y + "-" + (x-1);
			var fi = y + "-" + x;
			
			var f = document.getElementById(fi);
			var s = document.getElementById(se);
			if(checkMove(f, s)){
				moveright(x+1, y);
			}else{
				moveright(x-1, y);
			}
		
		}else if(x == 5){
			moveright(4, y);
		}
		else{
				spawn();
				cantCombine = 0;
		}
}


function spawn(){
	if(moveCheck1 == true){
		emptyCell = [];
		var em = 0;
		var celT = cellArray.length;
		for(var i=0; i < celT;i++){
			if(cellArray[i].innerHTML == 0){
				emptyCell[em] = cellArray[i];
				em++;
			}
		}
		
		 var t = emptyCell[Math.floor(Math.random() * emptyCell.length)];
		 t.innerHTML = 2;
		console.log("spawning at: " + t.outerHTML);
		moveCheck1 = false;
	}
}

function styleItUp(){
	var celT = cellArray.length;
	for(var i = 0; i < celT;i++){
		targetVAL = cellArray[i].innerHTML;
		cellArray[i].className = "td" + targetVAL;
	}
}

function setScore(s){
	var scorePLC = document.getElementById("scorePlace");
	let t = parseInt(s.innerHTML);
	let x = parseInt(scorePLC.innerHTML);
	let fin = t + x;
	scorePLC.innerHTML = fin;
	sendscore(fin);
}

function sendscore(s){ //sends the score towards php script
	var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log("sent score");
			console.log(this.responseText);				//response from writing message(sent)
		}
	};
	xhttp.open("POST", "/games/2048/2048score.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("score="+s);	
}
