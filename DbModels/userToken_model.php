<?php
class userToken_model
{
    public $user_id;
    public $token;
    public $date_expiration;

    public function CreateToken($conn_obj)
    {
        $this->GenerateToken();
        $this->CreateTimestamp();
        $stmt = mysqli_prepare($conn_obj->conn,"insert into user_token values(?,?,?)");
        $sii = 'sii';
        $stmt->bind_param($sii,$this->token,$this->user_id,$this->date_expiration);
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }
    function GenerateToken()
    {
        $this->token = bin2hex(random_bytes(20));
    }

    function CreateTimestamp()
    {
        $this->date_expiration = time()+1800;
    }


    public function TokenExists($conn_obj)
    {
        $stmt = mysqli_prepare($conn_obj->conn,"select user_id from user_token where token=?");
        $s = 's';
        $stmt->bind_param($s,$this->token);
        if($stmt->execute())
        {
            $stmt->bind_result($user_id);
            if($stmt->fetch())
            {
                $this->user_id = $user_id;
                $stmt->close();
                return true;
            }
        }
        $stmt->close();
        return false;
    }

    public static function LogIn($email,$pass,$conn_obj)
    {
        $stmt = mysqli_prepare($conn_obj->conn,"select user_id from users where email=? and password=?");
        $ss = 'ss';
        $stmt->bind_param($ss,$email,$pass);
        if($stmt->execute())
        {
            $stmt->bind_result($user_id);
            if($stmt->fetch())
            {
                $user_token = new userToken_model();
                $user_token->user_id = $user_id;
                $stmt->close();
                $user_token->CreateToken($conn_obj);
                return $user_token;
            }
        }
        return null;

    }



}