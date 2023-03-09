<?php
    session_start();

   include('resources/data/sessionLog.php');
   userLog( $sessionName, $_SESSION[$sessionName]['userID']);
    
    

?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        
    <meta charset='utf-8' />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SEAT RESERVATION</title>

        <!--       Standard CSS-->
       <link rel="stylesheet" type="text/css" href="../vendors/css/grid.css">
         <!-- <link rel="stylesheet" type="text/css" href="../../vendors/css/normalize.css"> -->

        <!-- Customized CSS -->
        
        <link rel="stylesheet" type="text/css" href="resources/css/style.css?random=<?= uniqid() ?>">
        <link rel="stylesheet" type="text/css" href="resources/css/responsive.css?random=<?= uniqid() ?>">
        <link rel="stylesheet" type="text/css" href="resources/css/dashboard-flex.css?random=<?= uniqid() ?>">
        <link rel="stylesheet" type="text/css" href="resources/css/loader.css?random=<?= uniqid() ?>">
        <link rel="stylesheet" type="text/css" href="resources/css/table.css?random=<?= uniqid() ?>">
       
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- JQUERY -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    
        <!--       ION ICONS -->
        <script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>
  
        <!-- Customized JS -->
         <script src="resources/js/java.js?random=<?= uniqid() ?>"></script> 
         
         <script src="resources/js/registration.js?random=<?= uniqid() ?>"></script> 
       
         <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
           <!-- DATATABLES -->
           <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
        
        <style>
            ion-icon {
                visibility: visible;
            }

            
            div#example_length, div#example_info, div#example_paginate, .dataTables_filter {
                margin: 15px 0;
            }
            table{
                
                border-radius: 3px;
                border: 1px solid #C7C7C7;
                box-shadow: -2px 2px 5px rgb(137 137 137 / 10%);
            }
            td.sorting {
                
                background: rgb(66 182 191 / 50%);
                color: #080808;
            }

            td.sorting:first-child {
                border-radius: 3px 0 0;
            }
            td.sorting:last-child {
                border-radius: 0 3px 0 0;
            }
            .dataTables_length select {
                width: 30%;
            }

