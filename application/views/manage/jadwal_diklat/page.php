<div class="card-body">

	
	<div class="table-responsive border-0 rounded-3">
		<table class="table table-dark-gray align-middle p-2 mb-0 table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Angkatan</th>
					<th>Periode</th>
					<th>Nama Diklat</th>
					<th>Tgl. Pelaksanaan</th>
					<th>Kouta</th>
					<th>Sisa Kouta</th>
					<th>Pendaftaran & Peserta</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>

				<?php if(isset($result)):?>

					<?php $no = $numbering;?>

					<?php foreach($result as $row):?>

						<tr>
							<td><?=$no?></td>
							<td><?=$row->tahun?></td>
							<td><?=$row->periode?></td>
							<td><?=$row->nama_diklat?></td>
							<td><?=time_format($row->pelaksanaan_mulai,'d/m/Y')?> s/d <?=time_format($row->pelaksanaan_akhir,'d/m/Y')?></td>
							<td><?=$row->kouta?></td>
							<td><?=$row->sisa_kursi?></td>
							<td>

								<a title="List Pendaftar" class="btn btn-primary btn-round btn-sm" href="<?=base_url('manage/jadwal_diklat/pendaftar/'.$row->uc)?>" ><i class="fas fa-tasks"></i></a>

								<a title="List Peserta" class="btn btn-primary btn-round btn-sm" href="<?=base_url('manage/jadwal_diklat/peserta/'.$row->uc)?>" ><i class="fas fa-tasks"></i></a>

							</td>

							<td>
								<a class="btn btn-info btn-round btn-sm btn-edit" href="#" data-bs-toggle="modal" data-bs-target="#modals" uc="<?=$row->uc?>"><i class="fas fa-pen-square"></i></a>

								<a class="btn btn-danger btn-round btn-sm" href="<?=base_url('manage/jadwal_diklat/delete/'.$row->uc)?>" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"></i></a>
							</td>

						</tr>

						<?php $no++;?>
					<?php endforeach;?>

				<?php else:?>
					<tr>
						<td colspan="9">
							<div class="alert alert-danger text-center">Data Kosong</div>
						</td>
						
					</tr>
				<?php endif;?>

			</tbody>
		</table>
	</div>


</div>
<div class="card-footer bg-white">

	<div class="page-jenis-diklat">
		<?php if (isset($pagination)) : ?>
            <?=$pagination?>
        <?php endif; ?>
	</div>
	
</div>