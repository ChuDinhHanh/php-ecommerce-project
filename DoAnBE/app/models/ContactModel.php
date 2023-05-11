<?php
class ContactModel extends Model
{
    public function getAllContact()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `contact`');
        return parent::select($sql)[0];
    }
    public function updateContact($phone_number, $addres, $open_time, $close_time, $email, $gg_link_addres, $name)
    {
        $sql = parent::$connection->prepare('UPDATE `contact` SET `phone_number`=?,`addres`=?,`open_time`=?,`close_time`=?,`email`=?,`gg_link_addres`=?,`name`=?');
        $sql->bind_param("sssssss", $phone_number, $addres, $open_time, $close_time, $email, $gg_link_addres, $name);
        return $sql->execute();
    }
}