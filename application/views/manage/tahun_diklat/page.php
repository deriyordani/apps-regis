<div class="card-body">
				
	<div class="table-responsive ">
		<table class="table table-dark-gray align-middle p-2 mb-0 table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Tahun</th>
					<th >Kelola Jadwal</th>
					<th >Aksi</th>
				</tr>
			</thead>
			<tbody>
				
				<?php if(isset($result)):?>

					<?php $no = $numbering;?>
					<?php foreach($result as $row):?>

						<tr>
							<td><?=$no?></td>
							<td><?=$row->tahun?></td>
							<td>

								<a href="<?=base_url('manage/jadwal_diklat/atur_jadwal/'.$row->uc.'/'.$row->uc_diklat)?>" class="btn btn-sm btn-warning mb-0" ><i class="fas fa-calendar"></i> Atur Jadwal Diklat</a>

								<a href="<?=base_url('manage/jadwal_diklat/jadwal/'.$row->uc.'/'.$row->uc_diklat)?>" class="btn btn-sm btn-info mb-0" ><i class="fas fa-calendar"></i> Jadwal</a>

								<a href="<?=base_url('manage/biaya_diklat/daftar/'.$row->uc.'/'.$row->uc_diklat)?>" class="btn btn-sm btn-danger mb-0" ><i class="fas fa-calendar"></i> Biaya Diklat</a>

							</td>
							<td>
								<a class="btn btn-info btn-round btn-sm btn-edit" href="#" data-bs-toggle="modal" data-bs-target="#modals" uc="<?=$row->uc?>"><i class="fas fa-pen-square"></i></a>
								<a class="btn btn-danger btn-round btn-sm" href="<?=base_url('manage/tahun_diklat/delete/'.$row->uc.'/'.$row->uc_diklat)?>" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"></i></a>
							</td>
						</tr>
						<?php $no++;?>
					<?php endforeach;?>

				<?php else:?>

					<tr>
						<td colspan="4">
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