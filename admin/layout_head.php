<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- set the page title -->
	<title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Admin"; ?></title>

</head>
<body>

	<?php
	// include top navigation bar
	include_once "navigation.php";
	?>

    <!-- container -->
    <div class="container">

		<!-- display page title -->
        <h1><?php echo isset($page_title) ? $page_title : "Books Galore"; ?></h1>
        