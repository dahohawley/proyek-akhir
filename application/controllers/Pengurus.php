<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Pengurus_model','pengurus');
		$this->load->helper('url');
		$this->load->library('m_pdf');
		$this->my_page->set_page('Pengurus');
		$check_session = $this->Account_model->check_session();
		if(!$check_session){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
			redirect('account');
		}
	}
	public function index(){
		$this->template->load('template','pengurus/pengurus_view');
	}
	public function ajax_list(){
		$list = $this->pengurus->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengurus) {
			$no++;
			$row = array();
			$row[] = $pengurus->id_pengurus;
			$row[] = $pengurus->nama;
			$row[] = $pengurus->alamat;
			if ($pengurus->hak_akses == '1'){
				$posisi = "Ketua";
			}elseif ($pengurus->hak_akses=='2'){
				$posisi="Bendahara";
			}else{
				$posisi = "Kasir";
			}
			$row[] = $posisi;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$pengurus->id_pengurus."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$pengurus->id_pengurus."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pengurus->count_all(),
						"recordsFiltered" => $this->pengurus->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id){
		$data = $this->pengurus->get_by_id($id);
		echo json_encode($data);
	}
	public function ajax_add(){
		$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'hak_akses' => $this->input->post('posisi'));
		$this->db->insert('account',$data);
		$data = array(
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'username' => $this->input->post('username'),
				'fp' => 'default.png'
			);
		$insert = $this->pengurus->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_update(){
		$data = array(
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'posisi' => $this->input->post('posisi'),
			);
		$this->pengurus->update(array('id_pengurus' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_delete($id){
		$this->pengurus->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function cetak_pdf(){
		ini_set('max_execution_time', 300);
	        $data['pengurus'] = $this->db->get('pengurus')->result();
	        $sumber = $this->load->view('data_pengurus_pdf', $data, TRUE);
	        $html = $sumber;
	        $pdfFilePath = "DataPengurus".date('Y-m-d H:i').".pdf";

	        //$css = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css";
	        //$stylesheet = file_get_contents($css);
	 
	        $pdf = $this->m_pdf->load();

	        $pdf->AddPage('P');
	        $pdf->useSubstitutions = false;
	        $pdf->simpleTables = true;
	        //$pdf->WriteHTML($stylesheet, 1);
	        $pdf->WriteHTML($html);
	        
	        $pdf->Output($pdfFilePath, "D");
	        exit();
	}
}
