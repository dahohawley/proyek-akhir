<?php
	class Model_laporan extends CI_Model{
		public $tanggal_awal;
		public $tanggal_akhir;
		function data(){
			$this->db->select("tgl_trans,jurnal.id_trans,jurnal.no_akun,nama_akun,nominal,posisi_dr_cr");
			$this->db->join('coa','jurnal.no_akun = coa.no_akun');
			$this->db->join('transaksi','transaksi.id_trans = jurnal.id_trans');
			$this->db->where('tgl_trans >=',$this->tanggal_awal);
			$this->db->where('tgl_trans <=',$this->tanggal_akhir);
            $this->db->where('tipe','0');
			$this->db->order_by('id_jurnal','asc');
            // $this->db->order_by('tgl_trans');
			// $this->db->order_by('id_trans');
			// $this->db->order_by('posisi_dr_cr','asc');
			return $this->db->get('jurnal')->result();		
		}
        function data_peny(){
            $this->db->select("tgl_trans,jurnal.id_trans,jurnal.no_akun,nama_akun,nominal,posisi_dr_cr");
            $this->db->join('coa','jurnal.no_akun = coa.no_akun');
            $this->db->join('transaksi','transaksi.id_trans = jurnal.id_trans');
            $this->db->where('tgl_trans >=',$this->tanggal_awal);
            $this->db->where('tgl_trans <=',$this->tanggal_akhir);
            $this->db->where('tipe','1');
            $this->db->order_by('id_jurnal','asc');
            // $this->db->order_by('tgl_trans');
            // $this->db->order_by('id_trans');
            // $this->db->order_by('posisi_dr_cr','asc');
            return $this->db->get('jurnal')->result();      
        }
		function count_filtered(){
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
		public function count_all(){
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}
		function jumlah_data(){
			$query = $this->db->query("SELECT tgl_trans,jurnal.id_trans,jurnal.no_akun,nama_akun,nominal,posisi_dr_cr from jurnal join coa on jurnal.no_akun = coa.no_akun join transaksi on transaksi.id_trans = jurnal.id_trans where tipe = '0' and where tgl_trans between '".$this->tanggal_awal."' and '".$this->tanggal_akhir."'")->result();
			return count($query);
			//return $this->db->get('user')->num_rows();
		}
		function get_bukbesar($no_akun,$bulan,$tahun){
			$data = $this->db->query("SELECT tgl_trans,jurnal.no_akun,nama_akun,posisi_dr_cr,nominal,tipe FROM `jurnal` 
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
		public function get_detail_usp($no_anggota,$tahun){
            //get sisa pinjaman
                $this->db->where('no_anggota',$no_anggota);
                $this->db->where('year(tgl_pencairan)',$tahun);
                $this->db->select('sum(jml_pinjam) as jml_pinjam');
                $this->db->where('status >=','2');
                $total_pinjaman = $this->db->get('pinjaman')->row()->jml_pinjam;

                $this->db->where('no_anggota',$no_anggota);
                $this->db->where('year(tgl_angsur)',$tahun);
                $this->db->select('sum(jml_angsur) as jml_pinjam');
                $jumlah_bayar = $this->db->get('angsuran_pinj')->row()->jml_pinjam;

                $sisa_pinjaman = $total_pinjaman - $jumlah_bayar*(100/101.2);
            //get jasa manasuka simpanan hari raya
                // Get manasuka Seluruh anggota
                     $sp_mn_seluruh = $this->db->query("SELECT sum(jml_simpanan) as jml_simpanan from simpanan where tahun = '".$tahun."' and (id_jenis != '1' and id_jenis != '2')")->row()->jml_simpanan;
                     $this->db->where('year(tgl_penarikan)',$tahun);
                     $this->db->join('penarikan','penarikan.id_penarikan = detail_penarikan.id_penarikan');
                     $q = $this->db->get('detail_penarikan')->result();
                     if(count($q) == 0){
                        $penarikan = 0;
                     }else{
                        $this->db->where('year(tgl_penarikan)',$tahun);
                        $this->db->join('penarikan','penarikan.id_penarikan = detail_penarikan.id_penarikan');
                        $q = $this->db->get('detasil_penarikan')->roww(); 
                        $pernarikan = $q->subtotal;
                     }
                     $sp_mn_seluruh = $sp_mn_seluruh - $penarikan;
                // Get manasuka per Anggota
                    $sp_mn_anggota = $this->db->query("SELECT sum(jml_simpanan) as jml_simpanan from simpanan where tahun = '".$tahun."' and no_anggota = '".$no_anggota."' and (id_jenis != '1' and id_jenis != '2')")->row()->jml_simpanan;
                    $this->db->where('no_anggota',$no_anggota);
                    $this->db->where('year(tgl_penarikan)',$tahun);
                    $this->db->select('sum(jml_penarikan) as jml_penarikan');
                    $penarikan2 = $this->db->get('penarikan')->row()->jml_penarikan;
                    $sp_mn_anggota = $sp_mn_anggota - $penarikan2;
                // get pembagian SHU
                    $this->db->where('id','6');
                    $this->db->where('periode',$tahun);
                    $pemb_shu_mn = $this->db->get('rencana_pembagian')->row()->hasil_pembagian;
                $jasa_smn_shr = $sp_mn_anggota/$sp_mn_seluruh*$pemb_shu_mn;
            //get jasa sp sw
                // get sp sw seluruh
                    $q = $this->db->query("select sum(jml_simpanan) jml_simpanan from simpanan where year(tgl_simpan) = '".$tahun."' and (id_jenis = '1' or id_jenis = '2')")->row();
                    $sp_sw_seluruh = $q->jml_simpanan;

                    $q = $this->db->query("select sum(jml_simpanan) jml_simpanan from simpanan where no_anggota = '".$no_anggota."' and year(tgl_simpan) = '".$tahun."' and (id_jenis = '1' or id_jenis = '2')")->row();
                    $sp_sw_anggota = $q->jml_simpanan;

                    $this->db->where('id','5');
                    $this->db->where('periode',$tahun);
                    $q = $this->db->get('rencana_pembagian')->row();
                    $rencana_pembagian_sp_sw = $q->hasil_pembagian;
                $jasa_sp_sw_anggota = $sp_sw_anggota/$sp_sw_seluruh*$rencana_pembagian_sp_sw;

            //get jasa peminjam
                /* (jumlah pinjam per anggota yang disetujui / total pinjaman seluruh anggota pertahun) * rencana_pembagian id 7 */
            	$this->db->where('no_anggota',$no_anggota);
            	$this->db->where('year(tgl_pencairan)',$tahun);
            	$this->db->Where('status >','0');
            	$this->db->Where('status <','4');
            	$this->db->select('sum(jml_pinjam) as jml_pinjam');
            	$q = $this->db->get('pinjaman')->row();
            	$pinjaman_per_anggota = $q->jml_pinjam;

            	$this->db->where('year(tgl_pencairan)',$tahun);
            	$this->db->Where('status >','0');
            	$this->db->Where('status <','4');
            	$this->db->select('sum(jml_pinjam) as jml_pinjam');
            	$q = $this->db->get('pinjaman')->row();
            	$pinjaman_seluruh_anggota = $q->jml_pinjam;

            	$this->db->where('id','7');
            	$this->db->where('periode',$tahun);
                $this->db->select('*,sum(hasil_pembagian) as test');
            	$q = $this->db->get('rencana_pembagian')->row();
            	$rencana_pembagian = $q->hasil_pembagian;

            	$jasa_peminjam = ($pinjaman_per_anggota/$pinjaman_seluruh_anggota)*$rencana_pembagian;

            return $data = array(
                'sisa_pinjaman' => $sisa_pinjaman,
                'jasa_peminjam' => $jasa_peminjam,
                'jasa_sp_sw' => $jasa_sp_sw_anggota,
                'jasa_smn_shr' => $jasa_smn_shr);
        }
        function get_keuntungan($periode){
        	$data = array();
        	for($i=1;$i<=12;$i++){
				$query = $this->db->query("(SELECT sum(keuntungan) as keuntungan from nota_penjualan where  month(tgl_trans) = '".$i."' and year(tgl_trans) = '".$periode."' group by month(tgl_trans)) 
					UNION 
					(SELECT '0')
					LIMIT 1")->row();
				if($query->keuntungan == null){
					$data[$i] = 0;
				}else{
					$data[$i] = $query->keuntungan;
				}
			}
			return $data;
        }
        function get_data_tunggakan(){
        	$query = $this->db->query('SELECT * from anggota where status = "1"')->result();
        	return $query;
        }


        public function get_penerimaan_toko($no_anggota,$tahun){
        	$this->db->where('no_anggota',$no_anggota);
        	
        	$data = array(
        		'sisa_pinjaman' => 0,
        		'tunai' => 0,
        		'kredit' => 0,
        		'pemerataan' => 0 );
        }
        public function insert_jurnal($no_akun,$posisi_dr_cr,$id_trans,$id_rencana){
            $this->db->where('id',$id_rencana);
            $nominal = $this->db->get('rencana_pembagian')->row()->hasil_pembagian;
            $this->db->where('id_trans',$id_trans);
            $this->db->where('no_akun',$no_akun);
            $cek = $this->db->get('jurnal')->row();
            if(count($cek) < 1){
                $data = array(
                    'no_akun' => $no_akun,
                    'posisi_dr_cr' => $posisi_dr_cr,
                    'id_trans' => $id_trans,
                    'nominal' => $nominal,
                    'tipe' => 1);
                $this->db->insert('jurnal',$data);
            }else{
                $this->db->query("UPDATE jurnal set nominal = (nominal+".$nominal.") WHERE no_akun = '".$no_akun."' AND id_trans = '".$id_trans."' ");
            }
        }
        function get_total_jurnal($kode_akun,$tahun,$bulan){
            $this->db->where('no_akun',$kode_akun);
            $this->db->where('month(tgl_trans)',$bulan);
            $this->db->where('year(tgl_trans)',$tahun);
            $this->db->join('transaksi','transaksi.id_trans = jurnal.id_trans');
            $q = $this->db->get('jurnal')->result();
            $total_jurnal = 0;
            foreach ($q as $data) {
                if($data->posisi_dr_cr == 'd'){
                    $total_jurnal += $data->nominal;
                }else{
                    $total_jurnal -= $data->nominal;
                }
            }
            return $total_jurnal;
        }
	}