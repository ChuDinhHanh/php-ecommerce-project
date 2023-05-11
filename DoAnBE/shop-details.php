<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
$_SESSION['page'] = "shop-details.php";
$heartModel = new HeartModel();
$product = new ProductModel();
$productShow = $product->getProductsTopView();
if (!isset($_SESSION['idLoadNow'])) {
    $productShow = $product->getProductsTopView();
    $_SESSION['idLoadNow'] = $productShow[0]['id'];
}
if (!empty($_GET['id'])) {
    $_SESSION['idLoadNow'] = $_GET['id'];
}
$id =  $_SESSION['idLoadNow'];
$productShow = $product->getAProductByID($id);
$flag = 1;
if ($productShow && isset($productShow['stb'])) {
    $flag = false;
    if ((floor($productShow['stb']) - $productShow['stb'] != 0) && (floor($productShow['stb']) - $productShow['stb'] >= 0.5)) {
        $flag = true;
    }
}

//lay tong so san pham theo danh muc
$productListRelated = $product->getAllProductsSameCategory($id);
//trang hein tai
$pageNow = 1;
if (isset($_GET['pageNow'])) {
    $pageNow = $_GET['pageNow'];
}
// //san pham tren 1 trang
$productPerpage = 8;
//dem so luong san pham
$qtyProduct = count($productListRelated);
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
$productListPerpageRalated = $product->getProductsPerpageRelated($productPerpage, $offset, $id);
//thuc hien them binh luan
$user = null;
if (isset($_SESSION['login']['id_user'])) {
    $account = new AccountModel();
    $user = $account->getAccountById($_SESSION['login']['id_user']);
}
//lien ket rating
$rating  = new RatingModel();
//delete comment
if (isset($_POST['id_delete_com']) && !empty(trim($_POST['id_delete_com']))) {
    if ($rating->deleteRatingById($_POST['id_delete_com'])) {
?>
        <script>
            confirm("xoa thanh cong!");
        </script>
    <?php
    } else {
    ?>
        <script>
            confirm("xoa that bai!");
        </script>

    <?php
    };
}
//create comment

