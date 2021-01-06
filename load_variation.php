<?php
if($_POST){

    // core configuration
    include_once "config/core.php";

    // connect to database
    include_once "config/database.php";
	
	 // include objects and classes
    include_once 'objects/variation.php';
	
	// get database connection
	$database = new Database();
    $db = $database->getConnection();
	
	 // initialize objects
    $variation = new Variation($db);

	//get the id
	$variation_id=isset($_POST['variation_id']) ? $_POST['variation_id'] : die('ERROR: Variation ID not found.');
    $product_id=isset($_POST['product_id']) ? $_POST['product_id'] : die('ERROR: Product ID not found.');

	// read variation
    $variation->id=$variation_id;
    $variation->readOne();

    // price
	echo "<p>Price: &#36;" . number_format($variation->price, 2, '.', ',') . "</p>";
	
    // display stock count
    if($variation->stock>0){

        // display quantity selection
        echo "<p>Select Quantity:</p>";
		echo "<select class='form control cart-quantity' name='quantity' style='font-size:14px'>";
        //echo "<select style='font-size:14px'>";
            for($x=1; $x<=$variation->stock; $x++){
                echo "<option>{$x}</option>";
            }
        echo "</select>";

    	echo "<p></p>";
    	echo "<p>Only {$variation->stock} left in stock.</p>";
    	

        // enable add to cart button
		echo "<button class='btn btn-primary buy-button' type='submit'>";
            echo "<i class='glyphicon glyphicon-shopping-cart add-to-cart'></i> Add to cart";
        echo "</button>";
        
    }else if($variation->stock==0){
    	echo "<p>Out of stock.</p>";
    	echo "<a href='{$home_url}contact.php'>Contact Us</a>";
    }else{
    	echo "<p>Unable to identify stock.</p>";
    }
}
?>
