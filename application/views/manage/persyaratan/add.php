<div class="modal-header">
	<h5 class="modal-title" id="">Tambah Persyaratan</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/persyaratan/insert')?>
<div class="modal-body">

	<div class="form-group">
		<label>Persyaratan</label>
		<textarea class="form-control" name="f_persyaratan"></textarea>
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>