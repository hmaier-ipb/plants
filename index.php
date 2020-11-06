<?php
require_once("../smarty/libs/Smarty.class.php");
require_once ("include/classes/content.class.php");
//require_once ("include/classes/db.class.php");
function errl($var){
  error_log(json_encode($var));
}

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

$tpl = ["m"=>"main.html"];
$smarty_object->assign($vars);
$smarty_object->display($tpl["m"]);


/*
//receiving content from javascript
$email = $_POST["email"];
$firstname = $_POST["firstname"];
$surname = $_POST["surname"];
$streetname = $_POST["streetname"];
$streetnumber = $_POST["streetnumber"];
$city = $_POST["city"];
$postalcode = $_POST["postalcode"];
$country = $_POST["country"];
$phonenumber = $_POST["phonenumber"];
//indices synchronous
$items = $_POST["items"]; //items array
$quantity = $_POST["quantity"]; //quantity array
$totalprice = $_POST["totalprice"];
*/

$itemlist_string = isset($_POST["itemlist"])?$_POST["itemlist"]: "";

//using regex to filter out the "item=>quantity"
$pattern = "/[a-z]+=>\d/";
if(preg_match_all($pattern,$itemlist_string,$matches)){
  foreach ($matches as $match){
    errl($match);
  }
}






