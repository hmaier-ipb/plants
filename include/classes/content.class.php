<?php

/**
 *
 *elements.class.php is responsible for creating redundant HTML elements
 *the functions are giving out strings, containing HTML tags
 *input variables for the functions are different kind of arrays
 *
 */


class content
{


  function card_html($plants)
  {
    //$plants = [
    //            ["image path","plant name","plant description",price as int],
    //            ["image path","plant name","plant description", price as int]
    //          ]

    $output = "";
    //$output .= "<div class='scroll-container' style='display: block'>";
    foreach ($plants as $info) {
      $plantname = $info[0];
      $image = $info[1];
      $description = $info[2];
      $price = $info[3];
      $output .= "<div class='card'>
                    <div class='info'>
                    <div class='plant'><div class='circle'><img class='product-image' src='/plants/include/media/$image' alt='image'></div></div>
                    <h1 class='title'>$plantname</h1>
                    <h3>$description</h3>
                    <div class='price'>Price: <b>$price</b> EUR</div>
                    <button class='add-to-cart-btns'>Add to Cart</button>
                    </div>
                   </div>";

    }
    //$output .= "</div>";
    return $output;
  }


  function dropdown_html($dropdown_content)
  {
    // $dropdown_content = [["colum",[["link1", "description1"],["link2", "description2"]]]]
    $output = "";
    $output .= "<div class='dropdown_container'>";
    foreach ($dropdown_content as $col) {
      $output .= "<div class='dropdown'>";
      $output .= "<button class='dropdown_button'>" . $col[0] . "</button>";
      $output .= "<div class='dropdown_col'>";
      //$col[1] bezieht sich auf den array mit den arrays->["link", "description"]
      //$col[0] ist "col"
      foreach ($col[1] as $row) {
        $output .= "<a  class='dropdown_row' href='$row[0]'>$row[1]</a>";
      }
      $output .= "</div>";
      $output .= "</div>";
    }
    $output .= "</div>";
    return $output;
  }

  function checkout_html()
  {
    $output = "<div class='checkout-div' style='display: none;'>
    <div class='customer-info'>
      <span>email<input id='email' type='email' placeholder='email'></span>
      <div class='two-inputs'><span>firstname<input id='firstname' placeholder='firstname'></span><span>surname<input id='surname' placeholder='surname'></span></div>
      <div class='two-inputs'><span>streetname<input id='streetname' placeholder='streetname'></span><span>street number<input id='streetnumber' placeholder='streetnumber'></span></div>
      <div class='two-inputs'><span>city<input id='city' placeholder='city'></span><span>postal code<input id='postalcode' placeholder='postal code'></span></div>
      <span>country <input id='country' placeholder='country'></span>
      <span>phone number <input id='phonenumber' placeholder='phone number'></span>
      <button class='place_order'>Place Order</button>
    </div>
  </div>
    ";
    return $output;
  }

  /**
   * @param array $list_content
   * @return string
   *
   * default mode = 0 -> UNORDERED LIST
   * mode = 1 -> ORDERED LIST
   */
  function generate_nav_buttons($list_content)
  {
    $output = "";
    foreach ($list_content as $item=>$key) {
      $output .= "<button class='nav' id='$key'>$item</button>";
    }
    return $output;
  }

}

