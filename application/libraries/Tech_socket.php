<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tech_socket extends CI_Controller{
	function __construct(){
		$this->host    		= "192.168.2.209";
		$this->port_write	= 4500;
		$this->port_read	= 4501;
	}

	function write($value = NULL){
		// create socket
		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		// connect to server
		$result = socket_connect($this->socket, $this->host, $this->port_write) or die("Could not connect to server\n"); 

		//send string to server
		socket_write($this->socket, $value, strlen($value)) or die("Could not send data to server\n");
		// close socket
		socket_close($this->socket);
	}

	function read(){
		// create socket
		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		// connect to server
		$result = socket_connect($this->socket, $this->host, $this->port_read ) or die("Could not connect to server\n"); 

		// get server response
		$result = socket_read ($this->socket, 1024) or die("Could not read server response\n");
		
		return $result;
		
		// close socket
		socket_close($this->socket);
	}
}