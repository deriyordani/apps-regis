<option value=""> --- Pilih --- </option>
<?php foreach($result as $row):?>
	<option value="<?=$row->uc?>"> <?=$row->nama_diklat?> </option>
<?php endforeach;?>