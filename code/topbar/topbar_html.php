<script type="text/javascript" src="/code/topbar/topbar.js"></script>
<link rel="stylesheet" type="text/css" href="/code/topbar/topbar.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class = "topbar">
	<div id = "NavLinksDrop">
	<button class = "NavBut" id = "NavLinksBut">Go To</button>
		<div id = "NavLinksDrop-content">
			<a href = "/">Home</a></br>
			<a href = "/showinv.php">Inventory</a></br>
			<a href = "/ah/index.php">WoW AH</a></br>
			<a href = "/games/snake/index.php">Snake</a></br>
			<a href = "/games/2048/index.php">2048</a></br>
			<a href = "/games/rps/index.php">R-P-S</a>
		</div>
	</div>

	<div class = "chatdivbut">
		<i class = "material-icons" style = "font-size:30px">insert_comment</i>
	</div>

		<div class = 'maildiv'>
			<i id = 'mailbut' class="material-icons" style="font-size:32px">mail_outline</i>
				<div class = 'mailcontent'>
					
				</div>
		</div>
	<div class = "dropdown">
		<button class = "accbut" id = "loginbut">My account</button>
		
		<div id = "logindiv" class = "dropdown-login">
			<form action = "" onsubmit = "sendlogin()" method = "POST">
				<input class = "logINPUT" autocomplete="username" type = "text" value = "Xror" id = "username" name = "username"/> </br>
				<input class = "logINPUT" autocomplete="current-password" type = "password" id = "passwd" name = "passwd"/> </br>
				<input type = "submit" value = "Log in"/>
				<button type = "button" id = "logincbut">Sign Up</button>
			</form>
			
		</div>
		<div id = "creatediv" class = "dropdown-newacc">
			<form action = "" onsubmit = "sendnewacc()" method = "POST">
				<input class = "logINPUT" type = "text" id = "newaccname" placeholder = "Username" /> </br>
				<input class = "logINPUT" type = "password" id = "newaccpass" placeholder = "Password" /> </br>
				<input class = "logINPUT" type = "text" id = "newaccnick" placeholder = "Nickname" /> </br>
				<input type = "submit" value = "Create Account" />
				<button type = "button" id = "createlbut">Sign In</button>
			</form>
		</div>
		<div id = "loggeddiv" class = "dropdown-loggedin">
			<button type = "button" id = "invbut">See inventory</button></br>
			<button type = "submit" id = "logoutbut">Logout</button>
		</div>
	</div>
	<div id = "chatmain">
		<span id = 'chatdisconected'>You have been disconected from the chat server. Attempting to reconnect!</span>
	</div>
	
	
</div>
