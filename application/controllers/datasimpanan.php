<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class datasimpanan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('datasimpanan_model','model');
		$this->load->helper('url');
		$this->load->library('M_pdf');
		$this->my_page->set_page('Data Simpanan Anggota');
		$check_session = $this->Account_model->check_session();
		if(!$check_session){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
			redirect('account');
		}
	}
	public function index(){
		$data['anggota'] = $this->model->get_anggota();
		$data['jenis'] = $this->model->get_jenis();
		$this->template->load('template','simpanan/simpanan_anggota',$data);
	}
	public function LihatData(){
		$list = $this->model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $simpanan) {
			$no++;
			$row = array();
			$row[] = $simpanan->no_anggota;
			$row[] = $simpanan->nama;
			$row[] = $simpanan->keterangan;
			$row[] = format_rp($simpanan->tarif);
			$row[] = format_rp($simpanan->jml_simpanan_dimiliki);
			if ($simpanan->tgl_ambil == 0000-00-0) {
				$tgl = '-';
				$row[] = $tgl;
			}else{
				$row[] = $simpanan->tgl_ambil;
			};
			//add html for action
			if (!$simpanan->id_jenis == '3' || $simpanan->id_jenis == '4' || $simpanan->id_jenis == '5' ) {
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" 			onclick="edit_simpanan('."'".$simpanan->no_anggota."',".''."'".$simpanan->id_jenis."'".')"><i 					class="glyphicon glyphicon-pencil"></i> Ubah</a>
				  	  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_simpanan('."'".$simpanan->no_anggota."',".''."'".$simpanan->id_jenis."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
				  	  ';
			}else{
				$row[] = '';
			}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->model->count_all(),
						"recordsFiltered" => $this->model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function EditData($no_anggota,$id_jenis){
		$data = $this->model->get_by_id($no_anggota,$id_jenis);
		echo json_encode($data);
	}
	public function TambahData(){
		$data = array(
				'no_anggota' => $this->input->post('no_anggota'),
				'id_jenis' => $this->input->post('id_jenis'),
				'tarif' => $this->input->post('tarif'),
				'tgl_ambil' => $this->input->post('tgl_ambil')
			);
		$insert = $this->model->save($data);
		echo json_encode(array("status" => TRUE));
		redirect('datasimpanan');
	}
	public function get_simpanan_angg($no_anggota){
		$data = $this->model->get_simpanan_angg($no_anggota);
			foreach($data as $data){
				echo "<option value='".$data->id_jenis."'>".$data->keterangan."</option>";					
			}
	}
	public function UpdateData(){
		$data = array(
				'tarif' => $this->input->post('tarif'),
			);
		$this->model->update(array('no_anggota' => $this->input->post('no_anggota')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function DeleteData($no_anggota,$id_jenis){
		$this->model->delete_by_id($no_anggota,$id_jenis);
		echo json_encode(array("status" => TRUE));
	}
}
