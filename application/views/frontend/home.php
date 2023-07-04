<!-- =======================
	Counter START -->
	<section class="pt-3">
		<div class="container">
			<div class="row">
			<div class="col-lg-8 mb-4">
				<h2>Selamat Datang !</h2>
				<p class="mb-0">Application Integrated Registration System</p>
			</div>
		</div>

			<div class="row g-4">
				<!-- Counter item -->
				<div class="col-sm-6 col-xl-3">
					<div class="d-flex justify-content-center align-items-center p-4 bg-warning bg-opacity-15 rounded-3">
						<span class="display-6 lh-1 text-warning mb-0"><i class="fas fa-calendar"></i></span>
						<div class="ms-4 h6 fw-normal mb-0">
							<div class="d-flex">
								<h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?=$count_jadwal?>"	data-purecounter-delay="200">0</h5>
								<!-- <span class="mb-0 h5"> Periode</span> -->
							</div>
							<p class="mb-0">Jadwal Tersedia</p>
						</div>
					</div>
				</div>
				<!-- Counter item -->
				<div class="col-sm-6 col-xl-3">
					<div class="d-flex justify-content-center align-items-center p-4 bg-blue bg-opacity-10 rounded-3">
						<span class="display-6 lh-1 text-blue mb-0"><i class="fas fa-user-tie"></i></span>
						<div class="ms-4 h6 fw-normal mb-0">
							<div class="d-flex">
								<h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?=$count_pendaftar?>" data-purecounter-delay="200">0</h5>
								<!-- <span class="mb-0 h5">+</span> -->
							</div>
							<p class="mb-0">Pendaftar</p>
						</div>
					</div>
				</div>
				<!-- Counter item -->
				<div class="col-sm-6 col-xl-3">
					<div class="d-flex justify-content-center align-items-center p-4 bg-purple bg-opacity-10 rounded-3">
						<span class="display-6 lh-1 text-purple mb-0"><i class="fas fa-user-graduate"></i></span>
						<div class="ms-4 h6 fw-normal mb-0">
							<div class="d-flex">
								<h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?=$count_peserta?>"	data-purecounter-delay="200">0</h5>
								<!-- <span class="mb-0 h5">K+</span> -->
							</div>
							<p class="mb-0">Peserta Diklat</p>
						</div>
					</div>
				</div>
				<!-- Counter item -->
				<div class="col-sm-6 col-xl-3">
					<div class="d-flex justify-content-center align-items-center p-4 bg-info bg-opacity-10 rounded-3">
						<span class="display-6 lh-1 text-info mb-0"><i class="bi bi-patch-check-fill"></i></span>
						<div class="ms-4 h6 fw-normal mb-0">
							<div class="d-flex">
								<h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?=$count_diklat?>" data-purecounter-delay="200">0</h5>
								<!-- <span class="mb-0 h5">K+</span> -->
							</div>
							<p class="mb-0">Diklat Tersedia</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- =======================
	Counter END -->


	<section class="pt-2">
		<div class="container">
			<!-- Title -->
			<div class="row mb-4">
				<div class="col-lg-8 mx-auto text-center">
					<h2 class="fs-2">Kategori Diklat</h2>
					<p class="mb-0">Pilih diklat yang akan anda cari dan daftar</p>
				</div>
			</div>
			<!-- Tabs START -->
			<ul class="nav nav-pills nav-pills-bg-soft justify-content-lg-center mb-4 px-2" id="course-pills-tab" role="tablist">
				
				<?php $list_jenis_diklat = list_jenis_diklat();?>


				<?php if(isset($list_jenis_diklat)):?>

					<?php foreach($list_jenis_diklat as $jd):?>

						<!-- Tab item -->
						<li class="nav-item me-2 me-sm-3">
							<button class="nav-link mb-2 mb-md-0 <?=($jd->uc == '92-94216-73' ? 'active' : '')?>" id="course-pills-tab-<?=$jd->uc?>" data-bs-toggle="pill" data-bs-target="#course-pills-tabs-<?=$jd->uc?>" type="button" role="tab" aria-controls="course-pills-tabs-<?=$jd->uc?>" aria-selected="false"><?=$jd->jenis_diklat?></button>
						</li>


					<?php endforeach;?>

				<?php endif;?>
				
			</ul>
			<!-- Tabs END -->

			<div class="tab-content" id="course-pills-tabContent">
				<?php if(isset($list_jenis_diklat)):?>

						<?php foreach($list_jenis_diklat as $jd2):?>

							<div class="tab-pane fade <?=($jd2->uc == '92-94216-73' ? 'show active' : '')?>" id="course-pills-tabs-<?=$jd2->uc?>" role="tabpanel" aria-labelledby="course-pills-tab-<?=$jd2->uc?>">

								<div class="row g-4">
									
									<?php $list_diklat = list_diklat(array('uc_jenis_diklat' => $jd2->uc));?>

									<?php if(isset($list_diklat)):?>

										<?php foreach($list_diklat as $ld):?>

											<div class="col-sm-6 col-md-4 col-xl-3">
												<div class="bg-primary bg-opacity-10 rounded-3 text-center p-3 position-relative btn-transition">
													<!-- Image -->
													<div class="icon-xl bg-body mx-auto rounded-circle mb-3">
														<!-- <img src="<?=base_url()?>assets/images/element/online.svg" alt=""> -->
														<img src="<?=base_url()?>assets/images/logo-poltekpel-banten.png" alt="">
													</div>
													<!-- Title -->
													<h5 class="mb-1"><a href="<?=base_url('schedule/lists/'.$ld->uc)?>" class="stretched-link"><?=$ld->nama_diklat?></a></h5>
													
												</div>
											</div>

										<?php endforeach;?>

									<?php endif;?>
								</div>
							</div>


						<?php endforeach;?>

					

				<?php endif;?>
			</div>
		</div>
	</section>