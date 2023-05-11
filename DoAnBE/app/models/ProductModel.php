<?php
class ProductModel extends Model
{

    public function getProductByPageNumber($pageNow, $productnumberOnPage)
    {
        $start = ($pageNow - 1) * $productnumberOnPage;
        $sql = parent::$connection->prepare('SELECT * FROM `product` LIMIT ?,?');
        $sql->bind_param("ii", $start, $productnumberOnPage);
        return parent::select($sql);
    }

    //giam
    public function getProductByPageNumberDESC($pageNow, $productnumberOnPage)
    {
        $start = ($pageNow - 1) * $productnumberOnPage;
        $sql = parent::$connection->prepare('SELECT * FROM `product` ORDER BY price DESC  LIMIT ?,?');
        $sql->bind_param("ii", $start, $productnumberOnPage);
        return parent::select($sql);
    }

    //tang
    public function getProductByPageNumberASC($pageNow, $productnumberOnPage)
    {
        $start = ($pageNow - 1) * $productnumberOnPage;
        $sql = parent::$connection->prepare('SELECT * FROM `product` ORDER BY price ASC LIMIT ?,?');
        $sql->bind_param("ii", $start, $productnumberOnPage);
        return parent::select($sql);
    }



    public function searchByNameAndDescribe($q)
    {
        $q = "%$q%";
        $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE `name` LIKE ? OR `description` LIKE ?');
        $sql->bind_param("ss", $q, $q);
        return parent::select($sql);
    }


    public function searchByNameAndDescribeForAjax($q)
    {
        $q = "%$q%";
        $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE `name` LIKE ? OR `description` LIKE ? LIMIT 5');
        $sql->bind_param("ss", $q, $q);
        return parent::select($sql);
    }

    public function getAllProducts($idOfCategory)
    {
        if ($idOfCategory == 0) {
            $sql = parent::$connection->prepare('SELECT * FROM `product`');
        } else {
            $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE `id_category` = ?');
            $sql->bind_param('i', $idOfCategory);
        }
        return parent::select($sql);
    }
    

    public function getAllProductsRelated($limit, $offset, $id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE id_category = ? LIMIT ? OFFSET ?');
        $sql->bind_param('iii', $id, $limit, $offset);
        return parent::select($sql);
    }


    public function getAllProductsSameCategory($id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE id_category IN (SELECT id_category FROM product WHERE id = ?)');
        $sql->bind_param('i', $id);
        return parent::select($sql);
    }

    public function getProductsPerpage($limit, $offset, $idOfCategory)
    {
        if ($idOfCategory == 0) {
            $sql = parent::$connection->prepare('SELECT * FROM `product` LIMIT ? OFFSET ?');
            $sql->bind_param('ii', $limit, $offset);
        } else {
            $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE `id_category` = ? LIMIT ? OFFSET ?');
            $sql->bind_param('iii', $idOfCategory, $limit, $offset);
        }
        return parent::select($sql);
    }



    public function getProductsPerpageRelated($limit, $offset, $id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product`  WHERE id_category in(SELECT id_category FROM `product`  WHERE id = ?) LIMIT ? OFFSET ?');
        $sql->bind_param('iii', $id, $limit, $offset);
        return parent::select($sql);
    }


    public function getProductsNew()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product` ORDER BY id DESC LIMIT 15');
        return parent::select($sql);
    }

    public function getProductsTopView()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product` ORDER BY view DESC LIMIT 15');
        return parent::select($sql);
    }

    public function getProductsTopRate()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `rating` INNER JOIN product ON rating.id_product = product.id GROUP BY `id_product`ORDER BY  AVG(`star`)  DESC LIMIT 15');
        return parent::select($sql);
    }

    public function getAProductByID($id)
    {
        $sql = parent::$connection->prepare('SELECT *, product.image  as imgpro, product.name as namepro,AVG(rating.star) as stb,COUNT(*) as sldg, cty.id AS idty, cty.name as tencty, cty.address as dchicty  FROM `product` INNER JOIN rating on product.id = rating.id_product 
        INNER JOIN company AS cty ON product.id_company = cty.id
        GROUP BY product.id HAVING product.id = ?');
        $sql->bind_param('i', $id);
        $check = parent::select($sql);
        if (empty($check)) {
            $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE id = ?');
            $sql->bind_param('i', $id);
        }
        return parent::select($sql)[0];
    }
    public function getRelatedProduct($id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE `id_category` = ?');
        $sql->bind_param('i', $id);
        return parent::select($sql);
    }

    //------------------------------------------------------ minh 12/29/2022
    public function getProductById($idP)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE `id`=?');
        $sql->bind_param("i", $idP);
        return parent::select($sql)[0];
    }
    public function getCountAllProduct()
    {
        $sql = parent::$connection->prepare("SELECT COUNT(*) as 'total_page' FROM `product`");
        return parent::select($sql)[0]['total_page'];
    }

    public function pageQuantity($countProduct, $productnumberOnPage)
    {
        $numberPage = ceil($countProduct / $productnumberOnPage);
        return $numberPage;
    }

    public function getAllProductSale()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `product` WHERE `sale_off` != 0');
        return parent::select($sql);
    }
    public function createProduct($name,$price,$sale_off,$description,$image,$company,$category,$status){
        $sql = parent::$connection->prepare('INSERT INTO `product`(`name`, `price`, `id_company`, `id_category`, `sale_off`, `description`, `image`, `status`) VALUES (?,?,?,?,?,?,?,?)');
        $sql->bind_param("siiiissi",$name,$price,$company,$category,$sale_off,$description,$image,$status);
        return $sql->execute();
    }
    public function updateProduct($id,$name,$price,$sale_off,$description,$image,$company,$category,$status){
        $sql = parent::$connection->prepare('UPDATE `product` SET `name`=?, `price`=?, `id_company`=?, `id_category`=?, `sale_off`=?, `description`=?, `image`=?, `status`=? WHERE `id`=?');
        $sql->bind_param("siiiissii",$name,$price,$company,$category,$sale_off,$description,$image,$status,$id);
        return $sql->execute();
    }
}
