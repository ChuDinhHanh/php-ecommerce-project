<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require_once "./app/models/$className.php";
});
//0 -> moi | 1- dang giao | 2 - dagiao

$status_bill = 0;
if (isset($_GET['status_bill'])) {
    $status_bill = $_GET['status_bill'];
}




//day danh muc----------------
$bill = new BillModel();
$billLists = $bill->getAllBill();


// thay doi status
if (isset($_GET['new'])) {
    $bill->updateStatusBill(0, $_GET['new']);
} else if (isset($_GET['beingDelivered'])) {
    $bill->updateStatusBill(1, $_GET['beingDelivered']);
} else if (isset($_GET['hadDelivered'])) {
    $bill->updateStatusBill(2, $_GET['hadDelivered']);
}


//connect product model
$product = new ProductModel();
//conect accountModel
$account = new AccountModel();
//connect billModel
$bill = new BillModel();
//connect to contact model
$contact = new ContactModel();

$totalProduct = $product->getCountAllProduct();
$totallAccount = $account->getCountAccountCustomer();
$totallBill = $bill->getAllBill();
$totallAmount = $bill->getAllAmount();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn'])) {
    if (!empty($_POST['phone_number']) && !empty($_POST['addres']) && !empty($_POST['open_time']) && !empty($_POST['close_time']) && !empty($_POST['email']) && !empty($_POST['gg_link_addres']) && !empty($_POST['name'])) {


        $result = $contact->updateContact($_POST['phone_number'], $_POST['addres'], $_POST['open_time'], $_POST['close_time'], $_POST['email'], trim($_POST['gg_link_addres']), $_POST['name']);

        if ($result) {
?>
            <script>
                alert("luu thanh cong");
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("luu khong thanh cong");
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            alert("yeu cau nhap du thong tin")
        </script>
<?php
    }
}
$contactIn4 = $contact->getAllContact();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Google Web Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="dashmin/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="dashmin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="dashmin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="dashmin/css/style.css" rel="stylesheet">
    <style>
        .num {
            padding: 2px 5px;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php include 'silder_top_admin.php'; ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index_admin.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-inline-flex">John Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
<p class="mb-2">Total product</p>
                                <h6 class="mb-0"><?php echo $totalProduct; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Amount</p>
                                <h6 class="mb-0"><?php echo $totallAmount; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Number Bill</p>
                                <h6 class="mb-0"><?php echo count($totallBill); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Number Cus</p>
                                <h6 class="mb-0"><?php echo $totallAccount; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Bill List</h6>
                    </div>
                    <div class="table-responsive">
                        <form action="contact_manager_admin.php" method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1"></label>
                                <input value="<?php echo $contactIn4['phone_number']; ?>" name="phone_number" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"></label>
<input value="<?php echo $contactIn4['addres']; ?>" name="addres" type="text" class="form-control" id="exampleInputPassword1" placeholder="Addres">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"></label>
                                <input value="<?php echo $contactIn4['open_time']; ?>" name="open_time" type="text" class="form-control" id="exampleInputPassword1" placeholder="Opend time">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"></label>
                                <input value="<?php echo $contactIn4['close_time']; ?>" name="close_time" type="text" class="form-control" id="exampleInputPassword1" placeholder="Close time">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"></label>
                                <input value="<?php echo $contactIn4['email']; ?>" name="email" type="text" class="form-control" id="exampleInputPassword1" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"></label>
                                <textarea class="form-control" name="gg_link_addres">
                                    <?php echo $contactIn4['gg_link_addres']; ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"></label>
                                <input value="<?php echo $contactIn4['name']; ?>" name="name" type="text" class="form-control" id="exampleInputPassword1" placeholder="Name">
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <button type="submit" name="btn" class="btn btn-primary mb-0" style="margin-top:10px;">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            </br>
                            Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dashmin/lib/chart/chart.min.js"></script>
    <script src="dashmin/lib/easing/easing.min.js"></script>
    <script src="dashmin/lib/waypoints/waypoints.min.js"></script>
    <script src="dashmin/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="dashmin/lib/tempusdominus/js/moment.min.js"></script>
    <script src="dashmin/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="dashmin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="dashmin/js/main.js"></script>
</body>

</html>