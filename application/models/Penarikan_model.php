<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penarikan_model extends CI_Model {

	var $table = 'penarikan';
	var $column_order = array('id_penarikan','jml_penarikan','tgl_penarikan','no_anggota',null); 
	var $column_search = array('id_penarikan','penarikan.no_anggota','tgl_penarikan','nama'); 
	var $order = array('id_penarikan' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->select('id_penarikan,jml_penarikan,tgl_penarikan,penarikan.no_anggota,anggota.nama');
		$this->db->from($this->table);
		$this->db->join('anggota', 'anggota.no_anggota = penarikan.no_anggota');
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
	public function get_id_penarikan(){
		/*$this->db->where('status','0');
		$query = $this->db->get('simpanan')->row();
		$jumlah_transaksi = count($query);
		if ($jumlah_transaksi < 1){*/
			//get nomor transaksi terakhir
				$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
				$transaksi = $query->notrans+1;
				$nomor_trans = "TRK-".$transaksi;
			//insert nomor transaksi
				$data = array(
					'id_trans' => $nomor_trans,
					'jml_trans'=> 0);
				$this->db->insert('transaksi',$data);
			//insert ke pembelian
				$data = array(
					'id_penarikan' => $nomor_trans
					);
				$this->db->insert('penarikan',$data);
				return $nomor_trans;
		/*}else{
				return $query->id_simpanan;
		}*/
	}
	public function get_anggota($no_anggota){
		$this->db->where('no_anggota',$no_anggota);
		return $this->db->get('anggota')->row();
	}
	public function save($data){
		$this->db->insert('detail_simpanan', $data);
		return $this->db->insert_id();
	}
}
