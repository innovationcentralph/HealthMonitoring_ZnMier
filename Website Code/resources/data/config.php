<?php
// local
// $servername="localhost";
// $username="root";
// $password="";
// $dbase="healthmonitoring";
// $isLocal = false;
//hostinger
$servername="localhost";
$username="u891337127_hmadmin";
$password="B2c>|y3&s";
$dbase="u891337127_healthstat";

$sql_details = array(
    'user' => $username,
    'pass' => $password,
    'db'   => $dbase,
    'host' => $servername
);

$sessionName = "healthmonitoring";

$adminInfo["Email"] = "healthmonitoring@mactechph.com";
$adminInfo["Name"] = "Health Monitoring Admin";

$adminPassword = "B2c>|y3&s";
$conn = new mysqli($servername,$username,$password,$dbase);


function sendOutput($data, $httpHeaders=array(),$noHeader = true) {
    
    if (!$noHeader){
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
    }

    echo $data;
    // exit;
}

function execQuery($conn, $query, $fail, $header, $noHeader = true){
    // echo $query ."<br>";
    if(!$conn->query($query)==TRUE){ 
        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        if ($noHeader){
            echo 'Line error ' .  __LINE__ .":". $fail  . mysqli_error($conn);
        }
        else{
            sendOutput(json_encode(array('Line error ' .  __LINE__ => $fail  . mysqli_error($conn))), 
            array('Content-Type: application/json', $header)
            );
        }
       
        
        return $fail;
    }
    return;
    
}

function deleteTempFiles($files){
    if ($files){
        foreach ($files as $file) {
            
          if (!unlink($file)){
            return json_encode(array("response"=>"error","data"=>"Can't delete file from $file"));
          }
          else{
            return 1;
          }
        }
    }
}


function uploadTempFiles($fileNames, $fileDIR){
    if ($fileNames){
        for ($i = 0; $i < count($fileNames); $i++){
            if(!move_uploaded_file($fileNames[$i], $fileDIR[$i])){
                return json_encode(array("response"=>"error","data"=>"Can't reupload file ". $fileNames[$i]));
            }
        }
    }
}
?>
