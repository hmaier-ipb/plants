var params, ajaxObj, action, error_message, url, output, class_name, customer_id;
function $ (class_name) {
  return document.getElementsByClassName(class_name);
}




function init_admin_ajax(){
  initEventListeners();
}

function initEventListeners() {
  /**
   * click an order to show the customer information
   *
   */
  var order_paragraphs = $("order_paragraph");
  var customer_id = $("customer_id");
  var order_id = $("order_id")
  //console.log(customer_id);
  for (let i = 0; i < order_paragraphs.length; i++) {
    order_paragraphs[i].addEventListener("click", function () {
      action = "load_customer_info";
      params = "action=" + action + "&customer_id_string=" + customer_id[i].innerHTML+"&order_id_string="+order_id[i].innerHTML;
      console.log(params);
      send_info(params);
    });
  }
}

function removeOrderEventListener(){
  var remove_order_button = $("remove_order")[0];
  var order_id = document.getElementById("order_id").innerHTML;
  remove_order_button.addEventListener("click", function (){
    action = "remove_order";
    params = "action=" + action +"&order_id=" + order_id;
    send_info(params);
  })

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
    ajaxObj.open("POST", "admin.php", true);
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
    //console.log(ajaxObj.responseText);
    if (ajaxObj.status === 200) {
      try {
        json_response = JSON.parse(ajaxObj.responseText);
      } catch (e) {
        console.log("Ungültige Daten. Kein JSON String!");
        console.log(ajaxObj.responseText);
        return false;
      }
      var customer_info_div = $("customer_info")[0];
      var order_list = $("order_list")[0];

      switch (action) {
        case "load_customer_info":

          var info_display =
            "<p>"+json_response[0]+" "+json_response[1]+"</p>" +
            "<p>"+json_response[2]+" "+json_response[3]+"</p>" +
            "<p>"+json_response[4]+" "+json_response[5]+"</p>" +
            "<p>Order ID: <span id='order_id'>"+ json_response[6]+"</span></p>" +
            "<button class='remove_order'>REMOVE ORDER</button>"

          customer_info_div.innerHTML = info_display;
          removeOrderEventListener();
          action = "";
          break;
        case "remove_order":
          customer_info_div.innerHTML = "";
          order_list.innerHTML = "";
          order_list.innerHTML = json_response;
          // TODO: überprüfen ob evenlisteners funktionieren
          
          initEventListeners();
        break;
        default:
          output.innerHTML = "Keine gültige Aktion";
      }

    }

  }
}