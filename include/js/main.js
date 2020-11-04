
function init_main() {
  //this function get initiated when the content of the page is loaded

  //add an event listener to all addToCartButtons (in every product-card)
  var addToCartButtons = document.getElementsByClassName("add-to-cart-buttons");
  for (let i = 0; i < addToCartButtons.length; i++) {
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
  var bottomDiv = document.getElementsByClassName("bot")[0];
  var checkoutDiv = document.getElementsByClassName("checkout-div")[0];
  var shopping_cart_items = document.getElementsByClassName("cart_items")[0];
  var cart_bottom_div = shopping_cart_items.getElementsByClassName("cart_bottom_div")[0];
  //right div on the checkoutDiv
  var checkout_shopping_cart = document.getElementsByClassName("shopping-cart")[0];
  for(var i = 0; i < checkoutButton.length; i++){
    checkoutButton[i].addEventListener("click", function (){
      //switching between the divs
      bottomDiv.style.display = "none";
      checkoutDiv.style.display = "flex";
      //copying the shopping cart (all functions remain) into
      checkout_shopping_cart.append(shopping_cart_items);
      //removing/disappearing the checkout button
      this.remove();
    });
  }
}

/*
* FUNCTIONS FOR EVENT LISTENERS
* */

function addToCartClicked(event) {
  //event is the object linked to the specific button clicked
  //the target is the button clicked on
  var buttonClicked = event.target;
  var cart = document.getElementsByClassName("cart_items")[0];
  cart.style.display = "block";
  //gets the class info which containes the description of the product and the price
  //starting from the buttonClicked as reference for the correct information
  var info = buttonClicked.parentElement.parentElement;
  var title = info.getElementsByClassName("title")[0].innerText
  //parse float and .replace is to get the price just as a number
  var price = parseFloat(info.getElementsByClassName("price")[0].innerText.replace("Price: ", ""))
  //accesing the source of the product picture
  var imageSrc = info.getElementsByClassName("product-image")[0].src;
  addItemToCart(title, price, imageSrc);

}

function removeFromCartClicked(event) {
  //removing the cart row in which the button was clicked
  var buttonClicked = event.target;
  buttonClicked.parentElement.parentElement.remove();
  //vars for removing the checkout button
  var shopping_cart_items = document.getElementsByClassName("cart_items")[0];
  //synonymous for cart-rows
  var cartItemNames = shopping_cart_items.getElementsByClassName("item-title");
  var checkoutButton = document.getElementsByClassName("checkout_button");
  updateTotal();
  //if there are no more cart-rows in the shopping-cart: the cart disappears
  if (cartItemNames.length <= 0) {
    checkoutButton[0].remove();
    var totalOutput = shopping_cart_items.getElementsByClassName("total")[0];
    totalOutput.innerHTML = "";
    var cart = document.getElementsByClassName("cart_items")[0];
    cart.style.display = "none";
  }

}

/*
* FUNCTION WHICH SHOWS THE SHOPPING CART PLUS ALL CONTAINING ELEMENTS
* */

function addItemToCart(title, price, imageSrc) {
  //creating the two divs for append an item to the list and the checkout button
  var cartRow = document.createElement("div");
  var checkoutRow = document.createElement("div");
  var shopping_cart_items = document.getElementsByClassName("cart_items")[0];
  var cartItemNames = shopping_cart_items.getElementsByClassName("item-title");
  //this for loop gets a hold of redundant cart-rows
  //checks if title is already existing
  //if it is: no second instance of it, is added to the array because the return-statement ends the functions instantly
  for (var i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].innerText === title) {
      return
    }
  }

  var cartRowContent = ` 
    <div class="cart-row">
      <div class="item-column cart-column">
        <img class="item-image" src="${imageSrc}" width="75" height="75">
        <span class="item-title">${title}</span>
      </div>
      <div class="price-column cart-column">
        <span class="item-price">${price}EUR</span>
      </div>  
      <div class="quantity-column cart-column">
        <input class="quantity-input" type="number" value="1">
        <button class="remove-from-cart" type="button">Remove</button>
      </div>
      </div>
    </div>`;
  cartRow.innerHTML = cartRowContent;
  shopping_cart_items.append(cartRow);
  //creating a checkout button and total price span
  var bottomDivContent = `
          <div class="cart_bottom_div">
           <button name="checkout" class="checkout_button">Checkout</button><div class="total"></div>
          </div>`;
  checkoutRow.innerHTML = bottomDivContent;
  var bottomDiv = document.getElementsByClassName("cart_bottom_div");
  // inserting it if none is already created
  if (bottomDiv.length <= 0) {
    shopping_cart_items.append(checkoutRow);
  } else {
    //removing the last button and append it to the end
    //because you dont want to have a checkout button after each cart row
    bottomDiv[0].remove();
    shopping_cart_items.append(checkoutRow);
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