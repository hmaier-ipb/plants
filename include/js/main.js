
function init_main() {
  //this function get initiated when the content of the page is loaded

  //add an event listener to all addToCartButtons (in every product-card)
  var addToCartButtons = document.getElementsByClassName("add-to-cart-btns");
  for (var i = 0; i < addToCartButtons.length; i++) {
    //the [i] ensures that every button in the "add-to-class-buttons"-Class gets an eventlistener by itself
    //[i] = on what iteration we are right now
    var addToCartButton = addToCartButtons[i];
    //do not add parenthesis "()" to addToCartClicked
    addToCartButton.addEventListener("click", addToCartClicked)
  }

}

/*
* EVENT LISTENERS FOR POSTLOADED DOCUMENT
* */

function removeAddEventListener() {
  //add an event listener to all removeFromCartButtons which are located in the shopping cart
  var removeFromCartButtons = document.getElementsByClassName("remove-from-cart");
  for (let i = 0; i < removeFromCartButtons.length; i++) {
    var removeFromCartButton = removeFromCartButtons[i];
    removeFromCartButton.addEventListener("click", removeFromCartClicked);
  }

}
//add an event listener to all quantityInputs which are located in the shopping cart
function quantityAddEventListener() {
  var quantityInputs = document.getElementsByClassName("quantity-input");
  for (var i = 0; i < quantityInputs.length; i++) {
    var quantityInput = quantityInputs[i];
    quantityInput.addEventListener("change", quantityChanged)
  }
}

function checkoutAddEventListener(){
  var checkoutButton = document.getElementsByClassName("checkout_button");
  for(var i = 0; i < checkoutButton.length; i++){
    checkoutButton[i].addEventListener("click", switchDivsCheckout);
    //console.log("checkout event listener set");
  }
}



/*
* FUNCTIONS FOR EVENT LISTENERS
* */

function addToCartClicked(event) {

  //event is the object linked to the specific button clicked
  //the target is the button clicked on
  //console.log("addToCartClicked");
  var buttonClicked = event.target;
  var cart1 = document.getElementsByClassName("cart_items")[0];
  cart1.style.display = "block";


  //gets the class info which containes the description of the product and the price
  //starting from the buttonClicked as reference for the correct information
  var info = buttonClicked.parentElement.parentElement;
  var title = info.getElementsByClassName("title")[0].innerText
  var price = parseFloat(info.getElementsByClassName("price")[0].innerText.replace("Price: ", ""))
  var imageSrc = info.getElementsByClassName("product-image")[0].src;
  addItemToCart(title, price, imageSrc);
}

function removeFromCartClicked(event) {
  //console.log("removeFromCartClicked");
  //removing the cart row in which the button was clicked
  var buttonClicked = event.target;
  //console.log(buttonClicked.parentElement.parentElement);
  buttonClicked.parentElement.parentElement.remove();
  //vars for removing the checkout button
  var shopping_cart_items = document.getElementsByClassName("cart_items")[0];
  //synonymous for cart-rows
  var cartItemNames = shopping_cart_items.getElementsByClassName("item-title");
  updateTotal();

  //if there are no more cart-rows in the shopping-cart: the cart disappears
  if (cartItemNames.length <= 0) {
    var checkoutButton = document.getElementsByClassName("checkout_button");
    checkoutButton[0].remove();
    var totalOutput = shopping_cart_items.getElementsByClassName("total")[0];
    totalOutput.innerHTML = "";
    var cart = document.getElementsByClassName("cart_items")[0];
    cart.style.display = "none";
    switchDivsRemove();
  }
}


function switchDivsCheckout(){
  //switchting divs by changing the DISPLAY.STYLE when pressing checkout
  var products_container = document.getElementsByClassName("products_container")[0];
  var checkoutDiv = document.getElementsByClassName("checkout-div")[0];
  var checkoutButton = document.getElementsByClassName("checkout_button")[0];

  if (products_container.style.display === "grid" && checkoutDiv.style.display === "none"){
    products_container.style.display = "none";
    checkoutDiv.style.display = "grid";
    checkoutButton.style.opacity = "0";
    checkoutButton.style.cursor = "default";
  }else{
    products_container.style.display = "none";
    checkoutDiv.style.display = "grid";
  }
}

