<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" /> 

        <title>Health Monitoring</title>
        <!-- Customized CSS -->
        <link rel="stylesheet" type="text/css" href="resources/css/style.css?random=<?= uniqid() ?>">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!--       ION ICONS -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
        
        <!--       ION ICONS -->
        <script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>
        
        <script src="resources/js/java.js?random=<?= uniqid() ?>"></script>
          <script src="resources/js/registration.js?random=<?= uniqid() ?>"></script> 
    
    <style>
        .content {
            background: rgb(0 0 0 / 20%);
            height: 100vh;
            width: 100%;
        }

        input:focus , input:focus::placeholder {
            color: black;
        }

        input, ::placeholder {
            color: white;
        }
        #addUserForm h2 {
            color: white;
        }
        
.login-form label {
    color: white;
}


    </style>
    </head>
    <body class="login dark-theme">
        <div class="container">
                
                <div class="login-form" >
                  
                    <form id="addUserForm" enctype="multipart/form-data" autocomplete="off" >
                        <!-- <img class="system-logo" src="../resources/img/logo.jpg" width="150" height="150"> -->
                        <h2>Register Nurse</h2>
                        <div class="form-content">
                            <div class="input-no-icon">
                                <input type="text" name="Name['value']" value="" placeholder="Name" id="Name" required autocomplete="false">
                                
                                <input type="hidden"  id="Nametype" name="Name['type']" value="s">
                            </div>  
                            <p id="alert-Name" class="alertMessage hide"></p>
                        </div>

                        <div class="form-content">
                            <div class="input-no-icon">
                                <input type="text" name="Age['value']" value="" placeholder="Age" id="Age" required autocomplete="false">
                                
                                <input type="hidden"  id="Agetype" name="Age['type']" value="d">
                            </div>  
                            <p id="alert-Age" class="alertMessage hide"></p>
                        </div>
                        
                        <div class="form-content">
                            <div class="input-no-icon">
                                <input type="text" name="DeviceID['value']" value="" placeholder="DeviceID" id="DeviceID" required autocomplete="false">
                                
                                <input type="hidden"  id="DeviceIDtype" name="DeviceID['type']" value="s">
                            </div>  
                            <p id="alert-DeviceID" class="alertMessage hide"></p>
                        </div>

                       

                        <div class="form-content">
                            <div class="input-no-icon">
                                <input type="text" id="username" name="username['value']" value="" placeholder="Username" required autocomplete="false" >
                                <input type="hidden" id="usernametype" name="username['type']" value="s">
                            </div>  
                            <p id="alert-username" class="alertMessage hide">Invalid username or password</p>
                        </div>

                        
                       
                        <div class="form-content">
                            <div class="input-no-icon">
                                <input type="password" id="password" name="password['value']" value="" placeholder="Password" required autocomplete="false">
                                <input type="hidden" id="passwordtype" name="password['type']" value="s">
                            </div>  
                            <p id="alert-password" class="alertMessage hide"></p>
                        </div>

                        <div class="form-content">
                            <div class="input-no-icon input-file"     style="padding: 0 5%;">
                                <label for="Photo" class="upload-button" >UPLOAD</label>
                                <input type="file" id="Photo" onchange="addFileName(this, 'Photo')" name="Photo" accept="image/jpeg,image/png" hidden readonly/>
                                <span id="file-chosen-Photo" class="span-file-chosen">Nurse's Photo (png, jpeg) 
                                    
                                    <!-- <ion-icon name="close-circle" class="upload-status-fail" id="upload-status fail"></ion-icon> -->
                                </span>
                                
                                <input type="hidden" name="PhotoPath" id="PhotoPath">
                            </div>
                            <p id="alert-Photo" class="alertMessage hide"></p>
                            
                            <progress id="progressBarPhoto" class="hide" value="0" max="100" ></progress>
                            
                        </div>

                
                        <h3 id="status"></h3>
                        <p id="loaded_n_total"></p>
                        
                        <div class="form-content">
                            <input type="checkbox" onclick="togglePassword()" >
                            <label>Show Password</label>
                        </div>
                         
                         
                         
                        <div class="submit-form">
                            <input class="submit-login" type="button"  value="Register" onclick="validateSingleForm('addUserForm')">
                        
                        </div>
                    
                       
                        <div class="form-link">
                            <a class="returnLink" href="index.php">Already have an account? Login!</a>
                        </div>

                    </form>

                    
                   
            </div>
        </div>

        <script>
            var activeProgressBar;
            
              function togglePassword() {
                        
                    var y = document.getElementById("password");
                    if (y.type === "password") {
                        y.type = "text";
                    }
                    else {
                        y.type = "password";
                    }
                }
            </script>
    </body>
</html>
