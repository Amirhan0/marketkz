<?php

if (isset($_GET['action'])) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_POST['quantity'] as $key => $val) {
            if ($val == 0) {
                unset($_SESSION['cart'][$key]);
            } else {
                $_SESSION['cart'][$key]['quantity'] = $val;
            }
        }
    }
}
?>

<?php
$sql = "SELECT * FROM products WHERE id IN (";
foreach ($_SESSION['cart'] as $id => $value) {
    $sql .= $id . ",";
}
$sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
$query = mysqli_query($con, $sql);
$totalprice = 0;
$totalqunty = 0;
if (!empty($query)) {
    while ($row = mysqli_fetch_array($query)) {
        $quantity = $_SESSION['cart'][$row['id']]['quantity'];
        $subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge'];
        $totalprice += $subtotal;
        $_SESSION['qnty'] = $totalqunty += $quantity;
    }
}
?>

<div class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                <!-- ============================================================= ЛОГО ============================================================= -->
                <div class="logo text-center">
                    <a href="index.php" style='display:flex; align-items:center'>
                        <img src="../IMG_0993.PNG" style='max-width: 100%; height: 100%' alt="">
                    </a>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                <div class="search-area">
                    <form name="search" method="post" action="search-result.php">
                        <div class="control-group">
                            <input class="search-field" placeholder="Ищите здесь..." name="product" required="required" style='outline:none' />
                            <button class="search-button" type="submit" name="search" style='border:none'></button>
                        </div>
                    </form>
                </div><!-- /.search-area -->
                <!-- ============================================================= ПОИСК : КОНЕЦ ============================================================= -->
            </div><!-- /.top-search-holder -->

            <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
                <!-- ============================================================= ВЫПАДАЮЩИЙ СПИСОК КОРЗИНЫ ============================================================= -->
                <?php
                if (!empty($_SESSION['cart'])) {
                ?>
                    <div class="dropdown dropdown-cart">
                        <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                            <div class="items-cart-inner">
                                <div class="total-price-basket">
                                    <span class="lbl">Корзина -</span>
                                    <span class="total-price">
                                        <span class="sign">₸.</span>
                                        <span class="value"><?php echo $totalprice; ?></span>
                                    </span>
                                </div>
                                <div class="basket">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </div>
                                <div class="basket-item-count"><span class="count"><?php echo $_SESSION['qnty']; ?></span></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">


                            <div class="clearfix cart-total">
                                <div class="pull-right">
                                    <span class="text">Итого:</span><span class='price'>₸.<?php echo $_SESSION['tp'] ?></span>
                                </div>
                                <div class="clearfix"></div>
                                <a href="my-cart.php" class="btn btn-upper btn-primary btn-block m-t-20">Моя корзина</a>
                            </div><!-- /.cart-total-->
                        </ul><!-- /.dropdown-menu-->
                    </div><!-- /.dropdown-cart -->
                <?php
                } else {
                ?>
                    <div class="dropdown dropdown-cart">
                        <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                            <div class="items-cart-inner">
                                <div class="total-price-basket">
                                    <span class="lbl">Корзина -</span>
                                    <span class="total-price">
                                        <span class="sign">₸.</span>
                                        <span class="value">0</span>
                                    </span>
                                </div>
                                <div class="basket">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </div>
                                <div class="basket-item-count"><span class="count">0</span></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="cart-item product-summary">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            Ваша корзина пуста.
                                        </div>
                                    </div>
                                </div><!-- /.cart-item -->
                                <hr>
                                <div class="clearfix cart-total">
                                    <div class="clearfix"></div>
                                    <a href="index.php" class="btn btn-upper btn-primary btn-block m-t-20">Продолжить покупки</a>
                                </div><!-- /.cart-total-->
                            </li>
                        </ul><!-- /.dropdown-menu-->
                    </div>
                <?php
                }
                ?>
                <!-- ============================================================= ВЫПАДАЮЩИЙ СПИСОК КОРЗИНЫ : КОНЕЦ ============================================================= -->
            </div><!-- /.top-cart-row -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div>