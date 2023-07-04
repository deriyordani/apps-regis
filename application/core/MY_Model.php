<?php
class MY_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function insert_data($data){		
		$this->db->insert($this->table_name, $data);			
	}
	
	function insert_multi_value($field, $value){
		$sql  = "INSERT INTO ".$this->table_name." ".$field." VALUE ".$value."";
		
		$this->exec_query($sql);
	}
	
	function update_data($data=NULL, $filter=NULL){
		$this->db->update($this->table_name, $data, $filter);
	}
	
	function delete_data($filter){
		$this->db->delete($this->table_name, $filter);
	}
	
	function get_all($order_by = "id", $ordered = "DESC", $limit = NULL, $offset = NULL){
		if($limit == NULL){
			$this->db->order_by($order_by, $ordered);
			return $this->db->get($this->table_name);	
		}
		else{
			if($offset == NULL){
				$offset = 0;
			}
			$this->db->order_by($order_by, $ordered);
			return $this->db->get($this->table_name, $limit, $offset);
		}		
	}
	
	function get_filtered($filter, $order_by="id", $ordered="DESC", $limit=NULL, $offset=NULL){
		if($limit == NULL){
			$this->db->order_by($order_by, $ordered); 
			return $this->db->get_where($this->table_name, $filter);	
		}
		else{
			if($offset == NULL){
				$offset = 0;
			}
			$this->db->where($filter);
			$this->db->order_by($order_by, $ordered);
			return $this->db->get_where($this->table_name, $filter, $limit, $offset);
		}
	}
	
	function exec_query($query){
		return $this->db->query($query);
	}
	
	function get_last_record(){
		return $this->get_all("id", "DESC", 1, 0);
	}
	
	function get_last_id(){
		$query = $this->get_all("id", "DESC", 1, 0);
		
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->id;
		}
		else{
			return 0;
		}		
	}

	function get_my_last_id(){
		$sql  = " SELECT `id` FROM `".$this->table_name."` ";
		$sql .= " WHERE `creator` = '".$this->session->userdata('log_user_id')."' ";
		$sql .= " ORDER BY `id` DESC ";
		$sql .= " LIMIT 0 , 1 ";

		$query = $this->exec_query($sql);

		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->id;
		}
		else{
			return 0;
		}
	}

	function get_all_document($order_by = "id", $ordered = "DESC", $limit = NULL, $offset = NULL){
		$filter = array('is_exist' => 1);
		return $this->get_filtered($filter, $order_by, $ordered, $limit, $offset);
	}

	function delete_document($filter = NULL){
		$data = array('is_exist' => 0);
		$this->db->update($this->table_name, $data, $filter);	
	}

	function get_checked_is_exist($filter = NULL, $pick_field = NULL, $reference_table = NULL){
		$sql  = "SELECT r . * , p.`".$pick_field."` ";
		$sql .= " FROM `".$reference_table."` r ";
		$sql .= " LEFT JOIN `".$this->table_name."` p ";
		$sql .= " ON p.`".$pick_field."` = r.`id` ";
		
		if ($filter != NULL) {
			$i = 0;
			foreach ($filter as $key => $fil) {
				$sql .= " AND p.`".$key."` = '".$fil."' ";
				$sql .= " WHERE r.is_exist = '1' ";

				$i++;
			}	
		}
		
		
		return $this->exec_query($sql);	
	}

	function get_checked_list($filter = NULL, $pick_field = NULL, $reference_table = NULL){
		$sql  = "SELECT r . * , p.`".$pick_field."` ";
		$sql .= " FROM `".$reference_table."` r ";
		$sql .= " LEFT JOIN `".$this->table_name."` p ";
		$sql .= " ON p.`".$pick_field."` = r.`id` ";
		
		if ($filter != NULL) {
			$i = 0;
			foreach ($filter as $key => $fil) {
				$sql .= " AND p.`".$key."` = '".$fil."' ";

				$i++;
			}	
		}
		
		
		return $this->exec_query($sql);	
	}
}