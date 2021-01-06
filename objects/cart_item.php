<?php
// 'cart_item' object
class CartItem{

	// database connection and table name
	private $conn;
	private $table_name = "cart_items";

	// object properties
	public $id;
	public $product_id;
	public $quantity;
	public $variation_id;
	public $variation_name;
	public $user_id;
	public $created;

	// constructor
	public function __construct($db){
		$this->conn = $db;

	}

	public function checkIfExists(){

		// query to count all data
		$query = "SELECT quantity FROM " . $this->table_name . " WHERE user_id = ? and product_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $this->user_id);
		$stmt->bindParam(2, $this->product_id);

		// execute query
		$stmt->execute();

		// get row value
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// set quantity
		$this->quantity=$row['quantity'];

		// return all data count
		return $stmt->rowCount();
	}
	
	// update user id
	function updateUserId(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET user_id = ?
				WHERE user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(1, $this->user_id);
		$stmt->bindParam(2, $_SESSION['user_id']);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// read all cart items without limit clause, used drop-down list
	function readAll_WithoutPaging(){
		
		// select all data
		$query="SELECT p.id, p.name, ci.price, ci.variation_id, ci.variation_name, ci.quantity, ci.quantity * ci.price AS subtotal 
			FROM " . $this->table_name . " ci 
				LEFT JOIN products p
					ON ci.product_id = p.id
			WHERE user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $this->user_id);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}
	
	// delete the product
	function deleteAllByUser(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->user_id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// create cart_item
	function create(){

		$created=$this->getTimestamp();

		// insert query
		$query = "INSERT INTO " . $this->table_name . "
					SET product_id=:product_id, quantity=:quantity, price=:price,
						user_id=:user_id, variation_id=:variation_id, variation_name=:variation_name, created=:created";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
		$this->quantity=htmlspecialchars(strip_tags($this->quantity));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));
		$this->variation_id=htmlspecialchars(strip_tags($this->variation_id));
		$this->variation_name=htmlspecialchars(strip_tags($this->variation_name));

		// bind values
		$stmt->bindParam(":product_id", $this->product_id);
		$stmt->bindParam(":quantity", $this->quantity);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":user_id", $this->user_id);
		$stmt->bindParam(":variation_id", $this->variation_id);
		$stmt->bindParam(":variation_name", $this->variation_name);
		$stmt->bindParam(":created", $this->timestamp);

		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// used for paging categories
	public function countAll(){

		// query to count all data
		$query = "SELECT count(*) FROM " . $this->table_name . " WHERE user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $this->user_id);

		// execute query
		$stmt->execute();

		// get row value
		$rows = $stmt->fetch(PDO::FETCH_NUM);

		// return all data count
		return $rows[0];
	}
	
	// delete the product
	function delete(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE product_id = ? AND user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->product_id);
		$stmt->bindParam(2, $this->user_id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// update the cart_item
	function update(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET quantity = ?
				WHERE user_id = ? AND product_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(1, $this->quantity);
		$stmt->bindParam(2, $this->user_id);
		$stmt->bindParam(3, $this->product_id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// used for the 'created' field
	function getTimestamp(){
		date_default_timezone_set('Pacific/Auckland');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}
?>
