<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		 /* Tanpa Rupiah */
	    var tanpa_rupiah = document.getElementById('tanpa-rupiah');
	    tanpa_rupiah.addEventListener('keyup', function(e)
	    {
	        tanpa_rupiah.value = formatRupiah(this.value);
	    });
	    
	  
	    
	    /* Fungsi */
	    function formatRupiah(angka, prefix)
	    {
	        var number_string = angka.replace(/[^,\d]/g, '').toString(),
	            split    = number_string.split(','),
	            sisa     = split[0].length % 3,
	            rupiah     = split[0].substr(0, sisa),
	            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
	            
	        if (ribuan) {
	            separator = sisa ? '.' : '';
	            rupiah += separator + ribuan.join('.');
	        }
	        
	        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	    }

	    $('.btn-add').click(function(){

	    	var uc_jenis_tarif = $('select[name=f_jenis_tarif] option:selected').val();
	    	var total_biaya = $('input[name=f_total_tarif]').val();
	    	var uc_diklat_tahun = $('input[name=f_uc_diklat_tahun]').val();
	    	var uc_diklat = $('input[name=f_uc_diklat]').val();


	    	$('.load-table').load(base_url+'manage/biaya_diklat/insert',{js_uc_jenis_tarif : uc_jenis_tarif, js_total_tarif : total_biaya, js_uc_diklat_tahun : uc_diklat_tahun, js_uc_diklat : uc_diklat });

	    	return false;
	    	
	    });

	});
</script>

<div class="row mb-3">
	
	<h1 class="h3 mb-2 mb-sm-0">DIKLAT</h1>
	<h4 class="h4 mb-2 mb-sm-0 text-warning">MENGELOLA BIAYA</h4>

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

<div class="row g-4 mb-4">
	<div class="col-md-12">
		<div class="card ">
			<h5 class="card-header-title">Form Biaya</h5>
			<div class="card-body border border-dash">


				<div class="row justify-content-md-center">

					<div class="col-md-auto col-8 align-items-center position-relative">
				      	<input type="hidden" name="f_uc_diklat_tahun" value="<?=$uc_diklat_tahun?>">
				      	<input type="hidden" name="f_uc_diklat" value="<?=$uc_diklat?>">
				      	
						<label>Jenis Tarif</label>
						<?php $list_jenis_tarif = list_jenis_tarif();?>

						<select name="f_jenis_tarif" class="form-control">
							<option value="">---Pilih----</option>

							<?php if(isset($list_jenis_tarif)):?>

								<?php foreach($list_jenis_tarif as $jt):?>

									<option value="<?=$jt->uc?>"><?=$jt->jenis_tarif?></option>

								<?php endforeach;?>
							<?php endif;?>
							
						</select>

				    </div>

				    <div class="col-md-auto col-8 align-items-center position-relative">
				      	
						<label>Biaya/Tarif</label>
						<input type="text" class="form-control" style="text-align: right;" id="tanpa-rupiah" name="f_total_tarif">

				    </div>


				</div>

				<div class="d-sm-flex justify-content-end">
					<a href="#" class="btn btn-sm btn-success btn-add"><i class="fas fa-save"></i> Tambah Biaya</a>
				</div>


			</div>
		</div>
	</div>
</div>

<div class="row g-4 mb-4">
	<div class="col-md-12">
		<div class="card ">
			<h5 class="card-header-title">Daftar Biaya Diklat</h5>
			<div class="card-body">
				<div class="table-responsive load-table">

					<table class="table table-dark-gray align-middle p-2 mb-0 table-hover">
						<thead>
							<tr>
								<th>No.</th>
								<th>Jenis Tarif</th>
								<th>BIaya/Tarif Diklat (Rp.)</th>
								<th>Aksi</th>
							</tr>
						</thead>

						<tbody>

							<?php if(isset($result)):?>

								<?php $no = 1;?>

								<?php foreach($result as $row):?>

									<tr>
										<td><?=$no?></td>
										<td><?=$row->jenis_tarif?></td>
										<td ><?=value_format($row->total_tarif)?></td>
										<td>
											
											<a class="btn btn-danger btn-round btn-sm" href="<?=base_url('manage/biaya_diklat/delete/'.$row->uc.'/'.$row->uc_diklat_tahun.'/'.$row->uc_diklat)?>" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"></i></a>
										</td>
									</tr>

									<?php $no++;?>
								<?php endforeach;?>

							<?php else:?>
								<tr>
									<td colspan="3">
										<div class="alert alert-danger text-center">Data Kosong</div>
									</td>
									
								</tr>
							<?php endif;?>

						</tbody>
						
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>

