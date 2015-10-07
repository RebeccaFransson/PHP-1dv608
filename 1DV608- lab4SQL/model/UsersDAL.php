<?php

namespace model;
class ExistingUserException extends \Exception {};
class UsersDAL{

  private static $table = "Users";
  private static $servername = "localhost";
  private static $usernameDB = "root";
  private static $passwordDB = "";
  private static $nameDB = "UsersLAB4";
  private static $usernameColom = "username";
  private static $passwordColom = "password";
  private $conn;
  private $UsersDB = array();

  /*public function __construct(){


  }*/
  // Create connection
  public function connetToDB(){
    $this->conn = new \mysqli(self::$servername, self::$usernameDB, self::$passwordDB, self::$nameDB);
    // Check connection
    if ($this->conn->connect_error) {
        die("Connection failed: " . $this->conn->connect_error);
    }
  }
  public function existingUser($username){
    //sql som lägger till en user i listan
    //return true om den finns
    $getexist = "SELECT EXISTS
      (SELECT 1
        FROM `". self::$table ."`
        WHERE username = ". $username ."`)";

    $result = mysql_query($getexist);
    var_dump($result);
    var_dump(mysqli_fetch_assoc($result));
    if ($getexist === FALSE) {//fått tillbaka en användare med det användarnamnet
      throw new ExistingUserException();
    }
  }

  public function addUser($username, $password){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $add = $this->conn->prepare("INSERT INTO  `". self::$table ."`(
			`". self::$usernameColom ."` , `". self::$passwordColom ."`)
				VALUES (?, ?)");
		if ($add === FALSE) {
			throw new \Exception($this->conn->error);
		}
		$add->bind_param('ss', $username, $password);
		$add->execute();
  }
  //finns det en användare med detta lösneordet?



}

?>
