<?php

/**
 * this class handles the information
 * gathered from the checkout process
 * and inserts it into a database
 *
 *
 */

require_once ("include/classes/db.class.php");

class checkout extends db
{
  private $email;
  private $firstname;
  private $surname;
  private $streetname;
  private $streetnumber;
  private $city;
  private $postalcode;
  private $country;
  private $phonenumber;
  private $items_string; //the string from the ajax request
  private $purchasedItems;
  private $product_info; //the array with the product information
  private $total;

  function __construct($product_info){
    $this->product_info = $product_info;
    parent::__construct();
    $this->connect = $this->connect();
    $this->getCustomerInfo();

  }


  public function getCustomerInfo()
  {

    $this->items_string = $_POST["itemlist"];
    $this->email = $_POST["email"];
    $this->firstname = $_POST["firstname"];
    $this->surname = $_POST["surname"];
    $this->streetname = $_POST["streetname"];
    $this->streetnumber = $_POST["streetnumber"];
    $this->city = $_POST["city"];
    $this->postalcode = $_POST["postalcode"];
    $this->country = $_POST["country"];
    $this->phonenumber = $_POST["phonenumber"];
    $this->getItemAndQuantity();

  }

  //filters the item+quantity from the items_string
  //formating the items_string into an dictionary {$item : $quantity}
  public function getItemAndQuantity(){

    if(preg_match_all("/[a-z\s]+=>\d/",$this->items_string,$matches)){
      foreach($matches[0] as $index){
       if(preg_match("/[a-z\s]+/",$index,$match)){$item_name = $match;}
       if(preg_match("/\d/",$index,$match)){$quantity = $match;}
       $this->purchasedItems[$item_name[0]] = $quantity[0];
      }
    }
    $this->calculateTotal();
  }

  // calculate the total price by
  public function calculateTotal(){
    $this->total = 0;
    $count1 = 0;
    $count2 = 0;
    foreach($this->purchasedItems as $item => $quantity){
      $count1 +=1;
      foreach($this->product_info as $key => $value){
        if ($item === $value[1]){
          $count2 +=1;
          $this->total += $value[3]*$quantity;
        }
      }
    }
    //validating the ItemNames by comparing if the same number of purchasedItems
    //also have been found in the product_info
    if ($count1 === $count2){
      error_log(json_encode("Total: ".$this->total));
      $this->databaseInsert();
    }else{
      error_log(json_encode("ItemNames have been changed. No Insert into the Database. Functions stops."));
      exit;
    }

  }

  public function databaseInsert(){

  }
}