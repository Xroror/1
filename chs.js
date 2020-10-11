const WebSocket = require('ws');
const mysql = require('mysql');
const fs = require('fs');

const domain = "46.10.191.25"
const imgpath = "\\"


const emotelink = `http://${domain}/img/emotes/`;
const derpsmile = `<img class = "emotes" src = "${emotelink}derpsmile.png">`;
const reversesmile = `<img class = "emotes" src = "${emotelink}backwardsderp.png">`;
const sadderp = `<img class = "emotes" src = "${emotelink}sadderp.png">`;
const suprised = `<img class = "emotes" src = "${emotelink}suprise.png">`;
const widesmile = `<img class = "emotes" src = "${emotelink}widesmile2.png">`;

const wss = new WebSocket.Server({host: "0.0.0.0", port: 9999 });

console.log('\033[2J'); //clear console

client_list = new Object();

conn = mysql.createConnection({
	host:"localhost",
	user:"root",
	password:"",
	database:"message_db"
});

conn.connect(function(err){
	if(err){throw err;}
	console.log('\x1b[32m%s\x1b[0m','DB CONNECTED!');
	console.log('\x1b[32m%s\x1b[0m','Server listening for clients!');
});

wss.on('connection', function connection(ws, req){
	
	ws.on('message', function incoming(message){
		if(message[0] == '/'){
			this.isAlive = true;
			confirmSessionID(ws, message.substr(1));
		}else if (message[0] == '`'){
			message = message.slice(1); //had problems with split
			let receiversSTR = message.substring(0, message.indexOf("`"));
			let actualmessage = message.substring(message.indexOf("`")+1);
			let receiversARR = receiversSTR.split(",");
			if(actualmessage.startsWith('data:image/')){
				actualmessage = uploadIMAGE(actualmessage);
			}
			sendMessage(receiversARR, ws, actualmessage);
			logmessage(getNameFromSocket(ws), receiversARR, actualmessage);
			
		}else if(message.startsWith("$!getnewhtml")){
			let users = message.substr(message.indexOf(":")+1);
			ws.send(sendnewchatwindow(users, null));
		}
	});

	ws.on('close', function closeconn(){
		let name = getNameFromSocket(ws);
		delete client_list[name];
		console.log(name + " disconnected!");
	});

	ws.on('pong', beatingheart); //ping-pong
});

function sendnewchatwindow(acc_nick, messageHTML){
	let htmldelim = `!newchat:`;
	let html = `<div class = 'chatdiv' id ='${acc_nick}'</div>
				<span class = 'openchat'>${acc_nick}</span>
				<div class = 'chathide'>
				<div class = 'chattext'>
				${messageHTML}
				</div>
				<form id = '${acc_nick}' class = 'typing'>
				<input class = 'messagebox' type = 'text' placeholder = 'Your message'>
				<input type = 'submit' value = 'send'>
				</form>
				</div>
				</div>
				</br>`;
	return htmldelim+html;
}

function confirmSessionID(ws, id){
	var sql = `SELECT acc_nick FROM \`auch\`.\`accounts\` WHERE acc_chatsession = '${id}'`;

	conn.query(sql, function(err, result){
		if(err) throw err;
		if(result.length){
			var name = result[0].acc_nick;
			addClientSOCKET(ws, name);
			checkForUserTable(name, ws); //create table to store chat if missing
			
		}else{
			return;
		}
		
	});
}


function getRandString(len){
	var name = "";
	var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	var charslen = chars.length-1;
	for(var i = 0; i<len;i++){
		name = name.concat(chars[Math.floor(Math.random()*charslen)]);
	}
	return name;
}

function uploadIMAGE(message){
	var data = message.substring(message.indexOf(","), message.length);
	var decodedimg = Buffer.from(data, 'base64');
	var filename = getRandString(20);
	var path = `C:\\xampp\\htdocs\\img\\chat\\${filename}.jpeg`;

	fs.writeFile(path, decodedimg, function(err){
		if(err)throw err;
		
	});
	return `upimg${filename}`;
}

