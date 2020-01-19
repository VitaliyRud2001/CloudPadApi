<?php
class mysql_connect
{
    public $host;
    public $user;
    public $pass;
    public $database;
    public $conn;
    public $query;


    public function __construct($host, $user, $pass, $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }

    public function connectToDatabase()
    {
        $this->conn=mysqli_connect($this->host,$this->user,$this->pass,$this->database) or die("mysql connection error");
        
    }


    public function closeConnection()
    {
        mysqli_close($this->conn);
    }

    public function query($query)
    {
        $this->query=mysqli_query($this->conn,$query) or die("There is some error!");
    }




};
?>
