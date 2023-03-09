<?php
session_start();
date_default_timezone_set('Asia/Singapore');
$date=date('Y-m-d H:i');
include('config.php');
include('registration_utils.php');
        if(isset($_POST) && (isset($_SESSION[$sessionName]['userID']))){ 
            $nurseID = $_SESSION[$sessionName]['userID']; 
            
            unset( $_POST["username"], $_POST["password"]);
            if(isset($_FILES["Photo"]["name"])){
                $_POST["Photo"] = $_FILES["Photo"]["name"];
            }
            foreach($_POST as $key => $value) {
                    $formValues[] = "'".$value. "'";
                    $formKeys[] = "`" . $key ."`";
            }
            
            $userID = generateID(3,3);
            // $password = password_hash($rawPassword, PASSWORD_DEFAULT);

            $colNames = implode(", ",$formKeys);
            $values =  implode(", ",$formValues);
            try{
                $addPatient = $conn->prepare("INSERT INTO `patientlist` ($colNames, `Patient`,`PatientNurse`, `PatientAdmitDate`)   VALUES ($values,'$userID','$nurseID','$date')");
                // echo "INSERT INTO `patientlist` ($colNames, `Patient`,`PatientNurse`, `PatientAdmitDate`)   VALUES ($values,'$userID','$nurseID','$date')";
                if(!$addPatient->execute()){
                    echo json_encode(array("response"=>"error","data"=>': Patient registration failed.  ' .$addPatient->error . '.'));
                    $addPatient->close();
                    exit;
                }
                else{
                    $addPatient->close();
                    echo json_encode(array("response"=>"success","data"=> "Patient successfully registered."));
                   

                }
            } 
            catch(Exception $e) {
                echo json_encode(array("response"=>"error","data"=>$e->getMessage() ));
            } 
        }
        else{
            echo json_encode(array("response"=>"error","data"=>"No parameters set." ));
        }
    


?>