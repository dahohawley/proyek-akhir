<?php
	class Laporan extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('model_laporan','model');
			$this->load->library('pagination');
		}
		public function jurnal(){
			if(isset($_POST['btnsubmit'])){
				$this->model->tanggal_awal = $this->input->post('tanggal_awal');
				$this->model->tanggal_akhir = $this->input->post('$tanggal_akhir');
			}else{
				$this->model->tanggal_awal = '0000-00-00';
				$this->model->tanggal_akhir = '9999-12-12';
			}
			$this->my_page->set_page('Jurnal Umum');
			$jumlah_data = $this->model->jumlah_data();
			$config['base_url'] = base_url().'index.php/laporan/jurnal/';
			$config['total_rows'] = $jumlah_data;
			$config['per_page'] = 2;
			//config bootstrap pagination
				$config['full_tag_open'] = '<ul class="pagination">';
		        $config['full_tag_close'] = '</ul>';
		        $config['first_link'] = false;
		        $config['last_link'] = false;
		        $config['first_tag_open'] = '<li>';
		        $config['first_tag_close'] = '</li>';
		        $config['prev_link'] = '&laquo';
		        $config['prev_tag_open'] = '<li class="prev">';
		        $config['prev_tag_close'] = '</li>';
		        $config['next_link'] = '&raquo';
		        $config['next_tag_open'] = '<li>';
		        $config['next_tag_close'] = '</li>';
		        $config['last_tag_open'] = '<li>';
		        $config['last_tag_close'] = '</li>';
		        $config['cur_tag_open'] = '<li class="active"><a href="#">';
		        $config['cur_tag_close'] = '</a></li>';
		        $config['num_tag_open'] = '<li>';
		        $config['num_tag_close'] = '</li>';
			$from = $this->uri->segment(3);
			$this->pagination->initialize($config);		
			$data['jurnal'] = $this->model->data($config['per_page'],$from);
			$this->template->load('template','laporan/jurnal',$data);
		}
	}