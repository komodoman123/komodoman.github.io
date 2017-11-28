
<?php
	include ('../../phpScript/connection.php');
	include ('../../phpScript/startSession.php');
	include ('../../phpScript/signedIn.php');
	echo $_GET['addType'];


	if(isset($_GET['submit'])){
		$GLOBALS['courseID'] =  $_GET['courseID'];
		$GLOBALS['topic']  = $_GET['topic'];
		$GLOBALS['courseTitle'] = $_GET['courseTitle'];
		$GLOBALS['addType'] =$_GET['addType'];
		if($addType=='assignments'){
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
				$dir="../../upload\\".$addType."\\".$codeCourse;
				
						
			if(!file_exists($dir)){
				mkdir($dir, 077, true);
			}
			$newname = "../../upload"."\\".$addType."\\".$codeCourse."\\" .$_FILES['upfile']['name'];
				move_uploaded_file($oldname, $newname);
				$dirname = "../../upload"."\\\\".$addType."\\\\".$codeCourse."\\\\" .$_FILES['upfile']['name'];

			}
			else{
				$dirname = "";
			}
			$query = "INSERT INTO activities (ID_A, ID_AT, ID_C, dateOpen, dateClose, submissions, title, topic, fileDir) VALUES('', '$act', '$courseID', '$start', '$end', '0', '$name', '$topic', '$dirname')";
		}
		else{ 
			if($_FILES['upfile']['name'] != ""){
				$oldname = $_FILES['upfile']['tmp_name'];
				$dir="../../upload\\".$addType."\\".$codeCourse;

			
				if(!file_exists($dir)){
					mkdir($dir, 077, true);
				}
				$newname = "../../upload"."\\".$addType."\\".$codeCourse."\\" .$_FILES['upfile']['name'];
				move_uploaded_file($oldname, $newname);
				$dirname = "../../upload"."\\\\".$addType."\\\\".$codeCourse."\\\\" .$_FILES['upfile']['name'];
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
			<div style="overflow:auto;height:70%">
				<div class="w3-panel w3-grey" style="margin:10px;margin-left:26%">
					<?php
						echo "<p class='w3-xlarge w3-text-black'>Adding a new ".$_GET['addType']."</p>";
					?>
				</div>

				<div style="margin:10px;margin-left:25%">
					<button class="w3-black w3-button w3-right w3-margin" id= "btnCollapseAll">Collapse All <i class="fa fa-caret-down" aria-hidden="true"></i></button>
					<form id="usrform" method="post" enctype="multipart/form-data">
						<div class="w3-container w3-margin-bottom">
							<fieldset >	
								<legend><button class="w3-button w3-black" id="btnGeneral">General <i class="fa fa-caret-down" aria-hidden="true"></i></button></legend>
								<div class="w3-hide" id="fsGeneral">
									<table class="w3-table w3-centered">
									<tr>
										<td><span style="color:red">Name *</span></td>
										<td><input class = "" type = "text" name = "name" style="width:100%"></td>
									</tr>
									<tr>
										<td><p class="w3-text-black">Description</p></td>
										<td><textarea rows="4" cols="50" name="description" form="usrform" style="width:100%"></textarea></td>
									</tr>
								</table>
								</div>
							</fieldset>
						</div>
						
						<?php
							if($addType== "assignments"){
								echo "<div class='w3-container w3-margin-bottom'>";
								echo "<fieldset>";
								echo "<legend><button class='w3-button w3-black' id='btnAvailibility'>Availability <i class='fa fa-caret-down' aria-hidden='true'></i></button></legend>";
								echo "<div class='w3-hide' id='fsAvail'>";
								echo "<table class='w3-centered'>";
								echo "<tr>";
								echo "<td>Allow submissions from <i class='fa fa-question-circle' aria-hidden='true'></i></td>";
								echo "<td><input class='' type = 'date'  name = 'dateStart' id = 'dateStart' disabled></td>";
								echo "<td><input type = 'checkbox' name = 'dateStartCheck' id = 'dateStartCheck'>Enable</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>Due date <i class='fa fa-question-circle' aria-hidden='true'></i></td>";
								echo "<td><input class='' type = 'date'  name = 'dateDue' id = 'dateDue' disabled></td>";
								echo "<td><input type = 'checkbox' name = 'dateDueCheck' id = 'dateDueCheck'>Enable</td>";
								echo "</tr>";
								echo "</table>";
								echo "</div>";
								echo "</fieldset>";
								echo "</div>";
							}
						?>
						<div class="w3-container w3-margin-bottom">
							<fieldset>
								<legend><button class="w3-button w3-black" id="btnContent" >Content <i class="fa fa-caret-down" aria-hidden="true"></i></button></legend>
								<div class="w3-hide" id="fsContent">
									Select files <i class='fa fa-question-circle' aria-hidden='true'></i>
									<input type = "file" name = "upfile" id = "upfile" style='margin:10px;margin-left:26%'>
								</div>
							</fieldset>
						</div>

						<div class="w3-center">
							<input class = "w3-btn" type = "submit" name = "save" value = "Save and Return to Course" >
							<input class = "w3-btn" type = "submit" name = "cancel" value = "Cancel">
						</div>
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

	$("#btnAvailibility").click(function(e){
			e.preventDefault();
			if($("#fsAvail").hasClass("w3-hide")){
				$("#fsAvail").removeClass("w3-hide").addClass("w3-show");
			} else{
				$("#fsAvail").removeClass("w3-show").addClass("w3-hide");
			}
	});

	$("#btnGeneral").click(function(e){
			e.preventDefault();
			if($("#fsGeneral").hasClass("w3-hide")){
				$("#fsGeneral").removeClass("w3-hide").addClass("w3-show");
			} else{
				$("#fsGeneral").removeClass("w3-show").addClass("w3-hide");
			}
	});

	$("#btnContent").click(function(e){
			e.preventDefault();
			if($("#fsContent").hasClass("w3-hide")){
				$("#fsContent").removeClass("w3-hide").addClass("w3-show");
			} else{
				$("#fsContent").removeClass("w3-show").addClass("w3-hide");
			}
	});

	$state = true;
	$("#btnCollapseAll").click(function(e){
			e.preventDefault();
			
			if($state == true){
				$("#fsAvail").removeClass("w3-hide").addClass("w3-show");
				$("#fsContent").removeClass("w3-hide").addClass("w3-show");
				$("#fsGeneral").removeClass("w3-hide").addClass("w3-show");
				$state = false;
			} else{
				$("#fsAvail").removeClass("w3-show").addClass("w3-hide");
				$("#fsContent").removeClass("w3-show").addClass("w3-hide");
				$("#fsGeneral").removeClass("w3-show").addClass("w3-hide");
				$state = true;
			}
	});
	</script>
</html>
