<?php
	class Pembelian extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('pembelian_model','model');
			$this->load->model('gudang_model','gudang');
			$this->my_page->set_page('Pembelian');
		}
		// laporan pembelian
			public function index(){
				$this->template->load('template','pembelian/pembelian_view');
			}
			public function read_pembelian(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_pembelian;
					$row[] = $transaksi->tgl_trans;
					$row[] = format_rp($transaksi->jml_trans);
					$row[] = $transaksi->nama_supplier;
					$row[] = '<button class="btn btn-primary" onclick="showModal('."'$transaksi->id_pembelian'".')">Lihat detail</button>';
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
			public function cetak_pdf(){
				ini_set('max_execution_time', 300);
		        $data['pembelian'] = $this->db->query("SELECT id_pembelian,tgl_trans,jml_trans,supplier.nama_supplier as nama_supplier from pembelian join supplier on pembelian.id_supplier = supplier.id_supplier")->result();
		        $sumber = $this->load->view('pembelian/pembelian_barang_pdf', $data, TRUE);
		        $html = $sumber;
		        $pdfFilePath = "LaporanPembelian".date('Y-m-d H:i').".pdf";
		        $pdf = $this->m_pdf->load();

		        $pdf->AddPage('P');
		        $pdf->useSubstitutions = false;
		        $pdf->simpleTables = true;
		        //$pdf->WriteHTML($stylesheet, 1);
		        $pdf->WriteHTML($html);
		        
		        $pdf->Output($pdfFilePath, "D");
		        exit();
			}
		//Tambah pembelian
			public function tambah_pembelian(){
				$id_pembelian = $this->model->get_id_pembelian();
				$data['id_pembelian'] = $id_pembelian;
				$data['detail_pembelian'] = $this->model->get_detail_pembelian($id_pembelian);
				$data['supplier'] = $this->model->get_supplier();
				$this->template->load('template','pembelian/add_pembelian_v',$data);
			}
			public function tambah_detail(){
				$id_pembelian = $this->input->post('id_pembelian');
				$id_barang = $this->input->post('id_barang');
				$jumlah = 1;
				$this->db->where('id_barang',$id_barang);
				$query = $this->db->get('barang')->row();
				$harga = $query->harga_jual;
				$total = $harga*$jumlah;
				//check detail_penjualan table
				$this->db->where('id_pembelian',$id_pembelian);
				$this->db->where('id_barang',$id_barang);
				$query1 = $this->db->get('detail_pembelian')->row();
				$jumlah_barang = count($query1);
				if ($jumlah_barang>0){
					$jumlah_sebelumnya = $query1->jumlah;
					$jumlah_tambah = $jumlah_sebelumnya+1;
					$this->db->set('jumlah',$jumlah_tambah);
					$this->db->set('subtotal',$harga*$jumlah_tambah);
					$this->db->where('id_pembelian',$id_pembelian);
					$this->db->where('id_barang',$id_barang);
					$this->db->update('detail_pembelian');
				}else{
					$data = array(
						'id_pembelian' => $id_pembelian,
						'id_barang' => $id_barang,
						'jumlah' => $jumlah,
						'subtotal' => $total
					);
					$insert = $this->model->save($data);
				}
				echo json_encode(array("status" => TRUE));
			}
			public function delete_detail($id_pembelian,$id_barang){
				$this->db->where('id_pembelian',$id_pembelian);
				$this->db->where('id_barang',$id_barang);
				$this->db->delete('detail_pembelian');
				echo json_encode(array("status" => TRUE));
			}
			public function selesai_pembelian(){
				$id_pembelian = $this->input->post('id_pembelian');
				$id_supplier = $this->input->post('id_supplier');
				$total_post = $this->input->post('total');
				$remove_rp = str_replace("Rp.","",$total_post);
				$total = str_replace(".","",$remove_rp)*1;
				$total_bayar = $this->input->post('total_bayar');
				$tanggal = date('Y-m-d');
				//update table transaksi
					$data = array(
						'tgl_trans' => $tanggal,
						'jml_trans' => $total);
					$this->db->where('id_trans',$id_pembelian);
					$this->db->update('transaksi',$data);
				//update table pembelian
					$data = array(
						'tgl_trans' => $tanggal,
						'jml_trans' => $total,
						'id_supplier' => $id_supplier,
						'status' => 1);
					$this->db->where('id_pembelian',$id_pembelian);
					$this->db->update('pembelian',$data);
				//update stok table barang
					$this->db->where('id_pembelian',$id_pembelian);
					$data = $this->db->get('detail_pembelian')->result();
					foreach ($data as $data){
						$id_barang = $data->id_barang;
						$jumlah_beli = $data->jumlah;
						//get stok awal
						$this->db->where('id_barang',$id_barang);
						$barang = $this->db->get('barang')->row();
						$stok_awal = $barang->stok;
						$stok_akhir = $stok_awal + $jumlah_beli;
						$this->db->where('id_barang',$id_barang);
						$this->db->set('stok',$stok_akhir);
						$this->db->update('barang');
					}
				//pembayaran 
				
				//insert ke angsuran_pmb
					//get id_angsuran()
						$id_angsuran = $this->model->get_id_angsuran();
					//insert id_angsuran ke table transaksi
						$data = array(
							'id_trans' => $id_angsuran,
							'tgl_trans' => date('Y-m-d'),
							'jml_trans' => $total_bayar);
						$this->db->insert('transaksi',$data);
					//insert ke table angsuran
						$data = array(
							'id_angsuran_pmb' => $id_angsuran,
							'tanggal' => date('Y-m-d'),
							'jumlah_angsuran' => $total_bayar,
							'id_pembelian' => $id_pembelian);
						$this->db->insert('angsuran_pmb',$data);
					redirect('pembelian');
			}
			public function daftar_barang(){
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
					$row[] = $barang->stok;
					$row[] = "<button class='btn btn-primary' onclick='pilihBarang($barang->id_barang)'>Pilih</button>";
				
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
			public function edit_jumlah(){
				header('Content-Type: application/json');
				$input = filter_input_array(INPUT_POST);
				$id = $input['id'];
				$jumlah = $input['jumlah'];
				echo $id." dan ".$jumlah;
			}
			public function detail_by_id($id_pembelian,$id_barang){
				$this->db->where('id_pembelian',$id_pembelian);
				$this->db->where('detail_pembelian.id_barang',$id_barang);
				$this->db->join('barang','barang.id_barang = detail_pembelian.id_barang');
				$query = $this->db->get('detail_pembelian')->row();
				echo json_encode($query);
			}
			public function edit_detail(){
				$id_pembelian = $this->input->post('id_pembelian');
				$id_barang = $this->input->post('id_barang_modal');
				$jumlah = $this->input->post('jumlah');
				$this->db->where('id_barang',$id_barang);
				$query = $this->db->get('barang')->row();
				$harga = $query->harga_jual;
				$this->db->set('jumlah',$jumlah);
				$this->db->set('subtotal',$harga*$jumlah);
				$this->db->where('id_pembelian',$id_pembelian);
				$this->db->where('id_barang',$id_barang);
				$this->db->update('detail_pembelian');
				$this->db->affected_rows();
				echo json_encode(array("status" => TRUE));
			}
		//misc
			public function detail_transaksi($id_pembelian){
				$this->db->where('id_pembelian',$id_pembelian);
				$this->db->join('barang','detail_pembelian.id_barang=barang.id_barang');
				$data = $this->db->get('detail_pembelian')->result();
				foreach($data as $data){
					echo "<tr>
							<td>".$data->nama_barang."</td>
							<td>".$data->jumlah."</td>
							<td>".format_rp($data->subtotal)."</td>
						</tr>";
				}
			}		
	}