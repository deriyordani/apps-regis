<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		$('select[name=f_diklat]').change(function(){
			var uc_diklat = $(this).val();

			$('select[name=f_angkatan]').load(base_url+'manage/jadwal_diklat/load_angkatan', {js_uc_diklat : uc_diklat});

			//return false;
		});

		$('select[name=f_angkatan]').change(function(){
			var uc_tahun = $(this).val();
			var uc_diklat = $('select[name=f_diklat] option:selected').val();

			// alert(uc_diklat);
			$('select[name=f_periode]').load(base_url+'manage/jadwal_diklat/get_periode',{js_uc_tahun : uc_tahun, js_uc_diklat : uc_diklat});
		});

		$('input[name=f_ok]').click(function(){
			var page = 1;
			var uc_diklat = $('select[name=f_diklat] option:selected').val();
			var angkatan = $('select[name=f_angkatan] option:selected').val();
			var periode = $('select[name=f_periode] option:selected').val();
			var bulan = $('select[name=f_month] option:selected').val();
			var tahun = $('select[name=f_year] option:selected').val();

			// alert(uc_diklat+"-"+angkatan+"-"+periode+"-"+bulan+"-"+tahun);
			$('.load-data').load(base_url+'manage/jadwal_diklat/page',{
							js_page : page,
							js_uc_diklat : uc_diklat,
							js_angkatan : angkatan,
							js_periode : periode,
							js_bulan : bulan,
							js_tahun : tahun
			});

			return false;

		});

		$('.page-jadwal-diklat a.pagination-ajax').click(function(){
			var page = $(this).attr('title');
			var uc_diklat = $('select[name=f_diklat] option:selected').val();
			var angkatan = $('select[name=f_angkatan] option:selected').val();
			var periode = $('select[name=f_periode] option:selected').val();
			var bulan = $('select[name=f_month] option:selected').val();
			var tahun = $('select[name=f_year] option:selected').val();

			$('.load-data').load(base_url+'manage/jadwal_diklat/page',{
							js_page : page,
							js_uc_diklat : uc_diklat,
							js_angkatan : angkatan,
							js_periode : periode,
							js_bulan : bulan,
							js_tahun : tahun
			});

			return false;
		});


		$('.btn-add').click(function(){
			

			$('.load-form').load(base_url+'manage/jadwal_diklat/add_atur_jadwal');
			
		
		});


		$('.btn-edit').click(function(){
			
			var uc = $(this).attr('uc');

			$('.load-form').load(base_url+'manage/jadwal_diklat/edit',{js_uc : uc});
			
		
		});


	});
</script>

<div class="row mb-3">
	<h1 class="h3 mb-2 mb-sm-0">JADWAL DIKLAT</h1>
	<h4 class="h4 mb-2 mb-sm-0 text-warning">DAFTAR</h4>
</div>

<div class="row mb-4">
	<div class="d-sm-flex justify-content-end">
		<a href="#" data-bs-toggle="modal" data-bs-target="#modals" class="btn btn-sm btn-primary mb-0 btn-add">Tambah Jadwal Diklat</a>
	</div>
</div>




<div class="row g-4 mb-4">
	<div class="col-md-12">
		<div class="card bg-primary bg-opacity-10 p-1 h-100">
			<div class="card-body">
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
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
					</div>
					<div class="col-md-2">
						<label>Diklat</label>

						<?php $list_diklat = list_diklat();?>
						<select name="f_diklat" class="form-control">
							
							<option value="">---Pilih---</option>

							<?php if(isset($list_diklat)):?>

								<?php foreach($list_diklat as $dk):?>

									<option value="<?=$dk->uc?>"><?=$dk->nama_diklat?></option>

								<?php endforeach;?>
							<?php endif;?>

						</select>

					</div>

					<div class="col-md-2">
						<label>Angkatan</label>

						<select name="f_angkatan"  class="form-control">
							<option value="">---Pilih---</option>
						</select>

					</div>

					<div class="col-md-2">
						<label>Periode</label>
						<select name="f_periode" class="form-control">
							<option value="">---Pilih---</option>
						</select>

					</div>

					<div class="col-md-2">
						<label>Bulan</label>
						<select name="f_month" class="form-control">
							<option value="0">--- All ---</option>
							<option value="1" <?=select_set(1,time_format(current_time(), 'm'))?>>Januari</option>
							<option value="2" <?=select_set(2,time_format(current_time(), 'm'))?>>Februari</option>
							<option value="3" <?=select_set(3,time_format(current_time(), 'm'))?>>Maret</option>
							<option value="4" <?=select_set(4,time_format(current_time(), 'm'))?>>April</option>
							<option value="5" <?=select_set(5,time_format(current_time(), 'm'))?>>Mei</option>
							<option value="6" <?=select_set(6,time_format(current_time(), 'm'))?>>Juni</option>
							<option value="7" <?=select_set(7,time_format(current_time(), 'm'))?>>Juli</option>
							<option value="8" <?=select_set(8,time_format(current_time(), 'm'))?>>Agustus</option>
							<option value="9" <?=select_set(9,time_format(current_time(), 'm'))?>>September</option>
							<option value="10"<?=select_set(10,time_format(current_time(), 'm'))?>>Oktober</option>
							<option value="11"<?=select_set(11,time_format(current_time(), 'm'))?>>November</option>
							<option value="12"<?=select_set(12,time_format(current_time(), 'm'))?>>Desember</option>
						</select>

					</div>

					<div class="col-md-2">
						<label>Tahun</label>
						<select name="f_year" class="form-control">
							<option value="">--- All ---</option>
							<?php 
								$start = time_format(current_time(), 'Y');

								for ($i=$start; $i <= $date_now ; $i++) { 
									echo "<option value='".$i."' ".select_set($i,time_format(current_time(), 'Y')).">".$i."</option>";
								}
							?>
						</select>

					</div>
				</div>
				<div class="row mt-3">
					<div class="d-sm-flex justify-content-end">
						<input type="submit" class="btn btn-sm btn-success btn-update" name="f_ok"  value="Filter" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card bg-transparent border load-data">

			<?php 

		        $data = NULL;
		        if (isset($result)) {
		            $data['result']         = $result;
		            $data['total_record']   = $total_record;
		            $data['pagination']     = $pagination;
		            }

		        $this->load->view('manage/jadwal_diklat/page', $data);
		    ?>

		</div>
		
	</div>

</div>

<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="addQuestTitle" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered " role="document">
    	<div class="modal-content load-form">
			
    	</div>
    </div>
</div>