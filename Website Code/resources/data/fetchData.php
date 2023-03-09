<?php
include('config.php');

date_default_timezone_set('Asia/Singapore');
if(isset($_GET["id"])){
    $patientID = $_GET["id"];
    $sql = "SELECT * from sensorlog , (select  
    MIN(OxygenSaturation) as OxygenSaturationMin, 
    MIN(Diastolic) as DiastolicMin, 
    MIN(Systolic) as SystolicMin, 
    MAX(HeartRate) as HeartRateMax, 
    MAX(OxygenSaturation) as OxygenSaturationMax, 
    MAX(Diastolic) as DiastolicMax, 
    MAX(Systolic) as SystolicMax from sensorlog  WHERE PatientID = '$patientID') table2 WHERE PatientID =  '$patientID' ORDER BY timeStamp ASC";
    $data = [];
    $value1 = [];
    $value2 = [];
    $value3 = [];
    $value4= [];

    $scan_query = mysqli_query($conn, $sql);
    $scan_numrows = mysqli_num_rows($scan_query);
    // `ambientTemp`, `coilTemp`, `TemperatureLevel`, `current`, `dateTime`, `tStamp`
    if ($scan_numrows > 0){
        // echo "inside this loop<br>";
        while($row = mysqli_fetch_assoc($scan_query)) {
            $row["DateTime"] = date("M j - h:iA",$row["timeStamp"] );
            
            $row["date"] = $row["timeStamp"] * 1000;
             $row["HeartRate"] = (double)$row["HeartRate"];
            $row["OxygenSaturation"] = (double)$row["OxygenSaturation"];
            $row["Diastolic"] = (double)$row["Diastolic"];
            $row["Systolic"] = (double)$row["Systolic"];
	
            $row["HeartRateTooltip"] = (double)$row["HeartRate"] . "bpm";
            $row["HeartRateTooltipLast"] = "[fontWeight: 500]Heart Rate[/]: " .(double)$row["HeartRate"] . "bpm";
            
            $row["OxygenSaturationTooltip"] = (double)$row["OxygenSaturation"] . "%";
            $row["OxygenSaturationTooltipLast"] = "[fontWeight: 500]Oxygen Saturation[/]: " .(double)$row["OxygenSaturation"] . "%";
           
            $row["DiastolicTooltip"] = (double)$row["Diastolic"];
            $row["DiastolicTooltipLast"] = "[fontWeight: 500]Current BP[/]: " .(double)$row["Diastolic"] . "/".(double)$row["Systolic"];

            $row["SystolicTooltip"] = (double)$row["Systolic"];
            $row["SystolicTooltipLast"] = "[fontWeight: 500]Systolic[/]: " .(double)$row["Systolic"];
            


            $row["HeartRateColor"]["stroke"] =  $row["HeartRateColor"]["fill"] = $row["OxygenSaturationColor"]["stroke"]  =  $row["OxygenSaturationColor"]["fill"] = $row["DiastolicColor"]["stroke"] =  $row["DiastolicColor"]["fill"] = "#64c09b";

            if ($row["HeartRate"] > 100 ||  $row["HeartRate"] < 60){
                $row["HeartRateColor"]["stroke"] = "#f44336";
                $row["HeartRateColor"]["fill"] = "#f44336";
            }
            if ($row["OxygenSaturation"] > 100 ||  $row["OxygenSaturation"] < 90){
                $row["OxygenSaturationColor"]["stroke"] = "#f44336";
                $row["OxygenSaturationColor"]["fill"] = "#f44336";
            }
            
            if ($row["Diastolic"] > 80 ||  $row["Diastolic"] < 60){
                $row["DiastolicColor"]["stroke"] = "#f44336";
                $row["DiastolicColor"]["fill"] = "#f44336";
            }
            $row["SystolicColor"]["stroke"] ="#c27df1";
            $row["SystolicColor"]["fill"] ="#c27df1";

            if ($row["Systolic"] > 120 ||  $row["Systolic"] < 90){
                $row["SystolicColor"]["stroke"] = "#f17dac";
                $row["SystolicColor"]["fill"] = "#f17dac";
            }

            $value1[] = $row["HeartRate"] ;
            $value2[] = $row["OxygenSaturation"] ;
            $value3[] = $row["Diastolic"] ;
            $value4[] = $row["Systolic"] ;
            $data[] = $row;
        }

        array_push($data,   
        ['HeartRateMax' => max($value1),
         'OxygenSaturationMax' => max($value2),
         'DiastolicMax' => max($value3),
         'SystolicMax' => max($value4),
         'HeartRateMin' => min($value1),
         'OxygenSaturationMin' => min($value2),
         'DiastolicMin' => min($value3),
         'SystolicMin' => min($value4)]
        );
        }

        echo json_encode(array("response"=>"success","data"=>$data));
  
        // echo json_encode($data);
}
?>
