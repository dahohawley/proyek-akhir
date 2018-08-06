<?php
	/**
	* 
	*/
	class Home extends CI_CONTROLLER
	{
		function __construct(){
			parent::__construct();
			$this->my_page->set_page('Home');
			$this->load->model('model_home','model');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		public function index(){
			$query = $this->db->query('SELECT sum(jml_trans) as total_penjualan FROM `nota_penjualan` WHERE `tgl_trans` between "'.date('Y').'-1-1" and "'.date('Y').'-12-31"')->row();
			$data['total_penjualan'] = $query->total_penjualan;
			$query = $this->db->query('SELECT sum(jml_trans) as total_pembelian FROM `pembelian` WHERE `tgl_trans` between "'.date('Y').'-1-1" and "'.date('Y').'-12-31"')->row();
			$data['total_pembelian'] = $query->total_pembelian;
			$query = $this->db->query("SELECT * from barang")->result();
			$data['jumlah_barang'] = count($query);

			$query = $this->db->query("SELECT * from anggota where no_anggota != '0'")->result();
			$data['jumlah_anggota'] = count($query);
			$data['chart_penjualan'] = $this->model->get_chart_penjualan();
			$data['chart_pembelian'] = $this->model->get_chart_pembelian();
			$data['barang_habis'] = $this->model->barang_habis();
			$this->template->load('template','home_view',$data);
		}
	}