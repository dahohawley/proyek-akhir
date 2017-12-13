<?php
	class Model_laporan extends CI_Model{
		public $tanggal_awal;
		public $tanggal_akhir;
		function data($number,$offset){
			$this->db->select("tgl_trans,jurnal.id_trans,jurnal.no_akun,nama_akun,nominal,posisi_dr_cr");
			$this->db->join('coa','jurnal.no_akun = coa.no_akun');
			$this->db->join('transaksi','transaksi.id_trans = jurnal.id_trans');
			$this->db->where('tgl_trans >=',$this->tanggal_awal);
			$this->db->where('tgl_trans <=',$this->tanggal_akhir);
			$this->db->order_by('id_trans');
			$this->db->order_by('posisi_dr_cr','asc');
			return $this->db->get('jurnal',$number,$offset)->result();		
		}
		function jumlah_data(){
			$query = $this->db->query("SELECT tgl_trans,jurnal.id_trans,jurnal.no_akun,nama_akun,nominal,posisi_dr_cr from jurnal join coa on jurnal.no_akun = coa.no_akun join transaksi on transaksi.id_trans = jurnal.id_trans where tgl_trans between '".$this->tanggal_awal."' and '".$this->tanggal_akhir."'")->result();
			return count($query);
			//return $this->db->get('user')->num_rows();
		}
		function get_bukbesar($no_akun){
			$this->db->where('jurnal.no_akun',$no_akun);
			$this->db->join('coa','coa.no_akun = jurnal.no_akun');
			return $this->db->get('jurnal')->result();
		}
	}