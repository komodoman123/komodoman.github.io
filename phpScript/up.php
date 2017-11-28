<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {
	if($_FILES['upfile']['name'] != ""){
		echo "The file's original name is: ".
			$_FILES['upfile']['name'];
		echo "The file's temporary name is: ".
			$_FILES['upfile']['tmp_name'];
		echo "The file's size is: ".
			$_FILES['upfile']['size'];
	}
	else
		echo "Error: No file uploaded";
}
//echo "Your path is: " . realpath(dirname(__FILE__)) . "<br />";
if($_FILES['upfile']['name'] != ""){
    $act="assignment";
    $currentCourse="AIF313";
    $oldname = $_FILES['upfile']['tmp_name'];
    $dir="../uploads\\".$act."\\".$currentCourse;
	$newname = "../uploads"."\\".$act."\\".$currentCourse."\\" .
            $_FILES['upfile']['name'];
    mkdir($dir,0777,true);
	move_uploaded_file($oldname, $newname);
	printf("File [%s] has successfully uploaded to [%s]",
		$oldname, $newname);
}
else
	echo "Error: No file uploaded";


?>
