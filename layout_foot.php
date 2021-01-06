	</div>
	<!-- /container -->

<!-- jQuery library -->
<script src="<?php echo $home_url; ?>libs/js/jquery.js"></script>

<!-- bootbox library -->
<script src="<?php echo $home_url; ?>libs/js/bootbox.min.js"></script>

<!-- our custom JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/custom-script2.js"></script>

<!-- bootstrap JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $home_url; ?>libs/js/bootstrap/docs-assets/js/holder.js"></script>

<script>
// jQuery codes
$(document).ready(function(){

	// lightbox settings
	$('#blueimp-gallery').data('useBootstrapModal', false);
	$('#blueimp-gallery').toggleClass('blueimp-gallery-controls', true);

	// if variation field exists
	if($(".variation").length){
		loadVariation();
	}

	$(document).on('change', '.variation', function(){
		loadVariation();
	});

	$(document).on('click', '#empty-cart', function(){
		bootbox.confirm({
			message: "<h4>Are you sure?</h4>",
			buttons: {
				confirm: {
					label: '<span class="glyphicon glyphicon-ok"></span> Yes',
					className: 'btn-danger'
				},
				cancel: {
					label: '<span class="glyphicon glyphicon-remove"></span> No',
					className: 'btn-primary'
				}
			},
			callback: function (result) {

				if(result==true){
					window.location.href = "<?php echo $home_url; ?>empty_cart.php";
				}
			}
		});

	});

	// add to cart button listener
	$('.add-to-cart-form').on('submit', function(){

		// info is in the table / single product layout
		var id = $(this).find('.product-id').text();
		var quantity = $(this).find('.cart-quantity').val();
		var variation_id=$('.variation').find(':selected').val();
		//window.alert(id);
		//window.alert(quantity);
		//window.alert(variation_id);
		// redirect to add_to_cart.php, with parameter values to process the request
		window.location.href = "<?php echo $home_url; ?>add_to_cart.php?id=" + id + "&quantity=" + quantity + "&variation_id=" + variation_id;
		return false;
	});

	// update quantity button listener
	$('.update-quantity-form').on('submit', function(){

		// get basic information for updating the cart
		var id = $(this).find('.product-id').text();
		var quantity = $(this).find('.cart-quantity').val();

		// redirect to update_quantity.php, with parameter values to process the request
		window.location.href = "<?php echo $home_url; ?>update_quantity.php?id=" + id + "&quantity=" + quantity;
		return false;
	});

	// catch the submit form, used to tell the user if password is good enough
	$('#register, #change-password').submit(function(){

		var password_strenght=$('#passwordStrength').text();

		if(password_strenght!='Good Password!'){
			alert('Password not strong enough');
			return false
		}

		return true;
	});

});

function loadVariation(){

	// get variable values
	var variation_id=$('.variation').find(':selected').val();
	var product_id=$('.product-id').text();
	var home_url = $('#home_url').text();
		
	$('.quantity-container').html("Loading...");

	// load price and quantity select box
	$.post( home_url+"load_variation.php", { variation_id: variation_id, product_id: product_id })
		.done(function( data ) {
			$('.quantity-container').html(data);

			// change price
			//var new_price=$('.price').text();
			//new_price=parseFloat(new_price).toFixed(2);
			//$('.price-description').html('&#36;'+new_price);
		});
}
</script>

<!-- end HTML page -->
</body>
</html>
