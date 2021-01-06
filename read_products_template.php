<?php

// loop through list of retrieved products from the database
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		
	echo "<div class='column'>";
				
		echo "<a href='{$home_url}product.php?id={$row['id']}'>";
			// related image files to a product
			$product_image->product_id=$row['id'];
			$stmt_product_image = $product_image->readFirst();
			$num_product_image = $stmt_product_image->rowCount();

			if($num_product_image>0){
				$x=1;
				while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
					$product_image_name = $row_product_image['name'];
					echo "<img src='uploads/images/{$product_image_name}' Width='200' Height='300'>";
					$x++;
				}
			}else{
				echo "No images.";
			}
		echo "</a>";
							
		// product name
		echo "<div class='product-id'>{$row['id']}</div>";
		echo "<div class='product-name'>{$row['name']}</div>";
		
		echo "<h2  title='{$row['name']}'><a href='{$home_url}product.php?id={$row['id']}'>{$row['name']}</a></h2>";
		echo "<h5 title='{$row['author']}'>Author: {$row['author']}</h5>";
				
			// product price and category name
			$variation->product_id=$row['id'];
			$variation->readFirstByProductId();

			echo "<h5>Price: &#36;" . number_format($variation->price, 2, '.', ',');
			echo "</h5>";
		echo "<h5>Category: {$row['category_name']}</h5>";
	echo "</div>";
}
echo "<div class='clear'></div>";
// pagination
// the page where this paging is used
$page_dom ="";

// count of all records
$total_rows=0;

// count all products in the database to calculate total pages
if($page_title=='Product Search Results'){
	$page_dom = "search.php?s={$search_term}&";
	$total_rows = $product->countAll_BySearch($search_term);
}

// all products page
else if(strpos($page_title, 'Product')!==false && !isset($category_name)){
	$page_dom = "products.php?";
	$total_rows = $product->countAll();
}

// it's a product category page
else{
	$page_dom = "category.php?id={$category_id}&";
	$product->category_id=$category_id;
	$total_rows = $product->countAll_ByCategory();
}

// actual paging buttons
include_once "paging.php";
?>
