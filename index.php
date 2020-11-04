<?php
require_once("../smarty/libs/Smarty.class.php");
require_once ("include/classes/content.class.php");
//require_once ("include/classes/db.class.php");
/*
spl_autoload_register(function ($class_name){
  include "include/classes/".$class_name. ".class.php";
});
*/

$smarty_object = new Smarty();
$smarty_object->left_delimiter = '<!--{';
$smarty_object->right_delimiter = '}-->';

$content = new content;

//smarty variables for loading the website
$vars  = ["products"=>"","dropdown"=>"","checkout"=>""];

//generating the plant cards
$plants = [
  "pilea" => ["pilea.png","pilea","pilea description",13.99],
  "monstera" => ["monstera.png","monstera","monstera description",9.99],
  "acrea" => ["acrea.png", "acrea","acrea description",19.99],
  "san_pedro" => ["san_pedro.png","san pedro", "san pedro description",42.01],
  "castano" =>["castanospermum_australe.png", "castanospermum australe", "castano description",15.15]

  ];
$vars["products"] =  $content->card_html($plants);

//generating the dropdowns
$dropdown_content = [
  ["colname1",[["link1", "row1"],["link2", "row2"],["link3","row3"],["link4","row4"]]],
  ["colname2",[["link1", "row1"],["link2", "row2"],["link3","row3"],["link4","row4"]]],
  ["colname3",[["link1", "row1"],["link2", "row2"]]]
  ];
$vars["dropdown"] = $content->dropdown_html($dropdown_content);

//generating the checkout
$vars["checkout"] = $content->checkout_html();

$tpl = ["m"=>"main.html","co"=>"checkout.html"];
$smarty_object->assign($vars);
$smarty_object->display($tpl["m"]);
