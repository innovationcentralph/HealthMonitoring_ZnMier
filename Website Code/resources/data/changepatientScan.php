<?php
include('config.php');
session_start();
date_default_timezone_set('Asia/Singapore');
if(isset($_SESSION[$sessionName]['userID']) && isset($_POST['id'])  && isset($_POST['status'])){ 
    $nurseID = $_SESSION[$sessionName]['userID'];
    $PatientID = $_POST['id'];
    $status = $_POST['status'];
    $params = array($nurseID, $PatientID,  $status);


    $deactivatePatientQuery = "UPDATE `patientlist` SET `isActiveScan`= 0 WHERE  `PatientNurse`=?";
    $deactivatePatient = $conn->prepare($deactivatePatientQuery);
    $deactivatePatient->bind_param("s",
        $params[0]
    ); 
        
    if(!$deactivatePatient->execute()){
        echo json_encode(array("response"=>"error","data"=>'Change patient status failed.' . $deactivatePatient->error));
        $deactivatePatient->close();
        exit;           
    }
    $deactivatePatient->close();


    $activatePatientQuery = "UPDATE `patientlist` SET `isActiveScan`=? WHERE `Patient`=? and `PatientNurse`=?";
    $activatePatient = $conn->prepare($activatePatientQuery);
    $activatePatient->bind_param("iss",
        $params[2],
        $params[1],
        $params[0]
    ); 
    if(!$activatePatient->execute()){
        echo json_encode(array("response"=>"error","data"=>'Change patient status failed.' . $activatePatient->error));
        $activatePatient->close();
        exit;            
    }

    $activatePatient->close();


    if($status == "0"){
        $params[1] = "";
    }
    $setActivePatientQuery = "UPDATE `nurselist` SET `activePatient`=? WHERE `Nurse`=?";
    $setActivePatient = $conn->prepare($setActivePatientQuery);
    $setActivePatient->bind_param("ss",
        $params[1],
        $params[0]
    );     
        
    if(!$setActivePatient->execute()){
        echo json_encode(array("response"=>"error","data"=>'Set active patient failed. ' . $setActivePatient->error));
        $setActivePatient->close();
        exit;            
    }
    $setActivePatient->close();


    echo json_encode(array("response"=>"success","data"=>"Updated patient status!"));

      
    
}
else{
    echo json_encode(array("response"=>"error","data"=>'You cannot access this page.'));
}
?>
