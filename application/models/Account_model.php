<?php
	class Account_model extends CI_MODEL{
		public function check_account($username,$password){
			$this->db->where('username',$username);
			$this->db->where('password',$password);
			return $this->db->get('account');
		}
		public function check_session(){
		 	$logged_in = $this->session->userdata('logged_in');
		 	if($logged_in){
		 		return true;
		 	}else{
		 		return false;
		 	}
		 }
	}