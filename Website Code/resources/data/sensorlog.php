<?php
include("config.php");

// temp ambient, temp coil, voltage and amphere



date_default_timezone_set('Asia/Singapore');
$date = new DateTime();
$tStamp = $date->format('U');
$dateEmail = $date->format('F j, Y g:i A');
$date = $date->format('Y-m-d H:i:s');

include('sendMail.php');

if (isset($_GET["id"])  ){
    // echo "received params";
    $devID = $_GET["id"];
    $heartRate = $_GET["hr"];        //heartrate (60 to 100)
    $o2Sat = $_GET["o2"];      //oxygen saturation (90 to 100)
    $diastolic = $_GET["bp1"];      //disatolic (60 to 80)
    $systolic = $_GET["bp2"];      //systolic (90 to 120)


    


                
    $selectRecords = "SELECT * FROM `nurselist` inner join patientlist on nurselist.activePatient = patientlist.Patient where deviceID = '$devID'";
    $data = [];
    $selectRecords_query = mysqli_query($conn, $selectRecords);
    $selectRecords_numrows = mysqli_num_rows($selectRecords_query);
    if ($selectRecords_numrows > 0){
        while($row = mysqli_fetch_assoc($selectRecords_query)) {
            $data[] = $row;
        }

        $sensorArray = array([
            "min"=> 60,
            "max"=> 100,
            "value"=> $heartRate,
            "label"=> "Heart Rate",
            "unit"=> "bpm",
            "alert"=> $data[0]["HeartRateAlert"]
        ],
        [
            "min"=> 90,
            "max"=> 100,
            "value"=> $o2Sat,
            "label"=> "Oxygen Saturation",
            "unit"=> "%",
            "alert"=> $data[0]["OxygenSaturationAlert"]
        ],
        [
            "min"=> 60,
            "max"=> 80,
            "value"=> $diastolic,
            "label"=> "Diastolic",
            "alert"=> $data[0]["DiastolicAlert"]
        ],
        [
            "min"=> 90,
            "max"=> 120,
            "value"=> $systolic,
            "label"=> "Systolic",
            "alert"=> $data[0]["SystolicAlert"]
        ]);
    $smsMessage = "";
    $smsMessage = checkAlerts($sensorArray);

    $params = array($data[0]["activePatient"], $heartRate, $o2Sat,  $diastolic, $systolic, $date, $tStamp);
    try {           
        $insert = $conn->prepare("INSERT INTO `sensorlog`(`PatientID`, `HeartRate`, `OxygenSaturation`, `Diastolic`, `Systolic`, `dateTime`, `timeStamp`) VALUES (?,?,?,?,?,?,?)");
        $insert->bind_param("sddddsd",
        $params[0],
        $params[1],
        $params[2],
        $params[3],
        $params[4],
        $params[5],
        $params[6]
        ); 
        if(!$insert->execute()){
            sendOutput(
                "Line" . __LINE__. ": " ."Sensor log failed. ". $insert->error,
                array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
            exit;
                            
        }
        else{
            
            $insert->close();
            if ($smsMessage[0] <> ""){
                
               $recipient["Name"] = $data[0]["DoctorName"];
                $recipient["Email"] = $data[0]["DoctorEmail"];
                $replyTo["Name"] = $data[0]["DoctorName"];
                $replyTo["Email"] = $data[0]["DoctorEmail"];
                $message["subject"] = $data[0]["PatientName"] . " Statistics Alert";
                $message["body"] = "Hello Doc <b>".$recipient["Name"]."</b>! This is to notify that <b> ".$data[0]["PatientName"] ." </b> has abnormal readings read as of $dateEmail. Displayed below are the patient's abnormal readings. <br/><br/>" . $smsMessage[0];
                $sendEmail = sendEmailAttachment($adminInfo, $adminPassword,  $recipient, $replyTo, null, $message);
                // echo $sendEmail;
                if ($sendEmail["response"] == "success"){

                    echo json_encode(array("response"=>"success","data"=>'Alert triggered! ' .$smsMessage[0]));
                
                }
                else{
                    echo json_encode(array("response"=>"error","data"=>"Email sending failed. ".$sendEmail["data"]));
                }
            }
            else{
            
            echo json_encode(array("response"=>"success","data"=>'Sensor logs clear!'));
            }
        }

        
    }
    catch(Exception $e) {
        throw New Exception( $e->getMessage() );
    } 
        
        
        
    }
    else{
        echo json_encode(array("response"=>"error","data"=>'No records found.'));
        exit;
    }
   
}
else{
    sendOutput(json_encode(array('error' => "No params set")), 
        array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized")
    );
    exit;
}

function checkAlerts($sensorArray){
    $alertMessage = array();
    $alertMessageStr = "";
    $alertUpdates = array();
    foreach($sensorArray as $sensorData){
        if ($sensorData["value"] > $sensorData["max"] ||  $sensorData["value"] < $sensorData["min"] ){
            if ($sensorData["alert"] == 0){
                array_push($alertMessage,$sensorData["label"] . " reading out of range with current reading of <b>". $sensorData["value"] . $sensorData["unit"]."</b>.");
            }
            
            array_push($alertUpdates,1);
        }
        else{
            $sensorData["alert"] == 0;
                array_push($alertUpdates,0);
        }
    }
    $alertMessageStr = implode("<br/>",$alertMessage);
    $response = array($alertMessageStr, $alertUpdates);
    return $response;

}

function smsgateway($recipients = [], $message, $apicode, $passwd)
{
    $url = 'http://mactechph.com/broker/api.php';
    $message = substr($message,0,200);
    $gatewayparams = array('1' => $recipients, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
    $config = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($gatewayparams),
            ),
    );

    $context  = stream_context_create($config);
    return file_get_contents($url, false, $context);
}
	

?>
