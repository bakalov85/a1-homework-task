<?php $pageTitle = 'Add range'; ?>
	
<?php require 'includes/header.php'; // $pageTitle is used here too ?>
<h1><?php echo $pageTitle; ?></h1>
<?php printMenu(["index.php" => "Ranges"]); ?>

<?php
    if ($_POST) {
        if (validateRange($_POST['range']) && addRange($_POST['range'])) {
            $statusMsg = ['type' => 'success', 'text' => 'Range created'];
        } else {
            $statusMsg = ['type' => 'error', 'text' => 'Error creating new range'];
        }
    }
?>

A range must start with a color, contain numbers and colors separated by commas, and end with a color. Example: green,-12,blue,-3,yellow,5,red<br />
Each consecutive number must be greater than the previous.
<br />
<?php if(!empty($statusMsg)): ?>
<span class="<?php echo $statusMsg['type']; ?>" id="status"><?php echo $statusMsg['text']; ?></span>
<?php endif; ?>

<form method="POST" axction="add-range.php">
    <input type="text" name="range" />
    <input type="submit" />
</form>


<?php require 'includes/footer.php'; ?>