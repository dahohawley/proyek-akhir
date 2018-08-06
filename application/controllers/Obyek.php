<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obyek extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Obyek_model','obyek');
		$this->load->helper('url');
		$this->load->library('m_pdf');
		$this->my_page->set_page('Obyek Alokasi SHU');
		$check_session = $this->Account_model->check_session();
		if(!$check_session){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
			redirect('account');
		}
	}
	public function index(){
		$this->template->load('template','obyek/obyek_view');
	}
	public function LihatObyek(){
		$list = $this->obyek->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $obyek) {
			$no++;
			$row = array();
			$row[] = $obyek->id_obyek;
			$row[] = $obyek->nama_obyek;
			$row[] = $obyek->prosentase.'%';
		
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$obyek->id_obyek."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$obyek->id_obyek."'".')"><i class="fa fa-trash-o"></i></a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->obyek->count_all(),
						"recordsFiltered" => $this->obyek->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function GetObyekDetail($id){
		$data = $this->obyek->get_by_id($id);
		echo json_encode($data);
	}
	public function TambahObyek(){
		$data = array(
				'nama_obyek' => $this->input->post('nama_obyek'),
				'prosentase' => $this->input->post('prosentase')
			);
		$insert = $this->obyek->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function EditObyek(){
		$data = array(
				'nama_obyek' => $this->input->post('nama_obyek'),
				'prosentase' => $this->input->post('prosentase')
			);
		$this->obyek->update(array('id_obyek' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function HapusObyek($id){
		$this->obyek->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function cetak_pdf(){
		ini_set('max_execution_time', 300);
	        $data['obyek'] = $this->db->get('obyek')->result();
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
