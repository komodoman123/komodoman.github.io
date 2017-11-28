<?php
	include ('connection.php');
	include ('startSession.php');

	$query="SELECT username FROM users";
	if(isSet($_POST['login'])){
		
	 $name=$_POST['username'];
	 $pass=$_POST['password'];
		if(isSet($name) && $name != ""){
			$query .= " WHERE username='$name'";
			$result=$conn->query($query);
			$row=$result->fetch_row();
			if($row["0"]==$name){
				$query= "SELECT pass FROM users WHERE username='$name'";
				$result=$conn->query($query);
				$row=$result->fetch_row();
				if($row["0"]==$pass){
					$query="SELECT Users.ID_U as id,Users.username as username,
									Users.pass as pass, Users.userID as userid,
									Users.name as name, UserGroups.name as position
							FROM Users JOIN UserGroups
							ON USers.ID_UG=UserGroups.ID_UG
							WHERE Users.username='$name'";
					$result=$conn->query($query);
					$row=$result->fetch_row();
					$_SESSION['id']=$row["0"];
					$_SESSION['username']=$row["1"];
					$_SESSION['password']=$row["2"];
					$_SESSION['userID']=$row["3"];
					$_SESSION['name']=$row["4"];
					$_SESSION['position']=$row["5"];
				
					$query="select usergroups.name from usergroups join users on usergroups.ID_UG=users.ID_UG where username='$name'";
					$result=$conn->query($query);
					$row=$result->fetch_row();
					if($row["0"]=='student'){
						header("Location: pages/student/std.php");
						exit();
					}else if($row["0"]=='lecturer'){
						header("Location: pages/lecturer/lct.php");
						exit();
					}
				}else{
					echo '<script language="javascript">';
					echo 'alert("Wrong Password")';
					echo '</script>';
				}

			}
			else{

				echo '<script language="javascript">';
				echo 'alert("Wrong Username")';
				echo '</script>';
			}
		}


	}

?>
