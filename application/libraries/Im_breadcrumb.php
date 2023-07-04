<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Im_breadcrumb {
	function __construct(){
		$this->CI =& get_instance();
		$this->separator = "|";
	}
	
	function generate($bc = NULL){
		$breadcrumb = "";
		
		if ($bc != NULL) {
			$i = 2;
			foreach ($bc as $label) {
				$url = base_url()."".$this->CI->uri->segment(1);
				
				if ($i > 2) {
					for ($j=2; $j<=$i; $j++) {
						$url .= "/".$this->CI->uri->segment($j);
					}					
					$breadcrumb .= "<span class=\"separator\">".$this->separator."</span>";
				}
				
				$breadcrumb .= "<a href=\"$url\">".$label."</a>";
				
				$i++;
			}
		}
		
		return $breadcrumb;		
	}
}