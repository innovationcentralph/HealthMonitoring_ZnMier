function getUser(){
    $.ajax({
        cache:false,
        async: false,
        url: 'resources/data/getloggeduser.php',
        type: 'GET',
        // data: dataArray,
        
        dataType: "JSON",
        success: function(msg) {

            var userData = JSON.parse(msg.data);
            var nurseName = userData[0].Name
            $("#userPhoto").attr("src","resources/files/temp/"+userData[0].PhotoPath);
            $("#headerName").html("Welcome, "+ nurseName)
        },
        error: function(req, err){
            console.log(err);
        }	
    });

}

function getPatient(patientID){
    $.ajax({
        cache:false,
        async: false,
        url: 'resources/data/getactivepatient.php',
        type: 'GET',
        data: {"id": patientID},
        
        dataType: "JSON",
        success: function(msg) {

            var userData = JSON.parse(msg.data)[0];
            console.log(userData)

            Object.keys(userData).forEach(key => {
                if (document.getElementById(key+"Input") !== null) {
                    console.log("Element "+ key +" exists");
                    $("#"+key + "Input").html(userData[key])
                    $("#PatientAgeInput").html(userData["PatientAge"] + " years old")
                    $("#PatientGuardianInput").html("Guardian: " +userData["PatientGuardian"])
                    $("#PatientDependentInput").html("Dependent (Optional): " +userData["PatientDependent"])
                      $("#PatientPhotoPathInput").attr("src","resources/files/temp/"+userData["PatientPhotoPath"]);
                } 
            });
                // console.log("patient active",userData["isActiveScan"] )
            if(userData["isActiveScan"] == 1){
                // console.log("patient active",userData["isActiveScan"] )
                $("#patientScan").removeClass("inactive")
                $("#toggleMessage").html("Deactivate patient scanning");
            }
            
        },
        error: function(req, err){
            console.log(err);
        }	
    });

}


function getActiveDevices(id){
    
    $.ajax({
        url: 'resources/data/fetchData.php',
        type: 'GET',
        data: {'id': patientID},
        dataType: "JSON",
        success: function (msg) {
            // console.log(msg)
            if (msg.data.length > 0){
                msg.data.forEach((value) =>{
                    activeDevices.push(value.DeviceID);
                    // var chartLabel = value.DeviceID.split(/(?=[A-Z])/);
                    var chartLabel = value.DeviceID ;
                    $("#chart-elements").append( createChartElement(value.DeviceID, chartLabel ));
                    
                    loadChartData(value.DeviceID);
                });

            }
        },
        error: function(req, err){
            console.log(err);
        },
        complete: function(msg){
             

        }
    });
}


function loadChartData(chartid, reload= false) {
    var tmp = [];
    var ajaxurl = 'resources/data/fetchData.php';
    // var data = {'device': selectedID};
    var data = {'id': chartid};
    $.get(ajaxurl, data, function (response) {
    // Response div goes here.]
        var data = new Array();
        data = jQuery.parseJSON(response);
        // console.log(data);
   
        // return chartData;
    // }
    })
    .always(function(data) { 

        var jsondata = jQuery.parseJSON(data).data
        console.log(jsondata, jsondata.length)
        if(jsondata.length > 0){

            
        
            var maxValues = jsondata[jsondata.length - 1]
            console.log(maxValues)
            // console.log(maxValues);
            // console.log(maxValues["TemperatureLevelMax"],maxValues["TemperatureLevelMin"]);
            // console.log(maxValues);
            jsondata.pop();
            // jsondata.forEach((value, index) => {
            //         // console.log(value)
            //         chartData.push({
            //             "date": parseInt(value.timeStamp * 1000), 
            //             "TemperatureLevel": parseInt(value.TemperatureLevel), 
            //             // "AlertLevel": parseInt(value.AlertLevel)
            //         }
            //             )
            // })
        }
        if(reload == false){
            generateChart( "HeartRate", ["HeartRate"], ["Heart Rate"], jsondata, ["HeartRateColor"], ["HeartRateTooltip"],"HeartRateTooltipLast",[[maxValues["HeartRateMin"] - 5,maxValues["HeartRateMax"] + 4]],"Line")
            generateChart("OxygenSaturation", ["OxygenSaturation"], ["Oxygen Saturation"], jsondata, ["OxygenSaturationColor"], ["OxygenSaturationTooltip"],"OxygenSaturationTooltipLast",[[maxValues["OxygenSaturationMin"] - 5,maxValues["OxygenSaturationMax"] + 4]],"Line")
            generateChart("BloodPressure", ["Diastolic","Systolic"], ["Diastolic", "Systolic"], jsondata, ["DiastolicColor", "DiastolicColor"], ["DiastolicTooltip","SystolicTooltip"],"DiastolicTooltipLast",[[maxValues["DiastolicMin"] - 5,maxValues["DiastolicMax"] + 4],[maxValues["SystolicMin"] - 5,maxValues["SystolicMax"] + 4]],"Line", false, true)
           
           
        }
        else{
            // console.log("rebuilding chart")
            console.log(chartElement["HeartRate-datacount"],jsondata.length)
            if(chartElement["HeartRate-datacount"]  != jsondata.length){
                
            console.log("rebuilding chart")
                chartElement["HeartRate-root"].dispose();
                generateChart( "HeartRate", ["HeartRate"], ["Heart Rate"], jsondata, ["HeartRateColor"], ["HeartRateTooltip"],"HeartRateTooltipLast",[[maxValues["HeartRateMin"] - 5,maxValues["HeartRateMax"] + 4]],"Line", true)
                chartElement["OxygenSaturation-root"].dispose();
                generateChart("OxygenSaturation", ["OxygenSaturation"], ["Oxygen Saturation"], jsondata, ["OxygenSaturationColor"], ["OxygenSaturationTooltip"],"OxygenSaturationTooltipLast",[[maxValues["OxygenSaturationMin"] - 5,maxValues["OxygenSaturationMax"] + 4]],"Line",true)
                
                chartElement["BloodPressure-root"].dispose();
                generateChart("BloodPressure", ["Diastolic","Systolic"], ["Diastolic", "Systolic"], jsondata, ["DiastolicColor", "DiastolicColor"], ["DiastolicTooltip","SystolicTooltip"],"DiastolicTooltipLast",[[maxValues["DiastolicMin"] - 5,maxValues["DiastolicMax"] + 4],[maxValues["SystolicMin"] - 5,maxValues["SystolicMax"] + 4]],"Line", true, true)
           
            }
        }

    })
}

