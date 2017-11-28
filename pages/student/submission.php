<!-- include connection -->
<?php
	include "../../phpScript/connection.php";
	include "../../phpScript/startSession.php";
	
	$GLOBALS['submitted']=false;
	if(isset($_POST['submitFile'])){
		$GLOBALS['submitted']=true;
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
				<?php
					    echo "<div class='w3-panel w3-grey' style='margin:10px;margin-left:26%'>";
						echo "<h3>".$_GET['actTitle']."</h3>";
						echo "</div>";
						$idAct = $_GET['id'];
						$actTitle=$_GET['actTitle'];
						$query = "SELECT * FROM activities where ID_A = $idAct";
						$res = $conn -> query($query);
						$row = $res -> fetch_array();
						
						
						
                        if($row['fileDir'] != ""){
							echo "<a href=".$row['fileDir']." download='' style='margin-left:26%'><p class='w3-text-black'><i class='fa fa-file' aria-hidden='true'></i>&nbsp;".$row['title']."</p></a>";
	                    }
	                    echo "<table class='w3-table w3-bordered' style='margin-left:26%'>";
	                    echo "<tr>";
						echo "<td class='w3-border-right'>Submission status</td>";
						if($submitted==true){
							echo "<td>Submitted for grading</td>";
						}
						else{
							echo "<td>no submit</td>";
						}
						echo "</tr>";
						echo "<tr>";
						echo "<td class='w3-border-right'>Due date</td>";
						echo "<td>".$row['dateClose']."</td>";
						echo "</tr>";

						$now = new DateTime();
						$close_date = new DateTime($row['dateClose']);
						
						$interval = $close_date->diff($now);
					
						 $interval->format("%h hours, %i minutes, %s seconds");
						

						echo "<tr>";
						echo "<td class='w3-border-right'>Time Remaining</td>";
						echo "<td>". $interval->format(" %a day,%h hours, %i minutes, %s seconds")."</td>";
						echo "</tr>";
						
						$query = "SELECT * FROM submissions where ID_A = $idAct AND ID_U = ".$_SESSION['id']."";
						$res = $conn -> query($query);
						$row = $res -> fetch_array();

	                    $submission = count($row);
	                    if($submission > 0){
		                    echo "<tr>";
		                    echo "<td class='w3-border-right'>Last Modified</td>";
		                    echo "<td>".$row['submitTime']."</td>";
		                    echo "</tr>";
		                    
						    echo "<tr>";
		                    echo "<td class='w3-border-right'>File Submission</td>";
		                    echo "<td><a href= '".$row['fileDirectory']."' download=''><i class='fa fa-file' aria-hidden='true'></i>&nbsp; Your Submission</a></td>";
		                    echo "</tr>";
							echo "</table>";
							echo "<br>";
		                    echo "<button onclick="."document.getElementById('submitModal').style.display='block'"." class = 'w3-btn'  style='margin-left:26%'>Edit Submission</button>";
		                }
		                else{
							echo "</table>";
							echo "<br>";
		                	echo "<button onclick="."document.getElementById('submitModal').style.display='block'"." class = 'w3-btn'  style='margin-left:26%'>Add Submission</button>";
		                	
		                }
					?>

					<div id="submitModal" class="w3-modal" >
							<div class="w3-modal-content ">
								<div id="modal" class="w3-container " style="padding-top: 16px; padding-bottom: 16px;">
								<span onclick="document.getElementById('submitModal').style.display='none'"class="w3-button w3-display-topright" style="margin-right:10px">&times;</span>

								
								<?php 
								if ($submitted==false){
									echo "<h3>Submit file</h3>";
								}
								else {
									echo "<h3>Edit Submission</h3>";
								}
								?>
								
								<form method="post" action = 'submission.php' class="w3-container" enctype='multipart/form-data'>
								<p>Upload files</p><br>
								<input type = 'file' name = 'submitUp' id = 'submitUp'>
								<br>
								<hr>
								<input class = 'w3-btn' type = 'submit' name = 'submitFile' value = 'Submit File'>
								</form>
								
							</div>
					</div>
					
					
			
		</div>
	</body>
	
</html>