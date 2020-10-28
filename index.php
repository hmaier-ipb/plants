<?php
require_once("../smarty/libs/Smarty.class.php");
require_once ("include/classes/content.class.php");
//require_once ("include/classes/db.class.php");
$smarty_object = new Smarty();
$smarty_object->left_delimiter = '<!--{';
$smarty_object->right_delimiter = '}-->';

$content = new content;



$plants = [
  "pilea" => ["pilea.png","pilea description"],
  "monstera" => ["monstera.png","monstera description"],
  "san_pedro" => ["san_pedro.png", "san pedro description"],
  "castano" =>["castanospermum_australe.png", "castano description"]
  ];

$vars  = ["content"=>""];

foreach($plants as $plant=>$info){
  $vars["content"] .=  $content->card_html($info[0],$info[1]);
}


$tpl = ["main"=>"main.html"];
$smarty_object->assign($vars);
$smarty_object->display($tpl["main"]);
