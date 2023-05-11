<?php
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require_once "./app/models/$className.php";
});

$textForSearch;
if (isset($_GET['txt'])) {
    $textForSearch = $_GET['txt'];
}

$product = new ProductModel();
$productListSearch = $product->searchByNameAndDescribeForAjax($textForSearch);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .abc:hover {
            background-color: greenyellow;
        
        }
        .abc{
            margin-top: -2px;
            border: none;
            outline: none;
        }
    </style>
</head>

<body>

    <?php
    foreach ($productListSearch  as $value) {
    ?>
        <div class="hero__search__form" style="background-color: wheat;">
            <div class="abc">
                <a href="shop-details.php?id=<?php echo $value['id']; ?>">
                    <div style="display: flex; justify-content: space-between;">
                        <img style="width: 50px; height: 50px;" src="img/product/<?php echo $value['image'] ?>" />
                        <p style="margin-right: 20px;color: white;"><?php echo $value['name']; ?></p>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>