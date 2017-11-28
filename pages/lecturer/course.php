<!-- include connection -->
<?php

	include ('../../phpScript/connection.php');
	include ('../../phpScript/startSession.php');
//echo $_GET['courseTitle'];
	//$currCourse=substr($_GET["courseTitle"],0,6);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>IDE</title>
		<!-- include style -->
		<?php
			include ('../../layout/style.php');
		?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

            <?php
				include ("../../phpScript/topics.php")

			?>

		</div>

		<div id="addActModal" class = "w3-modal ">
			<div class="w3-modal-content ">
				<div id="modal" class="w3-container " style="padding-top: 16px; padding-bottom: 16px;">
					<span onclick="document.getElementById('addActModal').style.display='none'"class="w3-button w3-display-topright" style="margin-right:10px">&times;</span>
					<h3>Add Activity </h3>
					<form method = "get" class = "w3-container" action = "addingActivity.php" >
						<input type = "radio" name = "addType" value = "assignments" checked="checked"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Assignment<br><br>
						<input type = "radio" name = "addType" value ="files"> <i class="fa fa-file-o" aria-hidden="true"></i> File<br><br>
						<input class = "topic" type = "hidden" name = "topic">
						<?php
							echo "<input class = 'courseID' type = 'hidden' name = 'courseID' value=".$_GET['id'].">";
							echo "<input class = 'courseTitle' type = 'hidden' name = 'courseTitle' value='".$_GET['courseTitle']."'>";
						?>
						<input type = "submit" name = "submit" value = "Add" class="w3-button w3-black">
					</form>
				</div>
			</div>
		</div>



	</body>

	<script>
		$('body').on('click', '.add', function(){
			var topik = this.id;
			$('.topic').attr('value', topik);

		});

	</script>


</html>
