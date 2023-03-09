
function addFileName(element, nameplaceholder, action = 'insert'){
    console.log(element)
    activeProgressBar = nameplaceholder;
    if (action == "insert"){

        document.getElementById(nameplaceholder).textContent = element.files[0].name
    }
    else {
        
        document.getElementById(nameplaceholder).value= element.files[0].name;
    }
    console.log(document.getElementById(nameplaceholder).files[0].name)
   var file = document.getElementById(nameplaceholder).files[0];
    var formdata = new FormData();
    formdata.append(nameplaceholder, file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.nameplaceholder = nameplaceholder;
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "resources/data/file_upload_parser.php");
    
    ajax.send(formdata);
}

function _(el) {
    return document.getElementById(el);
}

function progressHandler(event) {
      
    // _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar"+activeProgressBar).value = Math.round(percent);
    // _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
    var jsonData = JSON.parse(event.target.responseText)
    console.log(jsonData, event )
    if (jsonData.response == "success"){
        $("#"+activeProgressBar+"Path").val(jsonData.fileID)
        $("#file-chosen-Photo").html(document.getElementById(activeProgressBar).files[0].name +  `<ion-icon name="checkmark-circle" class="upload-status success" id="upload-status-success"></ion-icon>`)
        
        console.log("success")
        
        _("status").innerHTML = "";
        $("#status").addClass("hide");
    }
    else{
        $("#"+activeProgressBar+"Path").val("")
        _("status").innerHTML = jsonData.data;
        _("progressBarPhoto").value = 0;
        $("#"+activeProgressBar).val("");
        $("#file-chosen-Photo").html(`Identification (.png, .jpeg)<ion-icon name="close-circle" class="upload-status fail" id="upload-status-fail"></ion-icon>`)
        $("#Photo").val("")
        $("#progressBarPhoto").addClass("hide");
        $("#status").removeClass("hide");
    }
   
    // _("status").innerHTML = jsonData.data;
    
   }

function errorHandler(event) {  
    console.log("encountered error")
    _("status").innerHTML = "Upload Failed";
    
    $("#upload-status-success").removeClass("hide")
    $("#upload-status-success").addClass("hide")
    $("#upload-status-fail").removeClass("hide")
}

function abortHandler(event) {
    _("status").innerHTML = "Upload Aborted";
}
