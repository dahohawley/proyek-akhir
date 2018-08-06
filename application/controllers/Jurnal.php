<?php
	class Jurnal extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			//$this->load->model('Produksi_model','model');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		// laporan pemesanan
			public function index(){
			if(isset($_POST['tgl_awal']) && $_POST['tgl_awal'] != null && $_POST['tgl_akhir'] != null){
				$tanggal_awal = $_POST['tgl_awal'];
				$tanggal_akhir = $_POST['tgl_akhir'];
				$data['jurnal'] = $this->db->query("SELECT tgl_jurnal,jurnal.no_akun,coa.nama_akun,posisi_dr_cr,nominal from jurnal
				join coa on jurnal.no_akun = coa.no_akun where tgl_jurnal between '$tanggal_awal' and '$tanggal_akhir' order by id_trans,tgl_jurnal,posisi_dr_cr asc")->result();
				$this->template->load('template','laporan/jurnal_view',$data);
			}else{
				$data['jurnal'] = $this->db->query("SELECT tgl_jurnal,jurnal.no_akun,coa.nama_akun,posisi_dr_cr,nominal from jurnal
				join coa on jurnal.no_akun = coa.no_akun order by id_trans,tgl_jurnal,posisi_dr_cr asc")->result();
				$this->template->load('template','laporan/jurnal_view',$data);
			}
		}
	}