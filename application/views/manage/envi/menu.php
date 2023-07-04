<ul class="navbar-nav flex-column" id="navbar-sidebar">
				
	<!-- Menu item 1 -->
	<li class="nav-item"><a href="<?=base_url('manage/dashboard')?>" class="nav-link active"><i class="bi bi-house fa-fw me-2"></i>Dashboard</a></li>

	<li class="nav-item ms-2 my-2">Referensi</li>

	<li class="nav-item">
		<a class="nav-link" data-bs-toggle="collapse" href="#collapsepage" role="button" aria-expanded="false" aria-controls="collapsepage">
			<i class="bi bi-basket fa-fw me-2"></i>Data Master
		</a>
		<!-- Submenu -->
		<ul class="nav collapse flex-column" id="collapsepage" data-bs-parent="#navbar-sidebar">
			<li class="nav-item"> <a class="nav-link" href="<?=base_url('manage/jenis_diklat')?>">Jenis Diklat</a></li>
			<li class="nav-item"> <a class="nav-link" href="<?=base_url('manage/jenis_tarif')?>">Jenis Tarif</a></li>
			<li class="nav-item"> <a class="nav-link" href="<?=base_url('manage/persyaratan')?>">Persyaratan</a></li>
			<!-- <li class="nav-item"> <a class="nav-link" href="<?=base_url('manage/pengumuman')?>">Pengumuman</a></li> -->
		</ul>
	</li>

	<li class="nav-item"> <a class="nav-link" href="<?=base_url('manage/diklat')?>"><i class="fas fa-calendar fa-fw me-2"></i>Diklat</a></li>

	<li class="nav-item"> <a class="nav-link" href="<?=base_url('manage/jadwal_diklat')?>"><i class="fas fa-calendar fa-fw me-2"></i>Jadwal Diklat</a></li>

	<li class="nav-item"> <a class="nav-link" href="<?=base_url('manage/pendaftar')?>"><i class="fas fa-users fa-fw me-2"></i>Pendaftar</a></li>

</ul>