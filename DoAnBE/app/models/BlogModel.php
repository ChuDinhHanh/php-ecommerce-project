<?php
class BlogModel extends Model
{
    public function getAllBlogs()
    {
        $sql = parent::$connection->prepare("SELECT * FROM `blog` ORDER BY `view` DESC LIMIT 3");
        return parent::select($sql);
    }

    public function getBlogByPageNumber($pageNow, $productnumberOnPage)
    {
        $start = ($pageNow - 1) * $productnumberOnPage;
        $sql = parent::$connection->prepare('SELECT * FROM `blog` LIMIT ?,?');
        $sql->bind_param("ii", $start, $productnumberOnPage);
        return parent::select($sql);
    }

    public function getBlogByPageNumberByCategory($pageNow, $productnumberOnPage, $id)
    {
        $start = ($pageNow - 1) * $productnumberOnPage;
        $sql = parent::$connection->prepare('SELECT * FROM `blog` WHERE blog.category = ? LIMIT ?,? ');
        $sql->bind_param("iii", $id, $start, $productnumberOnPage);
        return parent::select($sql);
    }

    public function getCountAllBlog()
    {
        $sql = parent::$connection->prepare("SELECT COUNT(*) as 'total_page' FROM `blog`");
        return parent::select($sql)[0]['total_page'];
    }

    public function getCountAllBlogByCategory($id)
    {
        $sql = parent::$connection->prepare("SELECT COUNT(*)  as 'total_page' FROM `blog` WHERE blog.category = ?");
        $sql->bind_param('i', $id);
        return parent::select($sql)[0]['total_page'];
    }

    public function pageQuantityBlog($countProduct, $productnumberOnPage)
    {
        $numberPage = ceil($countProduct / $productnumberOnPage);
        return $numberPage;
    }

    public function getTop3Newslasted()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `blog` ORDER BY id DESC LIMIT 3');
        return parent::select($sql);
    }


    public function getBlogById($id)
    {
        $sql = parent::$connection->prepare('SELECT *,blog.img as img_pro FROM `blog` INNER JOIN account ON blog.id_account = account.id WHERE blog.id = ?');
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }

    public function searchBlogByTitleOrContent($q)
    {
        $q = "%$q%";
        $sql = parent::$connection->prepare('SELECT * FROM `blog` WHERE `title` LIKE ? OR `content` LIKE ?');
        $sql->bind_param("ss", $q, $q);
        return parent::select($sql);
    }


    public function getTop3BlogSameAutho($id)
    {
        $sql = parent::$connection->prepare('SELECT *,blog.id AS `index` FROM `blog` INNER JOIN account ON blog.id_account = account.id HAVING blog.id_account = ? ORDER BY blog.id DESC LIMIT 3');
        $sql->bind_param('i', $id);
        return parent::select($sql);
    }

    public function createBlog($id_account, $title, $content, $category, $img)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $time = date("M/d/y h:i:sa") . '';
        $sql = parent::$connection->prepare('INSERT INTO `blog`(`id_account`, `time`, `title`, `content`, `category`, `img`) VALUES (?,?,?,?,?,?)');
        $sql->bind_param('isssis', $id_account, $time, $title, $content, $category, $img);
        if ($sql->execute()) {
            $flag  = true;
        } else {
            $flag = false;
        };
        return $flag;
    }
}
