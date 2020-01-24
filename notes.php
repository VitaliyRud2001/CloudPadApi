<?php
require_once 'DbConnection/mysql-connect.php';
require_once 'DbConnection/mysql-info.php';
require_once 'DbModels/userToken_model.php';

$conn_obj = new mysql_connect($host,$user,$password,$database);
$conn_obj->connectToDatabase();
header('Content-type: application/json');
if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['token']) && isset($_POST['note'])) {
      $token = $_POST['token'];
      $note = $_POST['note'];
      $user_token = new userToken_model();
      $user_token->token = $token;
      if($user_token->TokenExists($conn_obj))
      {
        echo "Yes,token exsists";
      }
      else
      {
        echo "No fucking way!";
      }

    }else{
      http_response_code(404);
      $answer = array("message" => "not enough parameters provided" );
      exit(json_encode($answer));
    }



}





?>
