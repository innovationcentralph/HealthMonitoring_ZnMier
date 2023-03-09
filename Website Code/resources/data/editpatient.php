<?php

include('config.php');
$queryArray = array();

if (isset($_POST)){
    $patientID = $_POST["Patient"];
    unset($_POST["Patient"]);
    foreach($_POST as $key => $value) {
        // $query .= $key ."= " . $value;
        array_push($queryArray,$key ."= '" . $value."'");
    }
    $query = implode(",",$queryArray);
    $query ="UPDATE `patientlist` SET $query WHERE Patient = '$patientID'";
    // echo $query;
    if($conn->query($query)==TRUE){
        echo json_encode(array("response"=>"success","data"=> "Patient record update successfull!"));
       
    }
    else{ 
        echo json_encode(array("response"=>"error","data"=> "Patient record update failed!"));
        // echo "Patient record  update failed. " . mysqli_error($conn).".";
    }
}

?>