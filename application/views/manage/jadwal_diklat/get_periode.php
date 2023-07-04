<option value=""> --- Pilih --- </option>
<?php foreach($result as $row):?>
	<option value="<?=$row->periode?>"> <?=$row->periode?> </option>
<?php endforeach;?>