<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
////////////////////////////////////////////////'////////////////////////
/////////////////    Khai báo giá trị mặc định      ////////////////////

$listCartByIdAcount = null;
$bool_bill = false;
$idAccount = -1;
if (isset($_SESSION['login']['id_user'])) {
    $idAccount = $_SESSION['login']['id_user'];
}

/////////////////       Kết thúc khai báo           ////////////////////
////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
/////////////////         Khởi tạo class            ////////////////////

$cartModel = new CartModel();
$productModel = new ProductModel();
$billModel = new BillModel();
//contact information
$contact = new ContactModel();


/////////////////       Kết thúc khởi tạo           ////////////////////
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
/////////////////         Sử lí dữ liệu             ////////////////////

//header and footer
$in4Contact = $contact->getAllContact();
//check out
if ($idAccount == -1) {
    header('location:404.php');
}
///Lấy toàn bộ cart của người dùng có id chuyền vào là $idAccount
$listCartByIdAcount = $cartModel->getCartByIdUser($idAccount);
$array = array();
foreach ($listCartByIdAcount as $item) {
    $array['id'][] = $item['id_sp'];
    $array['qty'][] = $item['qty'];
}

if (!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['phone_number']) && !empty($_POST['total']) && !empty($_POST['payment_methods'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone_number'];
    $total = $_POST['total'];
    $paymentMethod = $_POST['payment_methods'];
    $note = $_POST['note'];
    $bool_bill = $billModel->creatBill($idAccount, $total, $phone, $note, $name, $address, $paymentMethod, $array);

    header("location:" . $_SESSION['page']);
}



/////////////////       Kết thúc sử lí dữ liệu      ////////////////////
////////////////////////////////////////////////////////////////////////
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
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action="checkout.php" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Recipient's name<span>*</span></p>
                                <input type="text" name="name">
                            </div>
                            <div class="checkout__input">
                                <p>Consignee address<span>*</span></p>
                                <input type="text" name="address" placeholder="house number - street name (if any), neighborhood/hamlet, ward/commune, district, province/city" class="checkout__input__add">
                            </div>
                            <div class="checkout__input">
                                <p>Recipient's phone number<span>*</span></p>
                                <input type="text" name="phone_number">
                            </div>

                            <div class="checkout__input">
                                <p>Order notes</p>
                                <input type="text" name="note" placeholder="Notes about your order, e.g. special notes for delivery.">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                    <?php foreach ($listCartByIdAcount as $item) { ?>
                                        <li><?php echo $productModel->getProductById($item['id_sp'])['name'] ?> <span>$<?php echo $productModel->getProductById($item['id_sp'])['price'] * $item['qty'] ?></span></li>
                                    <?php } ?>
                                </ul>
                                <input type="hidden" name="total" value="<?php echo $cartModel->getTotalByCart($idAccount) ?>">
                                <div class="checkout__order__subtotal">Subtotal <span>$<?php echo $cartModel->getTotalByCart($idAccount) ?></span></div>
                                <div class="checkout__order__total">Total <span>$<?php echo $cartModel->getTotalByCart($idAccount) ?></span></div>
                                <div class="checkout__input__checkbox">
                                    <label for="transfer">
                                        Transfer
                                        <input type="radio" id="transfer" name="payment_methods" value="2">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="direct_payment">
                                        Direct payment
                                        <input type="radio" id="direct_payment" name="payment_methods" value="1">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" value="order" name="order" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <?php include 'footer.php'; ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php
    if (isset($_POST['order'])) {

        if ($bool_bill) { ?>
            <script>
                alert('Payment success');
            </script>
        <?php
        } else {
        ?>
            <script>
                alert('Enter all information marked with *');
            </script>
    <?php
        }
    }
    ?>
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