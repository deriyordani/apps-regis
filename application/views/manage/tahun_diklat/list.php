<script type="text/javascript">
	$(document).ready(function(){
		var base_url = $('#base-url').text();

		$('.btn-add').click(function(){

			var uc = $('input[name=f_uc_diklat]').val();

			$('.load-form').load(base_url+'manage/tahun_diklat/add', {js_uc_diklat : uc});
		});

		$('.btn-edit').click(function(){
			var uc = $(this).attr('uc');

			$('.load-form').load(base_url+'manage/tahun_diklat/edit', {js_uc_tahun_diklat : uc});

			//return false;
		});

		$('.page-tahun-diklat a.pagination-ajax').click(function(){

			var page 			= $(this).attr('title');

			$('.load-data').load(
									base_url+'manage/tahun_diklat/page',
									{
										js_page 			: page
									}
								);
		});

	});
</script>

<div class="row mb-3">
	<div class="col-12 d-sm-flex justify-content-between align-items-center">
		<h1 class="h3 mb-2 mb-sm-0">Tahun Diklat</h1>
		<a href="#" data-bs-toggle="modal" data-bs-target="#modals" class="btn btn-sm btn-primary mb-0 btn-add">Tambah Tahun Diklat</a>
	</div>
</div>

<input type="hidden" value="<?=$dk->uc?>" type="text" name=f_uc_diklat />
<div class="row g-4 mb-3">
	<div class="col-md-12">
		<div class="card bg-primary bg-opacity-10 p-1 h-100">
			<div class="card-body">
				<table width="100%">
					<tr>
						<th>Jenis Diklat</th>
						<td>:</td>
						<td><?=$dk->jenis_diklat?></td>
					</tr>
					<tr>
						<th>Kode/Nama Diklat</th>
						<td>:</td>
						<td><?=$dk->kode_diklat?> / <?=$dk->nama_diklat?></td>
					</tr>
					<tr>
						<th>Lama Diklat )*Hari</th>
						<td>:</td>
						<td><?=$dk->lama_diklat?> </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>


<div class="row g-4 mb-3">
	<div class="col-md-12">
		<div class="card">

			<?php 

		        $data = NULL;
		        if (isset($result)) {
		            $data['result']         = $result;
		            $data['total_record']   = $total_record;
		            $data['pagination']     = $pagination;
		            }

		        $this->load->view('manage/tahun_diklat/page', $data);
		    ?>


			
		</div>
	</div>
</div>

<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="addQuestTitle" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered " role="document">
    	<div class="modal-content load-form">
			
    	</div>
    </div>
</div>