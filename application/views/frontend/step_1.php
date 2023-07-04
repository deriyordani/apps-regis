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
						
						<div class="step active">
							<div class="d-grid text-center align-items-center">
								<button type="button" class="btn btn-link step-trigger mb-0" role="tab" >
									<span class="bs-stepper-circle">1</span>
								</button>
								<h6 class="bs-stepper-label d-none d-md-block">Informasi Pribadi</h6>
							</div>
						</div>

						<div class="line"></div>

						<div class="step">
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

						<h4>Form Pendaftaran Diklat</h4>

						<hr class="mb-3">

						<?=form_open('register/insert_step_1')?>
						<input type="hidden" name="f_uc_jadwal_diklat" value="<?=$uc_jadwal_diklat?>">
						<div class="row g-4 d-flex justify-content-center">

							<div class="col-md-9">

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Status Pendaftaran</label>

									<div class="col-md-8">
										<?php $checked = (@$type_pendaftaran == NULL ? radio_set('0', 0) : radio_set('0', @$type_pendaftaran) )?>
					                    <input type="radio" name="f_status" value="0" <?=$checked?> > Belum Memiliki BST (Basic Safety Training)</input><br/>
					                    <input type="radio" name="f_status" value="1" <?=radio_set('1', @$type_pendaftaran)?>> Sudah Memiliki BST (Basic Safety Training)</input>
									</div>
								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Seafarers Code</label>

									<div class="col-md-8">
										<input type="text"  value="<?=@$seafarers_code?>" id="f_saeferers_code" maxlength="11" name="f_seafarers_code" disabled="disabled" size="11" class="form-control" />
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Nama Peserta</label>

									<div class="col-md-8">
										<input type="text"  id="f_name_peserta" value="<?=@$nama_lengkap?>" name="f_name_peserta" size="40" class="form-control" />
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Tempat Lahir</label>

									<div class="col-md-8">
										<input type="text" id="f_tempat_lahir" value="<?=@$tempat_lahir?>" name="f_tempat_lahir" size="40" class="form-control" />
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Tanggal Lahir</label>

									<div class="col-md-8">
										<input type="text" id="f_tgl_lahir" value="<?=@$tanggal_lahir?>" name="f_tgl_lahir" class="flatpickr form-control"  data-date-format="Y-m-d" size="40" />
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Alamat</label>

									<div class="col-md-8">
										 <textarea  id="f_alamat_rumah" name="f_alamat_rumah" rows="5" style="width: 400px; height: 87px;" class="form-control"><?=@$alamat_rumah?></textarea>
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">No. Handphone</label>

									<div class="col-md-8">
										<input value="<?=@$no_telepon?>" type="text" id="f_no_hp" name="f_no_hp" size="40" class="form-control" />
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Email</label>

									<div class="col-md-8">
										<input value="<?=@$email?>" id="f_email" type="text" name="f_email" size="40" class="form-control" />
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Nama Instansi/Perusahaan</label>

									<div class="col-md-8">
										<input value="<?=@$nama_instansi?>" id="f_instansi" type="text" name="f_instansi" size="40" class="form-control" />
									</div>

								</div>

								<div class="mt-4 mb-3 row">
									<label  class="col-md-3 col-form-label">Alamat Instansi/Perusahaan</label>

									<div class="col-md-8">
										<textarea class="form-control" name="f_alamat_instansi" rows="5" id="f_alamat_instansi" style="width: 400px; height: 87px;"><?=@$alamat_instansi?></textarea>
									</div>

								</div>


							</div>

							<div class="d-sm-flex justify-content-end">
								<input type="submit" class="btn btn-sm btn-primary" name="f_save" value="Lanjutkan">
							</div>
							

						</div>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</div>

		
	</div>
</section>