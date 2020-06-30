<?php

require_once '../private/system.php';
require_once '../private/PropertyRecord.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	/*
	if (is_uploaded_file($_FILES['image']['tmp_name'])) {
		move_uploaded_file($_FILES['image']['tmp_name'], '../private/images/image.jpg');
		$image = imagecreatefromjpeg('../private/images/image.jpg');
		$thumb = imagescale($image , 100);
		imagejpeg($thumb, '../private/images/image_thumb.jpg');
	}
	*/

	var_dump($_POST);

}

$uuid = $_GET['uuid'];
$record = (new TechnicalTrial\PropertyRecord())->getByUUID($uuid);

include 'header.php';

?>


<form method="post" action="" enctype="multipart/form-data" class="form-horizontal">
	
	<?php FOREACH ($record->getFields() AS $f => $fv): ?>

	<div class="form-group">
	<?php if ($fv['form_type']): ?>
		<label for="<?= $f ?>" class="control-label"><?= $f ?></label>:
		<input type="<?= $fv['form_type'] ?>" name="<?= $f ?>" value="<?= $fv['value'] ?>" />
	<?php endif ?>
	</div>

	<?php ENDFOREACH ?>

	<input type="file" name="image" />

	<input type="submit" />

</form>


<?php include 'footer.php' ?>
