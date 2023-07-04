<div class="modal-header">
	<h5 class="modal-title" id="">Ubah Tahun Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/tahun_diklat/update')?>
<input type="hidden" name="f_uc" value="<?=$row->uc?>">
<input type="hidden" name="f_uc_diklat" value="<?=$row->uc_diklat?>">
<div class="modal-body">

	<div class="form-group">
		<label>Tahun Diklat</label>
		 <input type="text" class="form-control" name="f_tahun" placeholder="YYYY" value="<?=$row->tahun?>">
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>