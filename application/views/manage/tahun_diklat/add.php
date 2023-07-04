<div class="modal-header">
	<h5 class="modal-title" id="">Tambah Tahun Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/tahun_diklat/insert')?>
<input type="hidden" name="f_uc_diklat" value="<?=$row->uc?>">
<div class="modal-body">

	<div class="form-group">
		<label>Tahun Diklat</label>
		 <input type="text" class="form-control" name="f_tahun" placeholder="YYYY">
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>