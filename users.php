<?php
require_once 'DbConnection/mysql-connect.php';
require_once 'DbConnection/mysql-info.php';
require_once 'DbModels/user_model.php';
$conn_obj = new mysql_connect($host,$user,$password,$database);
$conn_obj->connectToDatabase();

if($_SERVER['request_method']=='POST')
{
    if(isset($_POST['email']) && isset($_POST['password']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new user_model();
        $user->password = $password;
        $user->email = $email;
        $user->RegisterUser($conn_obj);
        exit(json_encode($user->message));
    }else{
        $message = array("message"=>"not enough parameters provided");
        http_response_code(404);
        exit(json_encode($message));
    }
}
?>
