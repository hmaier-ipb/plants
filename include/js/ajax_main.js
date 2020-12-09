
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
  //TODO: ->verification of the inputs -> forward the user to a new screen (thank you screen ect.??)

  params = "itemlist=";
  //var cart_items = $("cart_items")[0];
  var cart_rows = $("cart-row");
  //getting all differnt variables
  for (var i = 0;i<cart_rows.length;i++){
    var item_col = cart_rows[i].getElementsByClassName("item-column")[0];
    var quantity_col = cart_rows[i].getElementsByClassName("quantity-column")[0];
    var item = item_col.getElementsByClassName("item-title")[0].innerHTML
    var quantity = quantity_col.getElementsByClassName("quantity-input")[0].value;
    params += item+"=>"+quantity+"";
  }
  let email = document.getElementById("email");
  let firstname = document.getElementById("firstname");
  let surname = document.getElementById("surname");
  let streetname = document.getElementById("streetname");
  let streetnumber = document.getElementById("streetnumber");
  let city = document.getElementById("city");
  let postalcode = document.getElementById("postalcode");
  let country = document.getElementById("country");
  let phonenumber = document.getElementById("phonenumber");

  params += "&email="+email.value+"&firstname="+firstname.value+"&surname="+surname.value
  params += "&streetname="+streetname.value+"&streetnumber="+streetnumber.value
  params += "&city="+city.value+"&postalcode="+postalcode.value+"&country="+country.value+"&phonenumber="+phonenumber.value
  params += "&action=checkout";
  console.log(params);
  send_info(params);

  //switching back to the products_container
  var products_container = document.getElementsByClassName("products_container")[0];
  var checkoutDiv = document.getElementsByClassName("checkout-div")[0];
  var checkout_button = document.getElementsByClassName("checkout_button")[0];
  products_container.style.display = "grid";
  checkoutDiv.style.display = "none";
  checkout_button.style.opacity = "1";

  //deleting all cart_rows
  var cart = document.getElementsByClassName("cart_items")[0];
  cart.style.display = "none";
  while(cart_rows.length > 0){
    cart_rows[0].remove();
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
    ajaxObj.open("POST", "index.php", true);
    ajaxObj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxObj.onreadystatechange = setOutput;
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
      switch (action) {
        case "case":
          //encoded as a array with json_enode($myarray)
          output.innerHTML = json_response[0];
          action = "";
          break;

        default:
          output.innerHTML = "Keine gültige Aktion";
      }

    }

  }
}
