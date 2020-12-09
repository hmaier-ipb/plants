var params, ajaxObj, action, error_message, url, output, class_name, customer_id;

function $ (class_name) {
  return document.getElementsByClassName(class_name);
}


function init_admin_ajax(){
  initEventListeners();
}

function initEventListeners() {
  showCustomerInfoEventListener();
  navButtonsEventListener();

}

function showCustomerInfoEventListener(){
  var order_paragraphs = $("order_paragraph");
  var customer_id = $("customer_id");
  var order_id = $("order_id")
  for (let i = 0; i < order_paragraphs.length; i++) {
    order_paragraphs[i].addEventListener("click", function () {
      //ajax request to php
      action = "load_customer_info";
      params = "action=" + action + "&customer_id_string=" + customer_id[i].innerHTML+"&order_id_string="+order_id[i].innerHTML;
      //console.log(params);
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

function navButtonsEventListener(){
  var nav_buttons = $("nav");
  var nav_ids = [];
  for(let i = 0;i<nav_buttons.length;i++){
    nav_ids.push(nav_buttons[i].id);
    nav_buttons[i].addEventListener("click",function (){
      //filters all values that aren't current nav_button
      const not_current_nav_id = nav_ids.filter(function (value){
        return value !== nav_ids[i];
      })
      var requested_div = document.getElementsByClassName(nav_ids[i])[0];

      requested_div.style.display = "grid";
      for(let i = 0;i<not_current_nav_id.length;i++){
        //not requested divs
        document.getElementsByClassName(not_current_nav_id[i])[0].style.display = "none";
      }
      action = nav_buttons[i].id;
      params ="action="+ action;
      //console.log(params)
      send_info(params);
    })
  }
}

function changeOrderColor() {
  var order_paragraphs = $("order_paragraph");
  var order_ids = [];
  for (let i = 0; i < order_paragraphs.length; i++) {
    order_ids.push(order_paragraphs[i].id);
    order_paragraphs[i].addEventListener("click", function () {
      //filters all values that aren't clicked
      const not_current_orders = order_ids.filter(function (value){
        return value !== order_ids[i];
      })
      console.log(not_current_orders);
      document.getElementById(order_ids[i]).style.backgroundColor = "rgb(46,142,142)";
      for(let i = 0;i<not_current_orders.length;i++){
        document.getElementById(not_current_orders[i]).style.backgroundColor = "rgb(255,255,255)"
      }
    })
  }
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
      var statistics = $("statistics")[0];
      var new_product = $("new_product")[0];
      //console.log(statistics);
      switch (action) {
        case "load_customer_info":
          var info_display =
            "<div class='info_display'>" +
            "<p>"+json_response[0]+" "+json_response[1]+"</p>" +
            "<p>"+json_response[2]+" "+json_response[3]+"</p>" +
            "<p>"+json_response[4]+" "+json_response[5]+"</p>" +
            "<p>"+json_response[6]+"</p>" +
            "<p>Total Price: "+json_response[7]+"$</p>" +
            "<p style='display:none'>Order ID: <span id='order_id'>"+ json_response[8]+"</span></p>" +
            "<p><button class='remove_order'>REMOVE ORDER</button></p>" +
            "</div>"

          customer_info_div.innerHTML = info_display;
          //initialising the Event Listener for the REMOVE ORDER button
          removeOrderEventListener();
          action = "";
          break;
        case "remove_order":
          customer_info_div.innerHTML = "";
          order_list.innerHTML = "";
          order_list.innerHTML = json_response;
          showCustomerInfoEventListener();
        break;
        case "orders":
          order_list.innerHTML = "";
          order_list.innerHTML = json_response;
          showCustomerInfoEventListener();
          break;
        case "statistics":
          statistics.innerHTML = "";
          //console.log(json_response);
          statistics.innerHTML = json_response;
          break;
        case "new_product":
          new_product.innerHTML = "";
          new_product.innerHTML = json_response;
        default:
          console.log("Keine gültige Aktion");
      }

    }

  }
}