<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Anggota_model','anggota');
		$this->load->helper('url');
		$this->load->library('m_pdf');
		$this->my_page->set_page('Anggota');
		$check_session = $this->Account_model->check_session();
		if(!$check_session){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
			redirect('account');
		}
	}
	public function index(){
		$data['simpanan_pokok'] = $this->anggota->get_jumlah_simpanan(); 
		$this->template->load('template','anggota/anggota_view',$data);
	}
	public function LihatAnggota(){
		$list = $this->anggota->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $anggota) {
			$no++;
			$row = array();
			$row[] = $anggota->no_anggota;
			$row[] = $anggota->nama;
			$row[] = $anggota->alamat;
			if ($anggota->status == '1' && $anggota->keterangan == '1'){
				$status='Pegawai';
				$row[] = $status;
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$anggota->no_anggota."'".')"><i class="fa fa-edit"></i></a>
				  <a href="'.site_url('Penarikan/tambah_penarikan/').$anggota->no_anggota.'" class="btn btn-sm btn-info" target="_blank" title="Penarikan"><i class = "fa fa-money"></i></a>
				  <a href="'.site_url('Pinjaman/tambah_pinjaman/').$anggota->no_anggota.'" class="btn btn-sm btn-success" target="_blank" title = "Pengajuan Pinjaman"><i class = "fa fa-file-text"></i></a>';
			}else if ($anggota->status == '2') {
				$status='Pensiun';
				$row[] = $status;
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$anggota->no_anggota."'".')"><i class="fa fa-edit"></i></a>
				  <a href="'.site_url('Penarikan/tambah_penarikan/').$anggota->no_anggota.'" class="btn btn-sm btn-info" target="_blank" title="Penarikan"><i class = "fa fa-money"></i></a>
				  <a href="'.site_url('Pinjaman/tambah_pinjaman/').$anggota->no_anggota.'" class="btn btn-sm btn-success" target="_blank" title = "Pengajuan Pinjaman"><i class = "fa fa-file-text"></i></a>';
			}else if ($anggota->status == '3') {
				$status='Mutasi';
				$row[] = $status;
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$anggota->no_anggota."'".')"><i class="fa fa-edit"></i></a>
				  <a href="'.site_url('Penarikan/tambah_penarikan/').$anggota->no_anggota.'" class="btn btn-sm btn-info" target="_blank" title="Penarikan"><i class = "fa fa-money"></i></a>
				  <a href="'.site_url('Pinjaman/tambah_pinjaman/').$anggota->no_anggota.'" class="btn btn-sm btn-success" target="_blank" title = "Pengajuan Pinjaman"><i class = "fa fa-file-text"></i></a>';
			}else if($anggota->status=='4'){
				$status='Keluar';
				$row[] = $status;
				$row[] ='';
			}else if ($anggota->status == '1' && $anggota->keterangan == '0') {
				$status='Pegawai';
				$row[] = $status;
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$anggota->no_anggota."'".')"><i class="fa fa-edit"></i></a>
				  ';
			}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->anggota->count_all(),
						"recordsFiltered" => $this->anggota->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function GetAnggotaDetail($id){
		$data = $this->anggota->get_by_id($id);
		echo json_encode($data);
	}
	public function TambahAnggota(){
		$data = array(
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'status' => '1',
				'tahun_masuk' => date('y'),
				'bln_masuk' => date('m')
			);
		$this->db->insert('anggota',$data);
		$this->db->select('max(no_anggota) as no_anggota');
		$query = $this->db->get('anggota')->row();
		$no_anggota = $query->no_anggota;
		$simpanan_post = $this->input->post('tarif');
		$remove_rp = str_replace('Rp.','', $simpanan_post);
		$tarif = str_replace('.', '', $remove_rp)*1;
		$data = array(
				'no_anggota' => $no_anggota,
				'id_jenis' => 1,
				'tarif' => $tarif
			);
		$this->db->insert('simpanan_anggota',$data);
		$this->db->where('id_jenis',2);
		$ambiltarif = $this->db->get('jenis_simpanan')->row();
		$tarif = $ambiltarif->tarif;
		$data = array(
				'no_anggota' => $no_anggota,
				'id_jenis' => 2,
				'tarif' => $tarif
			);
		$this->db->insert('simpanan_anggota', $data);
		echo json_encode(array("status" => TRUE));
	}
	public function EditAnggota(){
		$data = array(
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'status' => '1'
			);
		$this->anggota->update(array('no_anggota' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function HapusAnggota($id){
		$this->anggota->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function cetak_pdf(){
		ini_set('max_execution_time', 300);
		$this->db->select('no_anggota, nama, alamat,status');
		$this->db->from('anggota');
		$this->db->where('status != 4');
        $data['anggota'] = $this->db->get();
        $sumber = $this->load->view('anggota/anggota_pdf', $data, true);
        $html = $sumber;
        $pdfFilePath = "DaftarAnggota---".date('Y-m-d H:i').".pdf";
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
