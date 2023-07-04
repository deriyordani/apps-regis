<?php
class Diklat_peserta_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_diklat_peserta';
	}
}