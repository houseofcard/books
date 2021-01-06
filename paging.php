<?php
// display page buttons
echo "<div class='center'>";
echo "<div class='pagination'>";

	// calculate total number of pages
	$total_pages = ceil($total_rows / $records_per_page);

	// range of links to show
	$range = 2;

	// display links to 'range of pages' around 'current page'
	$initial_num = $page - $range;
	$condition_limit_num = ($page + $range)  + 1;

	for ($x=$initial_num; $x<$condition_limit_num; $x++) {
    
		// be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
		if (($x > 0) && ($x <= $total_pages)) {
    
			// current page
			if ($x == $page) {
				echo "<a href='#' class='active'> $x</a>";
			} 
        
			// not current page
			else {
				echo "<a href='{$page_dom}page=$x'>$x</a>";
			}
		}
	}
echo "</div>";
echo "</div>";
?>