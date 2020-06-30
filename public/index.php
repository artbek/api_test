<?php

require_once '../private/system.php';

require_once get_path('PropertyRecord.php');
require_once get_path('PropertyRecord.php');

$iterator = TechnicalTrial\PropertyRecord::getIterator();


include 'header.php';

?>

<table class="table">

	<tr>
		<td>
			<h3>Properties</h3>
		</td>
	</tr>	

<?php WHILE ($record = $iterator->fetch_assoc()): ?>
	<tr>
		<td>
			<?= $record['uuid'] ?>
		</td>
		<td>
			<?= $record['business_type'] ?>
		</td>
		<td>
			<?= $record['property_title'] ?>
		</td>
		<td>
			<?= $record['address'] ?>
		</td>
		<td>
			<?= $record['town'] ?>
		</td>
		<td>
			<?= $record['country'] ?>
		</td>
		<td>
			<?= $record['source'] ?>
		</td>
		<td>
			<?php IF ($record['source'] === 'api'): ?>
				<a href="edit.php?uuid=<?= $record['uuid'] ?>">Read Only</a>
			<?php ELSE: ?>
				<a href="edit.php?uuid=<?= $record['uuid'] ?>">Edit</a>
			<?php ENDIF ?>
		</td>
	</tr>
<?php ENDWHILE ?>

</table>

<?php include 'footer.php' ?>