function getchatlogs(name, ws){
	let sql = `SELECT * FROM \`${name.toLowerCase()}\` ORDER BY \`last_activity\` DESC `;
	conn.query(sql, function(err, result){
		if(err) throw err;
		
		let wsname = getNameFromSocket(ws);
		for(let i = 0;i<result.length;i++){
			let names = result[i].participants;
			let chat_id = result[i].chat_id;
			let namearr = names.split(",");
			if(namearr.length>2){
				//
			}else{
				names = names.replace(wsname, "").replace(",", "");
			}
			let messageHTML = "";
			if(chat_id != null){
				let sql = `SELECT * FROM \`${chat_id}\` ORDER BY \`id\` DESC LIMIT 20`;
				conn.query(sql, function(err, result2){
					if(err) throw err;
					let r2len = result2.length;
					if(r2len > 1){
						for(let f = r2len-1;f>=0;f--){
							let message = result2[f].message;
							message = insertIMG(message);
							message = insertEmoticons(message);
							if(result2[f].sender == wsname){
								newHTML = `<div class = 'mymes'>${message}</div></br>`;
							}else{
								newHTML = `<div class = 'recmes'>${message}</div></br>`; //tooltips for time and sender
							}
							messageHTML = messageHTML+newHTML;			
						}
					ws.send(sendnewchatwindow(names, messageHTML));
					}
				});
			}

			
		}
	});
}



function logmessage(sender, receivers, message){
	if(!receivers.includes(sender)){
		receivers.push(sender); // all participants in the chat
	}
	
	receivers.sort();
	let chat_id = getRandString(40);
	var reclen = receivers.length;
	let sql = `SELECT * FROM \`${sender.toLowerCase()}\` WHERE participants = '${receivers.toString()}'`;
	conn.query(sql, function(err, result){
		if(err) throw err;
		if(result.length > 0){
			let chat_id = result[0].chat_id; // has id already
			checkforchattable(chat_id, receivers, sender, message);
		}else{
			for(let i = 0;i<reclen;i++){
			let sql = `INSERT INTO \`${receivers[i].toLowerCase()}\` (participants, chat_id) VALUES ('${receivers.toString()}', '${chat_id}')`;
			conn.query(sql, function(err, result){
				if(err) throw err;
			});
			}
			checkforchattable(chat_id, receivers, sender, message);
		}
	});
}

function checkforchattable(chat_id, receivers, sender, message){
	let sql = `SELECT * FROM information_schema.tables WHERE table_schema = 'message_db' AND table_name = '${chat_id}' LIMIT 1;`
	conn.query(sql, function(err, result){
		if(err) throw err;
		if(result.length > 0){
			LOGtoDB(chat_id, receivers, sender, message);
			
		}else{ //IF NOT EXISTS because async function made it so the timing between the loop and query execution time spit TABLE EXISTS error 
			let sql = `CREATE TABLE IF NOT EXISTS \`${chat_id}\` ( 
			  \`id\` int(11) NOT NULL AUTO_INCREMENT,
			  \`participants\` varchar(255) DEFAULT NULL,
			  \`sender\` varchar(45) DEFAULT NULL,
			  \`sent_on\` datetime NULL DEFAULT NULL,
			  \`status\` varchar(4) DEFAULT NULL,
			  \`message\` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (\`id\`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;`
			conn.query(sql, function(err, result){
				if(err) throw err;
				LOGtoDB(chat_id, receivers, sender, message);
				
			});
		}

		
	});
}

function LOGtoDB(chat_id, receivers, sender, message){
	let status = "sent";
	let sent_on = new Date().toISOString().slice(0, 19).replace('T', " ");
	let sql = `INSERT INTO \`${chat_id}\` (\`participants\`, \`sent_on\`,  \`sender\`, \`status\`, \`message\`) VALUES('${receivers}', '${sent_on}', '${sender}', '${status}', '${message}')`;
	conn.query(sql, function(err, result){
	if(err) throw err;
	});
	for(let i = 0;i<receivers.length;i++){
		let sql2 = `UPDATE \`${receivers[i]}\` SET \`last_activity\` = '${sent_on}' WHERE \`chat_id\` = '${chat_id}'`;
		conn.query(sql2, function(err, result){
			if(err) throw err;
		});
	}
	
}

