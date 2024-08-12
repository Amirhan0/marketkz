<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
else{
	$pid=intval($_GET['id']);// ID продукта
if(isset($_POST['submit']))
{
	$category=$_POST['category'];
	$subcat=$_POST['subcategory'];
	$productname=$_POST['productName'];
	$productcompany=$_POST['productCompany'];
	$productprice=$_POST['productprice'];
//	$productpricebd=$_POST['productpricebd']; //
	$productdescription=$_POST['productDescription'];
	$productscharge=$_POST['productShippingcharge'];
	$productavailability=$_POST['productAvailability'];
	
$sql=mysqli_query($con,"update products set category='$category',subCategory='$subcat',productName='$productname',productCompany='$productcompany',productPrice='$productprice',productDescription='$productdescription',shippingCharge='$productscharge',productAvailability='$productavailability' where id='$pid'");
$_SESSION['msg']="Продукт успешно обновлен!";

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Админ | Обновить продукт</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

   <script>
function getSubcat(val) {
	$.ajax({
	type: "POST",
	url: "get_subcat.php",
	data:'cat_id='+val,
	success: function(data){
		$("#subcategory").html(data);
	}
	});
}
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
async function fetchExchangeRate() {
                const response = await fetch('https://api.exchangerate-api.com/v4/latest/USD');
                const data = await response.json();
                return data.rates.KZT; // Получаем курс доллара к тенге
            }

            async function convertToTenge() {
                const exchangeRate = await fetchExchangeRate();
                let dollarPrice = document.getElementById('productpriceDollar').value;
                let tengePrice = dollarPrice * exchangeRate;
                document.getElementById('productprice').value = tengePrice.toFixed(2);
            }

</script>	


</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
<?php include('include/sidebar.php');?>				
			<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Обновить продукт</h3>
							</div>
							<div class="module-body">

									<?php if(isset($_POST['submit']))
{?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Отлично!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>


									<?php if(isset($_GET['del']))
{?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Ошибка!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
<?php } ?>

									<br />

			<form class="form-horizontal row-fluid" name="insertproduct" method="post" enctype="multipart/form-data">

<?php 

$query=mysqli_query($con,"select products.*,category.categoryName as catname,category.id as cid,subcategory.subcategory as subcatname,subcategory.id as subcatid from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>
<div class="control-group">
<label class="control-label" for="basicinput">Категория</label>
<div class="controls">
<select name="category" class="span8 tip" onChange="getSubcat(this.value);" required>
<option value="<?php echo htmlentities($row['cid']);?>"><?php echo htmlentities($row['catname']);?></option> 
<?php $query=mysqli_query($con,"select * from category");
while($rw=mysqli_fetch_array($query))
{
	if($row['catname']==$rw['categoryName'])
	{
		continue;
	}
	else{
	?>
<option value="<?php echo $rw['id'];?>"><?php echo $rw['categoryName'];?></option>
<?php }} ?>
</select>
</div>
</div>

									
<div class="control-group">
<label class="control-label" for="basicinput">Подкатегория</label>
<div class="controls">
<select name="subcategory" id="subcategory" class="span8 tip" required>
<option value="<?php echo htmlentities($row['subcatid']);?>"><?php echo htmlentities($row['subcatname']);?></option>
</select>
</div>
</div>


<div class="control-group">
<label class="control-label" for="basicinput">Название продукта</label>
<div class="controls">
<input type="text" name="productName" placeholder="Введите название продукта" value="<?php echo htmlentities($row['productName']);?>" class="span8 tip" >
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Компания-производитель</label>
<div class="controls">
<input type="text" name="productCompany" placeholder="Введите название компании" value="<?php echo htmlentities($row['productCompany']);?>" class="span8 tip" required>
</div>
</div>
<!-- <div class="control-group">
<label class="control-label" for="basicinput">Цена продукта до скидки</label>
<div class="controls">
<input type="text" name="productpricebd" placeholder="Введите цену продукта" value=" class="span8 tip" required>
</div>
</div> -->

<div class="control-group">
    <label class="control-label" for="basicinput">Цена продукта в долларах</label>
    <div class="controls">
        <input type="text" name="productpriceDollar" id="productpriceDollar" placeholder="Введите цену продукта в долларах" class="span8 tip" oninput="convertToTenge()" value="<?php echo isset($_POST['productpriceDollar']) ? htmlentities($_POST['productpriceDollar']) : ''; ?>" required>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="basicinput">Цена продукта в тенге</label>
    <div class="controls">
        <input type="text" name="productprice" id="productprice" placeholder="Цена продукта в тенге" class="span8 tip" value="<?php echo isset($_POST['productprice']) ? htmlentities($_POST['productprice']) : ''; ?>" readonly required>
    </div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Описание продукта</label>
<div class="controls">
<textarea name="productDescription" placeholder="Введите описание продукта" rows="6" class="span8 tip">
<?php echo htmlentities($row['productDescription']);?>
</textarea>  
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Стоимость доставки продукта</label>
<div class="controls">
<input type="text" name="productShippingcharge" placeholder="Введите стоимость доставки" value="<?php echo htmlentities($row['shippingCharge']);?>" class="span8 tip" required>
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Наличие продукта</label>
<div class="controls">
<select name="productAvailability" id="productAvailability" class="span8 tip" required>
<option value="<?php echo htmlentities($row['productAvailability']);?>"><?php echo htmlentities($row['productAvailability']);?></option>
<option value="В наличии">В наличии</option>
<option value="Нет в наличии">Нет в наличии</option>
</select>
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Изображение продукта 1</label>
<div class="controls">
<img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage1']);?>" width="200" height="100"> <a href="update-image1.php?id=<?php echo $row['id'];?>">Изменить изображение</a>
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Изображение продукта 2</label>
<div class="controls">
<img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage2']);?>" width="200" height="100"> <a href="update-image2.php?id=<?php echo $row['id'];?>">Изменить изображение</a>
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Изображение продукта 3</label>
<div class="controls">
<img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage3']);?>" width="200" height="100"> <a href="update-image3.php?id=<?php echo $row['id'];?>">Изменить изображение</a>
</div>
</div>
<?php } ?>
	<div class="control-group">
		<div class="controls">
			<button type="submit" name="submit" class="btn">Обновить</button>
		</div>
	</div>
</form>
							</div>
						</div>
					</div><!--/.content-->
					</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		});
	</script>
</body>
<?php } ?>
