<?php

require_once ("include/classes/content.class.php");
require_once ("include/classes/db.class.php");

class admin extends db
{

  public function load_orders()
  {
    $orders = $this->return_table("orders");
    //error_log(json_encode($orders));
    $out = "";

    while ($array = mysqli_fetch_row($orders)) {
      $out .= "<p class='order_paragraph' id='$array[0]'>";
      $out .= "<span class='order_id'>Order ID:$array[0]</span>";
      $out .= "<span style='display:none' class='customer_id'>Customer ID:$array[1]</span>";
      $out .= "<span>Ordered Items: $array[2] </span>";
      $out .= "<span>Total Price: $array[3]</span>";
      $out .= "</p>";
    }
    return $out;
  }


  public function load_customer_info($customer_id, $order_id)
  {
    $customer_info = $this->return_row($customer_id, "customers", "id");
    $firstname = $customer_info[2];
    $surname = $customer_info[3];
    $street_id = $customer_info[4];
    $street_row = $this->return_row($street_id, "streets", "id");
    $street_name = $street_row[2];
    $street_number = $customer_info[6];
    $postal_code_id = $customer_info[5];
    $postalcode_row = $this->return_row($postal_code_id, "postalcodes", "id");
    $postalcode = $postalcode_row[2];
    $city_id = $postalcode_row[1];
    $city_row = $this->return_row($city_id, "citys", "id");
    $city_name = $city_row[2];
    $order_row = $this->return_row($order_id, "orders", "id");
    $order = $order_row[2];
    $total_price = $order_row[3];
    return [$firstname, $surname, $street_name, $street_number, $postalcode, $city_name, $order, $total_price, $order_id];
  }

  public function remove_order($order_id)
  {
    $this->remove_row($order_id, "orders");
  }

  public function load_statistics()
  {
    $order_table = $this->return_table("orders");
    //average total price
    $count_total_prices = 0;
    $whole_total_price = 0;
    $active_ordered_items = [];
    while ($array = mysqli_fetch_row($order_table)) {

      #average total price
      $count_total_prices += 1;
      $whole_total_price += $array[3];

      //receive active orders
      $items_assoc_active = json_decode($array[2]);
      foreach($items_assoc_active as $key=>$value){
        if(array_key_exists($key,$active_ordered_items)){
          $existing_value = $active_ordered_items[$key];
          $active_ordered_items[$key] = $existing_value + $value;
        }else{
          $active_ordered_items[$key] = $value;
        }
      }
    }
    if($whole_total_price >= 1){
      $average_total = $whole_total_price / $count_total_prices;
      $average_total = strval(round($average_total,2));
    }else{
      $average_total = 0;
    }
    arsort($active_ordered_items);

    //generating HTML

    $active_average_total_div = "<div>
                          <h3>AVERAGE TOTAL PRICE</h3>
                          <p>$average_total$</p>
                          </div>";

    //generating a list of the quantity of all orderd items
    $active_ordered_items_div = "<div><h3>ORDERED ITEMS</h3>";
    foreach($active_ordered_items as $item=>$quantity){
      $active_ordered_items_div .= "<ul>$item: $quantity </ul>";
    }
    $active_ordered_items_div .= "</div>";


    //statistics of all time
    $count = 0;
    $total_price = 0;
    $all_ordered_items = [];
    $statistics_table = $this->return_table("statistics");
    while($array = mysqli_fetch_row($statistics_table)){
      $count += 1;
      $total_price += $array[2];

      $items_assoc = json_decode($array[1]);
      foreach($items_assoc as $key=>$value){
        if(array_key_exists($key,$all_ordered_items)){
          $existing_value = $all_ordered_items[$key];
          $all_ordered_items[$key] = $existing_value + $value;
        }else{
          $all_ordered_items[$key] = $value;
        }
      }
    }

    if($total_price >=1){
      $all_time_average_total = $total_price/$count;
      $all_time_average_total = strval(round($all_time_average_total,2));
    }else{
      $all_time_average_total = 0;
    }
    arsort($all_ordered_items);

    //generating HTML
    $all_time_average_total_div = "<div>
                          <h3>AVERAGE TOTAL PRICE</h3>
                          <p>$all_time_average_total$</p>
                          </div>";

    $all_time_ordered_items_div = "<div><h3>ORDERED ITEMS</h3>";
    foreach($all_ordered_items as $item=>$quantity){
      $all_time_ordered_items_div .= "<ul>$item: $quantity </ul>";
    }
    $all_time_ordered_items_div .= "</div>";



    return $out = "<div class='statistics_div' id='today'><h2>Today</h2>".$active_average_total_div . $active_ordered_items_div."</div>
                   <div class='statistics_div' id='all_time'><h2>All Time</h2>".$all_time_average_total_div.$all_time_ordered_items_div."</div>";
  }

  // kein ahnung bisher
  function new_product(){
    $out = "<form action='admin.php' method='post' enctype='multipart/form-data'>
            <input type='file' name='image' />
            <button>Upload</button>
            </form>";
    return $out;
  }
}