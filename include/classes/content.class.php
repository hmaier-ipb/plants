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
    $output .= "<div class='scroll-container'>";
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
    $output = "<div class='checkout-div'>
    <div class='customer-info'>
      email<input type='email' placeholder='email'>
      <div class='FaS_name'>firstname<input placeholder='firstname'>surname<input placeholder='surname'></div>
      city <input placeholder='city'>
      <div class='CaP'>country<input placeholder='country'>postal code<input placeholder='postal code'></div>
      phone number <input placeholder='phone number'>
      <button class='place_order'>Place Order</button>
    </div>
    <div class='shopping-cart'>
      <!--this part of the shopping cart get generated in javascript-->
    </div>
  </div>
    ";
    return $output;
  }
}