<?php
    session_start();
    date_default_timezone_set('Asia/Singapore');
    $date=date('Y-m-d H:i');
    include('config.php');
    include('registration_utils.php');
    include('pdoqueries.php');
    if(isset($_POST)){ 
        // echo $_POST["Name['value']"];
        $username = $_POST["username"]["'value'"];
        $Name = $_POST["Name"]["'value'"];
        $rawPassword = $_POST["password"]["'value'"];

        // echo $username;
        $access = "Nurse";
        $usertable = "nurselist";

        if(isset($_FILES["Photo"]["name"])){
            $Photo = $_FILES["Photo"]["name"];
            $_POST["Photo"]["'type'"] = "s";
            unset($_POST["Photo"]);
        }

        if(isset($_POST["PhotoPath"])){
            $PhotoPath = $_POST["PhotoPath"];
            unset($_POST["PhotoPath"]);
           
        }

        
        unset( $_POST["username"], $_POST["password"]);
        /***** Uncomment and follow structure if you want to perform insert query  *****/
        $parseRegisterUserForm = new GeneratePDOQuery();
        $parseRegisterUserForm->parseInsertForm($_POST);
        //
        /***** Uncomment and follow structure if you want to append derived fields  *****/
        $userID = generateID(3,3);
        $password = password_hash($rawPassword, PASSWORD_DEFAULT);
        $parseRegisterUserForm->insert_ColumnNames[] = "`Nurse`";
        $parseRegisterUserForm->insert_ColumnDataTypes[] = "s";
        $parseRegisterUserForm->insert_ColumnValues[] = $userID;
        $parseRegisterUserForm->insert_ColumnInstance[] = "?";

        
        $parseRegisterUserForm->insert_ColumnNames[] = "`Photo`";
        $parseRegisterUserForm->insert_ColumnDataTypes[] = "s";
        $parseRegisterUserForm->insert_ColumnValues[] = $Photo;
        $parseRegisterUserForm->insert_ColumnInstance[] = "?";

        $parseRegisterUserForm->insert_ColumnNames[] = "`PhotoPath`";
        $parseRegisterUserForm->insert_ColumnDataTypes[] = "s";
        $parseRegisterUserForm->insert_ColumnValues[] = $PhotoPath;
        $parseRegisterUserForm->insert_ColumnInstance[] = "?";
        /***** Uncomment and follow structure if you want to append derived fields  *****/
        //
        $parseRegisterUserForm->getInsertFormInputStr();
        /***** Uncomment and follow structure if you want to perform insert query  *****/


        /***** Uncomment and follow structure if you want to perform update query  *****/
        // $parseUpdateUserForm = new GeneratePDOQuery();
        // $parseUpdateUserForm->parseUpdateForm($_POST);
        //
        /***** Uncomment and follow structure if you want to append derived fields  *****/
        // $userID = generateID(3,3);
        // $parseRegisterUserForm->insert_ColumnNames[] = "`userID`";
        // $parseRegisterUserForm->insert_ColumnDataTypes[] = "s";
        // $parseRegisterUserForm->insert_ColumnValues[] = $userID;
        // $parseRegisterUserForm->insert_ColumnInstance[] = "?";
        /***** Uncomment and follow structure if you want to append derived fields  *****/
        //
        // $parseUpdateUserForm->getUpdateFormInputStr();
        /***** Uncomment and follow structure if you want to perform insert query  *****/
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

                 /***** Query for insert  *****/
                $sql = "INSERT INTO `$usertable` ($parseRegisterUserForm->insert_ColumnNamesStr) VALUES ($parseRegisterUserForm->insert_ColumnInstanceStr)";
                /***** Query for insert  *****/

                 /***** Query for update  *****/
                // $sql = "UPDATE `users` SET $parseUpdateUserForm->update_ColumnNameInstancePairStr";
                /***** Query for insert  *****/
                
                $addUser = $conn->prepare($sql);
                $addUser->bind_param($parseRegisterUserForm->insert_ColumnDataTypesStr,...$parseRegisterUserForm->insert_ColumnValues); 
              
                if(!$addUser->execute()){
                    echo json_encode(array("response"=>"error","data"=>': User registration failed.  ' . $addUser->error . '.'));
                    $addUser->close();
                    exit;
                }
                else{
                    $addUser->close();
                    echo json_encode(array("response"=>"success","data"=> "Congratulations! You have been successfully registered." ));
                }

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