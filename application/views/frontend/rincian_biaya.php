<div class="modal-header">
	<h5 class="modal-title" id="">Informasi Rincian Biaya Diklat</h5>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

	
	<div class="row g-4 mb-4">
		<div class="col-md-12">
			<div class="card bg-primary bg-opacity-10 p-1 h-100">
				<div class="card-body">
					<table width="100%">
						<tr>
							<th>Jenis Diklat</th>
							<td>:</td>
							<td><?=$info->jenis_diklat?></td>
						</tr>
						<tr>
							<th>Kode/Nama Diklat</th>
							<td>:</td>
							<td><?=$info->kode_diklat?> / <?=$info->nama_diklat?></td>
						</tr>
						<tr>
							<th>Tahun/Periode</th>
							<td>:</td>
							<td><?=$info->tahun?>/<?=$info->periode?></td>
						</tr>

						<tr>
							<th>Tanggal Penutupan</th>
							<td>:</td>
							<td><?=time_format($info->pendaftaran_akhir,'d M Y')?></td>
						</tr>

						<tr>
							<th>Tanggal Pelaksanaan</th>
							<td>:</td>
							<td><?=time_format($info->pelaksanaan_mulai,'d M Y')?> s/d <?=time_format($info->pelaksanaan_akhir,'d M Y')?></td>
						</tr>

						<tr>
							<th>Kuota/Sisa Kuota</th>
							<td>:</td>
							<td><?=$info->kouta?>/<?=$info->sisa_kursi?></td>
						</tr>


					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h5>Daftar Biaya</h5>
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

							<?php $no = 1;?>

							<?php foreach($result as $row):?>

								<tr>
									<td><?=$no?></td>
									<td><?=$row->jenis_tarif?></td>
									<td ><?=value_format($row->total_tarif)?></td>
								
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

<div class="modal-footer">

	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

</div>