function checkForUserTable(name, ws){
	let sql = "SELECT * FROM information_schema.tables WHERE table_schema = 'message_db' AND table_name = '"+name.toLowerCase()+"' LIMIT 1;"
	conn.query(sql, function(err, result){
		if(err) throw err;
		if(result.length > 0){
			getchatlogs(name, ws);
			//there is a table
			//log connection?
		}else{
			
			let sql = `CREATE TABLE \`${name.toLowerCase()}\` (
						\`id\` int(11) NOT NULL AUTO_INCREMENT,
						\`chat_id\` varchar(45) DEFAULT NULL,
						\`last_activity\` datetime DEFAULT NULL,
						\`participants\` varchar(255) DEFAULT NULL,
						PRIMARY KEY (\`id\`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;`;

			conn.query(sql, function(err, result){
				if(err)throw err;
				console.log("Creating Table for "+ name);
				getchatlogs(name, ws);
			});
		}
	});
}

function getNameFromSocket(ws){
	return Object.keys(client_list).find(key => client_list[key] === ws);
}

function insertEmoticons(s){
	s = s.replace(/:O/g, suprised);
	s = s.replace(/:D/g, widesmile);
	s = s.replace(/\(:/g, reversesmile);
	s = s.replace(/:\(/g, sadderp);
	s = s.replace(/:\)/g, derpsmile); // replace :) with link
	return s;
}

function insertIMG(s){
	if(s.startsWith('upimg')){
		var file = s.replace("upimg", "");
		var s = `<img class = 'upimg' src = 'http://${domain}/img/chat/${file}.jpeg' onclick = 'window.open(this.src)'>`
	}
	return s;
}

function sendMessage(receivers, ws, message){
	
		var sender = getNameFromSocket(ws);
		console.log(sender + ":" + message + " to " + "\"" + receivers.toString() + "\"");
		var message = insertIMG(message);
		var message = insertEmoticons(message);
		let sentmessageHTML = `<div class = 'mymes'>${message}</div></br>`;
		var receivedmessageHTML = `<div class = 'recmes'>${message}</div></br>`;
		if(receivers.length>1){ //group chat - send all names 
			if(!receivers.includes(sender)){
				receivers.push(sender);
				receivers.sort();
			}			
			var messagetosend = receivers.toString()+":"+receivedmessageHTML;
			var confirmsend = receivers.toString()+":"+sentmessageHTML;
		}else{ // one on one chat 
			var messagetosend = sender+":"+receivedmessageHTML;
			var confirmsend = receivers+":"+sentmessageHTML;
		}
		
		
		ws.send(confirmsend);//send the message to sender to display what is sent
	for(var i = 0;i<receivers.length;i++){
		if(typeof(client_list[receivers[i]]) === undefined){
			//user is offline ???
		}else{
			if(receivers[i] != sender){ // exclude the sender's name so he doesnt get it twice
				client_list[receivers[i]].send(messagetosend); // send the message to the target user
			}
			
		}
	}
	
	
}

function addClientSOCKET(ws, name){ //add the name of the connected client
	if(typeof(client_list[name]) === "undefined"){
		client_list[name] = ws;
		//ws.send("connected as "+name);
		console.log(name + " connected!");
	}else{
		//already connected, prevent double connection?
	}
	
	
}

function beatingheart(){
	this.isAlive = true;
}

function noop(){
	//console.log(getname(this) + " pong");
	// is it needed?
}

const pinginterval = setInterval(function ping(){
	wss.clients.forEach(function each(ws){

		if(ws.isAlive === false){
			return ws.terminate();
		}
		ws.isAlive = false;
		ws.ping();
		

	});
}, 30000); // is this even needed ?

wss.on('close', function close(){
	clearInterval(pinginterval);
});