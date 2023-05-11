<?php
session_start();
//thanh lap session chua danh muc dang xuat ra o hien tai
if (!isset($_SESSION['categoryLoadNow'])) {
    $_SESSION['categoryLoadNow'] = '0';
}
//bat danh muc hien tai
if (isset($_GET['categoryNow'])) {
    $_SESSION['categoryLoadNow'] = $_GET['categoryNow'];
}
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require_once "./app/models/$className.php";
});
//Lấy tất cả company
$companyModel = new CompanyModel();
$listCompany = $companyModel->getAllCompany();
$_SESSION['page'] = "index.php";
//day danh muc----------------
$category = new CategoryModel();
$categoryList = $category->getAllCategory();
//day san pham-----------
$product = new ProductModel();
//lay tong so san pham theo danh muc
$productList = $product->getAllProducts($_SESSION['categoryLoadNow']);
//trang hein tai
$pageNow = 1;
if (isset($_GET['pageNow'])) {
    $pageNow = $_GET['pageNow'];
}
//san pham tren 1 trang
$productPerpage = 8;
//dem so luong san pham
$qtyProduct = count($productList);
//so trang
$numberOfPage =  ceil(($qtyProduct) / $productPerpage);
if ($pageNow < 1) {
    $pageNow = $numberOfPage;
}
if ($pageNow > $numberOfPage) {
    $pageNow = 1;
}
//lay gia tri bat dau offset
$offset = (($pageNow - 1)  * $productPerpage);
//day san pham tren 1 trang
$productListPerpage = $product->getProductsPerpage($productPerpage, $offset, $_SESSION['categoryLoadNow']);
//lay danh sach san pham moi nhat
$productListNew = $product->getProductsNew();
//lay danh sach san pham co luot xem nhieu nhat
$productListMostView = $product->getProductsTopView();
//lay danh sach sab pham danh gia cao nhat
$productListMostRate = $product->getProductsTopRate();
//day blog 
$blog = new BlogModel();
$blogListMostView = $blog->getAllBlogs();
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
    <?php include "navbar-mobile.php"; ?>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                    </div>
                </div>
                <div class="col-lg-9">
                    <!-- Search start-->
                    <?php include 'search.php'; ?>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <?php foreach ($listCompany as $item){
                            ?>
                        <div class="categories__item set-bg" data-setbg="img/company/<?php echo $item['image'] ?>">
                            <h5><a href="#"><?php echo  $item['name'] ?></a></h5>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <?php
                            if ($_SESSION['categoryLoadNow'] == 0) {
                            ?>
                                <a style="color: greenyellow;" href="index.php?categoryNow=0" class="active" data-filter="*">All</a>
                            <?php
                            } else {
                            ?>
                                <a style="color: black;" href="index.php?categoryNow=0" class="active" data-filter="*">All</a>
                            <?php
                            }
                            ?>

                            <?php
                            foreach ($categoryList as $value) {
                            ?>
                                <?php
                                if ($_SESSION['categoryLoadNow'] ==  $value['id']) {
                                ?>
                                    <a style="color: greenyellow;" href="index.php?categoryNow=<?php echo  $value['id']; ?>" data-filter=".c<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a>
                                <?php
                                } else {
                                ?>
                                    <a style="color: black;margin: 10px;" href="index.php?categoryNow=<?php echo  $value['id']; ?>" data-filter=".c<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;" id="container_page_area">
                <div class="product__pagination">
                    <?php if ($numberOfPage >= 2) {
                    ?>
                        <?php
                        if ($pageNow > 2) {
                        ?>
                            <a style="background-color: #F3F6FA;" href="index.php?pageNow=1">First</a>
                        <?php
                        }
                        ?>
                        <a style="background-color: #F3F6FA;" href="index.php?pageNow=<?php echo ($pageNow - 1); ?>">
                            &lt; </a>

                        <?php
                        if ($pageNow > 3) {
                        ?>
                            <a style="background-color: #F3F6FA;">...</a>
                        <?php
                        }
                        ?>
                        <?php for ($i = 1; $i <= $numberOfPage; $i++) {
                        ?>

                            <?php
                            if ($i == $pageNow) {
                            ?>
                                <a style="background-color: greenyellow;"><?php echo $i; ?></a>
                            <?php
                            } else {
                            ?>
                                <?php
                                if ($i >= $pageNow - 2 && $i <= $pageNow + 2) {
                                ?>
                                    <a style="background-color: #F3F6FA;" href="index.php?pageNow=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                        <?php
                        if ($pageNow - $numberOfPage < -3) {
                        ?>
                            <a style="background-color: #F3F6FA;">...</a>
                        <?php
                        }
                        ?>
                        <a style="background-color: #F3F6FA;" href="index.php?pageNow=<?php echo ($pageNow + 1); ?>"> &gt;</a>
                        <?php
                        if ($pageNow <= $numberOfPage - 2) {
                        ?>
                            <a style="background-color: #F3F6FA;" href="index.php?pageNow=<?php echo ($numberOfPage); ?>">Last</a>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    if ($numberOfPage == 0) {
                    ?>
                        <h3>
                            do not have goods
                        </h3>
                    <?php } ?>
                </div>
            </div>
            <div class="row featured__filter" id="main_container_pro">

                <?php
                foreach ($productListPerpage as $product) {
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mix c<?php echo $product['id_category'] ?>">
                        <div class="featured__item">

                            <div class="featured__item__pic set-bg" data-setbg="img/product/<?php echo $product['image'] ?>" style="background-image: url(img/featured/feature-1.jpg);">
                                <ul class="featured__item__pic__hover">
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
                            <div class="featured__item__text">
                                <h6><a style="color: greenyellow;" href="shop-details.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></h6>
                                <p><del><?php echo ($product['price']) ?></del>$ <?php echo ($product['price'] - ($product['sale_off'] * $product['price']) / 100) ?>$</p>
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

    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top New Products</h4>
                        <!-- <div class="latest-product__slider owl-carousel">
                            <?php
                            if (sizeof($productListNew) >= 3) {
                                for ($i = 0; $i < sizeof($productListNew); $i++) {
                                    if ($i % 3 == 0) {
                            ?>
                                        <div class="latest-prdouct__slider__item">
                                            <?php
                                            for ($z = $i; $z < $i + 3; $z++) {
                                            ?>
                                                <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6><?php echo $productListNew[$z]['name']; ?></h6>
                                                        <span><del><?php echo ($productListNew[$z]['price']) ?></del>$ <?php echo ($productListNew[$z]['price'] - ($productListNew[$z]['sale_off'] * $productListNew[$z]['price']) / 100) ?>$</span>
                                                    </div>
                                                </a>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                <?php
                                    }
                                }
                            } else {
                                ?>

                                <div class="latest-prdouct__slider__item">
                                    <?php
                                    for ($z = 0; $z < sizeof($productListNew); $z++) {
                                    ?>
                                        <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="img/latest-product/lp-1.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6><?php echo $productListNew[$z]['name']; ?></h6>
                                                <span><del><?php echo ($productListNew[$z]['price']) ?></del>$ <?php echo ($productListNew[$z]['price'] - ($productListNew[$z]['sale_off'] * $productListNew[$z]['price']) / 100) ?>$</span>
                                            </div>
                                        </a>

                                    <?php
                                    }
                                    ?>
                                </div>


                            <?php } ?>
                        </div> -->
                        <div class="latest-product__slider owl-carousel">
                            <?php
                            if (count($productListNew) % 3 == 0) {
                                for ($i = 0; $i < sizeof($productListNew); $i++) {
                                    if ($i % 3 == 0) {
                            ?>
                                        <div class="latest-prdouct__slider__item">
                                            <?php
                                            for ($z = $i; $z < $i + 3; $z++) {
                                            ?>
                                                <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="img/product/TODO-img" alt="">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6><?php echo $productListNew[$z]['name']; ?></h6>
                                                        <span><del><?php echo ($productListNew[$z]['price']) ?></del>$ <?php echo ($productListNew[$z]['price'] - ($productListNew[$z]['sale_off'] * $productListNew[$z]['price']) / 100) ?>$</span>
                                                    </div>
                                                </a>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    }
                                }
                            } else {
                                if (sizeof($productListNew) < 3) {
                                    ?>
                                    <div class="latest-prdouct__slider__item">
                                        <?php
                                        for ($z = 0; $z < sizeof($productListNew); $z++) {
                                        ?>
                                            <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $productListNew[$z]['image'] ?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $productListNew[$z]['name']; ?></h6>
                                                    <span><del><?php echo ($productListNew[$z]['price']) ?></del>$ <?php echo ($productListNew[$z]['price'] - ($productListNew[$z]['sale_off'] * $productListNew[$z]['price']) / 100) ?>$</span>
                                                </div>
                                            </a>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                } else {
                                    while (true) {
                                        array_pop($productListNew);
                                        if (count($productListNew) % 3 == 0) break;
                                    }

                                    for ($i = 0; $i < sizeof($productListNew); $i++) {
                                        if ($i % 3 == 0) {
                                    ?>
                                            <div class="latest-prdouct__slider__item">
                                                <?php
                                                for ($z = $i; $z < $i + 3; $z++) {
                                                ?>
                                                    <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                                        <div class="latest-product__item__pic">
                                                            <img src="img/product/<?php echo $productListNew[$z]['image'] ?>" alt="">
                                                        </div>
                                                        <div class="latest-product__item__text">
                                                            <h6><?php echo $productListNew[$z]['name']; ?></h6>
                                                            <span><del><?php echo ($productListNew[$z]['price']) ?></del>$ <?php echo ($productListNew[$z]['price'] - ($productListNew[$z]['sale_off'] * $productListMostRate[$z]['price']) / 100) ?>$</span>
                                                        </div>
                                                    </a>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top Rated Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <?php
                            if (count($productListMostRate) % 3 == 0) {
                                for ($i = 0; $i < sizeof($productListMostRate); $i++) {
                                    if ($i % 3 == 0) {
                            ?>
                                        <div class="latest-prdouct__slider__item">
                                            <?php
                                            for ($z = $i; $z < $i + 3; $z++) {
                                            ?>
                                                <a href="shop-details?id=<?php echo $productListMostRate[$z]['id'] ?>" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="img/product/<?php echo $productListMostRate[$z]['image'] ?>" alt="">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6><?php echo $productListMostRate[$z]['name']; ?></h6>
                                                        <span><del><?php echo ($productListMostRate[$z]['price']) ?></del>$ <?php echo ($productListMostRate[$z]['price'] - ($productListMostRate[$z]['sale_off'] * $productListMostRate[$z]['price']) / 100) ?>$</span>
                                                    </div>
                                                </a>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    }
                                }
                            } else {
                                if (sizeof($productListMostRate) < 3) {
                                    ?>
                                    <div class="latest-prdouct__slider__item">
                                        <?php
                                        for ($z = 0; $z < sizeof($productListMostRate); $z++) {
                                        ?>
                                            <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $productListNew[$z]['image'] ?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $productListMostRate[$z]['name']; ?></h6>
                                                    <span><del><?php echo ($productListMostRate[$z]['price']) ?></del>$ <?php echo ($productListMostRate[$z]['price'] - ($productListMostRate[$z]['sale_off'] * $productListMostRate[$z]['price']) / 100) ?>$</span>
                                                </div>
                                            </a>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                } else {
                                    while (true) {
                                        array_pop($productListMostRate);
                                        if (count($productListMostRate) % 3 == 0) break;
                                    }

                                    for ($i = 0; $i < sizeof($productListMostRate); $i++) {
                                        if ($i % 3 == 0) {
                                    ?>
                                            <div class="latest-prdouct__slider__item">
                                                <?php
                                                for ($z = $i; $z < $i + 3; $z++) {
                                                ?>
                                                    <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                                        <div class="latest-product__item__pic">
                                                            <img src="img/product/<?php echo $productListNew[$z]['image'] ?>" alt="">
                                                        </div>
                                                        <div class="latest-product__item__text">
                                                            <h6><?php echo $productListMostRate[$z]['name']; ?></h6>
                                                            <span><del><?php echo ($productListMostRate[$z]['price']) ?></del>$ <?php echo ($productListMostRate[$z]['price'] - ($productListMostRate[$z]['sale_off'] * $productListMostRate[$z]['price']) / 100) ?>$</span>
                                                        </div>
                                                    </a>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top View Products</h4>
                        <!-- <div class="latest-product__slider owl-carousel">
                            <?php
                            if (sizeof($productListMostView) >= 3) {
                                for ($i = 0; $i < sizeof($productListMostView); $i++) {
                                    if ($i % 3 == 0) {
                            ?>
                                        <div class="latest-prdouct__slider__item">
                                            <?php
                                            for ($z = $i; $z < $i + 3; $z++) {
                                            ?>
                                                <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6><?php echo $productListMostView[$z]['name']; ?></h6>
                                                        <span><del><?php echo ($productListMostView[$z]['price']) ?></del>$ <?php echo ($productListMostView[$z]['price'] - ($productListMostView[$z]['sale_off'] * $productListMostView[$z]['price']) / 100) ?>$</span>
                                                    </div>
                                                </a>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                <?php
                                    }
                                }
                            } else {
                                ?>
                                <div class="latest-prdouct__slider__item">
                                    <?php
                                    for ($z = 0; $z < sizeof($productListMostView); $z++) {
                                    ?>
                                        <a href="shop-details?id=<?php echo $productListNew[$z]['id'] ?>" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="img/latest-product/lp-1.jpg" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6><?php echo $productListMostView[$z]['name']; ?></h6>
                                                <span><del><?php echo ($productListMostView[$z]['price']) ?></del>$ <?php echo ($productListMostView[$z]['price'] - ($productListMostView[$z]['sale_off'] * $productListMostView[$z]['price']) / 100) ?>$</span>
                                            </div>
                                        </a>

                                    <?php
                                    }
                                    ?>
                                </div>

                            <?php } ?>
                        </div> -->
                        <div class="latest-product__slider owl-carousel">
                            <?php
                            if (count($productListMostView) % 3 == 0) {
                                for ($i = 0; $i < sizeof($productListMostView); $i++) {
                                    if ($i % 3 == 0) {
                            ?>
                                        <div class="latest-prdouct__slider__item">
                                            <?php
                                            for ($z = $i; $z < $i + 3; $z++) {
                                            ?>
                                                <a href="shop-details?id=<?php echo $productListMostView[$z]['id'] ?>" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="img/product/<?php echo $productListMostView[$z]['image'] ?>" alt="">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6><?php echo $productListMostView[$z]['name']; ?></h6>
                                                        <span><del><?php echo ($productListMostView[$z]['price']) ?></del>$ <?php echo ($productListMostView[$z]['price'] - ($productListMostView[$z]['sale_off'] * $productListMostView[$z]['price']) / 100) ?>$</span>
                                                    </div>
                                                </a>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    }
                                }
                            } else {
                                if (sizeof($productListMostView) < 3) {
                                    ?>
                                    <div class="latest-prdouct__slider__item">
                                        <?php
                                        for ($z = 0; $z < sizeof($productListMostView); $z++) {
                                        ?>
                                            <a href="shop-details?id=<?php echo $productListMostView[$z]['id'] ?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/<?php echo $productListMostView[$z]['image'] ?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $productListMostView[$z]['name']; ?></h6>
                                                    <span><del><?php echo ($productListMostView[$z]['price']) ?></del>$ <?php echo ($productListMostView[$z]['price'] - ($productListMostView[$z]['sale_off'] * $productListMostView[$z]['price']) / 100) ?>$</span>
                                                </div>
                                            </a>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                } else {
                                    while (true) {
                                        array_pop($productListMostView);
                                        if (count($productListMostView) % 3 == 0) break;
                                    }

                                    for ($i = 0; $i < sizeof($productListMostView); $i++) {
                                        if ($i % 3 == 0) {
                                    ?>
                                            <div class="latest-prdouct__slider__item">
                                                <?php
                                                for ($z = $i; $z < $i + 3; $z++) {
                                                ?>
                                                    <a href="shop-details?id=<?php echo $productListMostView[$z]['id'] ?>" class="latest-product__item">
                                                        <div class="latest-product__item__pic">
                                                            <img src="img/<?php echo $productListMostView[$z]['image'] ?>" alt="">
                                                        </div>
                                                        <div class="latest-product__item__text">
                                                            <h6><?php echo $productListMostView[$z]['name']; ?></h6>
                                                            <span><del><?php echo ($productListMostView[$z]['price']) ?></del>$ <?php echo ($productListMostView[$z]['price'] - ($productListMostView[$z]['sale_off'] * $productListMostView[$z]['price']) / 100) ?>$</span>
                                                        </div>
                                                    </a>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From Top View Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                <?php
                foreach ($blogListMostView  as  $value) {
                ?>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="img/blog/<?php echo $value['img'] ?>" alt="Loi hinh">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i><?php echo  $value['time']; ?></li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a href="#"><?php echo  $value['title']; ?></a></h5>
                            </div>
                        </div>
                    </div>
                <?php
                } ?>

            </div>
        </div>
    </section>
    <!-- Blog Section End -->

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