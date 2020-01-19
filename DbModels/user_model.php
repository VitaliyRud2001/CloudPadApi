<?php


class user_model
{
public $user_id;
public $email;
public $password;

public $message;

public function RegisterUser($conn_obj)
{
    if (!($this->UserExists($conn_obj)))
    {
    $stmt = mysqli_prepare($conn_obj->conn,"insert into users values(null,?,?)");
    $ss = 'ss';
    $stmt->bind_param($ss,$this->email,$this->password);
    if($stmt->execute())
    {
        $this->user_id = $stmt->insert_id;
        http_response_code(201);
        $this->message = array("message"=>"user successfully created");
        return true;
    }else
    {
        http_response_code(409);
        $this->message=array("message"=>"error on server");
    }
    }

    return false;
}

public function UserExists($conn_obj)
{
    $stmt = mysqli_prepare($conn_obj->conn,"select user_id from users where email=?");
    $s = 's';
    $stmt->bind_param($s,$email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0)
    {
        $stmt->close();
        $this->message = array("message"=>"user already exists");
        http_response_code(409);
        return true;
    }
    $stmt->close();
    return false;
}


};



?>