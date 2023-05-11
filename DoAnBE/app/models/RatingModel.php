<?php
class RatingModel extends Model
{
    public function CreateRating($id_account, $id_product, $star, $comment)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $time = date("M/d/y h:i:sa") . '';
        $sql = parent::$connection->prepare('INSERT INTO `rating`(`id_account`, `id_product`, `star`, `comment`,`time`) VALUES (?,?,?,?,?)');
        $sql->bind_param('iiiss', $id_account, $id_product, $star, $comment, $time);
        return $sql->execute();
    }


    public function getAllRating($id_product)
    {
        $sql = parent::$connection->prepare('SELECT *,rating.id as id_com FROM `rating` INNER JOIN account ON rating.id_account = account.id WHERE rating.id_product = ? ORDER BY rating.id DESC');
        $sql->bind_param('i', $id_product);
        return parent::select($sql);
    }

    public function deleteRatingById($id_rating)
    {
        $flag = true;
        $sql = parent::$connection->prepare('DELETE FROM `rating` WHERE `id` = ?');
        $sql->bind_param('i', $id_rating);
        if ($sql->execute()) {
            $flag  = true;
        } else {
            $flag = false;
        };
        return $flag;
    }

    public function getARating($id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `rating` WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }
    public function updateRatingById($id, $comment)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $time = date("M/d/y h:i:sa") . '';
        $sql = parent::$connection->prepare('UPDATE `rating` SET `comment`=?, `time`= ? WHERE  `id` = ?');
        $sql->bind_param('ssi', $comment, $time, $id);
        return $sql->execute();
    }

    public function checkRatingByAccount($id_account, $id_product)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `rating` WHERE `id_account` = ? AND `id_product` = ?');
        $sql->bind_param('ii', $id_account, $id_product);
        return parent::select($sql);
    }
}
