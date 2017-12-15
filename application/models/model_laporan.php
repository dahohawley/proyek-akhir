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
		function get_bukbesar($no_akun,$bulan,$tahun){
			$data = $this->db->query("SELECT tgl_trans,jurnal.no_akun,nama_akun,posisi_dr_cr,nominal FROM `jurnal` 
							JOIN transaksi on jurnal.id_trans = transaksi.id_trans
							join coa on coa.no_akun = jurnal.no_akun
							where jurnal.no_akun = '".$no_akun."' and tgl_trans between '".$tahun."-".$bulan."-1' and '".$tahun."-".$bulan."-31'")->result();
			return $data;
		}
		function get_tot_pem(){
			$this->db->select("sum(jml_trans) as total_pembelian");
			$this->db->where('year(tgl_trans)',date('Y'));
			$data = $this->db->get('pembelian')->row();
			return $data->total_pembelian;
		}
		function get_saldo_awal_buku_besar($tahun,$bulan,$no_akun){
			$data = $this->db->query("SELECT tgl_trans,jurnal.no_akun,nama_akun,posisi_dr_cr,nominal FROM `jurnal` 
							JOIN transaksi on jurnal.id_trans = transaksi.id_trans
							join coa on coa.no_akun = jurnal.no_akun
							where jurnal.no_akun = '".$no_akun."' and tgl_trans between '2017-01-01' and '".$tahun."-".($bulan-1)."-31'")->result();
			$saldo = 0;
			foreach($data as $data){
				if($data->posisi_dr_cr == 'd'){
					$saldo = $saldo +$data->nominal;
				}else{
					$saldo = $saldo-$data->nominal;
				}
			}
			return $saldo;
		}
	}