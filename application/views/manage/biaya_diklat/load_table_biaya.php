<table class="table table-dark-gray align-middle p-2 mb-0 table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>Jenis Tarif</th>
			<th>BIaya/Tarif Diklat (Rp.)</th>
			<th>Aksi</th>
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
					<td>
						
						<a class="btn btn-danger btn-round btn-sm" href="<?=base_url('manage/biaya_diklat/delete/'.$row->uc.'/'.$row->uc_diklat_tahun.'/'.$row->uc_diklat)?>" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"></i></a>
					</td>
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