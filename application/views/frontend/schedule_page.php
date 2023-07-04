<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		$('select[name=f_jenis_diklat]').change(function(){

			var uc_jenis_diklat = $(this).val();

			$('select[name=f_diklat]').load(base_url+'schedule/get_diklat', {js_uc_jenis_diklat : uc_jenis_diklat});
		});


		$('select[name=f_diklat]').change(function(){
			var uc_diklat = $(this).val();

			$('select[name=f_angkatan]').load(base_url+'schedule/load_angkatan', {js_uc_diklat : uc_diklat});

			//return false;
		});

		$('select[name=f_angkatan]').change(function(){
			var uc_tahun = $(this).val();
			var uc_diklat = $('select[name=f_diklat] option:selected').val();

			// alert(uc_diklat);
			$('select[name=f_periode]').load(base_url+'schedule/get_periode',{js_uc_tahun : uc_tahun, js_uc_diklat : uc_diklat});
		});

		$('.btn-cari').click(function(){
			var page = 1;
			var uc_jenis_diklat = $('select[name=f_jenis_diklat] option:selected').val();
			var uc_diklat = $('select[name=f_diklat] option:selected').val();
			var angkatan = $('select[name=f_angkatan] option:selected').val();
			var periode = $('select[name=f_periode] option:selected').val();
			var bulan = $('select[name=f_month] option:selected').val();
			var tahun = $('select[name=f_year] option:selected').val();

			// alert(uc_diklat+"-"+angkatan+"-"+periode+"-"+bulan+"-"+tahun);
			$('.load-data').load(base_url+'manage/jadwal_diklat/page',{
							js_page : page,
							js_uc_jenis_diklat : uc_jenis_diklat,
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
			var uc_jenis_diklat = $('select[name=f_jenis_diklat] option:selected').val();
			var uc_diklat = $('select[name=f_diklat] option:selected').val();
			var angkatan = $('select[name=f_angkatan] option:selected').val();
			var periode = $('select[name=f_periode] option:selected').val();
			var bulan = $('select[name=f_month] option:selected').val();
			var tahun = $('select[name=f_year] option:selected').val();

			$('.load-data').load(base_url+'schedule/page',{
							js_page : page,
							js_uc_jenis_diklat : uc_jenis_diklat,
							js_uc_diklat : uc_diklat,
							js_angkatan : angkatan,
							js_periode : periode,
							js_bulan : bulan,
							js_tahun : tahun
			});

			return false;
		});


		$('.btn-biaya').click(function(){
			var uc_diklat_jadwal = $(this).attr('uc');
			var uc_diklat_tahun = $(this).attr('uc-diklat-tahun');
			var uc_diklat = $(this).attr('uc-diklat');

			$('.load-form').load(base_url+'schedule/rincian_biaya', {js_uc_diklat_jadwal : uc_diklat_jadwal,js_uc_diklat_tahun : uc_diklat_tahun, js_uc_diklat : uc_diklat});

		});

	});
</script>

<div class="card-body">
							
	<div class="table-responsive border-0 ">
		<table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
			<thead>
				<tr class="text-center">
					<th scope="col" class="border-0 rounded-start">Diklat dan Periode</th>
					<th scope="col" class="border-0">Penutupan Pendaftaran</th>
					<th scope="col" class="border-0">Pelaksanaan</th>
					<th scope="col" class="border-0">Kuota</th>
					<th scope="col" class="border-0">Sisa Kursi</th>
					<th scope="col" class="border-0">Ket.</th>
					<th scope="col" class="border-0 rounded-end">&nbsp;</th>
				</tr>
			</thead>

			<tbody>

				<?php if(isset($result)):?>

					<?php $no = $numbering;?>
					<?php foreach($result as $row):?>

						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div class="mb-0 ms-2">
										<!-- Title -->
										<h5><?=$row->nama_diklat?></h5>
										<h6><?=$row->jenis_diklat?></h6>
										<!-- Info -->
										<div class="d-sm-flex">
											<p class="h6 fw-light mb-0 small me-3">
												<a href="#" data-bs-toggle="modal" data-bs-target="#modals" class="btn-biaya" uc="<?=$row->uc?>" uc-diklat="<?=$row->uc_diklat?>" uc-diklat-tahun="<?=$row->uc_diklat_tahun?>"><i class="fas fa-comment-dollar text-orange me-2"></i>Detail Biaya </a>
											</p>
											<p class="h6 fw-light mb-0 small me-4"><i class="fas fa-check-circle text-success me-2"></i>Lama Diklat : 9 Hari</p>
											<p class="h6 fw-light mb-0 small"><i class="far fa-calendar-check me-2"></i></i>Tahun/Periode : <?=$row->tahun?>/<?=$row->periode?></p>
										</div>
									</div>
								</div>
							</td>
							<td><?=time_format($row->pendaftaran_akhir,'d M Y')?></td>
							<td><?=time_format($row->pelaksanaan_mulai,'d M Y')?> s/d <?=time_format($row->pelaksanaan_akhir,'d M Y')?></td>
							<td><?=$row->kouta?></td>
							<td><?=$row->sisa_kursi?></td>
							<td>
								<?php if($row->pendaftaran_akhir == time_format(current_time(),'Y-m-d')):?>

									<span class="badge bg-danger bg-opacity-15 text-danger">DITUTUP</span>

								<?php else:?>

									<?php if($row->sisa_kursi == 0):?>
										<span class="badge bg-danger bg-opacity-15 text-danger">DITUTUP</span>
									<?php else:?>
										<span class="badge bg-success bg-opacity-15 text-success">DIBUKA</span>
									<?php endif;?>
									
								<?php endif;?>
							</td>
							<td>

								<?php if($row->pendaftaran_akhir == time_format(current_time(),'Y-m-d')):?>

									<a href="javascript:void(0)" class="btn btn-sm btn-primary">
										<i class="fas fa-pen-square"></i> Daftar
									</a>

								<?php else:?>

									<?php if($row->sisa_kursi == 0):?>
										
										<a href="javascript:void(0)" class="btn btn-sm btn-primary">
											<i class="fas fa-pen-square"></i> Daftar
										</a>

									<?php else:?>
										
										<a href="<?=base_url('register/step_1/'.$row->uc)?>" class="btn btn-sm btn-primary">
											<i class="fas fa-pen-square"></i> Daftar
										</a>

									<?php endif;?>
									
								<?php endif;?>


								
							</td>

						</tr>

						<?php $no++;?>
					<?php endforeach;?>

				<?php else:?>

					<tr>
						<td colspan="7">
							<div class="alert alert-danger text-center">Data Kosong</div>
						</td>
						
					</tr>

				<?php endif;?>

				
			</tbody>


		</table>
	</div>


</div>

<div class="card-footer bg-white">

	<div class="page-jadwal-diklat">
		<?php if (isset($pagination)) : ?>
            <?=$pagination?>
        <?php endif; ?>
	</div>
	
</div>

