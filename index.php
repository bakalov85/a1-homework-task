<?php $pageTitle = 'Ranges'; ?>
	
<?php require 'includes/header.php'; // $pageTitle is used here too ?>
<h1><?php echo $pageTitle; ?></h1>
<?php printMenu(["add-range.php" => "Add range"]); ?>

Ranges: <?php printSelectElement('ranges', getRanges()); ?><br />

Number: <input type="number" id="number" /><br />

<button id="check-number">Check number color</button><br />

Result: <span id="result">Please select range, number and click "Check number color"</span>
<br />
Info: If you select a boundary number, it belongs to the right-most color. For example in the range "green,-12,blue,-3,yellow,5,red" , -3 is yellow.

<script src="assets/script.js"></script>
<?php require 'includes/footer.php'; ?>