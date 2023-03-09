
<?php
    session_start();
    include('resources/data/sessionLog.php');
    if(isset($_SESSION[$sessionName]['userID'])){
        userLog($sessionName, $_SESSION[$sessionName]['userID']);
    }
    else{
        
        userLog( $sessionName, null);
    }



?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" /> 
    <title>GOAT MONITORING SYSTEM</title>

    <!--       Standard CSS-->
    <link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/normalize.css">

    <!-- Customized CSS -->
    <link rel="stylesheet" type="text/css" href="resources/css/style.css?random=<?= uniqid() ?>">
    <link rel="stylesheet" type="text/css" href="resources/css/charts.css?random=<?= uniqid() ?>">
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300&display=swap" rel="stylesheet">
          
    <!--       ION ICONS -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
         
    <!--       FONT AWESOME-->
    <!-- <script src="https://kit.fontawesome.com/f0dbe7deea.js" crossorigin="anonymous"></script> -->
    
    <!-- JQUERY -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Customized JS -->
    <script src="resources/js/java.js?random=<?= uniqid() ?>"></script>
    <script src="resources/js/interact.js?random=<?= uniqid() ?>"></script>

    <script src="resources/js/maps.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

    
    <!-- AMCHARTS -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
</head>
<body>
    <div class="loader"></div>
    <div class="header">     
        <?php include('resources/html/header.php'); ?>
    </div>
    <div class="container with-header classic-container-bg">
        <!-- <div class="header-options">
            <h3 id="selectedDevice" class="page-title mb-0">ABC123</h3>
        </div> -->
        <div class="container-fluid chart-content">

        
            <div class="grid-row ss-1g" id="alert-elements" >
                <!--<div class="card col" style="margin: 0;">-->
                <!--    <div class="card-header">-->
                <!--        <h2 class="card-title">Alert History</h2>-->
                        <!--<ion-icon name="reload-outline" class="action-icon" onclick="loadAlerts()"></ion-icon>-->
                <!--    </div>-->
                <!--    <div class="card-body" id="alert-container">-->
                       
                       
                <!--    </div>-->
                <!--</div>-->
                    
            </div>
           
            
        </div>
    </div>


<script> 


var charts = [];
var init = 0;
var selectedID;
var activeDevices = [];
var chartElement = {};
// function reloadPage(){
    
//     selectedID = $('#devID').val();
//     window.location.href= "dashboard.php?devID="+selectedID;
// }
$( document ).ready(function() {
    getAlerts();
    
    setInterval(getAlerts(), 1000);
})



</script>


</body>
</html>