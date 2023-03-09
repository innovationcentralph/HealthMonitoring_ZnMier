
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
    <title>Health Monitoring</title>

    <!--       Standard CSS-->
    <link rel="stylesheet" type="text/css" href="../vendors/css/grid.css">
    <link rel="stylesheet" type="text/css" href="../vendors/css/normalize.css">

    <!-- Customized CSS -->
    <link rel="stylesheet" type="text/css" href="resources/css/style.css?random=<?= uniqid() ?>">
    <link rel="stylesheet" type="text/css" href="resources/css/responsive.css?random=<?= uniqid() ?>">
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
        <div class="container-fluid chart-content with-panel">
         
            <div class="card col form-card info-panel " style="width: 35%">
                <div class="card-body">
                    <div class="card-section">
                        <h2 class="section-title" >Patient's Info</h2>
                        <div class="details"  id="PatientNameInput" ></div>
                        <div class="details" id="PatientAgeInput"></div>
                    </div>
                    <div class="card-separator"></div>
                    
                    <div class="card-section">
                        <h2 class="section-title" >Doctor's Info</h2>
                        <div class="details" id="DoctorNameInput"></div>
                        <div class="details"  id="DoctorNumberInput"></div>
                        <div class="details" id="DoctorEmailInput" ></div>
                    </div>
                </div>
            </div>
            <div class="grid-row ss-1g" id="chart-elements"  style="width: 65%;
    margin-left: calc(35% + 20px);" >
               
                    
            </div>
           
            
        </div>
    </div>

   
   

    <div class="floating-button" onmouseover="toggleInfo('show')" onmouseout="toggleInfo('hide')" onclick="toggleButtonState('patientScan', patientID)">
        <ion-icon name="checkmark-circle" id="patientScan" class="toggle-btn inactive md hydrated" role="img" aria-label="add circle"></ion-icon>
    </div>
    <div id="info-content" class="hide">
        <p id="toggleMessage">Activate patient scanning.</p>
    </div>




<script> 


var charts = [];
var init = 0;
var selectedID;
var activeDevices = [];

var chartElement = {};

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const patientID = urlParams.get('id');
// document.getElementById("chart-elements").style.display = "none";


$( document ).ready(function() {
    
    getUser();
    getPatient(patientID);
    $("#chart-elements").append( createChartElement("HeartRate", "Heart Rate (60 to 100bpm Typ)" ));
    $("#chart-elements").append( createChartElement("OxygenSaturation", "Oxygen Saturation (90 to 100% Typ)" ));
    $("#chart-elements").append( createChartElement("BloodPressure", "Blood Pressure (60/90 to 80/120 Typ)" ));
                    
    loadChartData(patientID);
    setInterval(function (){
        activeDevices.forEach((values) => {
            loadChartData(values,true);
        })
        
        },5000);
})

/*********************************** */

function generateChart(chartID, seriesName, seriesLabel, chartData, pointColor,seriesTooltip,currentSeriesTooltip, yAxisBounds, chartType, refresh = false){
    // console.log("generating chart",chartID, seriesName, seriesLabel, chartData ,yAxisBounds)
  
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new(chartID);


        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
        am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX"
        }));
        // root.interfaceColors.set("grid", am5.color("#767676"));
