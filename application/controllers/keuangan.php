<?php
	class Keuangan extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('keuangan_model','model');
			$this->load->model('piutang_model','piutang');
			$this->my_page->set_page('Keuangan');
		}
		//piutang
			public function piutang(){
				$this->template->load('template','keuangan/piutang_v');
			}
			public function get_piutang(){
				$list = $this->piutang->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $angsuran) {
					$no++;
					$row = array();
					$row[] = $angsuran->id_angsurpenj;
					$row[] = $angsuran->tgl_trans;
					$row[] = format_rp($angsuran->jumlah_angsuran);
					$row[] = format_rp($angsuran->jml_trans);
					$row[] = $angsuran->nama;
					$row[] = '<a class="btn btn-sm btn-primary" href="'.base_url('index.php/keuangan/bayarkan_piutang/').$angsuran->id_penjualan.'" title="Edit"> Bayarkan</a>';
					$row[] = '<button class="btn btn-primary btn-sm" onclick="showModal('."'$angsuran->id_angsurpenj'".')">Lihat detail</button>';
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
			public function bayarkan_piutang($id_penjualan){
				if(isset($_POST['jumlah_bayar'])){
					$id_penjualan = $this->input->post('id_penjualan');
					$sisa_piutang = $this->input->post('sisa_piutang');
					$jumlah_bayar = $this->input->post('jumlah_bayar');
					$id_angsuran_penj = $this->piutang->get_id_angsuran();
					$data= array(
						'id_trans' => $id_angsuran_penj,
						'tgl_trans' => date('Y-m-d'),
						'jml_trans' => $jumlah_bayar);
					$this->db->insert('transaksi',$data);
					$data = array(
						'id_angsurpenj' => $id_angsuran_penj,
						'tgl_trans' => date('Y-m-d'),
						'jml_trans' => $jumlah_bayar,
						'id_penjualan' => $id_penjualan);
					$this->db->insert('angsuran_penj',$data);
					redirect('keuangan/piutang');
				}else{
					$data['id_penjualan'] = $id_penjualan;
					$data['detail'] = $this->piutang->get_detail($id_penjualan);
					$this->template->load('template','keuangan/bayar_piutang',$data);
				}
			}
		//utang
			public function utang(){
				$this->template->load('template','keuangan/utang_v');
			}
			public function get_utang(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $angsuran) {
					$no++;
					$row = array();
					$row[] = $angsuran->id_pembelian;
					$row[] = $angsuran->tanggal;
					$row[] = format_rp($angsuran->jumlah_angsuran);
					$row[] = format_rp($angsuran->jml_trans);
					$row[] = $angsuran->nama_supplier;
					$row[] = '<a class="btn btn-sm btn-primary" href="'.base_url('index.php/keuangan/bayarkan_piutang/').$angsuran->id_pembelian.'" title="Edit"> Bayarkan</a>';
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
			public function bayarkan_utang($id_pembelian){
				if(isset($_POST['jumlah_bayar'])){
					$id_pembelian = $this->input->post('id_pembelian');
					$sisa_piutang = $this->input->post('sisa_piutang');
					$jumlah_bayar = $this->input->post('jumlah_bayar');
					$id_angsuran_pmb = $this->model->get_id_angsuran();
					$data= array(
						'id_trans' => $id_angsuran_pmb,
						'tgl_trans' => date('Y-m-d'),
						'jml_trans' => $jumlah_bayar);
					$this->db->insert('transaksi',$data);
					$data = array(
						'id_angsuran_pmb' => $id_angsuran_pmb,
						'tanggal' => date('Y-m-d'),
						'jumlah_angsuran' => $jumlah_bayar,
						'id_pembelian' => $id_pembelian);
					$this->db->insert('angsuran_pmb',$data);
					redirect('keuangan/piutang');
				}else{
					$data['id_pembelian'] = $id_pembelian;
					$data['detail'] = $this->model->get_detail($id_pembelian);
					$this->template->load('template','keuangan/bayar_angsuran',$data);
				}
			}
		//misc
			public function detail_piutang($id_angsurpenj){
				$this->db->where('id_angsurpenj',$id_angsurpenj);
				$data = $this->db->get('angsuran_penj')->result();
				foreach($data as $data){
					echo "<tr>
							<td>".$data->id_angsurpenj."</td>
							<td>".$data->tgl_trans."</td>
							<td>".format_rp($data->jml_trans)."</td>
						</tr>";
				}
			}
	}