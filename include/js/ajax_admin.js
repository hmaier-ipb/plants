var params, ajaxObj, action, error_message, url, output;
function $ (class_name) {
  return document.getElementByClass(class_name);
}

function init_admin_ajax(){

}


function getAjaxObject() {
  //creating an ajax object
  if (window.ActiveXObject)
    return new ActiveXObject("Microsoft.XMLHTTP");
  else if (window.XMLHttpRequest)
    return new XMLHttpRequest();
  else {
    return null;
  }
}
function send_info(parameters) {
  //sending parameters(data) to url(index.php)
  ajaxObj = getAjaxObject();
  if (ajaxObj !== null) {
    ajaxObj.open("POST", "admin.class.php.php", true);
    ajaxObj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxObj.onreadystatechange = setOutput;
    ajaxObj.send(parameters);
  }
  else {
    console.log("Kein Ajax Objekt.");
    return false;
  }
}

function setOutput() {
  //recieving output form php as json
  if (ajaxObj.readyState === 4) {
    console.log(ajaxObj.responseText);
    if (ajaxObj.status === 200) {
      try {
        json_response = JSON.parse(ajaxObj.responseText);
      } catch (e) {
        console.log("Ungültige Daten. Kein JSON String!");
        console.log(ajaxObj.responseText);
        return false;
      }
      switch (action) {
        case "case":
          //encoded as a array with json_enode($myarray)
          output.innerHTML = json_response[0];
          action = "";
          break;
        //case: "second_case":
        // output my json_response
        //break;
        default:
          output.innerHTML = "Keine gültige Aktion";
      }

    }

  }
}