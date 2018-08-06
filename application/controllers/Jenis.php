<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Jenis_model','jenis');
		$this->load->helper('url');
		$this->load->library('m_pdf');
		$this->my_page->set_page('Jenis Simpanan');
		$check_session = $this->Account_model->check_session();
		if(!$check_session){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
			redirect('account');
		}
	}
	public function index(){
		$this->template->load('template','jenis/jenis_view');
	}
	public function LihatJenis(){
		$list = $this->jenis->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jenis) {
			$no++;
			$row = array();
			$row[] = $jenis->id_jenis;
			$row[] = $jenis->keterangan;
			if ($jenis->kategori == '1') {
				$kategori='Terikat';
			}else{
				$kategori='Tidak Terikat';
			}
			$row[] = $kategori;
			if ($jenis->kategori == '1') {
				$tarif = format_rp($jenis->tarif);
			}else{
				$tarif = '-';
			}
			$row[] = $tarif;
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$jenis->id_jenis."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$jenis->id_jenis."'".')"><i class="fa fa-trash-o"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->jenis->count_all(),
						"recordsFiltered" => $this->jenis->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function GetJenisDetail($id){
		$data = $this->jenis->get_by_id($id);
		echo json_encode($data);
	}
	public function TambahJenis(){
		$data = array(
				'keterangan' => $this->input->post('keterangan'),
				'kategori' => $this->input->post('kategori'),
			);
		$insert = $this->jenis->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function EditJenis(){
		$data = array(
				'keterangan' => $this->input->post('keterangan'),
				'kategori' => $this->input->post('kategori'),
			);
		$this->jenis->update(array('id_jenis' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function HapusJenis($id){
		$this->jenis->delete_by_id($id);
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
