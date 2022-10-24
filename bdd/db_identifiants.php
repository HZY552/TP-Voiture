<?php
abstract class db_identifiants{
    private $host = "89.156.15.147";
    private $db_name = "voiture";
    private $username = "pc";
    private $password = "jiojio000608.";

    public function get_identifiants(){
        $arr = array();
        array_push($arr,$this->host,$this->db_name,$this->username,$this->password);
        return $arr;
    }

}