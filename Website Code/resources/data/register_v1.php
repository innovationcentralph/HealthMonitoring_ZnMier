<?php
session_start();
date_default_timezone_set('Asia/Singapore');
$date=date('Y-m-d H:i');
include('config.php');
include('registration_utils.php');
        if(isset($_POST)){ 
            $username = $_POST["username"];
            $Name = $_POST["Name"];
            $rawPassword = $_POST["password"];
            $access = "Nurse";
            $usertable = "nurselist";
            
            unset( $_POST["username"], $_POST["password"]);
            if(isset($_FILES["Photo"]["name"])){
                $_POST["Photo"] = $_FILES["Photo"]["name"];
            }
            foreach($_POST as $key => $value) {
                    $formValues[] = "'".$value. "'";
                    $formKeys[] = "`" . $key ."`";
            }
            
            $userID = generateID(3,3);
            $password = password_hash($rawPassword, PASSWORD_DEFAULT);

            $colNames = implode(", ",$formKeys);
            $values =  implode(", ",$formValues);
            try{
                $register = $conn->prepare("INSERT INTO `users` ( `userID`, `Name`, `username`,  `password`, `access`) VALUES (?,?,?,?,?)");
                $register->bind_param("sssss",$userID,$Name, $username, $password, $access); 
                if(!$register->execute()){
                    echo json_encode(array("response"=>"error","data"=>': User registration failed.  ' . mysqli_error($conn) . '.'));
                    $register->close();
                    exit;
                }
                else{
                    
                    $register->close();

                    try{
                        $addUser = $conn->prepare("INSERT INTO `$usertable` ($colNames, `Nurse`)   VALUES ($values,'$userID')");
                        // echo "INSERT INTO `$usertable` ($colNames, `Nurse`)   VALUES ($values,'$userID')";
                        if(!$addUser->execute()){
                            echo json_encode(array("response"=>"error","data"=>'User registration failed.  ' .$addUser->error . '.'));
                            $addUser->close();
                            exit;
                        }
                        else{
                            
                            echo json_encode(array("response"=>"success","data"=> "Congratulations! You have been successfully registered."));
                        }
                    }
                    catch(Exception $e) {
                        echo json_encode(array("response"=>"error","data"=>$e->getMessage() ));
                    } 
                    $addUser->close();

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
