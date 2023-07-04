<div class="modal-header">
	<h5 class="modal-title" id="">Ubah Jenis Tarif</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/jenis_tarif/update')?>
<input type="hidden" name="f_uc" value="<?=$row->uc?>">
<div class="modal-body">

	<div class="form-group">
		<label>Jenis Tarif</label>
		 <input type="text" class="form-control" name="f_jenis_tarif" value="<?=$row->jenis_tarif?>">
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>