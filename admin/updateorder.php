<?php
session_start();
include_once 'include/config.php';

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $oid = intval($_GET['oid']);

    if (isset($_POST['submit2'])) {
        $status = $_POST['status'];
        $remark = $_POST['remark']; // комментарий

        // Добавление записи в историю отслеживания заказа
        $query = mysqli_query($con, "INSERT INTO ordertrackhistory (orderId, status, remark) VALUES ('$oid', '$status', '$remark')");
        // Обновление статуса заказа
        $sql = mysqli_query($con, "UPDATE orders SET orderStatus='$status' WHERE id='$oid'");
        echo "<script>alert('Заказ успешно обновлен...');</script>";
    }
?>
<script language="javascript" type="text/javascript">
function closeWindow() {
    window.close();
}
function printPage() {
    window.print();
}
</script>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Обновление заказа</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="anuj.css" rel="stylesheet" type="text/css">
</head>
<body>
<div style="margin-left:50px;">
    <form name="updateticket" id="updateticket" method="post"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr height="50">
                <td colspan="2" class="fontkink2" style="padding-left:0px;">
                    <div class="fontpink2"><b>Обновление заказа!</b></div>
                </td>
            </tr>
            <tr height="30">
                <td class="fontkink1"><b>ID заказа:</b></td>
                <td class="fontkink"><?php echo $oid; ?></td>
            </tr>
            <?php 
            $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
            while ($row = mysqli_fetch_array($ret)) {
            ?>
            <tr height="20">
                <td class="fontkink1"><b>Дата:</b></td>
                <td class="fontkink"><?php echo $row['postingDate']; ?></td>
            </tr>
            <tr height="20">
                <td class="fontkink1"><b>Статус:</b></td>
                <td class="fontkink"><?php echo $row['status']; ?></td>
            </tr>
            <tr height="20">
                <td class="fontkink1"><b>Комментарий:</b></td>
                <td class="fontkink"><?php echo $row['remark']; ?></td>
            </tr>
            <tr>
                <td colspan="2"><hr /></td>
            </tr>
            <?php } ?>

            <?php 
            $st = 'Delivered';
            $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");
            while ($num = mysqli_fetch_array($rt)) {
                $currentSt = $num['orderStatus'];
            }
            if ($st == $currentSt) { ?>
            <tr>
                <td colspan="2"><b>Продукт доставлен</b></td>
            </tr>
            <?php } else { ?>
            <tr height="50">
                <td class="fontkink1">Статус:</td>
                <td class="fontkink">
                    <span class="fontkink1">
                        <select name="status" class="fontkink" required="required">
                            <option value="">Выберите статус</option>
                            <option value="in Process">В процессе</option>
                            <option value="Delivered">Доставлен</option>
                        </select>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="fontkink1">Комментарий:</td>
                <td class="fontkink" align="justify">
                    <span class="fontkink">
                        <textarea cols="50" rows="7" name="remark" required="required"></textarea>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="fontkink1">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="fontkink"></td>
                <td class="fontkink">
                    <input type="submit" name="submit2" value="Обновить" size="40" style="cursor: pointer;" />
                    &nbsp;&nbsp;
                    <input name="Submit2" type="button" class="txtbox4" value="Закрыть это окно" onClick="closeWindow();" style="cursor: pointer;" />
                </td>
            </tr>
            <?php } ?>
        </table>
    </form>
</div>
</body>
</html>
<?php } ?>
