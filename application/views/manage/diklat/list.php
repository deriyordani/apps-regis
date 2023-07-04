<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		$('.btn-add').click(function(){

			$('.load-form').load(base_url+'manage/diklat/add');
		});

		$('.btn-edit').click(function(){
			var uc = $(this).attr('uc');

			$('.load-form').load(base_url+'manage/diklat/edit', {js_uc : uc});

			//return false;
		});

		$('.page-diklat a.pagination-ajax').click(function(){

			var page = $(this).attr('title');

			var uc_jenis_diklat = $('select[name=f_jenis_diklat] option:selected').val();
			var search = $('input[name=f_search_master]').val();

			$('.load-data').load(
									base_url+'manage/diklat/page',
									{
										js_page : page,
										js_uc_jenis_diklat : uc_jenis_diklat,
										js_search : search
									}
								);
		});

		$('.btn-filter').click(function(){

			var uc_jenis_diklat = $('select[name=f_jenis_diklat] option:selected').val();
			var search = $('input[name=f_search_master]').val();

			$('.load-data').load(
									base_url+'manage/diklat/page',
									{
										js_page : 1,
										js_uc_jenis_diklat : uc_jenis_diklat,
										js_search : search
									}
								);

		});

	});
</script>


<!-- Title -->
<div class="row">
	<div class="col-12 d-sm-flex justify-content-between align-items-center">
		<h1 class="h3 mb-2 mb-sm-0">Daftar Diklat</h1>
		<a href="#" data-bs-toggle="modal" data-bs-target="#modals" class="btn btn-sm btn-primary mb-0 btn-add">Tambah Diklat</a>
	</div>
</div>

<div class="row mt-3">
		<div class="col-md-4">
			<div class="form-group mb-3">
				<label>Kategori Diklat</label>

				<?php $list_jenis_diklat = list_jenis_diklat();?>
				<select name="f_jenis_diklat" class="form-control">
					
					<option value="">---Pilih---</option>

					<?php if(isset($list_jenis_diklat)):?>

						<?php foreach($list_jenis_diklat as $lj):?>

							<option value="<?=$lj->uc?>"><?=$lj->jenis_diklat?></option>

						<?php endforeach;?>
					<?php endif;?>

				</select>
				
			</div>
			
		</div>

		<div class="col-md-5">
			<div class="form-group ">
				<label>Nama Diklat</label>
				<input class="form-control bg-transparent" type="text" placeholder="Search" aria-label="Search" name="f_search_master">
				
			</div>
		</div>

		<div class="col-md-1">
			<br/>
			<a href="#" class="btn btn-sm btn-success btn-filter">Filter</a>
		</div>
	
</div>


<div class="card bg-transparent border load-data">

	<?php 

        $data = NULL;
        if (isset($result)) {
            $data['result']         = $result;
            $data['total_record']   = $total_record;
            $data['pagination']     = $pagination;
            }

        $this->load->view('manage/diklat/page', $data);
    ?>

</div>


<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="addQuestTitle" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered " role="document">
    	<div class="modal-content load-form">
			
    	</div>
    </div>
</div>