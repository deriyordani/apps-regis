<?php

include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf {
	public $param;
	public $pdf;

	public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3'){
		$this->param = $param;
		$this->pdf = new mPDF($this->param);

		//landscape mode
		$this->landscape = new mPDF('utf-8','A4-L');
		$this->pdf_ls = $this->landscape;
	}
}