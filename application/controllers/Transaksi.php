<?php
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	use Mike42\Escpos\Printer;
	class Transaksi extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('transaksi_model','transaksi');
			$this->load->model('gudang_model','gudang');
			$this->my_page->set_page('Transaksi');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		//data penjualan
			public function index(){
				$this->template->load('template','penjualan/data_penjualan');
			}
			public function read_penjualan(){
				$list = $this->transaksi->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list 	as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_penjualan;
					$row[] = $transaksi->tgl_trans;
					$row[] = format_rp($transaksi->jml_trans);
					$row[] = $transaksi->nama;
					$row[] = '<button class="btn btn-primary" onclick="showModal('."'$transaksi->id_penjualan'".')">Lihat detail</button>';
  					$data[] = $row;
				}

				$output = array(
								"draw" => $_POST['draw'],
								"recordsTotal" => $this->transaksi->count_all(),
								"recordsFiltered" => $this->transaksi->count_filtered(),
								"data" => $data,
						);
				//output to json format
				echo json_encode($output);
			}
		//tambah penjualan
			public function tambah_penjualan(){
				$no_trans = $this->transaksi->get_no_penjualan();
				$data['no_trans'] = $no_trans;
				$data['detail_penjualan'] = $this->transaksi->get_detail_penjualan($no_trans);
				$data['anggota'] = $this->db->get('anggota')->result();
				$this->template->load('template','penjualan/penjualan_view',$data);
			}
			public function ajax_add(){
				$id_penjualan = $this->input->post('id_penjualan');
				$id_barang = $this->input->post('id_barang');
				$jumlah = 1;

				$this->db->where('id_barang',$id_barang);
				$query = $this->db->get('barang')->row();
				$harga = $query->harga_jual;
				$total = $harga*$jumlah;

				//check detail_penjualan table
				$this->db->where('id_penjualan',$id_penjualan);
				$this->db->where('id_barang',$id_barang);
				$query1 = $this->db->get('detail_penjualan')->row();
				$jumlah_barang = count($query1);
				if ($jumlah_barang>0){
					$jumlah_sebelumnya = $query1->jumlah;
					$jumlah_tambah = $jumlah_sebelumnya+1;
					$this->db->set('jumlah',$jumlah_tambah);
					$this->db->set('subtotal',$harga*$jumlah_tambah);
					$this->db->where('id_penjualan',$id_penjualan);
					$this->db->where('id_barang',$id_barang);
					$this->db->update('detail_penjualan');
				}else{
					$data = array(
						'id_penjualan' => $id_penjualan,
						'id_barang' => $id_barang,
						'jumlah' => $jumlah,
						'subtotal' => $total
					);
					$insert = $this->transaksi->save($data);
				}
				echo json_encode(array("status" => TRUE));
			}
			public function get_by_id($id_penjualan,$id_barang){
				$this->db->where('id_penjualan',$id_penjualan);
				$this->db->where('detail_penjualan.id_barang',$id_barang);
				$this->db->join('barang','detail_penjualan.id_barang = barang.id_barang');
				$data = $this->db->get('detail_penjualan')->row();
				echo json_encode($data);
			}
			public function simpan_update(){
				$id_penjualan = $this->input->post('id_penjualan');
				$id_barang = $this->input->post('id_barang_modal');
				$jumlah = $this->input->post('jumlah');
				$harga = $this->input->post('harga');
				$subtotal = $jumlah*$harga;
				$this->db->where('id_penjualan',$id_penjualan);
				$this->db->where('id_barang',$id_barang);
				$this->db->set('jumlah',$jumlah);
				$this->db->set('subtotal',$subtotal);
				$this->db->update('detail_penjualan');
				echo json_encode(array("status" => TRUE));
			}
			public function ajax_delete($id_penjualan,$id_barang){
				$this->db->where('id_penjualan',$id_penjualan);
				$this->db->where('id_barang',$id_barang);
				$this->db->delete('detail_penjualan');
				echo json_encode(array("status" => TRUE));
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
			public function selesai_penjualan(){
				$id_penjualan = $this->input->post('id_penjualan');
				$no_anggota = $this->input->post('id_anggota');

				$total_post = $this->input->post('total');
				$remove_rp = str_replace("Rp.","",$total_post);

				$total = str_replace(".","",$remove_rp);
				$total_bayar = $this->input->post('total_bayar');
				$this->transaksi->id_penjualan = $id_penjualan;
				$this->transaksi->no_anggota = $no_anggota;
				$this->transaksi->total = $total;
				$this->transaksi->total_bayar = $total_bayar;
				$this->transaksi->simpan_transaksi();
				// Cetak Nota
				$this->cetak_nota($id_penjualan);
				redirect('Transaksi');
			}
			public function cetak_nota($id_penjualan){
				echo APPPATH . 'vendor\autoload.php';
				// GET DATA
					$this->db->select('LEFT(barang.nama_barang,15) as nama_barang,jumlah,subtotal');
					$this->db->join('barang','barang.id_barang = detail_penjualan.id_barang');
					$this->db->where('id_penjualan',$id_penjualan);
					$query = $this->db->get('detail_penjualan')->result();
					$items = array();
				// CETAK
				require_once(APPPATH.'vendor\autoload.php');
				$connector = new WindowsPrintConnector("Receipt Printer");
				$subtotals = 0;
				foreach($query as $data){
					$items[] = new item($data->nama_barang,format_rp($data->subtotal));
					$subtotals = $subtotals + $data->subtotal;
				}
				$total = new item('Total',format_rp($subtotals));
				/* Date is kept the same for testing */
				// $date = date('l jS \of F Y h:i:s A');
				$date = date('d-m-Y');

				/* Start the printer */
				$printer = new Printer($connector);

				/* Print top logo */

				/* Name of shop */
				$printer -> setJustification(Printer::JUSTIFY_CENTER);
				$printer -> text("KPRI Rukun Makmur.\n");
				$printer -> text("------------------------------\n");
				$printer -> selectPrintMode();
				$printer -> feed();

				/* Title of receipt */
				$printer -> setEmphasis(true);
				$printer -> text("Nota Penjualan\n");
				$printer -> setEmphasis(false);

				/* Items */
				$printer -> setJustification(Printer::JUSTIFY_LEFT);
				$printer -> setEmphasis(true);
				$printer -> text(new item('', 'Rp.'));
				$printer -> setEmphasis(false);
				foreach ($items as $item) {
				    $printer -> text($item);
				}
				$printer -> feed();
				/* Tax and total */
				$printer -> text($total);
				$printer -> selectPrintMode();

				/* Footer */
				$printer -> feed(2);
				$printer -> setJustification(Printer::JUSTIFY_CENTER);
				$printer -> text("Terimakasih telah berbelanja di KPRI Rukun Makmur\n");
				$printer -> feed(2);
				$printer -> text($date . "\n");

				/* Cut the receipt and open the cash drawer */
				$printer -> cut();
				$printer -> pulse();
				$printer -> close();

			}
		//misc
			public function detail_transaksi($id_penjualan){
				$this->db->where('id_penjualan',$id_penjualan);
				$this->db->join('barang','detail_penjualan.id_barang=barang.id_barang');
				$data = $this->db->get('detail_penjualan')->result();
				foreach($data as $data){
					echo "<tr>
							<td>".$data->nama_barang."</td>
							<td>".$data->jumlah."</td>
							<td>".format_rp($data->subtotal)."</td>
						</tr>";
				}
			}
			public function cetak_pdf(){
				ini_set('max_execution_time', 300);
				$this->db->select('id_penjualan,tgl_trans,jml_trans,anggota.nama');
				$this->db->from('nota_penjualan');
				$this->db->join('anggota','anggota.no_anggota = nota_penjualan.no_anggota');
		        $data['pembelian'] = $this->db->get();
		        $sumber = $this->load->view('penjualan/penjualan_barang_pdf', $data, true);
		        $html = $sumber;
		        $pdfFilePath = "LaporanPenjualan---".date('Y-m-d H:i').".pdf";
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
class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }
    
    public function __toString()
    {
        $rightCols = 8;
        $leftCols = 20;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;
        
        $sign = ($this -> dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}