<?php
include('config.php');

    $fetch = "SELECT * FROM `alerts` ORDER BY DateTime DESC";
    
    $fetch_query = mysqli_query($conn, $fetch);
    $fetch_numrows = mysqli_num_rows($fetch_query);
    if ($fetch_numrows > 0){
        $data = [];
        // echo "inside this loop<br>";
         while($row = mysqli_fetch_assoc($fetch_query)) {
            // if($_POST["data"] == "temp"){
                
           $data[] = $row;
        }
        echo json_encode(array("response"=>"success","data"=>$data));
    }
    else{
        echo json_encode(array("response"=>"error","data"=>"No data to show." ));
    }


?>