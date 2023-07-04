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
							<td><a href="<?=base_url('manage/diklat/tambah_persyaratan/'.$uc_diklat.'/'.$per->uc)?>" class="btn btn-primary btn-sm">Tambahkan</a> </td>
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
		