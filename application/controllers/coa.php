<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coa extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('coa_model','coa');
		$this->load->helper('url');
		$this->load->library('M_pdf');
		$this->my_page->set_page('COA');
	}
	public function index(){
		$this->template->load('template','coa/coa_view');
	}
	public function ajax_list(){
		$list = $this->coa->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $coa) {
			$no++;
			$row = array();
			$row[] = $coa->no_akun;
			$row[] = $coa->nama_akun;
			$row[] = format_rp($coa->saldo);
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_coa('."'".$coa->no_akun."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_coa('."'".$coa->no_akun."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->coa->count_all(),
						"recordsFiltered" => $this->coa->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id){
		$data = $this->coa->get_by_id($id);
		echo json_encode($data);
	}
	public function ajax_add(){
		$data = array(
				'no_akun' => $_POST['no_akun'],
				'nama_akun' => $_POST['nama_akun'],
				'saldo' => $_POST['saldo']
			);
		$insert = $this->coa->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_update(){
		$data = array(
				'nama_akun' => $_POST['nama_akun'],
				'saldo' => $_POST['saldo']
			);
		$this->coa->update(array('no_akun' => $this->input->post('no_akun')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_delete($id){
		$this->coa->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}
