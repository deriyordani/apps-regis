<div class="modal-header">
	<h5 class="modal-title" id="">Ubah Jenis Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/jenis_diklat/update')?>
<input type="hidden" name="f_uc" value="<?=$row->uc?>">
<div class="modal-body">

	<div class="form-group">
		<label>Jenis Diklat</label>
		 <input type="text" class="form-control" name="f_jenis_diklat" value="<?=$row->jenis_diklat?>">
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>