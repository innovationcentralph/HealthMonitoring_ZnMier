<?php
include('config.php');
session_start();
if(isset($_SESSION[$sessionName]['userID'])){ 
    $nurseID = $_SESSION[$sessionName]['userID'];
    date_default_timezone_set('Asia/Singapore');
    $table ="(SELECT * FROM patientlist WHERE PatientNurse = '$nurseID' ORDER BY PatientAdmitDate ASC) table1";

    $primaryKey = 'Patient';

        $columns = array(
            array( 'db' => 'Patient', 'dt' => 0),
            array( 'db' => 'PatientName', 'dt' => 1),
            array( 'db' => 'PatientAge', 'dt' => 2),
            array( 'db' => 'DoctorName', 'dt' => 3),
            array( 'db' => 'DoctorNumber', 'dt' => 4),
            array( 'db' => 'PatientAdmitDate', 'dt' => 5),
            array( 'db' => 'PatientAddress', 'dt' => 6),
            array( 'db' => 'PatientGuardian', 'dt' => 7),
            array( 'db' => 'PatientDependent', 'dt' => 8),
            array( 'db' => 'DoctorEmail', 'dt' => 9)
        );

    require( '../../../vendors/datatables/ssp.class.php' );
    echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,"1")
    );

}
else{
    echo json_encode(array("response"=>"error","data"=>'You cannot access this page.'));
}
?>
