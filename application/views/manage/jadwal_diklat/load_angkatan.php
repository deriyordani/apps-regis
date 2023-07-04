<option value="">--- Pilih ---</option>
<?php foreach($result as $row):?>
	<option value="<?=$row->uc?>"><?=$row->tahun?></option>
<?php endforeach;?>