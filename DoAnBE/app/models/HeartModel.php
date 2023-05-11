<?php
class HeartModel extends Model
{
    public function like($id_account, $idP)
    {
        $sql = parent::$connection->prepare("INSERT INTO `heart`(`id_account`, `id_product`) VALUES (?,?)");
        $sql->bind_param("ii", $id_account, $idP);
        return $sql->execute();
    }
    public function dislike($id_account, $idP)
    {
        $sql = parent::$connection->prepare('DELETE FROM `heart` WHERE `id_account`=? AND `id_product`=?');
        $sql->bind_param("ii", $id_account, $idP);
        return $sql->execute();
    }

    public function getAllProductLike($id_account)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `heart` WHERE `id_account`=?');
        $sql->bind_param("i", $id_account);
        if (!empty(parent::select($sql))) {
            return parent::select($sql);
        }
        return null;
    }
    public function getCountLikeByProduct($idP)
    {
        $sql = parent::$connection->prepare('SELECT COUNT(`id_account`) AS "count_like" FROM `heart` WHERE `id_product`=?');
        $sql->bind_param("i", $idP);
        if (!empty(parent::select($sql))) {
            return parent::select($sql)[0]["count_like"];
        }
        return null;
    }
    public function checkAccountLikeProduct($id_account, $idP)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `heart` WHERE `id_account`=? AND `id_product`=?");
        $sql->bind_param("ii", $id_account, $idP);
        if (!empty(parent::select($sql))) {
            return true;
        }
        return false;
    }

    public function getCountLikeByAcount($id_account)
    {
        $sql = parent::$connection->prepare('SELECT COUNT(`id_product`) as "count_like" FROM  `heart` WHERE `id_account`=?');
        $sql->bind_param("i", $id_account);
        if (!empty(parent::select($sql))) {
            return parent::select($sql)[0]["count_like"];
        }
        return 0;
    }
}
