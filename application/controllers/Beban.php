<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beban extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Beban_model','beban');
		$this->load->helper('url');
		$this->load->library('m_pdf');
		$this->my_page->set_page('Beban');
		$check_session = $this->Account_model->check_session();
		if(!$check_session){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
			redirect('account');
		}
	}
	public function index(){
		$this->template->load('template','beban/beban_view');
	}
	public function LihatBeban(){
		$list = $this->beban->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $beban) {
			$no++;
			$row = array();
			$row[] = $beban->id_beban;
			$row[] = $beban->nama_beban;
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$beban->id_beban."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$beban->id_beban."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->beban->count_all(),
						"recordsFiltered" => $this->beban->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function GetBebanDetail($id){
		$data = $this->beban->get_by_id($id);
		echo json_encode($data);
	}
	public function TambahBeban(){
		$data = array(
				'id_beban' => $this->input->post('id'),
				'nama_beban' => $this->input->post('nama_beban'),
			);
		$insert = $this->beban->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function EditBeban(){
		$data = array(
				'nama_beban' => $this->input->post('nama_beban'),
			);
		$this->beban->update(array('id_beban' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function HapusBeban($id){
		$this->beban->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function cetak_pdf(){
		ini_set('max_execution_time', 300);
	        $data['anggota'] = $this->db->get('anggota')->result();
	        $sumber = $this->load->view('data_barang_pdf', $data, TRUE);
	        $html = $sumber;
	        $pdfFilePath = "PersediaanBarang".date('Y-m-d H:i').".pdf";

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
