<?php
session_start();
$product_ids = array();
session_destroy();

//check if card button have been submited
if(filter_input(INPUT_POST, 'add_to_cart')){
	if(isset($_SESSION['shopping_cart'])){

	}
	else{ //if shopping cart doesn't exist, create first product with array key 0
		//create array using submitted from data, start from key 0
	$_SESSION['shopping_cart'][0] = array(
		'id' => filter_input(INPUT_GET, 'id'),
		'nume' => filter_input(INPUT_POST, 'nume'),
		'pret' => filter_input(INPUT_POST, 'pret'),
		'quantity' => filter_input(INPUT_POST, 'quantity'));
	}
}
pre_r($_SESSION);

function pre_r($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Selectare carti</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="Css/AfisareCarti.css" />
	</head>
	<body>
		<div class="container">
			
		
			<?php

				$connect = mysqli_connect('localhost', 'root', '', 'cart');
				$query = 'SELECT * FROM carti ORDER by id ASC';

				$result = mysqli_query($connect, $query);
				if($result):
					if(mysqli_num_rows($result)>0):
						while($product = mysqli_fetch_assoc($result)):
							?>
								<div class="col-sm-4 col-md-3">
									<form method="post" action="index.php?action=add&id= <?php echo $product['id']; ?>">
										<div class="products" style="height: 550px">
											<img src="<?php echo $product['imagine'];?>.jpg" class="img-responsive" />
											<h4 class="text-info" style="text-align: center;"><?php echo $product['nume']; ?></h4>
											<h4 style="text-align: right;"><?php echo $product['pret']; ?>Lei</h4>
											<input type="text" name="cantitate" class="form-control" value="1" />
											<input type="hidden" name="name" value="<?php echo $product['nume'];?>" />
											<input type="hidden" name="price" value="<?php echo $product['pret'];?>" />
											<div style="position:absolute;  bottom:5%; left: 28%"><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info"
													value="Adauga in cos" /></div>
										</div>
									</form>
								</div>
							<?php
						endwhile;
					endif;
				endif;
			?>

		</div>
	</body>
</html>
