<?php
session_start();
$product_ids = array();
session_destroy();

//check if card button have been submited
if(filter_input(INPUT_POST, 'add_to_cart')){
	if(isset($_SESSION['shopping_cart'])){
	    //keep track of number of item in cart
		$count = count($_SESSION['shopping_cart']);

		//create sequental array to match array key to products id's
		$product_ids = array_column($_SESSION['shopping_cart'], 'id');

        
		if(!in_array(filter_input(INPUT_GET, 'id'),$product_ids)){
			$_SESSION['shopping_cart'][$count] = array(
				'id' => filter_input(INPUT_GET, 'id'),
				'nume' => filter_input(INPUT_POST, 'nume'),
				'pret' => filter_input(INPUT_POST, 'pret'),
				'quantity' => filter_input(INPUT_POST, 'quantity')
			);
		}
		else{
           console_log(filter_input(INPUT_GET, 'id'));
			//match array key to the existing one
			for ($i=0; $i < count($product_ids); $i++) { 
				if($product_ids[$i] == filter_input(INPUT_GET, 'id')){
					//add item quantity to the existing product in the array

					$_SESSION['shopping_cart'][$i]['quantity'] += filter_input((INPUT_POST), 'quantity');
					}
				}
			}
	}
	else{ //if shopping cart doesn't exist, create first product with array key 0
		//create array using submitted from data, start from key 0
	$_SESSION['shopping_cart'][0] = array(
        
		'id' => filter_input(INPUT_GET, 'id'),
		'nume' => filter_input(INPUT_POST, 'nume'),
		'pret' => filter_input(INPUT_POST, 'pret'),
		'quantity' => filter_input(INPUT_POST, 'quantity')
		);echo 'CreatListaNoua';
	}
}

if(filter_input(INPUT_GET, 'action') == 'delete'){
	//loop throgh all product and check id
	foreach ($_SESSION['shopping_cart'] as $key => $product) {
		if($product['id'] == filter_input(INPUT_GET, 'id')){
			unset($_SESSION['shopping_cart'][$key]);
		}
	}
	//reset array key so they mach with $product_ids numeric array
	$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}


//pre_r($_SESSION);

function pre_r($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Selectare carti</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="Css/StyleMenu.css" />
	</head>
	<body>
		<div class="container">
            <div class="row">
		
			<?php

				$connect = mysqli_connect('localhost', 'root', '', 'cart');
				$query = 'SELECT * FROM carti  ORDER by id ASC';

				$result = mysqli_query($connect, $query);
				if($result):
					if(mysqli_num_rows($result)>0):
						while($product = mysqli_fetch_assoc($result)):
							?>
								<div class="col-sm-4 col-md-3">
									<form method="post" action="AfisareCarti.php?action=add&id=<?php echo $product['id']; ?>">
										<div class="products" style="height: 550px">
											<img src="<?php echo $product['imagine'];?>.jpg" class="img-responsive" />
											<h4 class="text-info" style="text-align: center;"><?php echo $product['nume']; ?></h4>
											<h4 style="text-align: right;"><?php echo $product['pret']; ?>Lei</h4>
											<input type="text" name="quantity" class="form-control" value="1" />
											<input type="hidden" name="nume" value="<?php echo $product['nume'];?>" />
											<input type="hidden" name="pret" value="<?php echo $product['pret'];?>" />
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
			<div style="clear:both"></div>
			<br />
			<div class="table-responsive">
				<table class = "table">
					<tr><th colspan="5"><h3>Detali comanda</h3></th></tr>
					<tr>
						<th width="40%">Nume Produs</th>
						<th width="10%">Cantitate</th>
						<th width="20%">Pret</th>
						<th width="15%">Total</th>
						<th width="5%">Actiune</th>
					</tr>
					<?php
						if(!empty($_SESSION['shopping_cart'])):

							$total = 0;

							foreach ($_SESSION['shopping_cart'] as $key => $product):
					?>
							<tr>
								<td><?php echo $product['nume'];?></td>
								<td><?php echo $product['quantity'];?></td>
								<td><?php echo $product['pret'];?> Lei</td>
								<td><?php echo number_format($product['quantity'] * $product['pret'],2);?> Lei</td>
								<td>
									<a href="AfisareCarti.php?action=delete$id=<?php echo $product['id']; ?>">
										<div class="btn-danger">Remove</div>
									</a>
								</td>
							</tr>
							<?php 
								$total = $total + ($product['quantity'] * $product['pret']);
									endforeach;
							?>
							<tr>
								<td colspan = "3" align="right">Total </td>
								<td align="right"><?php echo number_format($total,2);?> Lei</td>
								<td></td>
							</tr>
							<tr>
								<!-- Show checkout button only if shoping cart is not empty-->
								<td colspan="5">
									<?php
										if(isset($_SESSION['shopping_cart'])):
										if(count($_SESSION['shopping_cart']) > 0):
									  ?>
									   <a href="#" class="btn btn-info" style="float: : right;">Checkout</a>
									   <?php endif; endif;?>
								</td>
							</tr>
					<?php 
						endif;
					?>
				</table>
			</div>

		</div>
	</body>
</html>