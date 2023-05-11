<?php
class AccountModel extends Model
{
    public function checkAccount($user, $pass, $role)
    {
        $sql = parent::$connection->prepare('SELECT `id`,`status` FROM `account` WHERE `username`=?  AND `password`=? AND `role`=?');
        $sql->bind_param("ssi", $user, $pass, $role);
        if (!empty(parent::select($sql))) {
            if (parent::select($sql)[0]['status'] == 0) {
                return parent::select($sql)[0]['id'];
            } else {
                return -1;
            }
        }
        return 0;
    }

    public function registerAccount($user, $pass)
    {
        $sql = parent::$connection->prepare('INSERT INTO `account`(`username`, `password`) VALUES (?,?)');
        $sql->bind_param("ss", $user, $pass);
        return $sql->execute();
    }

    public function changePassword($id_user, $newPass)
    {
        $sql = parent::$connection->prepare('UPDATE `account` SET `password`=? WHERE `id`=?');
        $sql->bind_param("si", $newPass, $id_user);
        return $sql->execute();
    }

    public function lockAccount($status, $id_user)
    {
        $sql = parent::$connection->prepare('UPDATE `account` SET `status`=? WHERE `id`=?');
        $sql->bind_param("ii", $status, $id_user);
        return $sql->execute();
    }
    public function getAccountById($id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `account` WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return parent::select($sql);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////
    public function getCountAccountCustomer()
    {
        $sql = parent::$connection->prepare('SELECT count(*) as "qty_cus" FROM `account` WHERE `role` = 0');
        return parent::select($sql)[0]['qty_cus'];
    }
    public function getAllAccount()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `account` ');
        return parent::select($sql);
    }

    public function getAccountPage($limit, $offset)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `account` LIMIT ? OFFSET ?');
        $sql->bind_param('ii', $limit, $offset);
        return parent::select($sql);
    }
}
