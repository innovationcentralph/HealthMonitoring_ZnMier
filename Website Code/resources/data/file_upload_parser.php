<?php

date_default_timezone_set('Asia/Singapore');
$tStamp=date('U');
if (isset($_FILES['Photo'])){
    $fileID = $_FILES["Photo"];
}
$fileName = $fileID ["name"]; // The file name
$fileTmpLoc = $fileID ["tmp_name"]; // File in the PHP tmp folder

$extension=explode(".", $fileName);
$extension=end($extension);
// echo $fileTmpLoc;
$fileType = $fileID ["type"]; // The type of file it is
$fileSize = $fileID ["size"]; // File size in bytes

if (($fileSize > 500000)){
        $message = 'File too large. File must be less than 500KB.'; 
        echo json_encode(array("response"=>"error","data"=>$message));
    exit;
}
$fileErrorMsg = $fileID ["error"]; // 0 for false... and 1 for true
$rawFilename = pathinfo("../files/temp/$fileName", PATHINFO_FILENAME);
// echo $rawFilename;
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
$tempFileName = $rawFilename.$tStamp.".".$extension;
if(move_uploaded_file($fileTmpLoc, "../files/temp/$tempFileName")){
    echo json_encode(array("response"=>"success","data"=>"$fileName upload is complete","fileID"=> $tempFileName, "rawFileName"=>$rawFilename));
                        
    // echo "$fileName upload is complete";
} else {
    echo "move_uploaded_file function failed";
}
?>