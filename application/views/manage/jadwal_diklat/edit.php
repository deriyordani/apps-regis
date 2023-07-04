<link rel="stylesheet" type="text/css" href="<?=base_url('assets/vendor/flatpickr/css/flatpickr.min.css')?>">

<!-- Vendors -->
<script src="<?=base_url()?>assets/vendor/purecounterjs/dist/purecounter_vanilla.js"></script>
<script src="<?=base_url()?>assets/vendor/apexcharts/js/apexcharts.min.js"></script>
<script src="<?=base_url()?>assets/vendor/overlay-scrollbar/js/overlayscrollbars.min.js"></script>
<script src="<?=base_url('assets/vendor/flatpickr/js/flatpickr.min.js')?>"></script>

<!-- Template Functions -->
<script src="<?=base_url()?>assets/js/functions.js"></script>


<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').attr('title');
		$('input[name=f_lama_diklat]').click(function(){
			var pel_akhir = $('input[name=f_pel_akhir]').val();

			var pel_awal = $('input[name=f_pel_mulai]').val();

			$.ajax({
					type	: 'post',
					dataType: 'json',
					url		: base_url+'manage/jadwal_diklat/cheack_lama_diklat',
					data    : {js_pel_akhir : pel_akhir,js_pel_mulai : pel_awal},
					success	: function(output) {

							//alert(output['lama_diklat']);
								$('input[name=f_lama_diklat]').val(output['lama_diklat']);							
								
					}
			});


		});

		$('input[name=f_jml]').click(function(){
			var id_type_user = $(this).val();

			if (id_type_user == 1){
				$('input[name=f_kouta]').val(30);
			}else{
				$('input[name=f_kouta]').val(60);
			}

		});
	});
</script>


<div class="modal-header">
	<h5 class="modal-title" id="">Ubah Jadwal Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<?=form_open('manage/jadwal_diklat/update')?>
<input name="f_uc" type="hidden" value="<?=$row->uc?>" />

<div class="modal-body">

	<div class="form-group mb-3">
		<label>Diklat</label>

		<select name="f_uc_diklat" disabled class="form-control">
			<option value=""> --- Pilih --- </option>
			<?php if(isset($diklat)):?>
				<?php foreach($diklat as $dk):?>
					<option value="<?=$dk->uc?>" <?=select_set($dk->uc,$row->uc_diklat)?>>[<?=$dk->kode_diklat?>] <?=$dk->nama_diklat?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>
		
	</div>

	<div class="form-group mb-3">
		<label>Angkatan</label>
		
		<select name="f_angkatan" disabled class="form-control">
			<option value=""> --- Pilih --- </option>
			<?php $jadwal = list_angkatan(array('uc_diklat' => $row->uc_diklat));?>
			<?php if(isset($jadwal)):?>
				<?php foreach($jadwal as $dk):?>
					<option value="<?=$dk->uc?>"  <?=select_set($dk->uc,$row->uc_diklat_tahun)?>><?=$dk->tahun?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>

	</div>

	<div class="form-group mb-3">
		<label>Periode</label>
		<input name="f_periode" disabled value="<?=$row->periode?>" class="form-control" />
	</div>

	<div class="form-group mb-3">
		<label>Tanggal Pendaftaran Akhir</label>
		<input name="f_pen_akhir"  class="flatpickr form-control" data-date-format="Y-m-d" value="<?=time_format($row->pendaftaran_akhir,'Y-m-d')?>" />
	</div>

	<div class="form-group mb-3">
		<label>Tanggal Pelaksanaan</label>
		<div class="row">
			
			<div class="col-md-5">
				<input name="f_pel_mulai"  class="flatpickr form-control" data-date-format="Y-m-d" value="<?=time_format($row->pelaksanaan_mulai,'Y-m-d')?>" />
			</div>
			<div class="col-md-2">
				s/d
			</div>

			<div class="col-md-5">
				<input name="f_pel_akhir"  class="flatpickr form-control" data-date-format="Y-m-d" value="<?=time_format($row->pelaksanaan_akhir,'Y-m-d')?>" />
			</div>

		</div>
	</div>

	<div class="form-group mb-3">
		<label>Jumlah Kursi</label>
		<br/>
		<input name="f_jml" value="1" type="radio" <?=($row->jumlah_kelas != 0 ? radio_set(1, $row->jumlah_kelas) : 'checked="checked"')?> /> 1 Kelas *30 Kouta
		<br/>
		<input name="f_jml" value="2" type="radio" <?=radio_set(2, $row->jumlah_kelas)?> /> 2 Kelas (A dan B) *60 Kouta
		<br/>
		<input name="f_jml" value="3" type="radio" <?=radio_set(3, $row->jumlah_kelas)?> /> 3 Kelas (A,B dan C) *90 Kouta
		<br/>
		<input name="f_jml" value="4" type="radio" <?=radio_set(4, $row->jumlah_kelas)?> /> 4 Kelas (A,B,C dan D) *120 Kouta
	</div>

</div>

<div class="modal-footer">

	<input type="submit" name="f_save" value="Simpan" class="btn btn-primary" >

</div>

<?=form_close()?>

