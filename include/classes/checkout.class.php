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
  private $connect;
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
    //parent::__construct($this->db_name);
    $this->connect = $this->connect();
    $this->connect();
    $this->getCustomerInfo();

  }


  public function getCustomerInfo(){
    $this->items_string = $_POST["itemlist"];
    $this->email = mysqli_real_escape_string($this->connect,$_POST["email"]);
    $this->firstname = mysqli_real_escape_string($this->connect,$_POST["firstname"]);
    $this->surname = mysqli_real_escape_string($this->connect,$_POST["surname"]);
    $this->streetname = mysqli_real_escape_string($this->connect,$_POST["streetname"]);
    $this->streetnumber = mysqli_real_escape_string($this->connect,$_POST["streetnumber"]);
    $this->city = mysqli_real_escape_string($this->connect,$_POST["city"]);
    $this->postalcode = mysqli_real_escape_string($this->connect,$_POST["postalcode"]);
    $this->country = mysqli_real_escape_string($this->connect,$_POST["country"]);
    $this->phonenumber = mysqli_real_escape_string($this->connect,$_POST["phonenumber"]);
    $this->getItemAndQuantity();

  }

  //filters the item+quantity from the items_string
  //formating the items_string into an dictionary {$item : $quantity}
  public function getItemAndQuantity(){

    if(preg_match_all("/[a-z\s]+=>\d+/",$this->items_string,$matches)){
      foreach($matches[0] as $index){
       if(preg_match("/[a-z\s]+/",$index,$match)){$item_name = $match;}
       if(preg_match("/\d+/",$index,$match)){$quantity = $match;}
       $this->purchasedItems[$item_name[0]] = $quantity[0];
       //error_log(json_encode($this->purchasedItems));
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
      foreach($this->product_info as $values){
        if ($item == $values[0]){
          $count2 +=1;
          $this->total += $values[3]*$quantity;
        }
      }
    }
    //validating the ItemNames by comparing, if all purchasedItems
    //also have been found in the product_info
    if ($count1 === $count2){
      error_log(json_encode("Total: ". $this->total));
      $this->databaseInsert();
    }else{
      error_log(json_encode("ItemNames have been changed by the user. No Insert into the Database. Function stops."));
      exit;
    }

  }

  // contains SQL Logic
  public function databaseInsert(){
    $totalprice = $this->total;
    $orderedItems = json_encode($this->purchasedItems);
    $email = $this->email;
    $firstname = $this->firstname;
    $surname = $this->surname;
    $streetname = $this->streetname;
    $street_number = $this->streetnumber;
    $city = $this->city;
    $postalcode = $this->postalcode;
    $country = $this->country;
    $phone_number = $this->phonenumber;

    /**
     *
     * the following code handles the logic for database inputs
     *
     */

    //country
    if($this->check_value($country,"countrys","name") == 0){
      $this->insert_values(["name"],[$country],"countrys");
      }
    //city
    if($this->check_value($city,"citys","name") == 0){
      //country id
      $country_id = $this->return_id($country,"countrys","name");
      $this->insert_values(["country_id","name"],[$country_id,$city],"citys");
    }
    //postalcode
    if($this->check_value($postalcode,"postalcodes","postalcode") == 0){
      //city id
      $city_id = $this->return_id($city,"citys", "name");
      $this->insert_values(["city_id","postalcode"],[$city_id,$postalcode],"postalcodes");
    }
    //street
    if($this->check_value($streetname,"streets","name") == 0){
      $postalcode_id = $this->return_id($postalcode,"postalcodes","postalcode");
      $this->insert_values(["postalcode_id","name"],[$postalcode_id,$streetname],"streets");
    }
    //customer
    if($this->check_value($email,"customers","email") == 0){
      $street_id = $this->return_id($streetname,"streets","name");
      $postalcode_id = $this->return_id($postalcode,"postalcodes","postalcode");
      $cols = ["email","firstname","surname","street_id","postalcode_id","street_number","phone_number"];
      $vars = [$email,$firstname,$surname,$street_id,$postalcode_id,$street_number,$phone_number];
      $this->insert_values($cols,$vars,"customers");
    }
    //orders
    $customer_id = $this->return_id($email,"customers","email");
    $this->insert_values(["customer_id","ordered_items","total_price"],[$customer_id,$orderedItems,$totalprice],"orders");

    //statistics
    $this->insert_values(["ordered_items","total_price"],[$orderedItems,$totalprice],"statistics");
  }
}