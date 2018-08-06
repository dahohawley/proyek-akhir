<?php
	class Account extends CI_CONTROLLER{
		public function __construct(){
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Account_model');

		}
		public function index(){
			if($this->session->logged_in == TRUE){
				redirect('home');
			}
			$data['notification'] = '';
			$this->load->view('login_view',$data);
		}
		public function login(){
			if($this->session->logged_in == TRUE){
				redirect('home');
			}
			$model = $this->Account_model;
			$username = $this->input->post('username',true);
			$password = $this->input->post('password',true);
			$check_account = $model->check_account($username,$password)->row();
			$num_account = count($check_account);
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
			if ($this->form_validation->run() == FALSE){
				$data['notification'] = '';
				$this->load->view('login_view',$data);
			}else{
				$this->db->where('username',$username);
				$personal_info = $this->db->get('pengurus')->row();
				if ($num_account > 0){
					$user_data = array(
						'logged_in' => TRUE,
						'username' => $check_account->username,
						'password' => $check_account->password,
						'hak_akses' => $check_account->hak_akses,
						'nama' => $personal_info->nama,
						'fp' => $personal_info->fp);
					$this->session->set_userdata($user_data);
					redirect('home');
				}else{
					$data['notification'] = '<div class="alert alert-danger">Username atau password salah.</div>';
					$this->load->view('login_view',$data);
				}
			}
		}
		public function logout(){
			$this->session->sess_destroy();
			redirect();
		}
		public function setting(){
			$this->my_page->set_page('Pengaturan Akun');
			$username = $this->session->userdata('username');
			$this->db->where('username',$username);
			$data['account'] = $this->db->Get('account')->row();
			$this->db->where('username',$username);
			$data['personal'] = $this->db->Get('pengurus')->row();
			$data['error'] = '';
			$this->template->load('template','account/edit_account',$data);
		}
		public function update_data(){
			$username = $this->session->userdata('username');
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$data = array(
				'nama' => $nama,
				'alamat' => $alamat);
			$this->db->where('username',$username);
			$this->db->update('pengurus',$data);
			echo 'true';
		}
		public function do_upload(){
			$username = $this->session->userdata('username');
		    $config['upload_path']="./assets/gambar/";
		    $config['allowed_types']='gif|jpg|png';
		    $config['file_name'] = $username."_".date('ymdhi');
		    $config['max_size'] = 0;
		    $this->load->library('upload',$config);
		    if($this->upload->do_upload("file")){
			    $data = array('upload_data' => $this->upload->data());
			    print_r($data);
			    $this->db->set('fp',$this->upload->data('file_name'));
			    $this->db->where('username',$username);
			    $this->db->update('pengurus');
		    }else{
		    	echo $this->upload->display_errors();
		    }
		 }
		 public function delete_all_trans(){
		 	$this->db->query("DELETE FROM transaksi");
		 	$this->db->query("DELETE FROM `simpanan_anggota`");
		 }
		 public function delete_penjualan_pembelian(){
		 	$this->db->query("DELETE FROM transaksi where id_trans like '%PNJ%'");
		 	$this->db->query("DELETE FROM transaksi where id_trans like '%APJ%'");
		 	$this->db->query("DELETE FROM transaksi where id_trans like '%PMB%'");
		 	$this->db->query("DELETE FROM transaksi where id_trans like '%ANG%'");
		 	redirect('home');
		 }
		 
	}