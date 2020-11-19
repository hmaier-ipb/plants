<?php

require_once ("include/classes/content.class.php");
require_once ("include/classes/db.class.php");

class admin extends db
{
  //TODO: zeigt nur die erste zeile des tables an
  function load_orders(){
    $orders = $this->return_table("orders");
    //return json_encode($orders);
    //formating the array given from return_table to html format
    $out = "";
    foreach ($orders as $order){
      $out.= "<p>$order</p>";
    }
    return $out;
  }
}