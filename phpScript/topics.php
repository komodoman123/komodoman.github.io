<?php
include ('startSession.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $courseTitle = $_GET['courseTitle'];
    echo "<div class='w3-panel w3-grey' style='margin:10px;margin-left:26%'>";
    echo "<h3>$courseTitle</h3>";
    echo "</div>";
   
    $query = "SELECT * FROM activities WHERE ID_C = '$id'";
    $arr=array();
    $x=1;
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_array()) {
        $arr[$x]=$row;
        $x++;
        }
    }
    $x=1;
    $arrlength = count($arr);
   
    for($i=1; $i<=10; $i++){
        echo "<div class='w3-panel w3-card w3-white' style='margin:10px;margin-left:26%'>  <p class='w3-text-black'><i class='fa fa-newspaper-o'></i>&nbsp; TOPIC $i</p>";
        for($j=1; $j<=$arrlength; $j++){

                if($arr[$j]['topic']==$i){
                    if($arr[$j]['ID_AT']==2){
                        echo " <a href=".$arr[$j]['fileDir']." download><p class='w3-text-black'><i class='fa fa-file' aria-hidden='true'></i>&nbsp;".$arr[$j]['title']."</p></a>";
                    }
                    else{
                        echo "<a href= '../student/submission.php?id=".$arr[$j]['ID_A']."&courseCode=".$id."&actTitle=".$arr[$j]['title']."'><p class='w3-text-black'><i class='fa fa-pencil' aria-hidden='true'></i>&nbsp;".$arr[$j]['title']."</p></a>";
                         
                    }
                   
                }
            
        
        
        }
        if($_SESSION['position']=='lecturer'){
            echo "<button class='w3-btn w3-grey w3-hover-black add' id='".$i."' onclick=\"document.getElementById('addActModal').style.display='block'\" >Add Activity</button>";
        }
        echo "</div>";
    }
    
}
?>