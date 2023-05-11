<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php
$cartModel = new CartModel();
$idAccount = -1;
if (isset($_SESSION['login']['id_user'])) {
    $idAccount = $_SESSION['login']['id_user'];
}
//Gửi lại trang vừa rồi và cập nhật số lượng trong giỏ hàng
$countProductInCartByIdAccount = $cartModel->getCountCartByIdAccount($idAccount);
//Cập nhật số lượng vào session
$_SESSION['quantityProductByCart'] = $countProductInCartByIdAccount;
//heart
$heartModel = new HeartModel();
?>
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <?php if (isset($_SESSION['login']['id_user'])) { ?>
                            <div class="header__top__right__language">
                                <i class="fa fa-user"></i>
                                <div>
                                    My account
                                </div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="information.php">Information</a></li>
                                    <li><a href="logout.php">EXit</a></li>
                                </ul>
                            </div>
                        <?php }  ?>
                        <?php if (!isset($_SESSION['login']['id_user'])) { ?>
                            <div class="header__top__right__auth">
                                <a href="loginregister.php"><i class="fa fa-user"></i> Login</a>
                            </div>
                        <?php }  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="./index.php"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-7">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="./index.php">Home</a></li>
                        <li><a href="./shop-grid.php">Shop</a></li>
                        <li><a href="#">Page</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./shoping-cart.php">Shoping Cart</a></li>
                                <?php
                                if ($idAccount != -1) {
                                ?>
                                    <li><a href="./bill.php">Bill</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li><a href="#">Blog</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./blog.php">Read Blog</a></li>
                                <?php
                                if ($idAccount != -1) {
                                ?>
                                    <li><a href="./creat-blog.php">Create Blog</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li><a href="./contact.php">Contact</a></li>
                        <?php
                        if (isset($_SESSION['role'])) {
                            if ($_SESSION['role'] == 1) {
                        ?>
                                <li><a href="./index_admin.php">Admin Page</a></li>
                        <?php
                            }
                        }
                        ?>

                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="list-like.php"><i class="fa fa-heart"></i> <span><?php echo $heartModel->getCountLikeByAcount($idAccount); ?></span></a></li>
                        <?php if (isset($_SESSION['quantityProductByCart'])) { ?>
                            <li><a href="shoping-cart.php"><i class="fa fa-shopping-bag"></i> <span><?php echo $_SESSION['quantityProductByCart'] ?></span></a></li>
                        <?php } ?>
                    </ul>
                    <div class="header__cart__price">item: <span>$<?php echo $cartModel->getTotalByCart($idAccount) ?></span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>