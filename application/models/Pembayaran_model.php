<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {

	var $table = 'pembayaran';
	var $column_order = array('id_bayar','tgl_bayar',null); 
	var $column_search = array('id_bayar','tgl_bayar','coa.no_akun','nama_akun','no_bukti'); 
	var $order = array('id_bayar' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->join('coa','pembayaran.no_akun=coa.no_akun');
		$this->db->select('id_bayar,tgl_bayar,jml_bayar,pembayaran.no_akun,coa.nama_akun,no_bukti');
		$this->db->from($this->table);
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
	public function get_id_bayar(){
			//get nomor transaksi terakhir
				$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
				$transaksi = $query->notrans+1;
				$nomor_trans = "BYR-".$transaksi;
			//insert nomor transaksi
				$data = array(
					'id_trans' => $nomor_trans,
					'jml_trans'=> 0);
				$this->db->insert('transaksi',$data);
			//insert ke pembelian
				$data = array(
					'id_bayar' => $nomor_trans);
				$this->db->insert('pembayaran',$data);
				return $nomor_trans;
	}
	public function get_coa(){
		$query = $this->db->query("SELECT * FROM coa WHERE no_akun LIKE '6__'")->result();
		return $query;
	}
	public function delete_by_id($id){
	$this->db->where('id_trans', $id);
	$this->db->delete('transaksi');
	}
}
