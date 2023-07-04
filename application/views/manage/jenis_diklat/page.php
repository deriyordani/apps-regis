<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		$('.btn-add').click(function(){

			$('.load-form').load(base_url+'manage/jenis_diklat/add');
		});

		$('.btn-edit').click(function(){
			var uc = $(this).attr('uc');

			$('.load-form').load(base_url+'manage/jenis_diklat/edit', {js_uc : uc});

			//return false;
		});

		$('.page-jenis-diklat a.pagination-ajax').click(function(){

			var page 			= $(this).attr('title');

			$('.load-data').load(
									base_url+'manage/jenis_diklat/page',
									{
										js_page 			: page
									}
								);
		});

	});
</script>

<div class="card-body">

	
	<div class="table-responsive border-0 rounded-3">
		<table class="table table-dark-gray align-middle p-2 mb-0 table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Jenis Diklat</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>

				<?php if(isset($result)):?>

					<?php $no = $numbering;?>

					<?php foreach($result as $row):?>

						<tr>
							<td><?=$no?></td>
							<td><?=$row->jenis_diklat?></td>
							<td>
								<a class="btn btn-info btn-round btn-sm btn-edit" href="#" data-bs-toggle="modal" data-bs-target="#modals" uc="<?=$row->uc?>"><i class="fas fa-pen-square"></i></a>
								<a class="btn btn-danger btn-round btn-sm" href="<?=base_url('manage/jenis_diklat/delete/'.$row->uc)?>" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"></i></a>
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
	</div>


</div>
<div class="card-footer bg-white">

	<div class="page-jenis-diklat">
		<?php if (isset($pagination)) : ?>
            <?=$pagination?>
        <?php endif; ?>
	</div>
	
</div>