var score = 0;
var snakeArray = [];
var drawint = 50;
var inputdelay = [1, 1, 1, 1, 1];
var windowWidth = window.innerWidth - 30;
var windowHeight = window.innerHeight - 30;
var curr = 0;
var inputbusy = false;

function getSize(t){
	if(t%20 == 0){
		return 0;
	}else{ 
	var closest = t - t%20;
	return closest;
	}
}
	var gameWid = getSize(windowWidth);
	var gameHei = getSize(windowHeight);

function startGame() {
	myGameArea.start(gameWid, gameHei);
	myGameArea.paused = false;
	//background = new component (gameWid - 40, gameHei - 40, "f0f0f5", 20, 20);
	topWall = new component (gameWid, 20, "#666699", 0, 0);
	botWall = new component (gameWid, 20, "#666699", 0, gameHei);
	leftWall = new component (20, gameHei, "#666699", 0, 0);
	rightWall = new component (20, gameHei, "#666699", gameWid - 20, 0);
	snakeArray[0] = new component(20, 20, "red", 760, 300);
	snakeArray[1] = new component(20, 20, "brown", 760, 300);
	apple = new powerup(20, 20, "#ff66ff", 740, 320);
}

var myGameArea = {
	canvas : document.createElement("canvas"),
	start: function(wid, hei){
		this.canvas.width = wid;
		this.canvas.height = hei + 20;
		var paused = false;
		
		this.context = this.canvas.getContext("2d");
		
		document.getElementById("gamediv").appendChild(this.canvas);
		//document.body.insertBefore(this.canvas, document.body.childNodes[0]);
		this.draw = setInterval(pauseCheck, drawint); //draw interval / calculation interval
		this.update = setInterval(GameUpdate, drawint);
		window.addEventListener("keydown", function(e){
			myGameArea.key = e.keyCode;
		})
		window.addEventListener("keyup", function(e){
			myGameArea.key = false;
		})
	},
	clear : function(){
		this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
	},
	stop : function(){
		clearInterval(this.draw);
	}
}

function component(width, height, color, x, y){
	this.width = width;
	this.facing = 0;
	this.height = height;
	this.speedX = 0;
	this.speedY = 0;
	this.SpeedMult = 20;
	this.x = x;
	this.y = y;
	this.update = function(){
		ctx = myGameArea.context;
		ctx.fillStyle = color;
		ctx.fillRect(this.x, this.y, this.width, this.height);
	}
	this.newPos = function(){
		this.x += this.speedX * this.SpeedMult;
		this.y += this.speedY * this.SpeedMult;
		this.leftSide = this.x;
		this.rightSide = this.x + this.width;
		this.topSide = this.y;
		this.botSide = this.y + this.height;
	}
	
}

function powerup(width, height, color, x, y){
	component.call(this, width, height, color, x, y);
	this.respawn = function(){
		if (this.dead == true){
			score++;
			getTailSpawn();
			this.x = 20 + getSize(Math.floor(Math.random()*(gameWid - 40)));
			this.y = 20 + getSize(Math.floor(Math.random()*(gameHei - 40)));
			this.dead = false;
		}
	}
	this.dead = false;
}

function moveSnake(){
	if(snakeArray.length > 1){
		for (var i = 1; i < snakeArray.length; i++){
			snakeArray[snakeArray.length - i].facing = snakeArray[snakeArray.length - i - 1].facing;
			snakeArray[snakeArray.length - i].x = snakeArray[snakeArray.length - i - 1].x;
			snakeArray[snakeArray.length - i].y = snakeArray[snakeArray.length - i - 1].y;
		}
	}
}

function getTailSpawn(){
	if (snakeArray[snakeArray.length - 1].facing == 1){
		let x = snakeArray[snakeArray.length - 1].x - 20;
		let y = snakeArray[snakeArray.length - 1].y;
		snakeArray[snakeArray.length] = new component(20, 20, "red", x, y);
		snakeArray[snakeArray.length - 1].facing = snakeArray[snakeArray.length - 2].facing;
	}else if(snakeArray[snakeArray.length - 1].facing == 2){
		let x = snakeArray[snakeArray.length - 1].x;
		let y = snakeArray[snakeArray.length - 1].y - 20;
		snakeArray[snakeArray.length] = new component(20, 20, "red", x, y);
		snakeArray[snakeArray.length - 1].facing = snakeArray[snakeArray.length - 2].facing;
	}else if (snakeArray[snakeArray.length - 1].facing == 3){
		let x = snakeArray[snakeArray.length - 1].x + 20;
		let y = snakeArray[snakeArray.length - 1].y;
		snakeArray[snakeArray.length] = new component(20, 20, "red", x, y);
		snakeArray[snakeArray.length - 1].facing = snakeArray[snakeArray.length - 2].facing;
	}else if (snakeArray[snakeArray.length - 1].facing == 4){
		let x = snakeArray[snakeArray.length - 1].x;
		let y = snakeArray[snakeArray.length - 1].y + 20;
		snakeArray[snakeArray.length] = new component(20, 20, "red", x, y);
		snakeArray[snakeArray.length - 1].facing = snakeArray[snakeArray.length - 2].facing;
	}
	var counterDiv = document.getElementById("dropbut");
	counterDiv.innerHTML = score;
	console.log("pog");
}


function resetGame(){
	sendscore();
	score = 0;
	myGameArea.clear();
	snakeArray[0].speedX = 0;
	snakeArray[0].speedY = 0;
	snakeArray = [];
	startGame();
	
}

