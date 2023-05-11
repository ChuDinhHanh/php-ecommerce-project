<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
if (!isset($_SESSION['$type_sort'])) $_SESSION['$type_sort'] = 0;
////////////////////////////////////////////////'////////////////////////
/////////////////    Khai báo giá trị mặc định      ////////////////////

$productNumberOnPage = 6;
$listProductSearch = null;
$pageNow = 1;
$countProduct = 0;
$pageQuantity = 0;
$countProduct = 0;
$_SESSION['page'] = "shop-grid.php";
$type_sort = 0;

/////////////////       Kết thúc khai báo           ////////////////////
////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
/////////////////         Khởi tạo class            ////////////////////
$productModel = new ProductModel();

/////////////////       Kết thúc khởi tạo           ////////////////////
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
/////////////////         Sử lí dữ liệu             ////////////////////

//Tìm kiếm sản phẩm
if (isset($_POST['q'])) {
    $q = $_POST['q'];
    $listProductSearch = $productModel->searchByNameAndDescribe($q);
}
//Phân trang cho tất cả sản phẩm
if (isset($_GET['pageNow'])) {
    $pageNow = $_GET['pageNow'];
}

$countProduct = $productModel->getCountAllProduct();
$pageQuantity = $productModel->pageQuantity($countProduct, $productNumberOnPage);

if ($pageNow <= 0) {
    $pageNow = $pageQuantity;
}
if ($pageNow > $pageQuantity) {
    $pageNow = 1;
}

if (isset($_GET['sort'])) {
    $_SESSION['$type_sort'] = $_GET['sort'];
}
if ($_SESSION['$type_sort']  == 0) {
    $listProductOnPage = $productModel->getProductByPageNumber($pageNow, $productNumberOnPage);
} else if ($_SESSION['$type_sort']  == 1) {
    $listProductOnPage = $productModel->getProductByPageNumberASC($pageNow, $productNumberOnPage);
} else {
    $listProductOnPage = $productModel->getProductByPageNumberDESC($pageNow, $productNumberOnPage);
}
/////////////////       Kết thúc sử lí dữ liệu      ////////////////////
////////////////////////////////////////////////////////////////////////


