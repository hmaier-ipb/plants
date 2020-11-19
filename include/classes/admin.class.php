<?php

require_once ("include/classes/content.class.php");
require_once ("include/classes/db.class.php");

class admin extends db
{

  public function load_orders(){
    $orders = $this->return_table("orders");
    //error_log(json_encode($orders));
    $out = "";

    while($array = mysqli_fetch_row($orders)){
      $out .= "<p class='order_paragraph'>";
      $out .= "<span class='order_id'>Order ID:$array[0]</span>";
      $out .= "<span class='customer_id'>Customer ID:$array[1]</span>";
      $out .= "<span>Ordered Items: $array[2] </span>";
      $out .= "<span>Total Price: $array[3]</span>";
      $out .= "</p>";
    }
    return $out;
  }

  //on click of p load this function
  public function load_customer_info($customer_id,$order_id)
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
    return [$firstname,$surname,$street_name,$street_number,$postalcode,$city_name,$order_id];
  }
  public function remove_order($order_id){
    $this->remove_row($order_id,"orders");
  }
}