if (isset($_POST['comment'])) {
    if (isset($_POST['rating'])) {
        $rating->CreateRating($_SESSION['login']['id_user'], $id, $_POST['rating'], $_POST['comment']);
    } else {
        $rating->CreateRating($_SESSION['login']['id_user'], $id, 0, $_POST['comment']);
    }
    ?>
    <script>
        confirm("da them thanh cong!");
    </script>
<?php
}
//lay cac comment
$ratingList = $rating->getAllRating($id);
//id comment dung de update
$comment_upadte = null;
if (isset($_POST['id_update_com']) && !empty(trim($_POST['id_update_com']))) {
    $comment_upadte = $rating->getARating($_POST['id_update_com']);
}
//update comment
if (
    isset($_POST['id_comment_updated']) && !empty(trim($_POST['id_comment_updated'])) &&
    isset($_POST['comment_updated']) && !empty(trim($_POST['comment_updated']))
) {
    $rating->updateRatingById($_POST['id_comment_updated'], $_POST['comment_updated']);
}
//check had rating this product yet?
if (isset($_SESSION['login']['id_user'])) {
    $result = $rating->checkRatingByAccount($_SESSION['login']['id_user'], $id);
    if ($result != null && !empty($result)) {
        $result = true;
    } else {
        $result = false;
    }
}
//contact information
$contact = new ContactModel();
$in4Contact = $contact->getAllContact();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Css Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/cssforcomment.css" type="text/css">
    <link rel="stylesheet" href="css/cssforcommentbox.css" type="text/css">

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
                <li class="active"><a href="./shop-details.php">Home</a></li>
                <li><a href="./shop-grid.php">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.php.php">Shop Details</a></li>
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
                        <h2>Vegetable’s Package</h2>
                        <div class="breadcrumb__option">
                            <a href="./shop-details.php">Home</a>
                            <a href="./shop-details.php">Vegetables</a>
                            <span>Vegetable’s Package</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="img/product/<?php echo $productShow['imgpro']; ?>" alt="">
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $productShow['namepro']; ?></h3>
                        <i class="fa fa-heart"></i> <span><?php echo $heartModel->getCountLikeByProduct($productShow['id']) ?></span>
                        <div class="product__details__rating">
                            <?php
                            if ($flag != 1) {
                                for ($i = 1; $i <= $productShow['stb']; $i++) {
                                    if ($flag && $i == floor($productShow['stb'])) {
                            ?>
                                        <i class="fa fa-star-half-o"></i>
                                    <?php
                                    } else {
                                    ?>
                                        <i class="fa fa-star"></i>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                            } else {
                                ?>
                                <h6>Be the first to review this product</h6>
                            <?php
                            }
                            ?>

                            <span>(<?php if ($flag != 1) {
                                        echo $productShow['sldg'];
                                    } else {
                                        echo 0;
                                    } ?> reviews)</span>
                        </div>
                        <div class="product__details__price">$<?php echo $productShow['price']; ?></div>
                        <p> Company:
                            <?php
                            if (isset($productShow['idty'])) {
                            ?>
                                <a href="detailCompany?id=<?php echo $productShow['idty']; ?>">

                                <?php
                                if (isset($productShow['tencty'])) {
                                    if (trim($productShow['tencty']) != 'null') {
                                        echo $productShow['tencty'];
                                    }
                                }
                            } else {
                                echo '
                      Company in4 is empty';
                            } ?>

                                </a>
                        </p>

                        <p>Address:<?php
                                    if (isset($productShow['dchicty'])) {
                                        if (trim($productShow['dchicty']) != 'null') {
                                            echo $productShow['dchicty'];
                                        }
                                    } else {
                                        echo '
                              Company in4 is empty';
                                    } ?>


                        </p>
                        <a href="carthandling.php?idP=<?php echo $productShow['id'] ?>" class="primary-btn">ADD TO CARD</a>
                        <?php
                        if ($heartModel->checkAccountLikeProduct($idAccount, $productShow['id']) == false) { ?>
                            <a style="color:black;" href="heart.php?idPL=<?php echo $productShow['id']; ?>"><i class="fa fa-heart"></i></a>
                        <?php
                        } else { ?>
                            <a style="color:red;" href="heart.php?idPDL=<?php echo $productShow['id']; ?>"><i class="fa fa-heart"></i></a>
                        <?php
                        } ?>


                        <ul>
                            <li><b>Availability</b> <span><?php if ($productShow['qty'] > 0) {
                                                            ?>
                                        In Stock
                                    <?php
                                                            } else {
                                    ?>
                                        Nothing
                                    <?php
                                                            } ?></span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <?php
                        if ($comment_upadte == null) {
                        ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#tabs-2" role="tab" aria-selected="true">Read Review</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews <span></span></a>
                                </li>
                            </ul>
                        <?php } ?>
                        <?php
                        if ($comment_upadte != null) {
                        ?>
                            <div class="comment-box ml-2">

                                <h4>UPDATE COMMENT</h4>

                                <form action="shop-details.php" method="POST">
                                    <input name="id_comment_updated" type="hidden" value="<?php echo $comment_upadte['id']; ?>">
                                    <div class="comment-area">

                                        <textarea name="comment_updated" class="form-control" placeholder="what is your view?" rows="4">
                                            <?php echo $comment_upadte['comment']; ?>
                                        </textarea>

                                    </div>

                                    <div class="comment-btns mt-2">

                                        <div class="row">

                                            <div class="col-6">

                                                <div class="pull-left">

                                                    <a href="shop-details.php" class="btn btn-success btn-sm">Cancel</a>

                                                </div>

                                            </div>

                                            <div class="col-6">

                                                <div class="pull-right">
                                                    <?php
                                                    if (isset($_SESSION['login']['id_user'])) {
                                                    ?>
                                                        <button type="submit" class="btn btn-success send btn-sm">Send <i class="fa fa-long-arrow-right ml-1"></i></button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="loginregister.php" class="btn btn-success send btn-sm">Login</a>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </form>

                            </div>

                        <?php
                        }
                        ?>
                        <?php
                        if ($comment_upadte == null) {
                        ?>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Products Infomation</h6>
                                        <p><?php
                                            if (trim($productShow['description']) != 'null') {
                                                echo $productShow['description'];
                                            } else {
                                            ?>
                                        <div class="alert alert-danger" role="alert">
                                            NOTHING
                                        </div>
                                    <?php
                                            } ?></p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-2" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <div class="container d-flex justify-content-center mt-100 mb-100">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="card-title">Recent Comments</h4>
                                                            <h6 class="card-subtitle">Latest Comments section by users</h6>
                                                        </div>

                                                        <?php foreach ($ratingList as $value) { ?>
                                                            <div class="comment-widgets m-b-20">

                                                                <div class="d-flex flex-row comment-row" style="width: 1024px;">
                                                                    <div class="p-2"><span class="round"><img src="https://i.imgur.com/uIgDDDd.jpg" alt="user" width="50"></span></div>
                                                                    <div class="comment-text w-100">
                                                                        <h5><?php echo $value['username'] ?></h5>
                                                                        <div class="comment-footer">
                                                                            <span class="date"><?php echo $value['time'];  ?></span>
                                                                            <span class="action-icons" style="display: flex;">
                                                                                <?php
                                                                                if (isset($_SESSION['login']['id_user'])) {
                                                                                    if ($value['id_account'] == $_SESSION['login']['id_user']) {
                                                                                ?>
                                                                                        <form action="shop-details.php" method="post">
                                                                                            <input name="id_update_com" type="hidden" value="<?php echo $value['id_com'] ?>">
                                                                                            <button style="border: none;" type="submit" data-abc="true"><i class="fa fa-pencil"></i></button>
                                                                                        </form>
                                                                                        <form action="shop-details.php" method="post">
                                                                                            <input name="id_delete_com" type="hidden" value="<?php echo $value['id_com'] ?>">
                                                                                            <button style="border: none;" type="submit" data-abc="true"><i class="fa-solid fa-trash-can"></i></button>
                                                                                        </form>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </div>
                                                                        <p class="m-b-5 m-t-10"><?php echo htmlentities($value['comment']) ?></p>
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
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-3" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <div class="card">

                                            <div class="row">

                                                <div class="col-2">


                                                    <img src="https://i.imgur.com/xELPaag.jpg" width="70" class="rounded-circle mt-2">


                                                </div>

                                                <div class="col-10">

                                                    <div class="comment-box ml-2">

                                                        <h4>ADD COMMENT</h4>

                                                        <form action="shop-details.php" method="POST">

                                                            <?php
                                                            if (isset($_SESSION['login']['id_user'])) {
                                                                if ($result == false) {
                                                            ?>
                                                                    <div class="rating">
                                                                        <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                                                                        <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                                                                        <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                                                                        <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                                                                        <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                            <div class="comment-area">

                                                                <textarea name="comment" class="form-control" placeholder="what is your view?" rows="4"></textarea>

                                                            </div>

                                                            <div class="comment-btns mt-2">

                                                                <div class="row">

                                                                    <div class="col-6">

                                                                        <div class="pull-left">

                                                                            <a href="shop-details.php" class="btn btn-success btn-sm">Cancel</a>

                                                                        </div>

                                                                    </div>

                                                                    <div class="col-6">

                                                                        <div class="pull-right">
                                                                            <?php
                                                                            if (isset($_SESSION['login']['id_user'])) {
                                                                            ?>
                                                                                <button type="submit" class="btn btn-success send btn-sm">Send <i class="fa fa-long-arrow-right ml-1"></i></button>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="loginregister.php" class="btn btn-success send btn-sm">Login</a>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </form>

                                                    </div>

                                                </div>


                                            </div>

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
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
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
                            <a style="background-color: #F3F6FA;" href="shop-details.php?pageNow=1">First</a>
                        <?php
                        }
                        ?>
                        <a style="background-color: #F3F6FA;" href="shop-details.php?pageNow=<?php echo ($pageNow - 1); ?>">
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
                                    <a style="background-color: #F3F6FA;" href="shop-details.php?pageNow=<?php echo $i; ?>"><?php echo $i; ?></a>
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
                        <a style="background-color: #F3F6FA;" href="shop-details.php?pageNow=<?php echo ($pageNow + 1); ?>"> &gt;</a>
                        <?php
                        if ($pageNow <= $numberOfPage - 2) {
                        ?>
                            <a style="background-color: #F3F6FA;" href="shop-details.php?pageNow=<?php echo ($numberOfPage); ?>">Last</a>
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
            <div class="row">
                <?php
                foreach ($productListPerpageRalated as $value) {
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="img/product/product-1.jpg">
                                <ul class="product__item__pic__hover">
                                    <?php
                                    if ($heartModel->checkAccountLikeProduct($idAccount, $value['id']) == false) { ?>
                                        <li><a href="heart.php?idPL=<?php echo $value['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                    <?php
                                    } else { ?>
                                        <li><a style="color:red;" href="heart.php?idPDL=<?php echo $value['id']; ?>"><i class="fa fa-heart"></i></a></li>
                                    <?php
                                    } ?>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a style="color: greenyellow;" href="shop-details.php?id=<?php echo $value['id']; ?>">Crab Pool Security</a></h6>
                                <h5>$<?php echo $value['price']; ?></h5>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

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