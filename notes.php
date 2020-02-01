<?php
require_once 'DbConnection/mysql-connect.php';
require_once 'DbConnection/mysql-info.php';
require_once 'DbModels/userToken_model.php';
require_once 'DbModels/note_model.php';
$conn_obj = new mysql_connect($host,$user,$password,$database);
$conn_obj->connectToDatabase();
header('Content-type: application/json');


if($_SERVER['REQUEST_METHOD']=='GET')
{
    $_GET = json_decode(file_get_contents('php://input'), true);
    if(isset($_GET['token'])) {
        $token = $_GET['token'];
        $user_token = new userToken_model();
        $user_token->token = $token;
        if($user_token->TokenExists($conn_obj))
        {
            $notes = note_model::GetNotes($conn_obj,$user_token->user_id);
            if($notes!=null)
            {
                http_response_code(200);
                exit(json_encode($notes));
            }
            else
            {
                http_response_code(404);
                $answer = array("message"=>"content not found");
                exit(json_encode($answer));
            }
        }
      http_response_code(401);
      $answer = array("message"=>"Incorrect token");
      exit(json_encode($answer));
    }
    http_response_code(404);
    $answer = array("message" => "not enough parameters provided" );
    exit(json_encode($answer));

}




else if($_SERVER['REQUEST_METHOD']=='POST') {
  $_POST = json_decode(file_get_contents('php://input'), true);
    if (isset($_POST['token']) && isset($_POST['note'])) {
      $token = $_POST['token'];
      $note = $_POST['note'];
      $user_token = new userToken_model();
      $user_token->token = $token;
      if($user_token->TokenExists($conn_obj))
      {
        $note_model = new note_model();
        $note_model->user_id = $user_token->user_id;
        $note_model->note = $note;
        if($note_model->CreateNote($conn_obj))
        {
          http_response_code(201);
          $answer = array("message"=>"successfully created nodt");
          exit(json_encode($answer));
        }else{
          http_response_code(400);
          $answer = array("message"=>"error while creating note");
        }
      }
      else{
      http_response_code(401);
      $answer = array("message"=>"incorrect token");
      exit(json_encode($answer));
      }

    }else{
      http_response_code(404);
      $answer = array("message" => "not enough parameters provided" );
      exit(json_encode($answer));
    }



}
else if($_SERVER['REQUEST_METHOD']=='PUT') {
 $_PUT = json_decode(file_get_contents('php://input'), true);
 $token = $_PUT['token'];
 $note_id = $_PUT['note_id'];
 $new_note = $_PUT['new_note'];

 $user_token = new userToken_model();
 $user_token->token = $token;
  if($user_token->TokenExists($conn_obj)){
    $note_model = new note_model();
    $note_model->note_id = $note_id;
    if($note_model->UpdateNote($conn_obj,$new_note))
    {
        http_response_code(200);
        $answer = array("message"=>"successfuly updated note");
        exit(json_encode($answer));
    }else{
        http_response_code(400);
        $answer = array("message"=>"error while updating note");
        exit(json_encode($answer));
    }
  }else{
      http_response_code(401);
      $answer = array("message"=>"incorrect token");
      exit(json_encode($answer));
  }


}





?>
