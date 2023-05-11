<?php
session_start();
if (!isset($_SESSION['category_now'])) $_SESSION['category_now'] = 0;
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$category_id = 0;
$productNumberOnPage = 4;
$listProductSearch = null;
$pageNow = 1;
$countProduct = 0;
$pageQuantity = 0;
$countProduct = 0;
$_SESSION['page'] = "blog.php";

if (isset($_GET['category'])) {
    $_SESSION['category_now'] = $_GET['category'];
}
$category_id = $_SESSION['category_now'];

/////////////////       Kết thúc khai báo           ////////////////////
////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
/////////////////         Khởi tạo class            ////////////////////
$productModel = new BlogModel();

/////////////////       Kết thúc khởi tạo           ////////////////////
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
/////////////////         Sử lí dữ liệu             ////////////////////


//Phân trang cho tất cả sản phẩm
if (isset($_GET['pageNow'])) {
    $pageNow = $_GET['pageNow'];
}

if ($category_id == 0) {
    $countProduct = $productModel->getCountAllBlog();
    $pageQuantity = $productModel->pageQuantityBlog($countProduct, $productNumberOnPage);
    /////////////////       Kết thúc sử lí dữ liệu      ////////////////////
    ////////////////////////////////////////////////////////////////////////

    if ($pageNow <= 0) {
        $pageNow = $pageQuantity;
    } else if ($pageNow > $pageQuantity) {
        $pageNow = 1;
    }
    //lay blog phan trang 
    $listProductOnPage = $productModel->getBlogByPageNumber($pageNow, $productNumberOnPage);
} else {
    $countProduct =  $productModel->getCountAllBlogByCategory($category_id);
    $pageQuantity = $productModel->pageQuantityBlog($countProduct, $productNumberOnPage);

    if ($pageNow <= 0) {
        $pageNow = $pageQuantity;
    } else if ($pageNow > $pageQuantity) {
        $pageNow = 1;
    }
    //lay blog phan trang 
    $listProductOnPage = $productModel->getBlogByPageNumberByCategory($pageNow, $productNumberOnPage, $category_id);
}
//lay top 5 blog moi nhat
$Top5BlogLasted = $productModel->getTop3Newslasted();
//contact information
$contact = new ContactModel();
$in4Contact = $contact->getAllContact();
//get all category
$category = new CategoryModel();
$categoryList = $category->getAllCategory();
//notify
if ($listProductOnPage == null) {
?>
<script>alert('blog of this category is null');</script>
<?php
}
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
    <style>
        .list-group-item:hover {
            background-color: greenyellow;
        }

        .blog__sidebar__recent__item:hover {
            background-color: greenyellow;
        }
    </style>
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
                <li><a href="./blog.php">Shop</a></li>
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
                        <h2>Blog</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search" style="margin-top: -50px;">
                            <form action="#">
                                <input type="text" placeholder="Search Blogs..." oninput="loadBlog(this)">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <div style="height: 150px; overflow-y: scroll;" class="blog__sidebar__recent" id="container_blog">

                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Category List</h4>
                            <ul class="list-group">
                                <a href="blog.php?category=0">
                                    <li class="list-group-item" style="background-color: <?php echo ($category_id  == 0) ? 'green' : ''; ?>">All</li>
                                </a>
                                <?php
                                foreach ($categoryList as $value) {
                                ?>
                                    <a href="blog.php?category=<?php echo $value['id']; ?>">
                                        <li class="list-group-item" style="background-color: <?php echo ($category_id  == $value['id']) ? 'green' : ''; ?>"><?php echo $value['name']; ?></li>
                                    </a>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>

                        <div class="blog__sidebar__item">
                            <h4>Top 3 Recent News</h4>
                            <div class="blog__sidebar__recent">

                                <?php
                                foreach ($Top5BlogLasted as $value) {
                                ?>
                                    <a href="blog-details.php?id=<?php echo $value['id']; ?>" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img style="width: 120px;" src="img/blog/<?php echo $value['img']; ?>" alt="">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6><?php echo $value['title']; ?></h6>
                                            <span><?php echo $value['time']; ?></span>
                                        </div>
                                    </a>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                        <?php
                        if (isset($listProductOnPage)) {
                            foreach ($listProductOnPage as $value) {
                        ?>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__item">
                                        <div class="blog__item__pic">
                                            <img src="img/blog/<?php echo $value['img']; ?>" alt="">
                                        </div>
                                        <div class="blog__item__text">
                                            <ul>
                                                <li><i class="fa fa-calendar-o"></i> <?php echo $value['time']; ?></li>
                                            </ul>
                                            <h5><a href="#"><?php echo $value['title']; ?></a></h5>
                                            <a href="blog-details.php?id=<?php echo $value['id']; ?>" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo 'nothing';
                        }
                        ?>

                        <div class="col-lg-12">
                            <div class="product__pagination" style="display: flex; justify-content: center; align-items: center;">
                                <?php if ($pageQuantity > 1) { ?>
                                    <a href="blog.php?pageNow=1">FIRST</a>
                                    <a href="blog.php?pageNow=<?php echo ($pageNow - 1) ?>"><i class="fa fa-long-arrow-left"></i></a>
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
                                            <a href="blog.php?pageNow=<?php echo $i ?>"><?php echo $i ?></a>
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
                                    <a href="blog.php?pageNow=<?php echo ($pageNow + 1) ?>"><i class="fa fa-long-arrow-right"></i></a>
                                    <a href="blog.php?pageNow=<?php echo $pageQuantity; ?>">LAST</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script>
        function loadBlog(param) {
            var row = document.getElementById("container_blog");
            var txtSearch = param.value;
            if (txtSearch != '') {
                $.ajax({
                    url: "searchBlogByAjax.php",
                    type: "get", //send it through get method
                    data: {
                        //du lieu gui ve ben kia
                        txt: txtSearch
                    },
                    success: function(data) {
                        //tao the co ten la conent
                        row.innerHTML = data;
                    },
                    error: function(xhr) {
                        //Do Something to handle error
                    }
                })
            } else {
                row.innerHTML = '';
            }
        };
    </script>



</body>

</html>