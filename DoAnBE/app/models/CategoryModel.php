<?php
class CategoryModel extends Model
{
    
    public function getAllCategory()
    {
            $sql = parent::$connection->prepare('SELECT * FROM `category`');
            return parent::select($sql);
    }
    public function getCategoryPage($limit, $offset)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `category` ORDER BY `id` DESC LIMIT ? OFFSET ?');
        $sql->bind_param('ii', $limit, $offset);
        return parent::select($sql);
    }
    public function updateCategory($name,$id)
    {
        $sql = parent::$connection->prepare('UPDATE `category` SET `name`= ? WHERE `id` = ?');
        $sql->bind_param('si', $name, $id);
        return $sql->execute();
    }
    public function createCategory($name)
    {
        $sql = parent::$connection->prepare('INSERT INTO `category`(`name`) VALUES (?)');
        $sql->bind_param('s', $name);
        return $sql->execute();
    }
}