<?php

class note_model
{
    public $note_id;
    public $user_id;
    public $note;

    public function CreateNote($conn_obj)
    {
        $stmt = mysqli_prepare($conn_obj->conn,"insert into note values(null,?,?)");
        $si = 'si';
        $stmt->bind_param($si,$this->note,$this->user_id);
        if($stmt->execute())
        {
            $this->note_id = $stmt->insert_id;
            return true;
        }
        return false;

    }

    public function DeleteNote($conn_obj)
    {
        $stmt = mysqli_prepare($conn_obj->conn,"delete from note where note_id=?");
        $stmt->bind_param('i',$this->note_id);
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }

    public function UpdateNote($conn_obj,$note)
    {
        $stmt = mysqli_prepare($conn_obj->conn,"update note set note=? where note_id=?");
        $stmt->bind_param('si',$note,$this->note_id);
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }

    public static function GetNotes($conn_obj,$user_id)
    {
        $info = array();
        $stmt = mysqli_prepare($conn_obj->conn,"select users.user_id,users.email, note.note_id, note.note from users inner join note on note.user_id=users.user_id where users.user_id=?;");
        $stmt->bind_param('i',$user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row=$result->fetch_row())
        {
            $arr = array("user_id"=>$row[0],"user_email"=>$row[1],"note_id"=>$row[2],"note"=>$row[3]);
            $info[]=$arr;
        }
        exit(json_encode($info));
    }



};



?>