</style>


        
    </head>
    <body>
    <div class="header">     
        <?php include('resources/html/header.php'); ?>
    </div>
       <div class="container classic-container-bg">
              
    <div id="loader"></div> 

            <section id="tabledashboard" >
                <div class="dashboard">
                    <div style="width:80%; margin-left: 10%">
                        <table id="example" class="row-border hover order-column" >
                    

                        <thead>
                            <tr>
                                <td>Patient ID</td>
                                <td>Name</td>
                                <td>Age</td>
                                <td>Doctor's Name</td>
                                <td>Doctor's Contact#</td>
                                <td>Date Admitted</td>
                                <td>PatientAddress</td>
                                <td>PatientGuardian</td>
                                <td>PatientDependent</td>
                                <td>DoctorEmail</td>
                            </tr>
                        </thead>
                        <tbody>
                       
                        </tbody>
                        </table>
                    </div>
                </div>  
            </section>
             
        </div>
        <div class="floating-button" onmouseover="toggleInfo('show')" onmouseout="toggleInfo('hide')" onclick="showModal('addPatientModal')">
            <ion-icon name="add-circle" id="toggleBtn" class="add-btn inactive md hydrated" role="img" aria-label="add circle"></ion-icon>
        </div>
        <div id="info-content" class="hide">
            <p>Add patient.</p>
        </div>

                
        <div class="modal" id="addPatientModal" style="z-index:1001">
            <div class="modal-header">
                <h1>Add Patient</h1>
                <span class="close"  onclick="closeModal('addPatientModal', 'addPatientForm')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="addPatientForm" enctype="multipart/form-data" autocomplete="off" class="form-grid">
                    <div class="form-content lm-0">
                        <div class="bordered-input input-no-icon">
                            <input type="text" name="PatientName" value="" placeholder="Name" required autocomplete="false">
                        </div>
                    </div>
                    
                    <div class="form-content lm-0">    
                        <div class="bordered-input input-no-icon">
                            <input type="number" name="PatientAge" value="" placeholder="Age" required autocomplete="false">
                        </div>
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="bordered-input input-no-icon">
                            <input type="text" name="PatientAddress" value="" placeholder="Patient Address" required autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="bordered-input input-no-icon">
                            <input type="text" name="PatientGuardian" value="" placeholder="Authorized Patient Guardian" required autocomplete="false">
                        </div>  
                    </div>

                    <div class="form-content grid-2w lm-0">
                        <div class="bordered-input input-no-icon">
                            <input type="text" name="PatientDependent" value="" placeholder="Patient's Dependent (Optional)"  autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="bordered-input input-no-icon">
                            <input type="text" name="DoctorName" value="" placeholder="Doctor's Name" required autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="bordered-input input-no-icon">
                            <input type="text" name="DoctorNumber" value="" placeholder="Doctor's Contact Number (+639xxxxxxxxx)" required autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="bordered-input input-no-icon">
                            <input type="email" name="DoctorEmail" value="" placeholder="Doctor's Email" required autocomplete="false">
                        </div>  
                    </div>

               


                    <div class="form-content  grid-2w lm-0">
                            <div class="input-no-icon input-file"     style="padding: 0 5%;">
                                <label for="Photo" class="upload-button" >UPLOAD</label>
                                <input type="file" id="Photo" onchange="addFileName(this, 'Photo')" name="Photo" accept="image/jpeg,image/png" hidden readonly/>
                                <span id="file-chosen-Photo" 
                                class="span-file-chosen"
                                style="color: var(--inactive);font-size: 0.8rem">Patient Photo (png, jpeg)</span>
                                
                                <input type="hidden" name="PatientPhotoPath" id="PhotoPath">
                            </div>
                            <p id="alert-Photo" class="alertMessage hide"></p>
                            <progress id="progressBarPhoto" class="hide" value="0" max="100" ></progress>
                        </div>
                </form>
            </div>

            <div class="modal-footer form-grid 2-cols">
                <h3 id="status" class="hide"></h3>
                <!-- <p id="loaded_n_total"></p> -->
                <div class="submit-form lm-0">
                    <input type="button" value="Register" onclick="validateSingleForm('addPatientForm')">
                </div>
            </div>
        </div>
        
        
                     
        <div class="modal" id="editPatientModal" style="z-index:1001">
            <div class="modal-header">
                <h1>Edit Patient</h1>
                <span class="close"  onclick="closeModal('editPatientModal', 'editPatientForm')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="editPatientForm"  autocomplete="off" class="form-grid">
                    <div class="form-content lm-0">
                        <div class="textOnInput">
                            <label for="EditPatientName" class="topLabel">Name</label>
                            <input type="text" name="PatientName" id="EditPatientName" value="" placeholder="Name" required autocomplete="false">
                        </div>
                    </div>
                    <input type="hidden" name="Patient"   id="EditPatient" value="" placeholder="Name" required autocomplete="false">
                    <div class="form-content lm-0">    
                        <div class="textOnInput">
                            <label for="EditPatientAge" class="topLabel">Age</label>
                            <input type="number" name="PatientAge"  id="EditPatientAge" value="" placeholder="Age" required autocomplete="false">
                        </div>
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="textOnInput">
                            <label for="EditPatientAddress" class="topLabel">Patient Address</label>
                            <input type="text" name="PatientAddress" id="EditPatientAddress" value="" placeholder="Patient Address" required autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="textOnInput">
                            <label for="EditPatientGuardian" class="topLabel">Patient Guardian</label>
                            <input type="text" name="PatientGuardian"  id="EditPatientGuardian"  value="" placeholder="Authorized Patient Guardian" required autocomplete="false">
                        </div>  
                    </div>

                    <div class="form-content grid-2w lm-0">
                        <div class="textOnInput">
                            <label for="EditPatientDependent" class="topLabel">Patient Dependent</label>
                            <input type="text" name="PatientDependent"  id="EditPatientDependent" value="" placeholder="Patient's Dependent (Optional)"  autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="textOnInput">
                            <label for="EditDoctorName" class="topLabel">Doctor's Name</label>
                            <input type="text" name="DoctorName" id="EditDoctorName" value="" placeholder="Doctor's Name" required autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="textOnInput">
                            <label for="EditDoctorNumber" class="topLabel">Doctor's Phone#</label>
                            <input type="text" name="DoctorNumber"  id="EditDoctorNumber" value="" placeholder="Doctor's Contact Number (+639xxxxxxxxx)" required autocomplete="false">
                        </div>  
                    </div>
                    
                    <div class="form-content grid-2w lm-0">
                        <div class="textOnInput">
                            <label for="EditDoctorEmail" class="topLabel">Doctor's Email</label>
                            <input type="email" name="DoctorEmail" id="EditDoctorEmail" value="" placeholder="Doctor's Email" required autocomplete="false">
                        </div>  
                    </div>

               

                </form>
            </div>

            <div class="modal-footer form-grid 2-cols">
                <h3 id="status" class="hide"></h3>
                <!-- <p id="loaded_n_total"></p> -->
                <div class="submit-form lm-0">
                    <input type="button" value="Update" onclick="validateSingleForm('editPatientForm')">
                </div>
            </div>
        </div>

               

  

