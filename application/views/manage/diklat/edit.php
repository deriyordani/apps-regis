<div class="modal-header">
	<h5 class="modal-title" id="">Ubah Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/diklat/update')?>
<input type="hidden" name="f_uc" value="<?=$row->uc?>">
<div class="modal-body">

	<div class="form-group mb-3">
		<label>Kategori Diklat</label>

		<?php $list_jenis_diklat = list_jenis_diklat();?>
		<select name="f_jenis_diklat" class="form-control">
			
			<option value="">---Pilih---</option>

			<?php if(isset($list_jenis_diklat)):?>

				<?php foreach($list_jenis_diklat as $lj):?>

					<option value="<?=$lj->uc?>" <?=select_set($lj->uc, $row->uc_jenis_diklat)?>><?=$lj->jenis_diklat?></option>

				<?php endforeach;?>
			<?php endif;?>

		</select>
		
	</div>

	<div class="form-group mb-3">
		<label>Kode Diklat</label>
		<input type="text" class="form-control" name="f_kode_diklat" required="" value="<?=$row->kode_diklat?>">
	</div>

	<div class="form-group mb-3">
		<label>Nama Program Diklat</label>
		<input type="text" class="form-control" name="f_nama_diklat" required="" value="<?=$row->nama_diklat?>">
	</div>

	<div class="form-group mb-3">
		<label>Lama Diklat</label>
		<input type="text" class="form-control" name="f_lama_diklat" value="<?=$row->lama_diklat?>">
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>