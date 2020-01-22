<?php
class userToken_model
{
    public $user_id;
    public $token;
    public $date_expiration;

    public function CreateToken($conn_obj)
    {
    if(!$this->TokenExsist($conn_obj))
    {

    }
    }
    function GenerateToken()
    {
        $this->token = bin2hex(random_bytes(20));
    }

    public function TokenExsist($conn_obj)
    {

    }

    public static function LogIn($email,$pass)
    {

    }



}