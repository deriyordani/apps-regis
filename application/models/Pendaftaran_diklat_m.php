<?php
class Pendaftaran_diklat_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_pendaftaran_diklat';
	}

	function get_diklat_daftar($uc_pendaftaran = 0,$limit = NULL,$offset = 0){
		$sql = " SELECT pd.*, dj.pelaksanaan_mulai,dj.pelaksanaan_akhir,dj.jumlah_kelas, ";
		$sql .= " dj.pendaftaran_mulai, dj.pendaftaran_akhir,dj.uc_diklat,  dj.kouta, ";
		$sql .= " dj.sisa_kursi,dt.tahun,d.kode_diklat,d.nama_diklat,d.biaya,dj.periode ";
		$sql .= " FROM `".$this->table_name."` pd ";
		$sql .= " LEFT JOIN `dkp_diklat_jadwal` dj ON pd.`uc_jadwal_diklat` = dj.uc ";
		$sql .= " LEFT JOIN dkp_diklat_tahun dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN `dkp_diklat` d ON dt.uc_diklat = d.uc ";

		if ($uc_pendaftaran != 0) {
			$sql .= " WHERE pd.`uc_pendaftaran` = '".$uc_pendaftaran."' ";
		}

		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}


		return $this->exec_query($sql);
	}

	function get_filter_pendaftaran($data = NULL){
		$sql = " SELECT pd.*, dj.pelaksanaan_mulai,dj.pelaksanaan_akhir,dj.jumlah_kelas, ";
		$sql .= " dj.pendaftaran_mulai, dj.pendaftaran_akhir,dj.uc_diklat,dj.kuota_per_kelas, ";
		$sql .= " dj.kouta,dj.sisa_kursi,dt.tahun,d.kode_diklat,d.nama_diklat,d.biaya,dj.periode ";
		$sql .= " FROM `".$this->table_name."` pd ";
		$sql .= " LEFT JOIN `dkp_diklat_jadwal` dj ON pd.`uc_jadwal_diklat` = dj.uc ";
		$sql .= " LEFT JOIN dkp_diklat_tahun dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN `dkp_diklat` d ON dt.uc_diklat = d.uc ";

		if (@$data['uc_pendaftaran'] != 0) {
			$sql .= " WHERE pd.`uc_pendaftaran` = '".@$data['uc_pendaftaran']."' ";
		}

		if (@$data['uc_jadwal_diklat'] != 0) {
			$sql .= " AND pd.`uc_jadwal_diklat` = '".$data['uc_jadwal_diklat']."' ";
		}

		return $this->exec_query($sql);
	}

	function get_diklat($uc_pendaftaran = NULL){

		$sql  = " SELECT dpr.*,dp.uc_pendaftar ,dp.tanggal_daftar ,dj.pelaksanaan_mulai, ";
		$sql .= " dj.pelaksanaan_akhir, dd.nama_diklat , dd.biaya , dd.lama_diklat,dt.tahun,dj.periode " ;
		$sql .= " FROM `dkp_pendaftar` dpr  " ;
		$sql .= " LEFT JOIN `dkp_pendaftaran` dp ON dpr.uc = dp.uc_pendaftar " ;
		$sql .= " LEFT JOIN `dkp_pendaftaran_diklat` dpd ON dp.uc = dpd.uc_pendaftaran " ;
		$sql .= " LEFT JOIN `dkp_diklat_jadwal` dj ON dpd.uc_jadwal_diklat = dj.uc " ;
		$sql .= " LEFT JOIN dkp_diklat_tahun dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN `dkp_diklat` dd ON dt.uc_diklat = dd.uc " ;

		if ($uc_pendaftaran != NULL) {
			$sql .= " WHERE dp.uc = '".$uc_pendaftaran."' " ;
		}

		return $this->exec_query($sql);

	}
	
}