function createChartElement(id, label){
    var chartTemplate = ` <div class="card col chart-card" style="margin: 0;">
    <div class="card-header">
        <h2 class="card-title" >`+label+`</h2>`
        // <ion-icon name="reload-outline" class="action-icon" onclick="loadChartData('`+id+`',true)"></ion-icon>
    +`</div>
    <div class="card-body">
        <div id="`+id+`" class="section-cover chart-holder"></div>
    </div>
</div>`;
return chartTemplate;
}


function getAlerts(){
    
    $.ajax({
        url: 'resources/data/fetchAlerts.php',
        type: 'GET',
        // data: formData,
        dataType: "JSON",
        success: function (msg) {
            // console.log(msg)
            if (msg.data.length > 0){
                $("#alert-elements").empty();
                msg.data.forEach((value) =>{
                    $("#alert-elements").append( createAlertElement(value.Message, value.DateTime,value.DeviceID ));
                    
                    // loadChartData(value.DeviceID);
                });

            }
        },
        error: function(req, err){
            console.log(err);
        },
        complete: function(msg){
             

            //  loadChartData(activeDevices);
            // charts.push =[chart1, chart2];
            // chartGen(chart1, "WaterLevel","%", "#ed3434");
            // chartGen(chart2, "AlertLevel","", "#ed3434");
            // initMap()
            // chartGen(chart2, "Current","A", "#38C9C9");
            // chartGen(chart3, "Power","W","#49c920");
            // chartGen(chart4, "Energy","W","#be2596");
            
            // currentDataCount = chart1.data.length;
            

        }
    });
}

function createAlertElement(message,date,id){
    // var alertTemplate = `
    //     <div  class="alert-element grid-row ss-1g ls-3g">
    //         <div class="title">`+id+`</div>
    //         <div  class="message">`+message+`</div>
    //         <div  class="info">`+date+`</div>
    //     </div>`;
  var alertTemplate = `      
<div class="card col alert-card " style="margin: 0;">
    <div class="card-header">
        <h2 class="card-title" >Alert for device `+id+`</h2>`
    +`</div>
    <div class="card-body">
        <div class="info">`+date+`</div>
        <div class="message">`+message+`</div>
    </div>
</div>`;
return alertTemplate;
}

// function reloadData() {
//     var lastDataItem = series.dataItems[series.dataItems.length - 1];
  
//     var lastValue = lastDataItem.get("valueY");
//     var newValue = value + ((Math.random() < 0.5 ? 1 : -1) * Math.random() * 5);
//     var lastDate = new Date(lastDataItem.get("valueX"));
//     var time = am5.time.add(new Date(lastDate), "second", 1).getTime();
//     series.data.removeIndex(0);
//     series.data.push({
//       date: time,
//       value: newValue
//     })
  
//     var newDataItem = series.dataItems[series.dataItems.length - 1];
//     newDataItem.animate({
//       key: "valueYWorking",
//       to: newValue,
//       from: lastValue,
//       duration: 600,
//       easing: easing
//     });
  
//     // use the bullet of last data item so that a new sprite is not created
//     newDataItem.bullets = [];
//     newDataItem.bullets[0] = lastDataItem.bullets[0];
//     newDataItem.bullets[0].get("sprite").dataItem = newDataItem;
//     // reset bullets
//     lastDataItem.dataContext.bullet = false;
//     lastDataItem.bullets = [];
  
  
//     var animation = newDataItem.animate({
//       key: "locationX",
//       to: 0.5,
//       from: -0.5,
//       duration: 600
//     });
//     if (animation) {
//       var tooltip = xAxis.get("tooltip");
//       if (tooltip && !tooltip.isHidden()) {
//         animation.events.on("stopped", function () {
//           xAxis.updateTooltip();
//         })
//       }
//     }
//   }


function toggleButtonState(btnID, patientID){
    var stat = "";
    if ($("#"+btnID).hasClass("inactive")){
        $("#"+btnID).removeClass("inactive")
        stat = 1;
        $("#toggleMessage").html("Deactivate patient scanning");
    }
    else{
        $("#"+btnID).addClass("inactive")
        stat = 0;
        $("#toggleMessage").html("Activate patient scanning");
    }    
    var data = {"id": patientID, "status": stat};
    $.ajax({
        cache:false,
        async: false,
        url: 'resources/data/changepatientScan.php',
        type: 'POST',
        data: data,
        
        dataType: "JSON",
        success: function(msg) {
                console.log(msg);
                if (msg.response == "success"){
                    Swal.fire({
                        title: "SUCCESS!",
                        text: msg.data,
                        icon: "success"
                      }).then((result)=>{
                        if (result){
                            window.location.reload();
                        }
                      });
                }
                else{
                    Swal.fire({
                        title: "Oops! Something went wrong.",
                        html:  msg.data,
                        icon: "error"
                      })
                }

            
        },
        error: function(req, err){
            console.log(err);
        }	
    });
   
}