<?php

require_once("../smarty/libs/Smarty.class.php");
require_once ("include/classes/admin.class.php");
require_once ("include/classes/content.class.php");

$smarty_object = new Smarty();
$smarty_object->left_delimiter = '<!--{';
$smarty_object->right_delimiter = '}-->';
$tpl = ["a"=>"admin.html"];

$admin = new admin();

$content = new content();

$vars = ["nav"=>"","orders"=>"","statistics"=>""];

//generating the navbar
$nav = ["Orders"=>"orders","New Product"=>"new_product","Statistics"=>"statistics"];
$vars["nav"] = $content->generate_nav_buttons($nav);

//showing the orders
$vars["orders"] = $admin->load_orders();

//load statistics
$vars["statistics"] = $admin->load_statistics();


if (isset($_POST["action"])){
  switch($_POST["action"]){
    case "load_customer_info":
      $customer_id_string = $_POST["customer_id_string"];
      $order_id_string = $_POST["order_id_string"];
      if(preg_match_all("/\d+/",$customer_id_string,$match)){$customer_id = $match[0][0];}
      if(preg_match_all("/\d+/",$order_id_string,$match)){$order_id = $match[0][0];}
      echo json_encode($admin->load_customer_info($customer_id,$order_id));
      break;
    case "remove_order":
      $order_id = $_POST["order_id"];
      $admin->remove_order($order_id);
      echo json_encode($admin->load_orders());
      break;
    case "statistics":
      //error_log(json_encode($admin_site->load_statistics()));
      echo json_encode($admin->load_statistics());
      break;
    case "orders":
      echo json_encode($admin->load_orders());
      break;
    case "new_product":
      echo json_encode($admin->new_product());
      break;
    default:
  }
}else {

  $smarty_object->assign($vars);
  $smarty_object->display($tpl["a"]);
}

