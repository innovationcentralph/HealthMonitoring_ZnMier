<?php
include('config.php');
session_start();
date_default_timezone_set('Asia/Singapore');
if(isset($_SESSION[$sessionName]['userID']) && isset($_GET["id"])){ 
    $patientID = $_GET["id"];
    $sql = "select * from patientlist  where Patient = '$patientID'";

    
    // echo $sql;
    $data = [];
    $scan_query = mysqli_query($conn, $sql);
    $scan_numrows = mysqli_num_rows($scan_query);
    if ($scan_numrows > 0){
        while($row = mysqli_fetch_assoc($scan_query)) {
            $data[] = $row;
        }
    }
     echo json_encode(array("response"=>"success","data"=>json_encode($data)));
}
else{
    echo json_encode(array("response"=>"error","data"=>'You cannot access this page.'));
}
?>
