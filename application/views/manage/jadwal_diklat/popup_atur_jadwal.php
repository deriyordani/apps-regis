<script type="text/javascript">
$(document).ready(function(){
	var base_url = $('#base-url').text();

	$('select[name=f_jenis_diklat]').change(function(){
		var uc_jenis_diklat = $(this).val();

		$('select[name=f_uc_diklat]').load(base_url+'manage/jadwal_diklat/get_diklat',{js_uc_jenis_diklat : uc_jenis_diklat});
		
	});

	$('select[name=f_uc_diklat]').change(function(){
		var uc_diklat = $(this).val();

		// alert(base_url);
		$('select[name=f_uc_angkatan]').load(base_url+'manage/jadwal_diklat/get_angkatan',{js_uc_diklat : uc_diklat});
	});

});
</script>


<div class="modal-header">
	<h5 class="modal-title" id="">Tambah Jadwal Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/jadwal_diklat/proses_atur_jadwal');?>
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
		<label>Diklat</label>
		
		<select name="f_uc_diklat" class="form-control">
			<option value=""> --- Pilih --- </option>
			<!-- <?php $diklat = list_diklat(); ?>
			<?php if(isset($diklat)):?>
				<?php foreach($diklat as $dk):?>
					<option value="<?=$dk->uc?>">[<?=$dk->kode_diklat?>] <?=$dk->nama_diklat?></option>
				<?php endforeach;?>
			<?php endif;?> -->
		</select>

	</div>

	<div class="form-group mb-3">
		<label>Angkatan</label>
		<select name="f_uc_angkatan" class="form-control">
			<option value=""> --- Pilih --- </option>
		</select>
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Proses" class="btn btn-primary" >

</div>

<?=form_close()?>