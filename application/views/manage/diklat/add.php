<div class="modal-header">
	<h5 class="modal-title" id="">Tambah Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/diklat/insert')?>
<div class="modal-body">

	<div class="form-group mb-3">
		<label>Kategori Diklat</label>

		<?php $list_jenis_diklat = list_jenis_diklat();?>
		<select name="f_jenis_diklat" class="form-control">
			
			<option value="">---Pilih---</option>

			<?php if(isset($list_jenis_diklat)):?>

				<?php foreach($list_jenis_diklat as $lj):?>

					<option value="<?=$lj->uc?>"><?=$lj->jenis_diklat?></option>

				<?php endforeach;?>
			<?php endif;?>

		</select>
		
	</div>

	<div class="form-group mb-3">
		<label>Kode Diklat</label>
		<input type="text" class="form-control" name="f_kode_diklat" required="">
	</div>

	<div class="form-group mb-3">
		<label>Nama Program Diklat</label>
		<input type="text" class="form-control" name="f_nama_diklat" required="">
	</div>

	<div class="form-group mb-3">
		<label>Lama Diklat</label>
		<input type="text" class="form-control" name="f_lama_diklat">
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>