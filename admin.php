<?php

require_once("../smarty/libs/Smarty.class.php");
require_once ("include/classes/admin.class.php");
require_once ("include/classes/content.class.php");

$smarty_object = new Smarty();
$smarty_object->left_delimiter = '<!--{';
$smarty_object->right_delimiter = '}-->';
$tpl = ["a"=>"admin.html"];

$admin_site = new admin();

$content = new content();

$vars = ["nav"=>"","orders"=>""];

//generating the navbar
$nav = ["Orders","Customer Search","New Product","Statistics"];
$vars["nav"] = $content->generate_nav_buttons($nav);

//showing the orders
$vars["orders"] = $admin_site->load_orders();

if (isset($_POST["action"])){
  switch($_POST["action"]){
    case "load_customer_info":
      $customer_id_string = $_POST["customer_id_string"];
      $order_id_string = $_POST["order_id_string"];
      if(preg_match_all("/\d+/",$customer_id_string,$match)){$customer_id = $match[0][0];}
      if(preg_match_all("/\d+/",$order_id_string,$match)){$order_id = $match[0][0];}
      echo json_encode($admin_site->load_customer_info($customer_id,$order_id));
      break;
    case "remove_order":
      $order_id = $_POST["order_id"];
      $admin_site->remove_order($order_id);
      echo json_encode($admin_site->load_orders());
      break;
    default:
  }
}else{

  $smarty_object->assign($vars);
  $smarty_object->display($tpl["a"]);
}