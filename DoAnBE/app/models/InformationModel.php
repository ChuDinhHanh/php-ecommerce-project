<?php
class InformationModel extends Model
{
    public function getInformationByIdAccount($id_account)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `information` WHERE `id_account` = ?');
        $sql->bind_param("i", $id_account);
        if (!empty(parent::select($sql))) {
            return parent::select($sql)[0];
        }
        return null;
    }
    public function updateInformationByIdAccount($id_account, $name, $address,$phone)
    {
        $sql = parent::$connection->prepare('UPDATE `information` SET `name`=?, `phone_number`=?, `addres`=? WHERE `id_account`=?');
        $sql->bind_param("sssi", $name, $phone, $address, $id_account);
        return $sql->execute();
    }
    public function insertInformationByIdAccount($id_account, $name, $address,$phone)
    {
        $sql = parent::$connection->prepare('INSERT INTO `information`(`id_account`, `name`, `phone_number`, `addres`) VALUES (?,?,?,?)');
        $sql->bind_param("isss", $id_account, $name, $phone, $address);
        return $sql->execute();
    }
}