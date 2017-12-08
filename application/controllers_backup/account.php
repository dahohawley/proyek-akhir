<?php
	class Account extends CI_CONTROLLER{
		public function __construct(){
			parent::__construct();
			$this->load->library('form_validation');
			$this->load->model('Account_model');
		}
		public function index(){
			$data['notification'] = '';
			$this->load->view('login_view',$data);
		}
		public function login(){
			$model = $this->Account_model;
			$username = $this->input->post('username',true);
			$password = $this->input->post('password',true);
			$check_account = $model->check_account($username,$password)->row();
			$num_account = count($check_account);

			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('password','Password','required');
			if ($this->form_validation->run() == FALSE){
				$data['notification'] = '';
				$this->load->view('login_view',$data);
			}else{
				if ($num_account > 0){
					$user_data = array(
						'logged_in' => TRUE,
						'username' => $check_account->username,
						'password' => $check_account->password);
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
	}