<script> 

var navClicked = false;
var overlaycount = 0;
var table = "";
document.getElementById("loader").style.display = "none";
$(document).ready(function () {
    getUser()
    table = $('#example').DataTable({
        // "autoWidth": true,
        "order": [[5, 'asc']],
        orderCellsTop: true,
        processing: true,
        fixedHeader: true,
        serverSide: true, 
        ajax: {
          url: 'resources/data/gettblpatients.php',
          type: 'GET'
        //   data: function (d) {
        //     d.user = "gatekeeper";
        //   },
        },
        'columnDefs': [
            
            {
                'targets': '_all',
                className: "dt-head-center dt-body-center"
                
            },
            {
                'targets': [0,6,7,8,9],
                visible: false
                
            }
        ]
    });
    
    
     $.contextMenu({
        selector: '#example tbody tr', 
        trigger: 'right',
        callback: function(key, options) {
            console.log(table)
            var row = table.row(options.$trigger)
            var rowData = table.row($(this)).data();
            console.log("rowData",rowData)
            switch (key) {
                case 'edit' :
                    $("#EditPatient").val(rowData[0])
                    $("#EditPatientName").val(rowData[1])
                    $("#EditPatientAge").val(rowData[2])
                    $("#EditPatientAddress").val(rowData[6])
                    $("#EditPatientGuardian").val(rowData[7])
                    $("#EditPatientDependent").val(rowData[8])
                    $("#EditDoctorName").val(rowData[3])
                    $("#EditDoctorNumber").val(rowData[4])
                    $("#EditDoctorEmail").val(rowData[9])
                    showModal('editPatientModal')
                break;
            
            default :
                break
            } 
        },
        items: {
          "edit": {name: "Edit", icon: "edit", visible: true}
        }
      }) ;
    
    setInterval(reloadTable,10000)

    $('#example tbody').on('click', 'tr', function () {
        var data = table.row(this).data();
        
        window.open("patientdashboard.php?id="+data[0],"_self")
    });

});


    // getTableStats();
    // setInterval(getTableStats, 60000)
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
                $("#headerName").html("Welcome, "+ nurseName + "!")
            },
            error: function(req, err){
                console.log(err);
            }	
        });

    }

    function reloadTable(){
        table.ajax.reload();
    }
   
</script>
   
    </body>
</html>