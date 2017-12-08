<?php
	/**
	* 
	*/
	class Home extends CI_CONTROLLER
	{
		function __construct(){
			parent::__construct();
			$this->my_page->set_page('Home');
		}
		public function index(){
			$query = $this->db->query('SELECT sum(jml_trans) as total_penjualan FROM `nota_penjualan` WHERE `tgl_trans` between "2017-1-1" and "2017-12-31"')->row();
			$data['total_penjualan'] = $query->total_penjualan;
			$this->template->load('template','home_view',$data);
		}
	}