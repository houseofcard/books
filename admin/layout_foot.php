<!-- end HTML page -->
</body>
</html>

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
	
	// change order status
	$('input[type=radio][name=status]').change(function() {
		// get the transaction id
		var transaction_id=$(this).attr('transaction-id');

		// post the change status request to change_order_status.php file
		// post variable include transaction_id and status
		$.post("change_order_status.php", {
			transaction_id: transaction_id,
			status: this.value
		}, function(data){

			// view the response in the log
			console.log(data);

			// tell the user order status was changed
			bootbox.alert("Order status was changed.");

		}).fail(function() {

			// in case posting the request failed, tell the user
			bootbox.alert("Unable to change order status.");

		});
	});
	
	// click listener for all delete buttons
	$(document).on('click', '.delete-object', function(){
		
		// current button
		var current_element=$(this);

		// id of record to be deleted
		var id = $(this).attr('delete-id');
		
		// php file used for deletion
		var file = $(this).attr('file');
		
		//window.alert(id);
		//window.alert(file);
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
					if(file=='product'){ 
						document.location.href = "delete_product.php?id=" + id;
					} 
					else if(file=='category'){ 
						document.location.href = "delete_category.php?id=" + id;
					}
					else if(file=='user'){
						document.location.href = "delete_user.php?id=" + id;
					}	
					else if(file=='image'){
						document.location.href = "delete_image.php?id=" + id;
					}	
					else if(file=='variation'){
						document.location.href = "delete_variation.php?id=" + id;
					}	
				}
			}
		});

		return false;
	});
	
	// catch the submit form, used to tell the user if password is good enough
	$('#create-user, #change-password').submit(function(){

		var password_strenght=$('#passwordStrength').text();

		if(password_strenght!='Good Password!'){
			alert('Password not strong enough');
			return false
		}

		return true;
	});

});

</script>

<!-- end HTML page -->
</body>
</html>
