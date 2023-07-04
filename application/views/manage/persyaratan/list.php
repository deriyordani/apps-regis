<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		$('.btn-add').click(function(){

			$('.load-form').load(base_url+'manage/persyaratan/add');
		});

		$('.btn-edit').click(function(){
			var uc = $(this).attr('uc');

			$('.load-form').load(base_url+'manage/persyaratan/edit', {js_uc : uc});

			//return false;
		});

		$('.page-jenis-tarif a.pagination-ajax').click(function(){

			var page 			= $(this).attr('title');

			$('.load-data').load(
									base_url+'manage/persyaratan/page',
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
		<h1 class="h3 mb-2 mb-sm-0">Template Persyaratan</h1>
		<a href="#" data-bs-toggle="modal" data-bs-target="#modals" class="btn btn-sm btn-primary mb-0 btn-add">Tambah Persyaratan</a>
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

        $this->load->view('manage/persyaratan/page', $data);
    ?>

</div>


<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="addQuestTitle" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered " role="document">
    	<div class="modal-content load-form">
			
    	</div>
    </div>
</div>