<?php

require_once("../smarty/libs/Smarty.class.php");
require_once ("include/classes/content.class.php");
require_once ("include/classes/checkout.class.php");

function errl($var){
  error_log(json_encode($var));
}

$plants = [
  "pilea" => ["pilea.png","pilea","pilea description",13.99],
  "monstera" => ["monstera.png","monstera","monstera description",9.99],
  "acrea" => ["acrea.png", "acrea","acrea description",19.99],
  "san_pedro" => ["san_pedro.png","san pedro", "san pedro description",42.01],
  "castano" =>["castanospermum_australe.png", "castanospermum australe", "castano description",15.15]
];

$dropdown_content = [
  ["colname1",[["link1", "row1"],["link2", "row2"],["link3","row3"],["link4","row4"]]],
  ["colname2",[["link1", "row1"],["link2", "row2"],["link3","row3"],["link4","row4"]]],
  ["colname3",[["link1", "row1"],["link2", "row2"]]]
];

if(isset($_POST["action"])){
  switch($_POST["action"]){
    case "checkout":
      //place order button was pressed
      $checkout = new checkout($plants);
      break;
    default:
  }
}else{
  
  $smarty_object = new Smarty();
  $smarty_object->left_delimiter = '<!--{';
  $smarty_object->right_delimiter = '}-->';
  $tpl = ["m"=>"main.html"];

  $content = new content;

  //smarty variables for loading the website
  $vars  = ["products"=>"","dropdown"=>"","checkout"=>""];

  //generating the plant cards and inserting them into vars
  $vars["products"] =  $content->card_html($plants);

  //generating the dropdowns and inserting them into vars
  $vars["dropdown"] = $content->dropdown_html($dropdown_content);

  //generating the checkout and inserting them into vars
  $vars["checkout"] = $content->checkout_html();

  $smarty_object->assign($vars);
  $smarty_object->display($tpl["m"]);
}










