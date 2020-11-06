
//HTML  <script>document.addEventListener("DOMContentLoaded", function(){init()})</script>

function $(class_name) {
  return document.getElementsByClassName(class_name);
}
var params, ajaxObj, action, error_message, url, output;

function init_ajax() {
  initEventListeners();
}

function initEventListeners() {
  var checkoutDiv = $("checkout-div")[0];

  var placeOrderButton = checkoutDiv.getElementsByClassName("place_order");
  for(var i = 0; i<placeOrderButton.length;i++){
    placeOrderButton[i].addEventListener("click",placeOrderClicked);
  }
}


function placeOrderClicked(){
  params = "itemlist=";
  var itemsarray = [];
  var quantityarray = [];
  //var cart_items = $("cart_items")[0];
  var cart_rows = $("cart-row");
  //getting all differnt variables
  for (var i = 0;i<cart_rows.length;i++){
    var item_col = cart_rows[i].getElementsByClassName("item-column")[0];
    var quantity_col = cart_rows[i].getElementsByClassName("quantity-column")[0];
    var item = item_col.getElementsByClassName("item-title")[0].innerHTML
    var quantity = quantity_col.getElementsByClassName("quantity-input")[0].value;
    params += item+"=>"+quantity+"";
    //itemsarray.push(item);
    //quantityarray.push(quantity);
    //console.log(item," ",quantity);
  }
  //console.log(itemsarray);
  //console.log(quantityarray);
  console.log(params);
  //sending them to php
  //
  send_info(params);
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
    ajaxObj.open("POST", "index.php", true);
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
