<span class="heading">Main</span>
<ul class="list-unstyled">
            <li>
              <a href="<?php echo base_url('index.php/home')?>"><i class="fa fa-home"></i>Beranda</a>
            </li>
            <li><a href="#simpanan" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-money"></i></i>Pinjaman</a>
              <ul id="simpanan" class="collapse list-unstyled">
                <li><a href="<?php echo base_url('index.php/Pinjaman/index_ketua')?>">Data Pinjaman</a>
                <!--<li><a href="<?php echo base_url('index.php/Pinjaman/')?>">Pengajuan Pinjaman</a>-->
              </ul>
            </li>
             <li><a href="#laporan" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list"></i></i>Laporan</a>
              <ul id="laporan" class="collapse list-unstyled">
                <!-- <li><a href="#">Laporan Tunggakan</a></li> -->
                <li><a href="<?php echo base_url('index.php/Laporan/jurnal')?>">Jurnal Umum</a></li>
                <li><a href="<?php echo base_url('index.php/Laporan/buku_besar')?>">Buku Besar</a></li>
                <li><a href="<?php echo base_url('index.php/Laporan/neraca_saldo')?>">Neraca Saldo</a></li>
                <li><a href="<?php echo base_url('index.php/Laporan/filter_phu')?>">Perhitungan Hasil Usaha</a></li>
                <li><a href="<?php echo base_url('index.php/Laporan/filter_shu')?>">Rencana Pembagian Hasil Usaha</a></li>
                <li><a href="<?php echo base_url('index.php/Laporan/arus_kas')?>">Arus Kas</a></li>
                <li><a href="<?php echo base_url('index.php/Laporan/penerimaan_jasa')?>">Penerimaan Jasa </a></li>
              </ul>
            </li>
          </ul>
          <span class="heading">Extras</span>
          <ul>
            <li><a href="#masterdata" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-database"></i></i>Master data</a>
              <ul id="masterdata" class="collapse list-unstyled">
                <li><a href="<?php echo base_url('index.php/Pengurus/')?>">Pengurus</a></li> 
              </ul>
            </li>
          </ul>