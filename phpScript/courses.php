<?php 
        include ('connection.php');

        $id=$_SESSION['id'];
        $query="SELECT CONCAT(Courses.code,'/',Courses.course) as course, Courses.ID_C as id
                FROM Courses JOIN Enrollments
                ON Courses.ID_C =Enrollments.ID_C
                WHERE $id=Enrollments.ID_U";
?>

<?php 
        if($result=$conn->query($query)){
                while($row=$result->fetch_array()){
                        echo "<div class='w3-card-2 w3-container w3-padding' style='margin:10px;margin-left:26%'>";
                        echo "<a href='course.php?id=".$row["id"]."&courseTitle=".$row["course"]."' class='w3-xlarge w3-text-black' style='text-decoration:none'> ".$row["course"];
                        echo "</div>";		
                }   
        }
?>