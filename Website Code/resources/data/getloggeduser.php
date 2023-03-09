<?php
include('config.php');
session_start();
if(isset($_SESSION[$sessionName]['userID'])){ 
    $nurseID = $_SESSION[$sessionName]['userID'];
    date_default_timezone_set('Asia/Singapore');
    // $sql = "select * from nurselist left join patientlist on nurselist.Nurse = patientlist.PatientNurse where Nurse = '$nurseID' ORDER BY patientlist.PatientAdmitDate ASC";

    
    $sql = "select * from nurselist  where Nurse = '$nurseID'";

    
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
