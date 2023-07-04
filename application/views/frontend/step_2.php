<script type="text/javascript">
	$(document).ready(function(){

		var base_url = $('#base-url').text();


		$('input[name=f_seafarers_code]').blur(function(){
            var status = $('input[name=f_status]:checked').val();
            var seafarers = $(this).val();

            $.ajax({
                    type    : 'post',
                    dataType: 'json',
                    url     : base_url+'register/check_seafarers_code',
                    data    : {js_seafarers_code : seafarers},
                    success : function(output) {
                                                                    
                                $('input[name=f_name_peserta]').val(output['nama_lengkap']);
                                $('input[name=f_seafarers_code]').val(output['seafarers']);
                                $('input[name=f_tempat_lahir]').val(output['tmp_lahir']);
                                $('input[name=f_tgl_lahir]').val(output['tgl_lahir']);
                                $('textarea[name=f_alamat_rumah]').text(output['alamat_rumah']);
                                $('input[name=f_no_hp]').val(output['no_hp']);
                                $('input[name=f_email]').val(output['email']);
                                $('input[name=f_instansi]').val(output['instansi']);
                                $('textarea[name=f_alamat_instansi]').text(output['alamat_instansi']);                      
                            }
            });

        });

		 $('input[name=f_status]').click(function(){
            var status = $('input[name=f_status]:checked').val();

            if (status == 0) {
                $('input[name=f_seafarers_code]').attr('disabled','disabled');
                $('input[name=f_name_peserta]').val("");
                $('input[name=f_seafarers_code]').val("");
                $('input[name=f_tempat_lahir]').val("");
                $('input[name=f_tgl_lahir]').val("");
                $('textarea[name=f_alamat_rumah]').text("");
                $('input[name=f_no_hp]').val("");
                $('input[name=f_email]').val("");
                $('input[name=f_instansi]').val("");
                $('textarea[name=f_alamat_instansi]').text(""); 
            }else{
                $('input[name=f_seafarers_code]').removeAttr('disabled','disabled');
                
            };
        });

	});
</script>
<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-8 mb-4">
				<a href="javascript:history.back()" class="btn btn-primary mt-3 mb-3">
					<i class="fas fa-chevron-circle-left"></i> Kembali
				</a>

				<h2>Registrasi</h2>
				<p class="mb-0">Isikan data dengan benar</p>

			</div>
		</div>

		<div class="card bg-transparent border rounded-3 mb-5">
			<div id="stepper" class="bs-stepper stepper-outline">

				<div class="card-header bg-light border-bottom px-lg-5">

					<div class="bs-stepper-header" role="tablist">
						
						<div class="step ">
							<div class="d-grid text-center align-items-center">
								<button type="button" class="btn btn-link step-trigger mb-0" role="tab" >
									<span class="bs-stepper-circle">1</span>
								</button>
								<h6 class="bs-stepper-label d-none d-md-block">Informasi Pribadi</h6>
							</div>
						</div>

						<div class="line"></div>

						<div class="step active">
							<div class="d-grid text-center align-items-center">
								<button type="button" class="btn btn-link step-trigger mb-0" role="tab" >
									<span class="bs-stepper-circle">2</span>
								</button>
								<h6 class="bs-stepper-label d-none d-md-block">Preview Data & Biaya</h6>
							</div>
						</div>

						<div class="line"></div>

						<div class="step">
							<div class="d-grid text-center align-items-center">
								<button type="button" class="btn btn-link step-trigger mb-0" role="tab" >
									<span class="bs-stepper-circle">3</span>
								</button>
								<h6 class="bs-stepper-label d-none d-md-block">Selesai</h6>
							</div>
						</div>



					</div>


				</div>

				<div class="card-body">
					<!-- Step content START -->
					<div class="bs-stepper-content">

						<h4>Preview Data</h4>

						<hr class="mb-3">

						<div class="row g-4 d-flex justify-content-center">

							<div class="col-md-12 mb-3">

								<div class="card bg-primary bg-opacity-10 p-1 h-100">
									<div class="card-body">
										<table class="table" width="100%">
											<tr >
												<th>Jenis Diklat</th>
												<td>:</td>
												<td><?=$info->jenis_diklat?></td>


												<th>Kode/Nama Diklat</th>
												<td>:</td>
												<td><?=$info->kode_diklat?> / <?=$info->nama_diklat?></td>


											</tr>

											<tr >
												<th>Tahun/Periode</th>
												<td>:</td>
												<td><?=$info->tahun.'/'.$info->periode?></td>


												<th>Tgl Pelaksanaan</th>
												<td>:</td>
												<td><?=time_format($info->pelaksanaan_mulai,'d M Y')?> s/d <?=time_format($info->pelaksanaan_akhir,'d M Y')?></td>


											</tr>

											<tr >
												<th colspan="5">Informasi Pribadi</th>
												
											</tr>

											<tr >
												<th>Account ID</th>
												<td>:</td>
												<td colspan="4"><?=$info->account_id?></td>

											</tr>

											<tr >
												<th>Seafarer Code</th>
												<td>:</td>
												<td colspan="4"><?=$info->seafarers_code?>></td>

											</tr>

											<tr >
												<th>Nama Lengkap</th>
												<td>:</td>
												<td colspan="4"><?=$info->nama_lengkap?></td>

											</tr>

											<tr >
												<th>Tempat Tgl. Lahir</th>
												<td>:</td>
												<td colspan="4"><?=$info->tempat_lahir?>, <?=time_format($info->tanggal_lahir,'d M Y')?></td>

											</tr>
											
											
										</table>
									</div>
								</div>


								
							</div>

						</div>


						<h4>Rincian Biaya Diklat</h4>

						<hr class="mb-3">

						<div class="row g-4 d-flex justify-content-center">

							<div class="col-md-9">
								
								<div class="table-responsive">
									<table class="table table-dark-gray align-middle p-2 mb-0 table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>Jenis Tarif</th>
												<th>BIaya/Tarif Diklat (Rp.)</th>
											</tr>
										</thead>

										<tbody>

											<?php if(isset($result)):?>

												<?php $no = 1; $biaya =0;?>

												<?php foreach($result as $row):?>

													<tr>
														<td><?=$no?></td>
														<td><?=$row->jenis_tarif?></td>
														<td ><?=value_format($row->total_tarif)?></td>
													
													</tr>
													<?php $biaya = $biaya+$row->total_tarif?>
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

								<h6 class="mt-3">Total Yang Harus diBayar : Rp. <?=value_format($biaya)?></h6>

							</div>

						</div>

						<div class="d-sm-flex justify-content-end">
							<a href="<?=base_url('register/step_3')?>"  class="btn btn-sm btn-primary">Lanjut & Lakukan Pembayaran</a>
							
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</div>
</section>