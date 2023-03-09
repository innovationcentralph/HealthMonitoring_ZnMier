
        <div class="flex-nav left">
            <!-- <div class="container-logo left">
                <img  class="icon-logo"  id="userPhoto">
            </div>
            <h2 id="headerName"></h2> -->
            <ul class="sidebarnav headertabs" id="headertabs-full">
                <li class="sidebar-item container-logo left" > 
                    <img  class="icon-logo"  id="userPhoto">
                </li>
               
                
                <li class="sidebar-item" > 
                    <h2 id="headerName"></h2>
                </li>
            </ul>
            
        </div> 
        <div class="flex-nav right">
            <div class="mobile-nav-icon" onmouseover="displayChild('headertabs', true)" onmouseout="displayChild('headertabs', false)">
                <ion-icon name="menu" class="nav-icon"></ion-icon>
                <ul class="sidebarnav headertabs" id="headertabs">
                    <li class="sidebar-item" > 
                        <a class="sidebar-link header-dashboard" id="dashboard" href="dashboard.php" aria-expanded="false">
                            Patient List
                        </a>
                    </li>
                  
                    
                    <li class="sidebar-item" > 
                        <a class="sidebar-link" id="logout" href="resources/data/logout.php" aria-expanded="false" id="logout">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
             <ul class="sidebarnav headertabs" id="headertabs-full">
                <li class="sidebar-item" > 
                    <a class="sidebar-link header-dashboard" id="dashboard" href="dashboard.php" aria-expanded="false">
                        Patient List
                    </a>
                </li>
               
                
                <li class="sidebar-item" > 
                    <a class="sidebar-link" id="logout" href="resources/data/logout.php" aria-expanded="false" id="logout">
                        Logout
                    </a>
                </li>
            </ul>
       
        </div>
        

    <script>
        
function displayChild(listid, display){
    if(display == true){
        $("#"+listid).css("display","block")
    }if(display == false){
        $("#"+listid).css("display","none")
    }
}

    </script>
