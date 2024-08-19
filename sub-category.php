<?php
session_start();
error_reporting(0);
include('includes/config.php');
$cid = intval($_GET['scid']);
if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $sql_p = "SELECT * FROM products WHERE id={$id}";
        $query_p = mysqli_query($con, $sql_p);
        if (mysqli_num_rows($query_p) != 0) {
            $row_p = mysqli_fetch_array($query_p);
            $_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
            echo "<script>alert('Товар добавлен в корзину')</script>";
            echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
        } else {
            $message = "Неверный ID товара";
        }
    }
}

// Код для списка желаемого
if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
    if (strlen($_SESSION['login']) == 0) {   
        header('location:login.php');
    } else {
        mysqli_query($con, "insert into wishlist(userId,productId) values('" . $_SESSION['id'] . "','" . $_GET['pid'] . "')");
        echo "<script>alert('Товар добавлен в список желаемого');</script>";
        header('location:my-wishlist.php');
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <title>Категория товаров</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Customizable CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/green.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
    <link href="assets/css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/rateit.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

    <!-- Demo Purpose Only. Should be removed in production -->
    <link rel="stylesheet" href="assets/css/config.css">

    <link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
    <link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
    <link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
    <link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
    <link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
    <!-- Demo Purpose Only. Should be removed in production : END -->

    
    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Fonts --> 
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->

</head>
<body class="cnt-home">

<header class="header-style-1">

    <!-- ============================================== TOP MENU ============================================== -->
    <?php include('includes/top-header.php'); ?>
    <!-- ============================================== TOP MENU : END ============================================== -->
    <?php include('includes/main-header.php'); ?>
    <!-- ============================================== NAVBAR ============================================== -->
    <?php include('includes/menu-bar.php'); ?>
    <!-- ============================================== NAVBAR : END ============================================== -->

</header>
<!-- ============================================== HEADER : END ============================================== -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row outer-bottom-sm'>
            <div class='col-md-3 sidebar'>
                <!-- ================================== TOP NAVIGATION ================================== -->
                <!-- ================================== TOP NAVIGATION : END ================================== -->               
                <div class="sidebar-module-container">
                    <div class="sidebar-filter">
                        <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                        <div class="sidebar-widget wow fadeInUp outer-bottom-xs">
                            <div class="widget-header m-t-20">
                                <h4 class="widget-title">Категории</h4>
                            </div>
                            <div class="sidebar-widget-body m-t-10">
                                <?php 
                                $sql = mysqli_query($con, "select id,categoryName from category");
                                while ($row = mysqli_fetch_array($sql)) { ?>
                                    <div class="accordion">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a href="category.php?cid=<?php echo $row['id']; ?>" class="accordion-toggle collapsed">
                                                    <?php echo $row['categoryName']; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div><!-- /.sidebar-widget-body -->
                        </div><!-- /.sidebar-widget -->
                    </div><!-- /.sidebar-filter -->
                </div><!-- /.sidebar-module-container -->
            </div><!-- /.sidebar -->
            <div class='col-md-9'>
                <!-- ========================================== SECTION – HERO ========================================= -->

                <div id="category" class="category-carousel hidden-xs">
                    <div class="item">  
                        <div class="image">
                            <img src="assets/images/banners/123.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="container-fluid">
                            <div class="caption vertical-top text-left">
                                <div class="big-text">
                                    <br />
                                </div>

                            </div><!-- /.caption -->
                        </div><!-- /.container-fluid -->
                    </div>
                </div>

                <div class="search-result-container">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active " id="grid-container">
                            <div class="category-product inner-top-vs">
                                <div class="row">                                    
                                    <?php
                                    $ret = mysqli_query($con, "select * from products where subCategory='$cid'");
                                    $num = mysqli_num_rows($ret);
                                    if ($num > 0) {
                                        while ($row = mysqli_fetch_array($ret)) { ?>                          
                                            <div class="col-sm-6 col-md-4 wow fadeInUp">
                                                <div class="products">              
                                                    <div class="product">      
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
                                                                    <img src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" alt="" width="200" height="300">
                                                                </a>
                                                            </div><!-- /.image -->                                             
                                                        </div><!-- /.product-image -->
                                                        
                                                        <div class="product-info text-left">
                                                            <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
                                                            <div class="description"></div>

                                                            <div class="product-price">   
                                                                <span class="price">
                                                                 <?php echo htmlentities($row['productPrice']); ?> ₸          
                                                                </span>
                                                            </div><!-- /.product-price -->
                                                            
                                                        </div><!-- /.product-info -->
                                                        <div class="cart clearfix animate-effect">
    <div class="action">
        <ul class="list-unstyled">
            <li class="add-cart-button btn-group">
                <?php if ($row['productAvailability'] == 'В наличии') { ?>
                    <!-- Иконка корзины для добавления товара в корзину -->
                    <a href="category.php?page=product&action=add&id=<?php echo $row['id']; ?>">
                        <button class="btn btn-primary icon" type="button" style='margin-right: 8px'>
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                    </a>
                    <!-- Кнопка "Просмотреть товар" -->
                    <a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
                        <button class="btn btn-primary" type="button" style='outline: none'>Просмотреть</button>
                    </a>
                <?php } else { ?>
                    <div class="action" style="color:red">Нет в наличии</div>
                <?php } ?>
            </li>
            <li class="lnk wishlist">
                <a class="add-to-cart" href="category.php?pid=<?php echo htmlentities($row['id']) ?>&&action=wishlist" title="Список желаемого">
                    <i class="icon fa fa-heart"></i>
                </a>
            </li>
        </ul>
    </div><!-- /.action -->
</div><!-- /.cart -->

                                                    </div><!-- /.product -->
                                                </div><!-- /.products -->
                                            </div><!-- /.item -->
                                        <?php } 
                                    } else { ?>
                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <h3>Товаров не найдено</h3>
                                        </div>
                                    <?php } ?>                          
                                </div><!-- /.row -->
                            </div><!-- /.category-product -->
                        </div><!-- /.tab-pane -->
                    </div><!-- /.search-result-container -->
                </div><!-- /.col -->
            </div>
        </div>
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->
        <div id="brands-carousel" class="logo-slider wow fadeInUp">
            <div class="logo-slider-inner">  
                <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                    <div class="item m-t-15">
                        <a href="#" class="image">
                            <img data-echo="brandsimage/brand1.png" src="assets/images/blank.gif" alt="">
                        </a>  
                    </div><!--/.item-->
                    
                    <div class="item m-t-10">
                        <a href="#" class="image">
                            <img data-echo="brandsimage/brand2.png" src="assets/images/blank.gif" alt="">
                        </a>  
                    </div><!--/.item-->
                    
                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="brandsimage/brand3.png" src="assets/images/blank.gif" alt="">
                        </a>  
                    </div><!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="brandsimage/brand4.png" src="assets/images/blank.gif" alt="">
                        </a>  
                    </div><!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="brandsimage/brand5.png" src="assets/images/blank.gif" alt="">
                        </a>  
                    </div><!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="brandsimage/brand6.png" src="assets/images/blank.gif" alt="">
                        </a>  
                    </div><!--/.item-->
                </div><!-- /.owl-carousel #logo-slider -->
            </div><!-- /.logo-slider-inner -->
        </div><!-- /.logo-slider -->
        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->  
    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php include('includes/footer.php'); ?>
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
