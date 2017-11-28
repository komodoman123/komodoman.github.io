
<?php
	include ('../../phpScript/connection.php');
	include ('../../phpScript/startSession.php');
	include ('../../phpScript/signedIn.php');



	if(isset($_GET['submit'])){
		$GLOBALS['courseID'] =  $_GET['courseID'];
		$GLOBALS['topic']  = $_GET['topic'];
		$GLOBALS['courseTitle'] = $_GET['courseTitle'];
		$GLOBALS['addType'] =$_GET['addType'];
		if($addType=='assignment'){
			$GLOBALS['act']='1';
		}else{
			$GLOBALS['act']='2';
		}

	}

	if(isset($_POST['save'])){
		$name = $_POST['name'];
		$activity = $addType;
		$topic = $topic;
		$courseID = $courseID;
		$query = "SELECT * from courses WHERE ID_C = $courseID";
		$result = $conn->query($query);
		$row = $result -> fetch_array();
		$codeCourse = $row['code'];

		if($activity == 'assignment'){
			if($_POST['dateStartCheck'] == 'on'){
				$start = $_POST['dateStart'];
			}
			if($_POST['dateDueCheck'] == 'on'){
				$end = $_POST['dateDue'];
			}
			if($_FILES['upfile']['name'] != ""){
				$oldname = $_FILES['upfile']['tmp_name'];
				$dir="../../uploads\\".$addType."\\".$codeCourse;
				
						
			if(!file_exists($dir)){
				mkdir($dir, 077, true);
			}
			$newname = "../../uploads"."\\".$addType."\\".$codeCourse."\\" .$_FILES['upfile']['name'];
				move_uploaded_file($oldname, $newname);
				$dirname = "../../uploads"."\\\\".$addType."\\\\".$codeCourse."\\\\" .$_FILES['upfile']['name'];

			}
			else{
				$dirname = "";
			}
			$query = "INSERT INTO activities (ID_A, ID_AT, ID_C, dateOpen, dateClose, submissions, title, topic, fileDir) VALUES('', '$act', '$courseID', '$start', '$end', '0', '$name', '$topic', '$dirname')";
		}
		else{ 
			if($_FILES['upfile']['name'] != ""){
				$oldname = $_FILES['upfile']['tmp_name'];
				$dir="../../uploads\\".$addType."\\".$codeCourse;

			
				if(!file_exists($dir)){
					mkdir($dir, 077, true);
				}
				$newname = "../../uploads"."\\".$addType."\\".$codeCourse."\\" .$_FILES['upfile']['name'];
				move_uploaded_file($oldname, $newname);
				$dirname = "../../uploads"."\\\\".$addType."\\\\".$codeCourse."\\\\" .$_FILES['upfile']['name'];
			}
			else{
				$dirname = "";
			}
			$query = "INSERT INTO activities (ID_A, ID_AT, ID_C, dateOpen, dateClose, submissions, title, topic, fileDir) VALUES('', '$act', '$courseID', '', '', '', '$name', '$topic', '$dirname')";
			}
				if($conn->query($query)){
					header ("Location: course.php?id=$courseID&courseTitle=$courseTitle");
				}
				else{
					echo $conn->error;
				}
			}



	if(isset($_POST['cancel'])){
		$id = $_GET['courseID'];
		$courseTitle = $_GET['courseTitle'];
		header("Location: course.php?id=$id&courseTitle=$courseTitle");
	}
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
			<div class="w3-panel w3-grey" style="margin:10px;margin-left:26%">
			<?php
				echo "<p class='w3-xlarge w3-text-black'>Adding a new ".$_GET['addType']."</p>";
				?>
			</div>

            <fieldset style="margin:10px;margin-left:26%">
			<form id="usrform"   method="post" enctype="multipart/form-data">
						<legend>General</legend>
						<p class="w3-text-black">Name</p><input class = "w3-input" type = "text" name = "name" > <br>
						<p class="w3-text-black">Description</p>
						<textarea rows="4" cols="50" name="description" form="usrform"></textarea>
					</fieldset>
					<?php
						if($addType== "assignment"){
							echo "<fieldset style='margin:10px;margin-left:26%'>";
							echo "<legend>Availability</legend>";
							echo "<p>Allow submissions from </p>";
							echo "<input class='w3-input' type = 'date'  name = 'dateStart' id = 'dateStart' disabled>";
							echo "<input type = 'checkbox' name = 'dateStartCheck' id = 'dateStartCheck'>Enable<br>";
							echo "<p>Due date </p>";
							echo "<input class='w3-input' type = 'date'  name = 'dateDue' id = 'dateDue' disabled><br>";
							echo "<input type = 'checkbox' name = 'dateDueCheck' id = 'dateDueCheck'>Enable<br>";
							echo "</fieldset>";
						}
					?>
					<fieldset style="margin:10px;margin-left:26%">
						<legend>Content</legend>
						<p>Select files</p>
						<input type = "file" name = "upfile" id = "upfile" style='margin:10px;margin-left:26%'>
					</fieldset>


					<input class = "w3-btn" type = "submit" name = "save" value = "Save and Return to Course" style='margin:10px;margin-left:26%'>
					<input class = "w3-btn" type = "submit" name = "cancel" value = "Cancel" style='margin:10px;margin-left:26%'>
				</form>
				<br>

			</div>
		</div>


	</div>
	</body>

	<script>
	$(document).ready(function(){
			$("input[name='dateStartCheck']").click(function(){
				if($(this).is(':checked')){
					$('#dateStart').prop("disabled", false);
				}
				else{
					$('#dateStart').prop("disabled", true);
				}
			});
			$("input[name='dateDueCheck']").click(function(){
				if($(this).is(':checked')){
					$('#dateDue').prop("disabled", false);
				}
				else{
					$('#dateDue').prop("disabled", true);
				}
			});

		});
	</script>
</html>
