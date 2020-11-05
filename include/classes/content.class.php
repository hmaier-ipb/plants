<?php

/**
 *
 *content.class.php is responsible for creating redundant HTML elements
 *the functions are giving out strings, containing HTML tags
 *input variables for the functions are differnt kind of arrays
 *
 */


class content
{


  function card_html($plants){
    //$plants = ["plant"=>["image path","plant name","plant description"]]
    $i = 0;
    $output = "";
    $output .= "<div class='scroll-container' style='display: block'>";
    foreach($plants as $plant=>$info){
      $i++;
      $image = $info[0];
      $plantname = $info[1];
      $description = $info[2];
      $price = $info[3];
      $output .= "<div class='card'>
            <div class='info'>
            <div class='plant'>
                <div class='circle'><img class='product-image' src='/plants/include/media/$image' alt='image'></div>
            </div>
                <h1 class='title'>$plantname</h1>
                <h3>$description</h3>
                <div class='price'>Price: <b>$price</b> EUR</div>
                <div class='add_to_cart_container'>
                    <button class='add-to-cart-buttons'>Add to Cart</button>
                </div>
            </div>
          </div>";

    }
    $output .= "</div>";
    return $output;
  }


  function dropdown_html($dropdown_content){
    // $dropdown_content = [["colum",[["link1", "description1"],["link2", "description2"]]]]
    $output = "";
    $output .= "<div class='dropdown_container'>";
    foreach ($dropdown_content as $col){
      $output .= "<div class='dropdown'>";
      $output .= "<button class='dropdown_button'>".$col[0]."</button>";
      $output .= "<div class='dropdown_col'>";
      //$col[1] bezieht sich auf den array mit den arrays->["link", "description"]
      //$col[0] ist "col"
      foreach ($col[1] as $row){
        $output .= "<a  class='dropdown_row' href='$row[0]'>$row[1]</a>";
      }
      $output .= "</div>";
      $output .= "</div>";
    }
    $output .= "</div>";
    return $output;
  }

  function checkout_html(){
    $output = "<form action='index.php' method='post'><div class='checkout-div' style='display: none;'>
    <div class='customer-info'>
      <span>email<input type='email' placeholder='email'></span>
      <div class='two-inputs'><span>firstname<input placeholder='firstname'></span><span>surname<input placeholder='surname'></span></div>
      <span>city <input placeholder='city'></span>
      <div class='two-inputs'><span>country<input placeholder='country'></span><span>postal code<input placeholder='postal code'></span></div>
      <span>phone number <input placeholder='phone number'></span>
      <button class='place_order'>Place Order</button>
    </div>
  </div></form>
    ";
    return $output;
  }
}