<?php
Class Api extends CI_controller{
	function __construct(){
		parent::__construct();

		$this->load->library('BniEnc');

		$this->client_id = '77661';
		$this->secret_key = '9b5237d7fa3df84e0dd6e7fea052a613';
		$this->url = 'https://apibeta.bni-ecollection.com/';

	}

	function create_va(){
	    
	    date_default_timezone_set('Asia/Jakarta');
        $trx_id = mt_rand();
        
		$data_asli = array(
		    'type' => "createBilling",
			'client_id' => $this->client_id,
			'trx_id' => $trx_id, // fill with Billing ID
			//'trx_id' => 22122013,
			'trx_amount' => 1000,
			'billing_type' => 'c',
			'datetime_expired' => date('c', time() + 2 * 3600), // billing will be expired in 2 hours
			'virtual_account' => '988'.$this->client_id.'20000005',
			'customer_name' => 'Mr. X',
			'customer_email' => '',
			'customer_phone' => '',
		);

		$hashed_string = BniEnc::encrypt(
			$data_asli,
			$this->client_id,
			$this->secret_key
		);

		$data = array(
			'client_id' => $this->client_id,
			'data' => $hashed_string
		);

		$response = $this->get_content($this->url, json_encode($data));
		$response_json = json_decode($response, true);

		if ($response_json['status'] !== '000') {
			// handling jika gagal
			var_dump($response_json);
		}
		else {
			$data_response = BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);
			// $data_response will contains something like this: 
			// array(
			// 	'virtual_account' => 'xxxxx',
			// 	'trx_id' => 'xxx',
			// );
			var_dump($data_response);
		}

	}
	
	function call_back(){
	    
	    date_default_timezone_set('Asia/Jakarta');
	    
	   	$data_asli = array(
		    'type' => "inquirybilling",
			'client_id' => $this->client_id,
			'trx_id' => 139043906, // fill with Billing ID
			//'trx_id' => 22122013,
			'trx_amount' => 1000
			
		);

		$hashed_string = BniEnc::encrypt(
			$data_asli,
			$this->client_id,
			$this->secret_key
		);

		$data = array(
			'client_id' => $this->client_id,
			'data' => $hashed_string
		);

		$response = $this->get_content($this->url, json_encode($data));
		$response_json = json_decode($response, true);

		if ($response_json['status'] !== '000') {
			// handling jika gagal
			var_dump($response_json);
		}
		else {
			$data_response = BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);
			// $data_response will contains something like this: 
			// array(
			// 	'virtual_account' => 'xxxxx',
			// 	'trx_id' => 'xxx',
			// );
			
			echo "<pre>";
			var_dump($data_response);
				echo "</pre>";
		}

	}

	function get_content($url, $post = '') {
		$usecookie = __DIR__ . "/cookie.txt";
		$header[] = 'Content-Type: application/json';
		$header[] = "Accept-Encoding: gzip, deflate";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		// curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

		if ($post)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$rs = curl_exec($ch);

		if(empty($rs)){
			var_dump($rs, curl_error($ch));
			curl_close($ch);
			return false;
		}
		curl_close($ch);
		return $rs;
	}


}