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


<!-- Title -->
<div class="row">
	<div class="col-12 d-sm-flex justify-content-between align-items-center">
		<h1 class="h3 mb-2 mb-sm-0">Jenis Diklat</h1>
		<a href="#" data-bs-toggle="modal" data-bs-target="#modals" class="btn btn-sm btn-primary mb-0 btn-add">Tambah Jenis Diklat</a>
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

        $this->load->view('manage/jenis_diklat/page', $data);
    ?>

</div>


<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="addQuestTitle" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered " role="document">
    	<div class="modal-content load-form">
			
    	</div>
    </div>
</div>