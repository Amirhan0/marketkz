<div class="span3">
    <div class="sidebar">

        <ul class="widget widget-menu unstyled">
            <li>
                <a class="collapsed" data-toggle="collapse" href="#togglePages">
                    <i class="menu-icon icon-cog"></i>
                    <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
                    Управление заказами
                </a>
                <ul id="togglePages" class="collapse unstyled">
                    <li>
                        <a href="todays-orders.php">
                            <i class="icon-tasks"></i>
                            Заказы сегодня
                            <?php
                            $f1 = "00:00:00";
                            $from = date('Y-m-d') . " " . $f1;
                            $t1 = "23:59:59";
                            $to = date('Y-m-d') . " " . $t1;
                            $result = mysqli_query($con, "SELECT * FROM Orders WHERE orderDate BETWEEN '$from' AND '$to'");
                            $num_rows1 = mysqli_num_rows($result);
                            ?>
                            <b class="label orange pull-right"><?php echo htmlentities($num_rows1); ?></b>
                        </a>
                    </li>
                    <li>
                        <a href="pending-orders.php">
                            <i class="icon-tasks"></i>
                            Ожидающие заказы
                            <?php
                            $status = 'В процессе';
                            $ret = mysqli_query($con, "SELECT * FROM Orders WHERE orderStatus != '$status' OR orderStatus IS NULL");
                            $num = mysqli_num_rows($ret);
                            ?>
                            <b class="label orange pull-right"><?php echo htmlentities($num); ?></b>
                        </a>
                    </li>
                    <li>
                        <a href="delivered-orders.php">
                            <i class="icon-inbox"></i>
                            Доставленные заказы
                            <?php
                            $status = 'Доставлен';
                            $rt = mysqli_query($con, "SELECT * FROM Orders WHERE orderStatus = '$status'");
                            $num1 = mysqli_num_rows($rt);
                            ?>
                            <b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="manage-users.php">
                    <i class="menu-icon icon-group"></i>
                    Управление пользователями
                </a>
            </li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li><a href="category.php"><i class="menu-icon icon-tasks"></i> Создать категорию </a></li>
            <li><a href="subcategory.php"><i class="menu-icon icon-tasks"></i> Подкатегория </a></li>
            <li><a href="insert-product.php"><i class="menu-icon icon-paste"></i> Вставить продукт </a></li>
            <li><a href="manage-products.php"><i class="menu-icon icon-table"></i> Управление продуктами </a></li>
        </ul><!--/.widget-nav-->

        <ul class="widget widget-menu unstyled">
            <li><a href="user-logs.php"><i class="menu-icon icon-tasks"></i> Журнал входа пользователей </a></li>
            
            <li>
                <a href="logout.php">
                    <i class="menu-icon icon-signout"></i>
                    Выйти
                </a>
            </li>
        </ul>

    </div><!--/.sidebar-->
</div><!--/.span3-->
