<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('supplier_model','supplier');
		$this->load->helper('url');
		$this->load->library('M_pdf');
		$this->my_page->set_page('Supplier');
	}
	public function index(){
		$this->template->load('template','supplier/supplier_v');
	}
	public function ajax_list(){
		$list = $this->supplier->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $supplier) {
			$no++;
			$row = array();
			$row[] = $supplier->id_supplier;
			$row[] = $supplier->nama_supplier;
			$row[] = $supplier->alamat;
			$row[] = $supplier->telp;
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_supplier('."'".$supplier->id_supplier."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_supplier('."'".$supplier->id_supplier."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->supplier->count_all(),
						"recordsFiltered" => $this->supplier->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id){
		$data = $this->supplier->get_by_id($id);
		echo json_encode($data);
	}
	public function ajax_add(){
		$data = array(
				'nama_supplier' => $this->input->post('nama_supplier'),
				'alamat' => $this->input->post('alamat'),
				'telp' => $this->input->post('telp'),
			);
		$insert = $this->supplier->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_update(){
		$data = array(
				'nama_supplier' => $this->input->post('nama_supplier'),
				'alamat' => $this->input->post('alamat'),
				'telp' => $this->input->post('telp'),
			);
		$this->supplier->update(array('id_supplier' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_delete($id){
		$this->supplier->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function cetak_pdf(){
		ini_set('max_execution_time', 300);
		$data['supplier'] = $this->db->get('supplier');
		$sumber = $this->load->view('supplier/supplier_pdf', $data, true);
		$html = $sumber;
		$pdfFilePath = "DataPemasok".date('Y-m-d H:i').".pdf";
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
