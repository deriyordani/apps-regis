<?php
class Pendaftaran_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_pendaftaran';
	}

	function get_info_daftar(){
		$sql = " SELECT pd.*, p.account_id, p.nama_lengkap, p.tempat_lahir,p.tanggal_lahir,p.no_telepon, p.email, p.seafarers_code, dj.periode, dj.pelaksanaan_mulai, dj.pelaksanaan_akhir, d.kode_diklat, d.nama_diklat, dth.tahun, jd.jenis_diklat, dj.uc_diklat, dj.uc_diklat_tahun
			FROM `dkp_pendaftaran` pd
			LEFT JOIN dkp_pendaftar p ON pd.uc_pendaftar = p.uc
			LEFT JOIN dkp_pendaftaran_diklat pdt ON pd.uc = pdt.uc_pendaftaran
			LEFT JOIN dkp_diklat_jadwal dj ON pdt.uc_jadwal_diklat = dj.uc
			LEFT JOIN dkp_diklat d ON dj.uc_diklat = d.uc 
			LEFT JOIN dkp_diklat_tahun dth ON  dj.uc_diklat_tahun = dth.uc
			LEFT JOIN dkp_jenis_diklat jd ON d.uc_jenis_diklat = jd.uc
			 ";

		if($this->session->userdata('uc_pendaftaran') != NULL){
			$sql .= "WHERE pd.uc = '".$this->session->userdata('uc_pendaftaran')."' ";
		}

		return $this->exec_query($sql);
	}

	function get_info_pendaftaran(){
		$sql = " SELECT pd.*,p.seafarers_code,p.nama_lengkap ";
		$sql .= " FROM `".$this->table_name."` pd ";
		$sql .= " LEFT JOIN  dkp_pendaftar p ON pd.uc_pendaftar = p.uc ";

		if($this->session->userdata('uc_pendaftaran') != NULL){
			$sql .= "WHERE pd.uc = '".$this->session->userdata('uc_pendaftaran')."' ";
		}

		return $this->exec_query($sql);
	}

	function get_list_pendaftar($data = NULL,$limit = NULL,$offset = 0){
		$sql = " SELECT dpn.*, dp.account_id, dp.nama_lengkap,dp.seafarers_code, dp.no_telepon, ";
		$sql .= " dp.nama_instansi,dj.uc_diklat, dp.tempat_lahir,dp.tanggal_lahir,dp.alamat_rumah, ";
		$sql .= " dp.email,dj.pelaksanaan_mulai,dj.pelaksanaan_akhir,dp.alamat_instansi,pdk.is_comfrim,";
		$sql .= " pdk.uc_jadwal_diklat,d.kode_diklat, d.nama_diklat,d.biaya,d.lama_diklat, dt.tahun,dj.periode ";
		$sql .= " FROM `dkp_pendaftaran` dpn ";
		$sql .= " LEFT JOIN dkp_pendaftar dp ON dpn.uc_pendaftar = dp.uc ";
		$sql .= " LEFT JOIN dkp_pendaftaran_diklat pdk ON pdk.uc_pendaftaran = dpn.uc "; 
		$sql .= " LEFT JOIN dkp_diklat_jadwal dj ON pdk.uc_jadwal_diklat = dj.uc ";
		$sql .= " LEFT JOIN dkp_diklat_tahun dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN dkp_diklat d ON dt.uc_diklat = d.uc   ";

		$sql .=" WHERE dp.is_exist = '1'  AND dpn.is_exist = '1' ";

		if (@$data['seafarers_code'] != NULL) {
			$sql .= " AND dp.seafarers_code = '".$data['seafarers_code']."' ";
		}

		if (@$data['uc_diklat'] != NULL) {
			$sql .= " AND dj.uc_diklat = '".$data['uc_diklat']."' ";
		}

		if (@$data['no_pendaftaran'] != NULL) {
			$sql .= " AND dpn.no_pendaftaran = '".$data['no_pendaftaran']."' ";
		}

		if (@$data['uc_pendaftar'] != NULL) {
			$sql .= " AND dpn.uc_pendaftar = '".$data['uc_pendaftar']."' ";
		}

		if (@$data['is_comfrim'] != NULL) {
			$sql .= " AND pdk.is_comfrim = '".$data['is_comfrim']."' ";
		}


		$sql .=" ORDER BY dp.nama_lengkap ASC,dpn.uc_pendaftar ASC ";
		
		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);
	}

	function get_pendaftaran_diklat($data = NULL,$limit = NULL,$offset = 0){
		$sql = " SELECT pd . * ,pn.uc AS uc_penda, pn.nama_lengkap, pn.seafarers_code, pn.tempat_lahir, pn.tanggal_lahir, pdn.is_comfrim, dpd.kelas ";
		$sql .= " FROM `dkp_pendaftaran` pd ";
		$sql .= " LEFT JOIN dkp_pendaftar pn ON pd.uc_pendaftar = pn.uc ";
		$sql .= " LEFT JOIN dkp_pendaftaran_diklat pdn ON pdn.uc_pendaftaran = pd.uc ";
		$sql .= " LEFT JOIN dkp_diklat_peserta dpd ON pdn.uc = dpd.uc_pendaftaran_diklat ";
		$sql .= " WHERE pd.is_exist  = '1' ";

		if (@$data['uc_jadwal_diklat'] != NULL) {
			$sql .= " AND pdn.uc_jadwal_diklat = '".$data['uc_jadwal_diklat']."' ";
		}

		if (@$data['kelas'] != NULL) {
			$sql .= " AND dpd.kelas = '".$data['kelas']."' ";
		}

		if (@$data['is_comfrim'] != NULL) {
			$sql .= " AND pdn.is_comfrim = '".$data['is_comfrim']."' ";
		}

		$sql .=" ORDER BY dpd.kelas ASC,pn.nama_lengkap ASC, pd.tanggal_daftar ASC";

		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}
		
		return $this->exec_query($sql);
	}

	function get_kartu_pendaftar($uc = NULL, $uc_diklat){
		$sql = " SELECT dpn.*, dp.account_id, dp.nama_lengkap,dp.seafarers_code, dp.no_telepon, dp.nama_instansi, ";
		$sql .= " dp.tempat_lahir,dp.tanggal_lahir,dp.alamat_rumah,dp.email, dj.pelaksanaan_mulai,dj.pelaksanaan_akhir, ";
		$sql .= " dp.alamat_instansi,pdk.is_comfrim,pdk.uc_jadwal_diklat,dt.tahun,d.kode_diklat, d.nama_diklat, ";
		$sql .= " d.biaya,d.lama_diklat, dj.uc_diklat,dj.periode ";
		$sql .= " FROM `dkp_pendaftaran` dpn ";
		$sql .= " LEFT JOIN dkp_pendaftar dp ON dpn.uc_pendaftar = dp.uc ";
		$sql .= " LEFT JOIN dkp_pendaftaran_diklat pdk ON pdk.uc_pendaftaran = dpn.uc "; 
		$sql .= " LEFT JOIN dkp_diklat_jadwal dj ON pdk.uc_jadwal_diklat = dj.uc ";
		$sql .= " LEFT JOIN dkp_diklat_tahun dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN dkp_diklat d ON dt.uc_diklat = d.uc   ";

		$sql .=" WHERE dp.is_exist = '1'  AND dpn.is_exist = '1' ";

		if ($uc != NULL) {
			$sql .= " AND dpn.uc = '".$uc."' " ;
		}

		if ($uc_diklat != NULL) {
			$sql .= " AND dj.uc_diklat = '".$uc_diklat."' " ;
		}


		return $this->exec_query($sql);
	}


}







 

