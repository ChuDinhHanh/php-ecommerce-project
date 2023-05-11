<?php
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require_once "./app/models/$className.php";
});

$textForSearch;
if (isset($_GET['txt'])) {
    $textForSearch = $_GET['txt'];
}

$product = new BlogModel();
$productListSearch = $product->searchBlogByTitleOrContent($textForSearch);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    foreach ($productListSearch  as $value) {
    ?>
        <a href="blog-details.php?id=<?php echo $value['id']; ?>" class="blog__sidebar__recent__item">
            <div class="blog__sidebar__recent__item__pic">
                <img style="width: 100px;" src="img/blog/<?php echo $value['img']; ?>" alt="">
            </div>
            <div class="blog__sidebar__recent__item__text">
                <h6><?php echo $value['title']; ?></h6>
                <span><?php echo $value['time']; ?></span>
            </div>
        </a>
    <?php
    }
    ?>
</body>

</html>