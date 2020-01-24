<?php
require_once 'DbConnection/mysql-connect.php';
require_once 'DbConnection/mysql-info.php';
require_once 'DbModels/userToken_model.php';

$conn_obj = new mysql_connect($host,$user,$password,$database);
$conn_obj->connectToDatabase();
header('Content-type: application/json');
if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_token = userToken_model::LogIn($email,$password,$conn_obj);
        if($user_token!=null)
        {
            http_response_code(201);

            $answer = array("token"=>$user_token->token);
            exit(json_encode($answer));
        }
        else
        {
            http_response_code(401);
            $answer = array("message"=>"incorrect password or login");
            exit(json_encode($answer));
        }
    }else{
      http_response_code(404);
      $answer = array("message" => "not enough parameters provided" );
      exit(json_encode($answer));
    }



}





?>
