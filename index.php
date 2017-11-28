<?php
	include ('layout/style.php');
	
	include ('phpScript/connection.php');
	include ('phpScript/startSession.php');
	include ('phpScript/login.php');


?>

<!DOCTYPE html>
<html>
	<head>
		<title>IDE</title>
		<style>
			h1,h4,h5{
				color:white;
				font-family: candara;
			}
			button{
				font-family: candara;
			}
			

		</style>
	</head

	<body>
		<!--<?php
			if(!isset($_COOKIE["username"])) {
				echo "Cookie not set!";
			} else {
				echo "Cookie  is set!<br>";
				echo "Value is: " . $_COOKIE["username"];
			}
			?>
			-->


		<img src="img/bgImg.jpg" alt="" id ="bg">
		<div class="w3-display-left">
			<div class="w3-container">
			<h1>IDE</h1>
			<h4>Interactive Digital Learning Environment</h4>
			<h5>-Faculty of Information and Science-</h5>
			<button onclick="document.getElementById('loginModal').style.display='block'"class="w3-btn w3-grey w3-hover-black" style="opacity: 0.7">Login</button>
		</div>
	</div>

	<div class="w3-display-topright">
		<div class="w3-container" style="margin-top:10px">
		<button class="w3-btn w3-grey w3-hover-black" style="opacity: 0.7">About us</button>
		<button class="w3-btn w3-grey w3-hover-black" style="opacity: 0.7">Contact us</button>
		<button class="w3-btn w3-grey w3-hover-black" style="opacity: 0.7">Help</button>
	</div>
</div>
		<div id="loginModal" class="w3-modal" >
		<div class="w3-modal-content ">
			<div id="modal" class="w3-container " style="padding-top: 16px; padding-bottom: 16px;">
			<span onclick="document.getElementById('loginModal').style.display='none'"class="w3-button w3-display-topright" style="margin-right:10px">&times;</span>

			<h3>Login </h3>
			<form method="post" class="w3-container" >
			<input class="w3-input" type="text" placeholder="Username" name="username" value='<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];} ?>'>
			<br>
			<input class="w3-input" type="password" placeholder="Password" name="password">
			<br>
			<input type="submit" name="login" value="login" class="w3-btn">
			</form>
			<a href="#">forgot password</a> or <a href="#"> forgot username </a>

			</div>
		</div>
		</div>
	</body>
</html>
