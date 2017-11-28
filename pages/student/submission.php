<!-- include connection -->
<?php
	include "../../phpScript/connection.php";
	include "../../phpScript/startSession.php";
	
	
	if(isset($_POST['submitFile'])){
		
		if(file_exists($_FILES['submitUp']['tmp_name'])){
			$courseID = $_GET['courseCode'];
			$query = "SELECT * from courses WHERE ID_C = $courseID";
			$result = $conn->query($query);
			$row = $result -> fetch_array();
			$courseCode = $row['code'];
			$idUser=$_SESSION['id'];
			
			$activityID = $_GET['id'];
			$activityTitle=$_GET['actTitle'];
			$oldname = $_FILES['submitUp']['tmp_name'];
			$dir="../../upload\\assignments\\".$courseCode.'\\answer\\';
			
			
			if(!file_exists($dir)){
				mkdir($dir, 077, true);
			}
			
			$newname = "../../upload\\assignments\\".$courseCode.'\\answer\\'.$_SESSION['id']."". $_FILES['submitUp']['name'];
			
			move_uploaded_file($oldname, $newname);
			$newname = "../../upload\\\\assignments\\\\".$courseCode.'\\\\answer\\\\'.$_SESSION['id']."". $_FILES['submitUp']['name'];
			$date = date('Y-m-d', time());
			$query = "INSERT INTO submissions (ID_SUB, ID_A, ID_U, submitTime, fileDirectory) VALUES('', '$activityID','$idUser', '$date', '$newname')";
			if($conn->query($query)){
				$query = "SELECT * FROM activities WHERE ID_A = '$activityID'";
				$res = $conn->query($query);
				$row = $res->fetch_array();
				$count = $row['submissions'];
				$count = $count + 1;
				$query = "UPDATE activities SET submissions = '$count' WHERE ID_A = '$activityID'";
				if($conn->query($query)){
					
					header ("Location: submission.php?id=$activityID&courseCode=$courseID&actTitle=$activityTitle");
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
		if(file_exists($_FILES['editUp']['tmp_name'])){
			echo "edit in";
			$courseID = $_GET['courseCode'];
			$query = "SELECT * from courses WHERE ID_C = $courseID";
			$result = $conn->query($query);
			$row = $result -> fetch_array();
			$courseCode = $row['code'];
			$idUser=$_SESSION['id'];
			
			$activityID = $_GET['id'];
			$activityTitle=$_GET['actTitle'];
			$oldname = $_FILES['editUp']['tmp_name'];
			$dir="../../upload\\assignments\\".$courseCode.'\\answer\\';
			
			
			if(!file_exists($dir)){
				mkdir($dir, 077, true);
			}
			
			$newname = "../../upload\\assignments\\".$courseCode.'\\answer\\'.$idUser."". $_FILES['editUp']['name'];
			
			move_uploaded_file($oldname, $newname);
			$newname = "../../upload\\\\assignments\\\\".$courseCode.'\\\\answer\\\\'.$idUser."". $_FILES['editUp']['name'];
			$date = date('Y-m-d', time());			
			$query = "UPDATE submissions SET fileDirectory = '$newname' WHERE ID_A = '$activityID' AND ID_U ='$idUser' ";
			if($conn->query($query)){
			//header ("Location: submission.php?id=$activityID&courseCode=$courseID&actTitle=$activityTitle");
				}
			else{
				echo $conn->error;
			}
		}
	}
	
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
							echo "<a href=".$row['fileDir']." download='' style='margin-left:26%'><p class='w3-text-black' style='margin-left:26%'><i class='fa fa-file' aria-hidden='true'></i>&nbsp;".$row['title']."</p></a>";
						}

						$query2 = "SELECT * FROM submissions where ID_A = $idAct AND ID_U = ".$_SESSION['id']."";
						$res2 = $conn -> query($query2);
						$row2 = $res2 -> fetch_array();
						$submission = count($row2);

	                    echo "<table class='w3-table w3-bordered' style='margin-left:26%'>";
	                    echo "<tr>";
						echo "<td class='w3-border-right'>Submission status</td>";
						if($submission > 0){
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
		                    echo "<button onclick="."document.getElementById('editModal').style.display='block'"." class = 'w3-btn'  style='margin-left:26%'>Edit Submission</button>";
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
					
									echo "<h3>Submit file</h3>";
								
								
								
								
								?>
								
								<form method="post"  class="w3-container" enctype='multipart/form-data'>
								<p>Upload files</p><br>
								<input type = 'file' name = 'submitUp' id = 'submitUp'>
								<br>
								<hr>
								<input class = 'w3-btn' type = 'submit' name = 'submitFile' value = 'Submit File'>
								</form>
								</div>
							</div>
					</div>

					<div id="editModal" class="w3-modal" >
							<div class="w3-modal-content ">
								<div id="modal" class="w3-container " style="padding-top: 16px; padding-bottom: 16px;">
								<span onclick="document.getElementById('submitModal').style.display='none'"class="w3-button w3-display-topright" style="margin-right:10px">&times;</span>

								
								<?php 
								
									echo "<h3>Edit Submission</h3>";
								
								?>
								
								<form method="post"  class="w3-container" enctype='multipart/form-data'>
								<p>Upload files</p><br>
								<input type = 'file' name = 'editUp' id = 'editUp'>
								<br>
								<hr>
								<input class = 'w3-btn' type = 'submit' name = 'editFile' value = 'Submit File'>
								</form>
								</div>
							</div>
					</div>
					
					
			
		</div>
	</body>
	
</html>