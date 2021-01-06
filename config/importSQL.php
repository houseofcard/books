<!DOCTYPE html>

<html lang="en">
<body>

<div id="main">

    <h3>Import SQL</h3>

    <?php
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {

        $conn = new mysqli('localhost', 'threecor', 'uaj478u5', 'threecor_books');
        if ($conn->connect_errno) {
            echo "Unable to connect to SQL";
            echo "<br>";
        }
		
		$sql = "CREATE TABLE IF NOT EXISTS `categories` (
		id int(11) NOT NULL AUTO_INCREMENT,
		name varchar(256) NOT NULL,
		description text NOT NULL,
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) AUTO_INCREMENT=20";
		
		if($conn->query($sql) === TRUE) {
			echo "Table categories created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
	
		$sql = "INSERT INTO `categories` (`id`, `name`, `description`, `created`, `modified`) VALUES
		(1, 'Business Books', 'Books for the aspiring businessperson.', '2019-11-05', '2019-11-05'),
		(2, 'Cooking Books', 'Books for the adventerous cook.', '2019-11-05', '2019-11-05'),
		(3, 'Drama', 'Books for the avid reader.', '2019-11-05', '2019-11-05')";
				
		if($conn->query($sql) === TRUE) {
			echo "Import into categories successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}	
		
		$sql = "CREATE TABLE IF NOT EXISTS products (
		id int(11) NOT NULL AUTO_INCREMENT,
		name varchar(512) NOT NULL,
		author varchar(512) NOT NULL,
		description text NOT NULL,
		category_id int(11) NOT NULL,
		active_until datetime NOT NULL,
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		) AUTO_INCREMENT=41";
		
		if($conn->query($sql) === TRUE) {
			echo "Table products created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
	
		$sql = "INSERT INTO `products` (`id`, `name`, `author`, `description`, `category_id`, `active_until`, `created`, `modified`) VALUES
		(1, 'For Your Eyes Only', 'Ian Fleming', 'Agent 007 is given the responsibility of locating a lost encryption device.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(2, 'From Russia With Love', 'Ian Fleming', 'James Bond searches a Lektor cryptographic device which has the potential to wreak havoc in the world.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(3, 'Goldfinger', 'Ian Fleming', 'MI6 agent James Bond investigates a gold-smuggling ring run by businessman Auric Goldfinger.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(4, 'Made In India', 'Meera Sodha', 'The best Indian food is cooked (and eaten) at home.', 2, '2022-12-31', '2018-11-23', '2018-11-23'),
		(5, 'Posh Eggs', 'Hardie Grant', 'Over 70 recipes for wonderful eggy things.', 2, '2022-12-31', '2018-11-23', '2018-11-23'),
		(6, 'Instant Pot Pressure Cook Book', 'Maria Dominguez', '500 everyday recipes for beginners and advanced users.', 2, '2022-12-31', '2018-11-23', '2018-11-23'),
		(7, 'Good to Great', 'James C. Collins', 'Why some companies make the leap... and others do not.', 1, '2022-12-31', '2018-11-23', '2018-11-23'),
		(8, 'Bad Blood', 'John Carreyrou', 'The full inside story of the breathtaking rise and shocking collapse of Theranos, the multibillion-dollar biotech startup.', 1, '2022-12-31', '2018-11-23', '2018-11-23'),
		(9, 'Blue Horizon', 'Wilbur Smith', 'The next generation of Courtneys are out to stake their claim in Southern Africa.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(10, 'Catch 22', 'Joseph Heller', 'Catch-22 is a satirical war novel by American author Joseph Heller.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(11, 'Eagle in the Sky', 'Wilbur Smith', 'Eagle in the Sky, by bestselling author Wilbur Smith, is a tense action-packed thriller, where tragedy and conflict endanger everything David holds dear.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(12, 'Kaliyuga Age of Darkness', 'Patrick Andrews', 'Kaliyuga Age of Darkness is a novel set in modern-day India about a demon-race of extra-terrestrials called the Bhuta who are intent on invading the Earth, by taking over governments and militaries, and reducing every city into heaps of ash.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(13, 'Killer Sea', 'Patrick Andrews', 'Killer Sea is the story of a young diver with a death wish who journeys through the South East Asian oil fields, finding a harsh and hostile world of survival and endurance amid a cast of cutthroat bastards and glorious sinners.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(14, 'King of Kings', 'Wilbur Smith', 'Bestselling author Wilbur Smith tells a tale of two powerful families, the Courtneys and the Ballantynes, who meet again in a captivating story of love, loyalty and courage in a land torn between two powerful enemies.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(15, 'The Day of the Jackal', 'Frederick Forsyth', 'The Day of the Jackal (1971) is a thriller novel by English author Frederick Forsyth about a professional assassin who is contracted by the OAS, a French dissident paramilitary organisation, to kill Charles de Gaulle, the President of France.', 3, '2022-12-31', '2018-11-23', '2018-11-23'),
		(16, 'Winterwood', 'Patrick Andrews', 'Winterwood, a tale of conflict, murder and transcendence, relates the cataclysmic events that engulf the Tulloch family during the harsh southern New Zealand winter of 1986.', 3, '2022-12-31', '2018-11-23', '2018-11-23')";
		
		if($conn->query($sql) === TRUE) {
			echo "Import into products successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}	
		
		$sql = "CREATE TABLE IF NOT EXISTS product_images (
		id int(11) NOT NULL AUTO_INCREMENT,
		product_id int(11) NOT NULL,
		name varchar(512) NOT NULL,
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		) AUTO_INCREMENT=105" ;
		
		if($conn->query($sql) === TRUE) {
			echo "Table product_image created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	
		
		$sql = "INSERT INTO `product_images` (`id`, `product_id`, `name`, `created`, `modified`) VALUES
		(101, 1, 'for_your_eyes_only.jpg', '2018-11-23', '2018-11-23'),
		(102, 2, 'from_russia_with_love.jpg', '2018-11-23', '2018-11-23'),
		(103, 3, 'goldfinger.jpg', '2018-11-23', '2018-11-23'),
		(104, 4, 'made_in_india.jpg', '2018-11-23', '2018-11-23'),
		(105, 5, 'posh_eggs.jpg', '2018-11-23', '2018-11-23'),
		(106, 6, 'instant_pot_pressure_cook_book.jpg', '2018-11-23', '2018-11-23'),
		(107, 7, 'good_to_great.jpg', '2018-11-23', '2018-11-23'),
		(108, 8, 'bad_blood.jpg', '2018-11-23', '2018-11-23'),
		(109, 9, 'blue_horizon.jpg', '2018-11-23', '2018-11-23'),
		(110, 10, 'catch22.jpg', '2018-11-23', '2018-11-23'),
		(111, 11, 'eagle_in_the_sky.jpg', '2018-11-23', '2018-11-23'),
		(112, 12, 'kaliyuga_age_of_darkness.jpg', '2018-11-23', '2018-11-23'),
		(113, 13, 'killer_sea.jpg', '2018-11-23', '2018-11-23'),
		(114, 14, 'king_of_kings.jpg', '2018-11-23', '2018-11-23'),
		(115, 15, 'the_day_of_the_jackal.jpg', '2018-11-23', '2018-11-23'),
		(116, 16, 'winterwood.jpg', '2018-11-23', '2018-11-23')";
		
		if($conn->query($sql) === TRUE) {
			echo "Import into product images successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}		
		
		$sql = "CREATE TABLE IF NOT EXISTS `cart_items` (
		id int(11) NOT NULL AUTO_INCREMENT,
		product_id int(11) NOT NULL,
		quantity double NOT NULL,
		price decimal(10,2) NOT NULL,
		variation_id int(11) NOT NULL,
		variation_name varchar(124) NOT NULL,
		user_id varchar(512) NOT NULL COMMENT 'can be a temporary id',
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) AUTO_INCREMENT=174" ;

		if($conn->query($sql) === TRUE) {
			echo "Table cart_items created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	
	
		$sql = "CREATE TABLE IF NOT EXISTS `orders` (
		id int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
		transaction_id varchar(512) NOT NULL,
		user_id int(11) NOT NULL,
		total_cost decimal(19,2) NOT NULL,
		status varchar(128) NOT NULL,
		from_paypal int(2) NOT NULL,
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) AUTO_INCREMENT=19" ;
	
		if($conn->query($sql) === TRUE) {
			echo "Table orders created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	
		
		$sql = "CREATE TABLE IF NOT EXISTS `order_items` (
		id int(11) NOT NULL AUTO_INCREMENT,
		transaction_id varchar(512) NOT NULL,
		product_id int(11) NOT NULL,
		price decimal(19,2) NOT NULL,
		quantity int(11) NOT NULL,
		variation_id int(11) NOT NULL,
		variation_name varchar(124) NOT NULL,
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) AUTO_INCREMENT=34";
	
	
		if($conn->query($sql) === TRUE) {
			echo "Table order_items created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	
	
		$sql = "CREATE TABLE IF NOT EXISTS `product_pdfs` (
		id int(11) NOT NULL AUTO_INCREMENT,
		product_id int(11) NOT NULL,
		name varchar(512) NOT NULL,
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) AUTO_INCREMENT=4";
	
		if($conn->query($sql) === TRUE) {
			echo "Table products_pdfs created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	
				
		$sql = "CREATE TABLE IF NOT EXISTS `users` (
		id int(11) NOT NULL AUTO_INCREMENT,
		firstname varchar(32) NOT NULL,
		lastname varchar(32) NOT NULL,
		email varchar(64) NOT NULL,
		contact_number varchar(64) NOT NULL,
		address text NOT NULL,
		password varchar(512) NOT NULL,
		access_level varchar(16) NOT NULL,
		access_code text NOT NULL,
		status int(11) NOT NULL COMMENT '0=pending,1=confirmed',
		created datetime NOT NULL,
		modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) AUTO_INCREMENT=33";

		if($conn->query($sql) === TRUE) {
			echo "Table users created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	
	
		$sql = "INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `contact_number`, `address`, `password`, `access_level`, `access_code`, `status`, `created`, `modified`) VALUES
		(1, 'Mike', 'Dalisay', 'mike@example.com', '0999999999', 'Blk. 24 A, Lot 6, Ph. 3, Peace Village', '$2y$10$zfqXYiS6Of7fNu4hEDVOYu4KZ4XYYqVWWTudqXBXZJLv2PtuXFMKK', 'Admin', '', 1, '0000-00-00 00:00:00', '2016-10-30 12:45:22'),
		(4, 'Darwin', 'Potter', 'darwin@example.com', '09194444444', 'Blk. 24 A, Lot 6, Ph. 3, Peace Village, Antipolo City, Rizal.', '$2y$10$XIA5/XazBK/6XmkoWnhe2esjmB8aZjTdIQl7iDuY8x4wDIGV4lhO2', 'Customer', 'ILXFBdMAbHVrJswNDnm231cziO8FZomn', 1, '2014-10-29 17:31:09', '2016-12-04 06:00:46')";

		if($conn->query($sql) === TRUE) {
			echo "Import into users successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}

		$sql = "CREATE TABLE IF NOT EXISTS `variations` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`product_id` int(11) NOT NULL,
		`name` varchar(512) NOT NULL,
		`price` decimal(10,2) NOT NULL,
		`stock` int(11) NOT NULL,
		`created` datetime NOT NULL,
		`modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) AUTO_INCREMENT=52" ;

		if($conn->query($sql) === TRUE) {
			echo "Table variations created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	

		$sql = "INSERT INTO `variations` (`id`, `product_id`, `name`, `price`, `stock`, `created`, `modified`) VALUES
		(1, 1, 'Paperback', '19.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(2, 1, 'Hard Cover', '29.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(3, 2, 'Paperback', '22.99', 20, '2016-11-01 01:12:11', '2016-11-21 07:26:03'),
		(4, 2, 'Hard Cover', '31.99', 20, '2016-11-01 14:35:15', '2016-11-21 07:26:59'),
		(5, 3, 'Paperback', '15.99', 20, '2016-11-01 14:37:14', '2016-11-01 06:37:14'),
		(6, 3, 'Hard Cover', '19.99', 20, '2016-11-01 14:37:14', '2016-11-01 06:37:14'),
		(7, 4, 'Paperback', '21.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(8, 4, 'Hard Cover', '25.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(9, 5, 'Paperback', '17.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(10, 5, 'Hard Cover', '22.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(11, 6, 'Paperback', '23.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(12, 6, 'Hard Cover', '42.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(13, 7, 'Paperback', '19.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(14, 7, 'Hard Cover', '29.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(15, 8, 'Paperback', '15.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(16, 8, 'Hard Cover', '25.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(17, 9, 'Paperback', '17.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(18, 9, 'Hard Cover', '27.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(19, 10, 'Paperback', '19.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(20, 10, 'Hard Cover', '29.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(21, 11, 'Paperback', '19.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(22, 11, 'Hard Cover', '29.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(23, 12, 'Paperback', '15.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(24, 12, 'Hard Cover', '25.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(25, 13, 'Paperback', '19.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(26, 13, 'Hard Cover', '29.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(27, 14, 'Paperback', '19.99', 20, '2016-11-01 01:08:11', '2016-12-01 19:58:40'),
		(28, 14, 'Hard Cover', '23.99', 20, '2016-11-01 01:11:56', '2016-11-21 07:26:52'),
		(29, 15, 'Paperback', '19.99', 20, '2016-11-01 01:12:11', '2016-11-21 07:26:03'),
		(30, 15, 'Hard Cover', '29.99', 20, '2016-11-01 14:35:15', '2016-11-21 07:26:59'),
		(31, 16, 'Paperback', '22.99', 20, '2016-11-01 14:37:14', '2016-11-01 06:37:14'),
		(32, 16, 'Hard Cover', '34.99', 20, '2016-11-01 14:37:14', '2016-11-01 06:37:14')";		

		if($conn->query($sql) === TRUE) {
			echo "Import into variations successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}
		
	
	}	
	$conn->close();
	?>	
</div>

</body>
</html>