// 
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "zoomXY",
            xAxis: xAxis
        }));
        cursor.lineY.set("visible", false);


        
        // var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
        // xRenderer.labels.template.setAll({
        //   rotation: -45,
        //   centerY: am5.p50,
        //   centerX: am5.p100,
        //   paddingRight: 15
        // });
    
            
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.GaplessDateAxis.new(root, {
            groupData: true,
            maxDeviation: 0,
            baseInterval: {
            timeUnit: "minute",
            count: 15
        },
        renderer: am5xy.AxisRendererX.new(root, {}),
            tooltip: am5.Tooltip.new(root, {})
        }));
        
        xAxis.get("renderer").grid.template.setAll({
            disabled: true,
            visible: false,
            stroke: am5.color("#000000")
        });
        xAxis.get("dateFormats")["day"] = "MM/dd";
        xAxis.get("periodChangeDateFormats")["day"] = "MMM";


        xAxis.get("dateFormats")["hour"] = "MM/dd hh:mm";
        xAxis.get("periodChangeDateFormats")["hour"] = "MM/dd hh:mm";


        xAxis.get("dateFormats")["minute"] = "MM/dd hh:mm";
        xAxis.get("periodChangeDateFormats")["minute"] = "MM/dd hh:mm";
        
        
        xAxis.get("dateFormats")["second"] = "smm:ss";
        xAxis.get("periodChangeDateFormats")["second"] = "mm:ss";
        
        xAxis.get("renderer").labels.template.setAll({
            fill: am5.color("#777d80"),
            fontSize: "0.8rem"
        });
        
        xAxis.set("tooltip", am5.Tooltip.new(root, {
            forceHidden: true
        }));




        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 1,
            fill: am5.color("#777d80"),
            min: yAxisBounds[0],
            max: yAxisBounds[1],
            renderer: am5xy.AxisRendererY.new(root, {})
        }));
       
        yAxis.get("renderer").grid.template.setAll({
            disabled: false,
            strokeDasharray: [5, 3],
            fontSize: "6px",
            stroke: am5.color("#777d80")
            // visible: false
        });
        yAxis.get("renderer").labels.template.setAll({
            
            fill: am5.color("#777d80"),
            fontSize: "0.8rem"
        });
        yAxis.set("tooltip", am5.Tooltip.new(root, {
            forceHidden: true
        }));

        var rangeDataItem = yAxis.makeDataItem({
            value: yAxisBounds[1]
        });

        var range = yAxis.createAxisRange(rangeDataItem);
        range.get("label").setAll({
            fill: am5.color(0x000),
            text: chartData[chartData.length - 1][currentSeriesTooltip],
            inside:true,
            location: 1,
            // right: true,
            // marginLeft:30,
            paddingTop: 10,
            paddingBottom: 10,
            paddingLeft: 10,
            paddingRight: 10,
            centerX: 0,
            dx: -150,
            dy: -10,
        });
      range.get("grid").setAll({
            disabled: true,
            visible: false,
            stroke: am5.color("#000000")
        });
  
        range.get("label").adapters.add("x", (x, target)=>{
            return chart.plotContainer.width();
        });


     



        chart.plotContainer.onPrivate("width", ()=>{
            range.get("label").markDirtyPosition();
        });
        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        if(chartType == "Column"){

            // if(seriesName.length > 0){
                
            //     var series = {};
            //     seriesName.forEach((seriesName, index) => {
            //         var tempSeries = chart.series.push(am5xy.ColumnSeries.new(root, {
            //             name: seriesLabel[index],
            //             xAxis: xAxis,
            //             yAxis: yAxis,
            //             valueYField: seriesName,
            //             valueXField: "date",
            //             tooltip: am5.Tooltip.new(root, {
                            
            //             })
            //         }));

                    
            //         tempSeries.columns.template.setAll({
            //             templateField: pointColor[index],
            //             strokeWidth: 2,
            //             width: am5.percent(20)
            //         });
            //         series.push(tempSeries);
            //         console.log(series)
            //     })
                
            // }
            // else{
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: seriesLabel,
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: seriesName,
                    valueXField: "date",
                    tooltip: am5.Tooltip.new(root, {
                        
                    })
                }));

                series.columns.template.setAll({
                    templateField: pointColor,
                    strokeWidth: 2,
                    width: am5.percent(20)
                });
            // }
            
            // xAxis.renderer.cellStartLocation = 0.2;
            // categoryAxis.renderer.cellEndLocation = 0.8;
            
            
        }
        else if(chartType == "Line"){
            
            // if(seriesName.length > 0){
                
            //     var series = {};
            //     seriesName.forEach((seriesName, index) => {
            //         var tempSeries = chart.series.push(am5xy.SmoothedXLineSeries.new(root, {
                        
            //             name: seriesLabel[index],
            //             xAxis: xAxis,
            //             yAxis: yAxis,
            //             valueYField: seriesName,
            //             valueXField: "date",
            //             // tooltipDate: "dateTime",
            //             tooltip: am5.Tooltip.new(root, {})
            //             // connect: false
            //         }));

            //         tempSeries.fills.template.setAll({
            //             templateField: pointColor[index],
            //             fillOpacity: 0.2
            //         });
            //         tempSeries.bullets.push(function() {
            //             return am5.Bullet.new(root, {
            //                 locationY: 0,
            //                 sprite: am5.Circle.new(root, {
            //                 radius: 4,
            //                 strokeWidth: 2,
            //                 templateField: pointColor[index],
            //                 })
            //             });
            //         });

            //         series.push(tempSeries);
            //     });
            // }
            // else{
                var series = chart.series.push(am5xy.SmoothedXLineSeries.new(root, {
                    
                    name: seriesLabel,
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: seriesName,
                    valueXField: "date",
                    // tooltipDate: "dateTime",
                    tooltip: am5.Tooltip.new(root, {})
                    // connect: false
                }));

                series.fills.template.setAll({
                    templateField: pointColor,
                    fillOpacity: 0.2
                });
                series.bullets.push(function() {
                    return am5.Bullet.new(root, {
                        locationY: 0,
                        sprite: am5.Circle.new(root, {
                        radius: 4,
                        strokeWidth: 2,
                        templateField: pointColor,
                        })
                    });
                });
            // }
        }
        
        // Add scrollbar
        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
        // chart.set("scrollbarX", am5.Scrollbar.new(root, {
        // orientation: "horizontal"
        // }));

        series.get("tooltip").label.set("text", "[#fff bold fontSize: 13px ]{DateTime}[/]\n[#fff fontSize: 13px]Temperature: {"+seriesTooltip+"}[/]")
        series.data.setAll(chartData);
        

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);
        // if(refresh == false){
            chartElement[chartID+"-root"] = root;
            chartElement[chartID+"-datacount"] = chartData.length;
        // }

    }); // end am5.ready()
}
/*************************************** */
</script>



</body>
</html>