function checkCollision(){
	
	if (snakeArray[0].x + snakeArray[0].width > gameWid - 20) {
		myGameArea.stop();
		resetGame();
	}else if(snakeArray[0].x	< 20){
		myGameArea.stop();
		resetGame();
	}else if(snakeArray[0].y < 20){
		myGameArea.stop();
		resetGame();
	}else if(snakeArray[0].y + snakeArray[0].height > gameHei){
		myGameArea.stop();
		resetGame();
	}
	if(snakeArray[0].leftSide == apple.x && snakeArray[0].topSide == apple.y){
		apple.dead = true;
	}
	for(var i = 4;i<snakeArray.length;i++){
		if(snakeArray[0].x == snakeArray[i].x && snakeArray[0].y == snakeArray[i].y){
			myGameArea.stop();
			resetGame();
			console.log("ded");
		}
	}
}

function draw(){	//called every second
	// debug();
	myGameArea.clear();
	//changeFacing();
	apple.respawn();
	//background.update();
	apple.update();
	topWall.update(); //can move later so its drawn once
	botWall.update();
	leftWall.update();
	rightWall.update();
	checkCollision();
	snakeArray[0].newPos();
	
	moveSnake();
	for (var i = 0; i < snakeArray.length; i++){
		snakeArray[i].update();
	}
	inputbusy == false;
	
}
/*
function changeFacing(){

	if(inputdelay[curr] == 3){
		console.log("left");
		snakeArray[0].speedX = -1;
		snakeArray[0].speedY = 0;
		snakeArray[0].facing = 3;
		myGameArea.paused = false;
	}else if(inputdelay[curr] == 1){
		console.log("right");
		snakeArray[0].speedX = 1;
		snakeArray[0].speedY = 0;
		snakeArray[0].facing = 1;
		myGameArea.paused = false;
	}else if(inputdelay[curr] == 2) {
		console.log("top");
		snakeArray[0].speedY = -1;
		snakeArray[0].speedX = 0;
		snakeArray[0].facing = 2;
		myGameArea.paused = false;
	}else if(inputdelay[curr] == 1){
		console.log("bot");
		snakeArray[0].speedY = 1;
		snakeArray[0].speedX = 0;
		snakeArray[0].facing = 4;
		myGameArea.paused = false;
	}
}

*/

// function debug(){
	// console.log("left-right: " + snakeArray[0].leftSide + ":" + snakeArray[0].rightSide + 
	// "  top-bot: " + snakeArray[0].topSide + ":" + snakeArray[0].botSide);
	// console.log(snakeArray[0].facing);
	// if(snakeArray[1]){
	// console.log(snakeArray[1].x + ":" + snakeArray[1].y);
	// }
// }


function GameUpdate(){ //called every 20ms //checks for user input
	if (myGameArea.key && myGameArea.key == 32){
		myGameArea.paused = true;		
	}

	if (myGameArea.key && myGameArea.key == 65 || myGameArea.key && myGameArea.key == 37) {
		if(snakeArray[0].facing != 1 && inputbusy == false){
		snakeArray[0].speedX = -1;
		snakeArray[0].speedY = 0;
		snakeArray[0].facing = 3;
		myGameArea.paused = false;
		inputbusy == true
		}
	}
	if (myGameArea.key && myGameArea.key == 68 || myGameArea.key && myGameArea.key == 39) {

		if(snakeArray[0].facing != 3 && inputbusy == false){
		snakeArray[0].speedX = 1;
		snakeArray[0].speedY = 0;
		snakeArray[0].facing = 1;
		myGameArea.paused = false;
		inputbusy == true
		}
	}
	if (myGameArea.key && myGameArea.key == 87 || myGameArea.key && myGameArea.key == 38) {
	
		if(snakeArray[0].facing != 4 && inputbusy == false){
		snakeArray[0].speedY = -1;
		snakeArray[0].speedX = 0;
		snakeArray[0].facing = 2;
		myGameArea.paused = false;
		inputbusy == true
		}
	}
	if (myGameArea.key && myGameArea.key == 83 || myGameArea.key && myGameArea.key == 40) {
		if(snakeArray[0].facing != 2 && inputbusy == false){
		snakeArray[0].speedY = 1;
		snakeArray[0].speedX = 0;
		snakeArray[0].facing = 4;
		myGameArea.paused = false;
		inputbusy == true;
		}
	}
	
}
	
	


function pauseCheck(){
	if(myGameArea.paused == false){
		draw();
	}else{
		//paused
	}
}

window.onload = function(){
	startGame();
	document.getElementById("gamehelp").addEventListener("mouseover", showhelp);
	document.getElementById("gamehelp").addEventListener("mouseout", hidehelp);
	document.getElementById("myRange").addEventListener("click", changespeed);
	
}

function changespeed(){
	drawint = 300 - document.getElementById("myRange").value;
	myGameArea.stop();
	myGameArea.draw = setInterval(pauseCheck, drawint);
}

function showhelp(){
	myGameArea.paused = true;
	document.getElementById("dropcontent").style.display = "block";
}

function hidehelp(){
	document.getElementById("dropcontent").style.display = "none";
}

function recievedata(s){
	console.log(s);
}


function sendscore(){ //sends the score towards php script
	var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log("sent score");
			console.log(this.responseText);				//response from writing message(sent)
		}
	};
	xhttp.open("POST", "/games/snake/snakescore.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("score="+score);	
}
