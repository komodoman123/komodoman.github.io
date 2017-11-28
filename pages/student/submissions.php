<!-- include connection -->
<?php
	include "../../phpScript/connection.php";
	include "../../phpScript/startSession.php";
	
	if(isset($_POST['submitFile'])){
		if(file_exists($_FILES['submissionUp']['tmp_name'])){
			$courseCode = $_SESSION['courseCode'];
			$activity = $_SESSION['actId'];
			$oldname = $_FILES['submissionUp']['tmp_name'];
			$path = 'C:\\xampp\htdocs\TUGAS\IDE\upload\\assignment\\'.$courseCode.'\\answer\\';
			//$path = realpath($path);
			if(!file_exists($path)){
				mkdir($path, 077, true);
			}
			$newname = "$path" . $_FILES['submissionUp']['name'];
			echo "$newname";
			move_uploaded_file($oldname, $newname);
			$newname = "../../upload/assignment/".$courseCode."/answer/".$_SESSION['id']."".$_FILES['submissionUp']['name'];
			$newname = trim(json_encode($newname, JSON_NUMERIC_CHECK), '"');
			$date = date('Y-m-d', time());
			$query = "INSERT INTO submissions (ID_SUB, ID_A, ID_U, submitTime, fileDirectory) VALUES('', '$activity',".$_SESSION['id'].", '$date', '$newname')";
			if($conn->query($query)){
				$query = "SELECT * FROM activities WHERE ID_A = '$activity'";
				$res = $conn->query($query);
				$row = $res->fetch_array();
				$num = $row['submissions'];
				$num = $num + 1;
				$query = "UPDATE activities SET submissions = '$num' WHERE ID_A = '$activity'";
				if($conn->query($query)){
					$_SESSION['courseCode'] = null;
					$courseTitle = $_SESSION['courseTitle'];
					$courseId = $_SESSION['courseId'];
					header ("Location: course.php?id=$courseId&courseTitle=$courseTitle");
				}
				else{
					echo $conn->error;
				}
			}
			else{
				echo $conn->error;
			}
		}
	}
	if(isset($_POST['editFile'])){
		if(file_exists($_FILES['submissionUp']['tmp_name'])){
			$courseCode = $_SESSION['courseCode'];
			$activity = $_SESSION['actId'];
			$idU = $_SESSION['id'];
			$oldname = $_FILES['submissionUp']['tmp_name'];
			$path = 'C:\\xampp\htdocs\TUGAS\IDE\upload\\assignment\\'.$courseCode.'\\answer\\'.$_SESSION['id'].'';
			//$path = realpath($path);
			/*if(!file_exists($path)){
				mkdir($path, 077, true);
			}*/
			$newname = "$path" . $_FILES['submissionUp']['name'];
			//echo "$newname";
			move_uploaded_file($oldname, $newname);
			$newname = "../../upload/assignment/".$courseCode."/answer/".$_SESSION['id']."".$_FILES['submissionUp']['name'];
			$newname = trim(json_encode($newname, JSON_NUMERIC_CHECK), '"');
			$date = date('Y-m-d', time());
			echo "$newname";
			$query = "UPDATE submissions SET fileDirectory = '$newname' WHERE ID_A = '$activity' AND ID_U = '$idU'";
			if($conn->query($query)){
				$_SESSION['courseCode'] = null;
				$courseTitle = $_SESSION['courseTitle'];
				$courseId = $_SESSION['courseId'];
				header ("Location: course.php?id=$courseId&courseTitle=$courseTitle");
			}
			else{
				echo $conn->error;
			}
		}
	}
	$query = "SELECT * FROM courses WHERE ID_C = ".$_GET['courseCode']."";
	$res = $conn -> query($query);
	$row = $res -> fetch_array();
	$_SESSION['courseCode'] = $row['code'];
	$_SESSION['courseId'] = $_GET['courseCode'];
	$_SESSION['actId'] = $_GET['id'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>IDE</title>
		<!-- include style -->
		<?php
			include "../../layout/style.php";
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
	</head>
	
	<body>
		<?php $myCourses = false ?>
		<!-- include header -->
		<?php
			include "../../layout/header.php";
		?>
		<div class="w3-main">
			<!-- include sidebar -->
			<?php
				include "../../layout/sidebar.php";
			?>
			<div class = "w3-main-content"  style = "margin-top : -45.4%; margin-left: 10%">
					<?php
						$idA = $_GET['id'];
						$query1 = "SELECT * FROM activities where ID_A = $idA";
						$query2 = "SELECT * FROM submissions where ID_A = $idA AND ID_U = ".$_SESSION['id']."";
						$res1 = $conn -> query($query1);
						$res2 = $conn -> query($query2);
						$row1 = $res1 -> fetch_array();
						$row2 = $res2 -> fetch_array();
						echo "<div class='w3-panel w3-gray titleCourse'>";
                        echo "<h3>".$row1['title']."</h3>";
                        echo "</div>";
                        if($row1['fileDir'] != ""){
	                        $path = $row1['fileDir'];
	                        echo "</br><p class='itemCourse'><a href= '$path' download>".$row1['title']."</a></p>";
	                    }
	                    echo "<table border = 2>";
	                    echo "<tr>";
	                    echo "<th>Due Date</th>";
	                    echo "<td>".$row1['dateClose']."</td>";
	                    echo "</tr>";
	                    $num = count($row2);
	                    if($num > 0){
		                    echo "<tr>";
		                    echo "<th>File submissions</th>";
		                    echo "<td>".$row2['submitTime']."</td>";
		                    echo "</tr>";
		                    echo "<tr>";
		                    $path = $row2['fileDirectory'];
		                    echo "<td colspan = 2><a href= '$path' download>Submission</a></td>";
		                    echo "</tr>";
		                    echo "</table>";
		                    echo "<button class = 'w3-btn editBtn'>Edit Submissions</button>";
		                }
		                else{
		                	echo "</table>";
		                	echo "<button class = 'w3-btn submitBtn'>Add Submissions</button>";
		                	/*echo "<form method = 'post' action = 'submissions.php' enctype='multipart/form-data'>";
	                    	echo "<p>Upload files</p><br><input type = 'file' name = 'fileUp' id = 'fileUp'>";
	                    	echo "</form>";*/
		                }
					?>
					<div class = "w3-modal add-modal" id = "addFile">
						<div class = "w3-modal-content" style = "padding: 10px">
							<span class = "close">&times;</span>
								<form method = 'post' action = 'submission.php' enctype='multipart/form-data'>
				                    <p>Upload files</p><br>
				                    <input type = 'file' name = 'submissionUp' id = 'submissionUp'><br>
				                    <input class = 'w3-btn' type = 'submit' name = 'submitFile' value = 'Submit File'>
							</form>
						</div>
					</div>
					<div class = "w3-modal add-modal" id = "editFile">
						<div class = "w3-modal-content" style = "padding: 10px">
							<span class = "close">&times;</span>
								<form method = 'post' action = 'submission.php' enctype='multipart/form-data'>
				                    <p>Upload files</p><br>
				                    <input type = 'file' name = 'submissionUp' id = 'submissionUp'><br>
				                    <input class = 'w3-btn' type = 'submit' name = 'editFile' value = 'Submit File'>
							</form>
						</div>
					</div>
			</div>
		</div>
	</body>
	<script>
		$('body').on('click', '.submitBtn', function(){
			$('#addFile').modal('show');
		});
		$('body').on('click', '.editBtn', function(){
			$('#editFile').modal('show');
		});
		$('span').click(function(){
			$('.add-modal').modal('hide');
		})
	</script>
</html>