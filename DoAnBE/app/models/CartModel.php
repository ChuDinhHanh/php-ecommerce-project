<?php
class CartModel extends Model
{
    public function getCartByIdUser($id)
    {
        if ($id == -1) {
            return null;
        }
        $sql = parent::$connection->prepare('SELECT * FROM `cart` WHERE `id_account` = ?');
        $sql->bind_param("i", $id);
        return parent::select($sql);
    }
    public function getCountCartByIdAccount($idAccount)
    {
        $sql = parent::$connection->prepare("SELECT COUNT(*) as 'quantity' FROM `cart` WHERE `id_account` = ?");
        $sql->bind_param("i", $idAccount);
        return parent::select($sql)[0]['quantity'];
    }

    public function getTotalByCart($idAccount)
    {
        $productModel = new ProductModel();
        $total = 0;
        $sql = parent::$connection->prepare("SELECT * FROM `cart` WHERE `id_account`=?");
        $sql->bind_param("i", $idAccount);
        foreach (parent::select($sql) as $item){
            $total += $productModel->getProductById($item['id_sp'])['price'] *  $item['qty'];
        }
        return $total;
    }

    public function addToCart($idAccount, $idP)
    {
        $sql = parent::$connection->prepare('INSERT INTO `cart`(`id_account`, `id_sp`) VALUES (?,?)');
        $sql->bind_param("ii", $idAccount, $idP);
        return $sql->execute();
    }

    public function deleteProductInCart($idAccount, $idP)
    {
        $sql = parent::$connection->prepare('DELETE FROM `cart` WHERE `id_account`=? AND `id_sp`=?');
        $sql->bind_param("ii", $idAccount, $idP);
        return $sql->execute();
    }
    public function deleteAllProductInCart($idAccount)
    {
        $sql = parent::$connection->prepare('DELETE FROM `cart` WHERE `id_account`=?');
        $sql->bind_param("i", $idAccount);
        return $sql->execute();
    }

    public function updateQuantityInCartByAccount($idAccount, $idP, $quantity)
    {
        $sql = parent::$connection->prepare("UPDATE `cart` SET `qty`=? WHERE `id_account`=? AND `id_sp`=?");
        $sql->bind_param("iii",$quantity, $idAccount, $idP);
        return $sql->execute();
    }

}
