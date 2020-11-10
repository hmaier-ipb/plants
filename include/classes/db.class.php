<?php

/**
 *
 */



class db
{
  //the standard database login credentials
  protected $host = "127.0.0.1";
  protected $user = "www-data";
  protected $pwd = "";
  protected $db_name = "";

  public function __construct ()
  {
    $this->connect = $this->connect();
  }

  //calling this function in __construct opens a connection when the class is instantiated
  function connect()
  {
    return mysqli_connect($this->host,$this->user,$this->pwd,$this->db_name);
  }

  //sets autoincrement to number of row plus 1
  // useful when deleting something from a table
  public function set_autoinc($table)
  {
    $query = "SELECT * FROM ".$table;
    $all_data = $this->query_to_db($query);
    $rows_num = mysqli_num_rows($all_data);
    $set_auto_increment_query = "ALTER TABLE ".$table." AUTO_INCREMENT=".$rows_num+=1;
    query_to_db($set_auto_increment_query);
  }

  //used for sending queries to the db
  public function query_to_db($query)
  {
    return mysqli_query($this->connect,$query);
  }

  //used for finding a certain variable in a certain table and column
  //if you want to search through ALL COLUMNS you have to address every column on its own
  public function search_entry($var, $table, $column)
  {
    $query = "SELECT * FROM " . $table . " WHERE " . $column . "='" . $var . "'";
    $check = $this->query_to_db($query);
    return (mysqli_num_rows($check) == 0) ? 0 : 1; // 0 = not existing, 1 >= existing
  }
  //delete the last 100 values from a table
  public function delete_table($table){
    $query = "DELETE FROM ". $table ."WHERE id ORDER BY id DESC LIMIT 100";
    $this->query_to_db($query);
    $this->set_autoinc($table);
  }

  //changes a single value
  public function change_entry($newvar,$oldvar,$table,$column)
  {
    $query1 = "SELECT id FROM ".$table."WHERE".$column."=".$oldvar;
    $id_result = $this->query_to_db($query1);
    $oldvar_id = mysqli_fetch_row($id_result);
    $query2 = "UPDATE ".$table." SET ".$column."=".$newvar." WHERE id=".$oldvar_id;
    $this->query_to_db($query2);
  }

  //deleting last row
  public function delete_last_row($table)
  {
    $query = "DELETE FROM ".$table." WHERE id ORDER BY id DESC LIMIT 1";
    $this->query_to_db($query);
  }

  //deletes the last 100 rows from all tables in the current database
  public function clear_all_tables()
  {
    $result = $this->query_to_db("SHOW TABLES");
    $tables = mysqli_fetch_assoc($result);

    foreach ($tables as $table)
    {
      $query = "DELETE FROM ".$table." WHERE id ORDER BY id DESC LIMIT 100";
      $this->query_to_db($query);
    }
  }


}