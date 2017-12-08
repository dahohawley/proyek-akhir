<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('gudang_model','gudang');
		$this->load->helper('url');
		$this->load->library('M_pdf');
		$this->my_page->set_page('Gudang');
	}
	public function index(){
		$this->template->load('template','gudang/barang_view');
	}
	public function ajax_list(){
		$list = $this->gudang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $barang) {
			$no++;
			$row = array();
			$row[] = $barang->id_barang;
			$row[] = $barang->nama_barang;
			$row[] = format_rp($barang->harga_beli);
			$row[] = format_rp($barang->harga_jual);
			if ($barang->kategori == 'KSM'){
				$kategori = "Konsumsi";
			}else{
				$kategori = "Kelontong";
			}
			$row[] = $kategori;
			$row[] = $barang->stok;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_barang('."'".$barang->id_barang."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_barang('."'".$barang->id_barang."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->gudang->count_all(),
						"recordsFiltered" => $this->gudang->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id){
		$data = $this->gudang->get_by_id($id);
		echo json_encode($data);
	}
	public function ajax_add(){
		$data = array(
				'nama_barang' => $this->input->post('nama_barang'),
				'harga_beli' => $this->input->post('harga_beli'),
				'harga_jual' => $this->input->post('harga_jual'),
				'kategori' => $this->input->post('jenis_barang'),
				'stok' => $this->input->post('stok'),
			);
		$insert = $this->gudang->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_update(){
		$data = array(
				'nama_barang' => $this->input->post('nama_barang'),
				'harga_beli' => $this->input->post('harga_beli'),
				'harga_jual' => $this->input->post('harga_jual'),
				'kategori' => $this->input->post('jenis_barang'),
				'stok' => $this->input->post('stok'),
			);
		$this->gudang->update(array('id_barang' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_delete($id){
		$this->gudang->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function cetak_pdf(){
		ini_set('max_execution_time', 300);
	        $data['barang'] = $this->db->get('barang')->result();
	        $sumber = $this->load->view('gudang/data_barang_pdf', $data, TRUE);
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
