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

$totalProduct = $product->getCountAllProduct();
$totallAccount = $account->getCountAccountCustomer();
$totallBill = $bill->getAllBill();
$totallAmount = $bill->getAllAmount();

if ($status_bill == 0) {
    // day san pham-----------
    // lay tong so san pham theo danh muc
    $billList = $billLists;

    //trang hein tai
    $pageNow = 1;
    if (isset($_GET['pageNow'])) {
        $pageNow = $_GET['pageNow'];
    }
    //san pham tren 1 trang
    $billPerpage = 8;
    //dem so luong san pham
    $qtyBill = count($billList);
    //so trang
    $numberOfPage =  ceil(($qtyBill) / $billPerpage);
    if ($pageNow < 1) {
        $pageNow = $numberOfPage;
    }
    if ($pageNow > $numberOfPage) {
        $pageNow = 1;
    }

    // //lay gia tri bat dau offset
    $offset = (($pageNow - 1)  * $billPerpage);
    // //day san pham tren 1 trang
    $billList  = $bill->getBillPage($billPerpage, $offset);
} else {
    $billList  = $bill->getBillByStatus($status_bill);
}

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
                <a href="bill_manager_admin.php?status_bill=0" type="button" class="btn " style="background-color:<?php echo ($status_bill  == 0) ? 'red' : ''; ?>;">NEW ORDER</a>
                <a href="bill_manager_admin.php?status_bill=1" type="button" class="btn " style="background-color:<?php echo ($status_bill  == 1) ? 'red' : ''; ?>;margin-left:10px;">BEING DELIVERED</a>
                <a href="bill_manager_admin.php?status_bill=2" type="button" class="btn " style="background-color:<?php echo ($status_bill  == 2) ? 'red' : ''; ?>;margin-left:10px;">HAD DELIVERED</a>
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
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">ID ACCOUNT</th>
<th scope="col">TOTAL</th>
                                    <th scope="col">PHONE</th>
                                    <th scope="col">NOTES</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">RECEIVE NAME</th>
                                    <th scope="col">RECEIVE ADDRESS</th>
                                    <th scope="col">MODE PAYMENT</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($billList  as $bill) {
                                ?>
                                    <tr>
                                        <td><?php echo $bill['id_account']; ?></td>
                                        <td><?php echo $bill['order_date']; ?></td>
                                        <td><?php echo $bill['bill_total']; ?></td>
                                        <td><?php echo $bill['order_notes']; ?></td>
                                        <?php
                                        if ($bill['bill_status'] == 0) {
                                        ?>
                                            <td style="background-color: orangered;color: white;">NEW ORDER</td>
                                        <?php
                                        } else if ($bill['bill_status'] == 1) {
                                        ?>
                                            <td style="background-color: yellow;color: white;">BEING DELIVERED</td>
                                        <?php
                                        } else {
                                        ?>
                                            <td style="background-color: green;color: white;">WAS DELIVERED</td>

                                        <?php
                                        }
                                        ?>
                                        <td><?php echo $bill['receive_name']; ?></td>
                                        <td><?php echo $bill['receive_address']; ?></td>
                                        <td><?php echo $bill['bill_pttt'] == 1 ? "Direct payment" : "Transfer" ?></td>
                                        <td style="display: flex;justify-content: space-around;">
                                            <a href="bill_manager_admin.php?new=<?php echo $bill['id']; ?>">Hang Moi</a>|
                                            <a href="bill_manager_admin.php?beingDelivered=<?php echo $bill['id']; ?>">Dag Giao</a>|
                                            <a href="bill_manager_admin.php?hadDelivered=<?php echo $bill['id']; ?>">Da Giao</a>
                                        </td>
                                    </tr>
                                <?php
                                }
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->
            <?php
            if ($status_bill == 0) {
            ?>
                <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;" id="container_page_area">
                    <div class="product__pagination">
                        <?php if ($numberOfPage >= 2) {
                        ?>
                            <?php
                            if ($pageNow > 2) {
                            ?>
                                <a class="num" style="background-color: #F3F6FA;" href="index_admin.php?pageNow=1">First</a>
                            <?php
                            }
                            ?>
                            <a class="num" style="background-color: #F3F6FA;" href="index_admin.php?pageNow=<?php echo ($pageNow - 1); ?>">
                                &lt; </a>

                            <?php
                            if ($pageNow > 3) {
                            ?>
                                <a class="num" style="background-color: #F3F6FA;">...</a>
                            <?php
                            }
                            ?>
                            <?php for ($i = 1; $i <= $numberOfPage; $i++) {
                            ?>

                                <?php
                                if ($i == $pageNow) {
                                ?>
                                    <a class="num" style="background-color: greenyellow;"><?php echo $i; ?></a>
                                <?php
                                } else {
                                ?>
                                    <?php
                                    if ($i >= $pageNow - 2 && $i <= $pageNow + 2) {
                                    ?>
                                        <a class="num" style="background-color: #F3F6FA;" href="index_admin.php?pageNow=<?php echo $i; ?>"><?php echo $i; ?></a>
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
                                <a class="num" style="background-color: #F3F6FA;">...</a>
                            <?php
                            }
                            ?>
                            <a class="num" style="background-color: #F3F6FA;" href="index_admin.php?pageNow=<?php echo ($pageNow + 1); ?>"> &gt;</a>
                            <?php
if ($pageNow <= $numberOfPage - 2) {
                            ?>
                                <a class="num" style="background-color: #F3F6FA;" href="index_admin.php?pageNow=<?php echo ($numberOfPage); ?>">Last</a>
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
            <?php } ?>
            <!-- Widgets Start -->



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