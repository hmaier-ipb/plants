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
$nav = ["Statistics","Orders","New Product"];
$vars["nav"] = $content->generate_nav_buttons($nav);

//showing the orders
$vars["orders"] = $admin_site->load_orders();


$smarty_object->assign($vars);
$smarty_object->display($tpl["a"]);