//getAllProductSale
$listProductSale =  $productModel->getAllProductSale();
//contact information
$contact = new ContactModel();
$in4Contact = $contact->getAllContact();
//heart 
$heartModel = new HeartModel();

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/logo.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.php">Home</a></li>
                <li><a href="./shop-grid.php">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.php">Shop Details</a></li>
                        <li><a href="./shoping-cart.php">Shoping Cart</a></li>
                        <li><a href="./checkout.php">Check Out</a></li>
                        <li><a href="./blog-details.php">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.php">Blog</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            <li><a href="#">Fresh Meat</a></li>
                            <li><a href="#">Vegetables</a></li>
                            <li><a href="#">Fruit & Nut Gifts</a></li>
                            <li><a href="#">Fresh Berries</a></li>
                            <li><a href="#">Ocean Foods</a></li>
                            <li><a href="#">Butter & Eggs</a></li>
                            <li><a href="#">Fastfood</a></li>
                            <li><a href="#">Fresh Onion</a></li>
                            <li><a href="#">Papayaya & Crisps</a></li>
                            <li><a href="#">Oatmeal</a></li>
                            <li><a href="#">Fresh Bananas</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!-- Search start-->
                    <?php include 'search.php'; ?>
                    <!-- Search end -->
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Organi Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <?php if ($listProductSearch != null) { ?>
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Search Results</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                <?php foreach ($listProductSearch as $product) { ?>
                                    <div class="col-lg-4">
                                        <div class="product__discount__item">
                                            <div class="product__discount__item__pic set-bg" data-setbg="img/product/<?php echo $product['image'] ?>">

                                                <ul class="product__item__pic__hover">
                                                    <?php
                                                    if ($heartModel->checkAccountLikeProduct($idAccount, $product['id']) == false) { ?>
                                                        <li><a href="heart.php?idPL=<?php echo $product['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                                    <?php
                                                    } else { ?>
                                                        <li><a style="color:red;" href="heart.php?idPDL=<?php echo $product['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                                    <?php
                                                    } ?>
                                                    <li><a href="carthandling.php?idP=<?php echo $product['id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="product__discount__item__text">
                                                <h5>
                                                    <a style="color: greenyellow;" href="shop-details.php?id=<?php echo $product['id'] ?>"><?php echo $product['name']; ?></a>
                                                </h5>
                                                <div class="product__item__price"><?php echo $product['price']; ?>đ<span><?php echo $product['price']; ?>đ</span></div>
                                                <div class="header__cart">
                                                    <i class="fa fa-heart"></i> <span><?php echo $heartModel->getCountLikeByProduct($product['id']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="product__discount">
                    <div class="section-title product__discount__title" style="display: flex;justify-content: center;align-items: center;">
                        <h2>Sale Off</h2>
                    </div>
                    <div class="row">
                        <div class="container">
                            <div class="product__discount__slider owl-carousel">
                                <?php
                                foreach ($listProductSale as $product) {
                                ?>
                                    <div class="col-lg-4">
                                        <div class="product__discount__item">
                                            <div class="product__discount__item__pic set-bg" data-setbg="img/product/<?php echo $product['image']; ?>">
                                                <div class="product__discount__percent">-<?php echo $product['sale_off']; ?> %</div>
                                                <ul class="product__item__pic__hover">
                                                    <?php
                                                    if ($heartModel->checkAccountLikeProduct($idAccount, $product['id']) == false) { ?>
                                                        <li><a href="heart.php?idPL=<?php echo $product['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                                    <?php
                                                    } else { ?>
                                                        <li><a style="color:red;" href="heart.php?idPDL=<?php echo $product['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                                    <?php
                                                    } ?>
                                                    <li><a href="carthandling.php?idP=<?php echo $product['id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="product__discount__item__text">
                                                <h5><a style="color: greenyellow;" href="shop-details.php?id=<?php echo $product['id'] ?>"><?php echo $product['name']; ?></a></h5>
                                                <div class="product__item__price">$<?php echo $product['price']; ?><span>$<?php echo ($product['price'] - ($product['sale_off'] * $product['price']) / 100) ?></span></div>
                                                <div class="header__cart">
                                                    <i class="fa fa-heart"></i> <span><?php echo $heartModel->getCountLikeByProduct($product['id']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex;justify-content: center;align-items: center;">
                    <div>
                        <div class="filter__sort" style="display: flex;">
                            <span style="padding-left: 90xp;">sorted:</span>
                            <a href="shop-grid?sort=0" style="margin: 0 5px;color: <?php echo ($_SESSION['$type_sort']  == 0) ? 'red' : ''; ?>">none</a></br>
                            <a href="shop-grid?sort=1" style="margin: 0 5px;color: <?php echo ($_SESSION['$type_sort']  == 1) ? 'red' : ''; ?>">ascending</a></br>
                            <a href="shop-grid?sort=2" style="margin: 0 5px;color: <?php echo ($_SESSION['$type_sort']  == 2) ? 'red' : ''; ?>">decrease</a>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <?php foreach ($listProductOnPage as $product) { ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="img/product/<?php echo   $product['image']; ?>">
                                        <ul class="product__item__pic__hover">
                                            <?php
                                            if ($heartModel->checkAccountLikeProduct($idAccount, $product['id']) == false) { ?>
                                                <li><a href="heart.php?idPL=<?php echo $product['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                            <?php
                                            } else { ?>
                                                <li><a style="color:red;" href="heart.php?idPDL=<?php echo $product['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                            <?php
                                            } ?>
                                            <li><a href="carthandling.php?idP=<?php echo $product['id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a style="color: greenyellow;" href="shop-details.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></h6>
                                        <div class="product__item__price">$<del><?php echo $product['price']; ?></del></del><span>$<?php echo ($product['price'] - ($product['sale_off'] * $product['price']) / 100) ?></span></div>
                                        <div class="header__cart">
                                            <i class="fa fa-heart"></i> <span><?php echo $heartModel->getCountLikeByProduct($product['id']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="product__pagination" style="display: flex; justify-content: center; align-items: center;">
                    <?php if ($pageQuantity > 1) { ?>
                        <a href="shop-grid.php?pageNow=1">FIRST</a>
                        <a href="shop-grid.php?pageNow=<?php echo ($pageNow - 1) ?>"><i class="fa fa-long-arrow-left"></i></a>
                        <?php

                        if ($pageNow > 3) {
                        ?>
                            <a>...</a>
                        <?php
                        }

                        ?>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $pageQuantity; $i++) { ?>
                        <?php

                        if ($pageNow == $i) {
                        ?>
                            <a style="background-color: greenyellow;"><?php echo $i ?></a>
                            <?php
                        } else {
                            if ($i >= $pageNow - 2 && $pageNow + 2 >= $i) {
                            ?>
                                <a href="shop-grid.php?pageNow=<?php echo $i ?>"><?php echo $i ?></a>
                        <?php
                            }
                        }
                        ?>
                    <?php } ?>
                    <?php if ($pageQuantity > 1) { ?>
                        <?php
                        if ($pageNow - $pageQuantity <= -3) {
                        ?>
                            <a>...</a>
                        <?php
                        }
                        ?>
                        <a href="shop-grid.php?pageNow=<?php echo ($pageNow + 1) ?>"><i class="fa fa-long-arrow-right"></i></a>
                        <a href="shop-grid.php?pageNow=<?php echo $pageQuantity; ?>">LAST</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Footer Section Begin -->
    <?php include 'footer.php'; ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>