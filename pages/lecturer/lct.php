<!-- include connection -->
<?php
	include ('../../phpScript/connection.php');
	include ('../../phpScript/startSession.php');
	include ('../../phpScript/signedIn.php');
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>IDE</title>
		<!-- include style -->
		<?php
			include ('../../layout/style.php');
		?>
	</head>
	
	<body>
		<?php $myCourses = false ?>
		<!-- include header -->
		<?php
			include ('../../layout/header.php');
		?>
		<div class="w3-main">
			<!-- include sidebar -->
			<?php
				include ('../../layout/sidebar.php');
			?>
			<div class="w3-panel w3-grey" style="margin:10px;margin-left:26%">
				<p class="w3-xlarge w3-text-black">Course overview</p>
			</div> 
			
			<?php
				include ('../../phpScript/courses.php');
			
			?>
			
		</div>
	</body>
</html>