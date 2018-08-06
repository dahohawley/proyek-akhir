<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simpanan_model extends CI_Model {

	var $table = 'simpanan';
	var $column_order = array('id_simpanan','jml_simpanan','tgl_simpan','no_anggota','periode','tahun','id_jenis',null); 
	var $column_search = array('id_simpanan','simpanan.no_anggota','jenis_simpanan.keterangan','periode', 'tahun'); 
	var $order = array('id_simpanan' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->select('id_simpanan,jml_simpanan,tgl_simpan,simpanan.no_anggota,anggota.nama,periode,tahun,simpanan.id_jenis,jenis_simpanan.keterangan');
		$this->db->from($this->table);
		$this->db->join('jenis_simpanan','jenis_simpanan.id_jenis=simpanan.id_jenis');
		$this->db->join('anggota', 'anggota.no_anggota = simpanan.no_anggota');
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	function get_datatables(){
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered(){
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all(){
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	public function get_id_simpanan(){
		/*$this->db->where('status','0');
		$query = $this->db->get('simpanan')->row();
		$jumlah_transaksi = count($query);
		if ($jumlah_transaksi < 1){*/
			//get nomor transaksi terakhir
				$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
				$transaksi = $query->notrans+1;
				$nomor_trans = "SIM-".$transaksi;
			//insert nomor transaksi
				$data = array(
					'id_trans' => $nomor_trans,
					'jml_trans'=> 0);
				$this->db->insert('transaksi',$data);
			//insert ke pembelian
				$data = array(
					'id_simpanan' => $nomor_trans,
					'id_jenis' => 1
					);
				$this->db->insert('simpanan',$data);
				return $nomor_trans;
		/*}else{
				return $query->id_simpanan;
		}*/
	}
	public function get_tarif($no_anggota,$id_jenis){
		$this->db->where('no_anggota',$no_anggota);
		$this->db->where('simpanan_anggota.id_jenis',$id_jenis);
		$this->db->select('no_anggota,simpanan_anggota.id_jenis,jenis_simpanan.keterangan,simpanan_anggota.tarif');
		$this->db->join('jenis_simpanan','jenis_simpanan.id_jenis=simpanan_anggota.id_jenis');
		$this->db->from('simpanan_anggota');
		return $this->db->get()->row();
	}
	public function save($data){
		$this->db->insert('detail_simpanan', $data);
		return $this->db->insert_id();
	}
	
	public function get_anggota(){
		$this->db->where('status !=',4);
		return $this->db->get('anggota')->result();
	}
	public function get_simpanan_angg($no_anggota){
		//check udah bayar pokok atau belum
		$this->db->where('no_anggota',$no_anggota);
		$data = $this->db->get('anggota')->row();
		if ($data->keterangan == '0'){
			$this->db->where('no_anggota',$no_anggota);
			$this->db->where('simpanan_anggota.id_jenis','1');
			$this->db->select('no_anggota,simpanan_anggota.id_jenis,jenis_simpanan.keterangan,simpanan_anggota.tarif');
			$this->db->join('jenis_simpanan','jenis_simpanan.id_jenis=simpanan_anggota.id_jenis');
			$this->db->from('simpanan_anggota');
			return $this->db->get()->result();
		}else{
			$this->db->where('simpanan_anggota.id_jenis != ','1');
			$this->db->where('no_anggota',$no_anggota);
			$this->db->select('no_anggota,simpanan_anggota.id_jenis,jenis_simpanan.keterangan,simpanan_anggota.tarif');
			$this->db->join('jenis_simpanan','jenis_simpanan.id_jenis=simpanan_anggota.id_jenis');
			$this->db->from('simpanan_anggota');
			return $this->db->get()->result();
		}
	}
}
