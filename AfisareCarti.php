<?php   

 session_start();  
 $product_ids = array();
 //session_destroy();
 $connect = mysqli_connect('localhost', 'root', '', 'cart');  

 //check if Add to Cart button has been submitted
 if(filter_input(INPUT_POST,'add_to_cart'))
 {    
      //if shopping cart $_SESSION variable already exists, add items to the existing cart array
      if(isset($_SESSION['shopping_cart']))  
      {   
           //keep track how many products are in the shopping cart 
           $count = count($_SESSION['shopping_cart']);  //count() starts from 1, array keys start from 0
           
           //create sequential for matching array keys to product id's
           $product_ids = array_column($_SESSION['shopping_cart'],'id'); 
           
           //if the product being added to the cart does NOT exist in the array
           if(!in_array(filter_input(INPUT_GET,'id'), $product_ids))  
           {     
                //fill the $_SESSION shopping cart array with GET id variable and POST form values
                $_SESSION['shopping_cart'][$count] = array //add next array key based on session count
                (  
                     'id'        =>  filter_input(INPUT_GET,'id'),  
                     'nume'      =>  filter_input(INPUT_POST,'nume'),  
                     'pret'     =>  filter_input(INPUT_POST,'pret'),    
                     'quantity'  =>  filter_input(INPUT_POST,'quantity')  
                );  
           }  
           else  //product already exists, increase quantity
           {  
                //match array key to id of the product being added to the cart
                for ($i = 0; $i < count($product_ids); $i++)
                {
                    if ($product_ids[$i] == filter_input(INPUT_GET,'id'))
                    {
                        //add item quantity to the existing product in the array
                        $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST,'quantity');
                    }
                } 
           } 
      }  
      else  //if shopping cart doesn't exist, create first product with array key 0
      {  
           //create array using submitted form data, starting from key 0 and fill it with values
            $_SESSION['shopping_cart'][0] = array
            (  
                 'id'        =>  filter_input(INPUT_GET,'id'),  
                 'nume'      =>  filter_input(INPUT_POST,'nume'),  
                 'pret'     =>  filter_input(INPUT_POST,'pret'),    
                 'quantity'  =>  filter_input(INPUT_POST,'quantity')  
            );   
      }  
 }  
 
 //removing products from the shopping cart session
 if(filter_input(INPUT_GET,'action'))  
 {  
      if(filter_input(INPUT_GET,'action') == 'delete')  
      {   
           //loop through all products in the shopping cart until it matches GET id variable
           foreach($_SESSION['shopping_cart'] as $key => $product)  
           {  
                if($product['id'] == filter_input(INPUT_GET,'id'))  
                {  
                     //remove product from the shopping cart when it matches with the GET id
                     unset($_SESSION['shopping_cart'][$key]);  
                }  
           }
           //reset session array keys so they match with $product_ids numeric array
           $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
      }  
 }  
 
 //pre_r($product_ids);
 //pre_r($_SESSION['shopping_cart']);
 
 function pre_r($array)
 {
     echo '<pre>';
     print_r($array);
     echo '</pre>';
 }
 ?>  

 <!DOCTYPE html> 
 <html>  
      <head>  
           <title>Shopping Cart (complete)</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <link rel="stylesheet" type="text/css" href="shopping-cart.css">
           <link rel="stylesheet" href="Css/StyleMenu.css" />
      </head>  
    <body style="background-image: linear-gradient(to left bottom, white 0%, grey 100%);">
   <div class="sandbox sandbox-titlu">
          <h1 class="heading-titlu">
              <em>Librarie</em>
              Online
          </h1>
      </div>
      <nav>
          <ul id="nav">
              <li>
                  <a href="Index.html">Home</a>
              </li>
              <li>
                  <a href="AfisareCarti.php">Magazin</a>
              </li>
              <li>
                  <a href="Chestionar.php">Chestionar Reducere</a>
              </li>
              <li>
                  <a href="form.php">Autentificare</a>
              </li>
          </ul>
      </nav>

    <br />  
    <div class="container"> 

         <?php  
         $query = 'SELECT * FROM carti ORDER BY id ASC';  
         $result = mysqli_query($connect, $query);  
         if ($result): //checks to make sure the products table is not empty
         if(mysqli_num_rows($result) > 0): 
              while($product = mysqli_fetch_array($result)): 
         ?>
         <div class="col-sm-4 col-md-3">  
            <form method="post" action="AfisareCarti.php?action=add&id=<?php echo $product['id']; ?>">  
                <div class="products">  
                     <?php 
                       $myNumber = $product['pret'];
                       $percentFinal = $myNumber;
                       if(isset($_SESSION['chestionarComplet'])){ 
                          if($_SESSION['chestionarComplet'] == 1){
                             $percentToGet = 85;
                             $percentInDecimal = $percentToGet / 100;
                             $percentFinal = $percentInDecimal * $myNumber;
                           }
                        }
                      ?>
                     <img src="<?php echo $product['imagine']; ?>.jpg" class="img-responsive" /><br />  
                     <h5 class="text-info"><?php echo $product['nume']; ?></h5>  
                     <h4><?php echo $percentFinal; ?> Lei</h4>  
                     <input type="text" name="quantity" class="form-control" value="1" />  
                     <input type="hidden" name="nume" value="<?php echo $product['nume']; ?>" />  
                     &nbsp;
                     <input type="hidden" name="pret" value="<?php echo $percentFinal ?>" />  
                     <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" 
                            value="Adauga in cos" />  
                </div>  
            </form>  
         </div>  
         <?php  
              endwhile;
         endif;   
         endif;
         ?>   
        <div style="clear:both"></div>  
        <br />  
        <div class="table-responsive">  
        <table class="table">  
            <tr><th colspan="5"><h3>Detalii comanda</h3></th></tr>   
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
        
             foreach($_SESSION['shopping_cart'] as $key => $product): 
        ?>  
        <?php 
              $myNumber = $product['pret'];
              $percentFinal = $myNumber;
                  if(isset($_SESSION['chestionarComplet'])){ 
                      if($_SESSION['chestionarComplet'] == 1){
                          $percentToGet = 85;
                          $percentInDecimal = $percentToGet / 100;
                          $percentFinal = $percentInDecimal * $myNumber;
                      }
                  }
        ?>
        <tr>  
           <td><?php echo $product['nume']; ?></td>  
           <td><?php echo $product['quantity']; ?></td>  
           <td><?php echo $percentFinal; ?> Lei</td>  
           <td><?php echo number_format($product['quantity'] * $percentFinal, 2); ?> Lei</td>  
           <td>
               <a href="AfisareCarti.php?action=delete&id=<?php echo $product['id']; ?>">
                    <div class="btn-danger">Sterge</div>
               </a>
           </td>  
        </tr>  
        <?php  
                  $total = $total + ($product['quantity'] * $percentFinal);  
             endforeach;  
        ?>  
        <tr>  
             <td colspan="3" align="right">Total</td>  
             <td align="right"> <?php echo number_format($total, 2); ?>Lei</td>  
             <td></td>  
        </tr>  
        <tr>
            <!-- Show checkout button only if the shopping cart is not empty -->
            <td colspan="5">
             <?php 
                if (isset($_SESSION['shopping_cart'])):
                if (count($_SESSION['shopping_cart']) > 0):
             ?>
                <a href="#" class="button">Checkout</a>
             <?php endif; endif; ?>
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