function switchDivsRemove(){
  //switchting divs by changing the display style when pressing remove
  var products_container = document.getElementsByClassName("products_container")[0];
  var checkoutDiv = document.getElementsByClassName("checkout-div")[0];

  if (checkoutDiv.style.display === "grid"){
    products_container.style.display = "grid";
    checkoutDiv.style.display = "none";
  }
}



/*
* FUNCTION WHICH SHOWS THE SHOPPING CART PLUS ALL CONTAINING ELEMENTS
* */

function addItemToCart(title, price, imageSrc) {
  //console.log("addItemToCart");

  var checkoutRow = document.createElement("div");
  var cart_items1 = document.getElementsByClassName("cart_items")[0];
  var cartItemTitles = cart_items1.getElementsByClassName("item-title");

  //this for loop gets a hold of redundant cart rows
  //return if title is already existing
  for (var i = 0; i < cartItemTitles.length; i++) {
    if (cartItemTitles[i].innerText === title) {
      return
    }
  }
  var cartRow = document.createElement("div");
  cartRow.innerHTML = ` 
    <div class="cart-row">
      <div class="item-column cart-column">
        <img class="item-image" src="${imageSrc}" width="75" height="75">
        <span class="item-title" >${title}</span>
      </div>
      <div class="price-column cart-column">
        <span class="item-price">${price}EUR</span>
      </div>  
      <div class="quantity-column cart-column">
        <input class="quantity-input" type="number" value="1" name="quantity">
        <button class="remove-from-cart" type="button">Remove</button>
      </div>
      </div>
    </div>`;

  //console.log(cartRow);
  cart_items1.append(cartRow);

  //creating a checkout button and total price span
  checkoutRow.innerHTML = `
          <div class="cart_bot_div">
           <button name="checkout" class="checkout_button" >Checkout</button><div class="total"></div>
          </div>`;
  //var checkout_button = checkoutRow.getElementsByClassName("checkout_button")[0];

  var cart_bot_div = document.getElementsByClassName("cart_bot_div");
  // inserting it if none is already created
  if (cart_bot_div.length <= 0) {
    cart_items1.append(checkoutRow);

  } else {
    //removing the last button and append it to the end
    //because you dont want to have a checkout button after each cart row
    cart_bot_div[0].remove();
    cart_items1.append(checkoutRow);
  }

  //when a cart row is appended to cart_items div (shopping cart)
  //the event listeners for all inputs get activated
  //and the total gets updated
  removeAddEventListener();
  quantityAddEventListener();
  checkoutAddEventListener();
  updateTotal();

}


function updateTotal() {
  var total = 0;
  var shopping_cart_items = document.getElementsByClassName("cart_items")[0];
  //array of all cartRow Elements
  var cartRows = shopping_cart_items.getElementsByClassName("cart-row");

  for (var i = 0; i < cartRows.length; i++) {
    var cartRow = cartRows[i];
    var cartItemPrice = cartRow.getElementsByClassName("item-price")[0];
    var cartQuantityInput = cartRow.getElementsByClassName("quantity-input")[0];
    var itemPrice = parseFloat(cartItemPrice.innerHTML.replace("EUR", ""));
    var quantity = cartQuantityInput.value;
    total += itemPrice * quantity;
    total = Math.round(total * 100) / 100;
  }
  var totalOutput = shopping_cart_items.getElementsByClassName("total")[0];
  totalOutput.innerHTML = "Total: " + total + " EUR";
}

function quantityChanged(event) {
  var input = event.target;
  if (isNaN(input.value) || input.value <= 0) {
    input.value = 1;
  }
  updateTotal();
}


//regex validation of checkout-div inputs
function checkoutValidation(){
  //TODO: use regex to validate user-input. create feedback icons.
}