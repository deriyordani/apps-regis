			
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/vendor/flatpickr/css/flatpickr.min.css')?>">
			
<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		$('.btn-update').click(function(){
			var id 			= $(this).attr('title');
			var pel_mulai 	= $("input[name=f_pel_mulai_"+id+"]").val();
			var pel_akhir 	= $("input[name=f_pel_akhir_"+id+"]").val();
			
			var pen_akhir 	= $("input[name=f_pen_akhir_"+id+"]").val();
			var jumlah 		= $("input[name=f_jml_"+id+"]:checked").val();
			var uc_jadwal 	= $("input[name=f_uc_jadwal_diklat_"+id+"]").val();

			if (pen_akhir == '') {
				var pen_akhir = 'NULL';
			}else if (pel_akhir == '') {
				var pel_akhir = 'NULL';
			}else if (pel_mulai == '') {
				var pel_mulai = 'NULL';
			};

			if ((pel_mulai != '') && (pel_akhir != '')) {
				$.ajax({
						type	: 'post',
						dataType: 'json',
						url		: base_url+'manage/jadwal_diklat/update_jadwal_ajax',
						data    : {
									js_pel_akhir : pel_akhir,
									js_pel_mulai : pel_mulai,
									js_pen_akhir : pen_akhir,
									js_jumlah 	 : jumlah,
									js_uc 		 : uc_jadwal
								}
				});

				alert("Update data periode berhasil !!!");
			}else{
				alert("Tanggal Pelaksanaan Mulai dan Akhir Tidak Boleh Kosong");
			}
			
		});

	});
</script>

<div class="row mb-3">
	
	<h1 class="h3 mb-2 mb-sm-0">JADWAL DIKLAT</h1>
	<h4 class="h4 mb-2 mb-sm-0 text-warning">ATUR JADWAL</h4>

</div>

<div class="row g-4 mb-4">
	<div class="col-md-12">
		<div class="card bg-primary bg-opacity-10 p-1 h-100">
			<div class="card-body">
				<table width="100%">
					<tr>
						<th>Jenis Diklat</th>
						<td>:</td>
						<td><?=$dk->jenis_diklat?></td>
					</tr>
					<tr>
						<th>Kode/Nama Diklat</th>
						<td>:</td>
						<td><?=$dk->kode_diklat?> / <?=$dk->nama_diklat?></td>
					</tr>
					<tr>
						<th>Lama Diklat )*Hari</th>
						<td>:</td>
						<td><?=$dk->lama_diklat?> </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>



<?php for ($i=0; $i < $num_rows; $i++):?>

	<div class="row g-4 mb-4">

		<div class="card bg-transparent">

			<div class="card-header bg-warning bg-opacity-15 border border-warning rounded-3">
				<b>Periode <?=$i+1?></b>

				<input name="f_uc_jadwal_diklat_<?=$i?>" value="<?=$result[$i]->uc?>" type="hidden" />

				
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3 row">
							<label class="col-4 col-form-label">Tgl. Pendaftaran Akhir</label>
							<div class="col-8">
								<input name="f_pen_akhir_<?=$i?>"  class="flatpickr form-control" data-date-format="Y-m-d"  value="<?=($result[$i]->pendaftaran_akhir != NULL ? time_format($result[$i]->pendaftaran_akhir,'Y-m-d') : NULL)?>"/>
							</div>
						</div>

						<div class="mb-3 row">
							<label class="col-4 col-form-label">Tgl. Pelaksanaan</label>
							<div class="col-3">
								<input name="f_pel_mulai_<?=$i?>"  class="flatpickr form-control" data-date-format="Y-m-d" value="<?=($result[$i]->pelaksanaan_mulai != NULL ? time_format($result[$i]->pelaksanaan_mulai,'Y-m-d') : NULL)?>"/> 
							</div>
							<div class="col-2">s/d</div>
							<div class="col-3">
								<input name="f_pel_akhir_<?=$i?>"  class="flatpickr form-control" data-date-format="Y-m-d" value="<?=($result[$i]->pelaksanaan_akhir != NULL ? time_format($result[$i]->pelaksanaan_akhir,'Y-m-d') : NULL)?>"/> 
							</div>
						</div>


						<div class="mb-3 row">
							<label class="col-4 col-form-label">Jumlah Kursi</label>
							<div class="col-8">
								<input name="f_jml_<?=$i?>" value="1" type="radio" <?=($result[$i]->jumlah_kelas != 0 ? radio_set(1, $result[$i]->jumlah_kelas) : 'checked="checked"')?> /> 1 Kelas *30 Kouta
								<br/>
								<input name="f_jml_<?=$i?>" value="2" type="radio" <?=radio_set(2, $result[$i]->jumlah_kelas)?> /> 2 Kelas (A dan B) *60 Kouta
								<br/>
								<input name="f_jml_<?=$i?>" value="3" type="radio" <?=radio_set(3, $result[$i]->jumlah_kelas)?> /> 3 Kelas (A,B dan C) *90 Kouta
								<br/>
								<input name="f_jml_<?=$i?>" value="4" type="radio" <?=radio_set(4, $result[$i]->jumlah_kelas)?> /> 4 Kelas (A,B,C dan D) *120 Kouta
							</div>
						</div>
					</div>
					
				</div>

				<div class="d-sm-flex justify-content-end">
					<a href="#" class="btn btn-sm btn-success btn-update"  title="<?=$i?>"><i class="fas fa-save"></i> Update Periode</a>
				</div>
				
			</div>

		</div>

	</div>

<?php endfor;?>