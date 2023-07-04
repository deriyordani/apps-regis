<script type="text/javascript">
	$(document).ready(function(){

		var base_url = $('#base-url').text();
		var uc_diklat = $('input[name=f_uc_diklat]').val();

		$('input[name=f_search_master]').keypress(function (e) {
			var key = e.which;

			if(key == 13)  // the enter key code
			{

				var text = $(this).val();

				$('.load-data').load(
									base_url+'manage/diklat/search_persyaratan',
									{
										js_text : text,
										js_uc_diklat : uc_diklat
									}
								);
				// $('input[name = butAssignProd]').click();
				// return false;  
			}
		});


		$('.page-persyaratan-master a.pagination-ajax').click(function(){

			var page = $(this).attr('title');
			var text = $('input[name=f_search_master]').val();

			$('.load-data').load(
									base_url+'manage/diklat/persyaratan_page',
									{
										js_page : page,
										js_text : text,
										js_uc_diklat : uc_diklat
									}
								);


			return false;
		});


	});
</script>

<!-- Title -->
<div class="row mb-3 ">
	<div class="col-12 mb-4 d-sm-flex justify-content-between align-items-center">
		<h1 class="h3 mb-2 mb-sm-0">Sertakan Persyaratan</h1>
	</div>
</div>

<div class="row g-4 mb-4">
	<div class="col-md-12">
		<div class="card bg-primary bg-opacity-10 p-1 h-100">
			<div class="card-body">
				<table width="100%">
					<tr>
						<th>Jenis Diklat</th>
						<td>:</td>
						<td><?=$row->jenis_diklat?></td>
					</tr>
					<tr>
						<th>Kode/Nama Diklat</th>
						<td>:</td>
						<td><?=$row->kode_diklat?> / <?=$row->nama_diklat?></td>
					</tr>
					<tr>
						<th>Lama Diklat )*Hari</th>
						<td>:</td>
						<td><?=$row->lama_diklat?> </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="f_uc_diklat" value="<?=$row->uc?>">

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="load-data">
				<div class="card-header bg-warning text-white">
					Template Persyaratan
				</div>
				<div class="card-body ">
					<div class="col-md-12">
						<!-- <form class="rounded position-relative">
							
						</form> -->
						<div class="rounded position-relative">
							<input class="form-control bg-transparent" type="text" placeholder="Search" aria-label="Search" name="f_search_master">
							<button class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset " type="submit">
								<i class="fas fa-search fs-6 "></i>
							</button>
						</div>
					</div>
					<div class="table-responsive ">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Persyaratan</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php if(isset($persyaratan)):?>

									<?php foreach($persyaratan as $per):?>

										<tr>
											
											<td><?=$per->persyaratan?></td>
											<td><a href="<?=base_url('manage/diklat/tambah_persyaratan/'.$row->uc.'/'.$per->uc)?>" class="btn btn-primary btn-sm">Tambahkan</a> </td>
										</tr>
									<?php endforeach;?>

								<?php else:?>

									<tr>
										<td colspan="2">
											<div class="alert alert-danger text-center">Data Kosong</div>
										</td>
										
									</tr>


								<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					<div class="page-persyaratan-master">
						<?php if (isset($pagination)) : ?>
				            <?=$pagination?>
				        <?php endif; ?>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="load-data-syarat">
				<div class="card-header bg-info text-white">
					Persyaratan Yang Di Pilih
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Persyaratan</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php if(isset($syarat)):?>

									<?php foreach($syarat as $per):?>

										<tr>
											
											<td><?=$per->persyaratan?></td>
											<td><a href="<?=base_url('manage/diklat/hapus_persyaratan/'.$row->uc.'/'.$per->uc)?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete?')">Hapus</a> </td>
										</tr>
									<?php endforeach;?>

								<?php else:?>

									<tr>
										<td colspan="2">
											<div class="alert alert-danger text-center">Data Kosong</div>
										</td>
										
									</tr>

								<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					<div class="page-persyaratan">
						<?php if (isset($pagination_syarat)) : ?>
				            <?=$pagination_syarat?>
				        <?php endif; ?>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
