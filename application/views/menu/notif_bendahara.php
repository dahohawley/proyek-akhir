<?php
  $this->db->where('status','1');
  $notif = $this->db->get('pinjaman')->result();
  $jumlah_notif = count($notif);
?>
<li class="nav-item dropdown show"> 
  <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="nav-link">
    <i class="fa fa-bell-o"></i>

    <?php
      if($jumlah_notif > 0){?>
        <span class="badge bg-red"><?php echo $jumlah_notif?></span>
    <?php
      }
    ?>

  </a>
    <ul aria-labelledby="notifications" class="dropdown-menu show" style="display: none;">
      <?php
        if($jumlah_notif > 0){
            foreach($notif as $notif){?>
              <li>
                  <a rel="nofollow" href="<?php echo base_url('index.php/Pinjaman')?>" class="dropdown-item">
                      <div class="notification">
                          <div class="notification-content"><i class="fa fa-envelope bg-green"></i>Pinjaman <?php echo $notif->id_pinjam?> membutuhkan tindakan</div>
                      </div>
                  </a>
              </li>
          <?php
            }
          ?>
      <?php
      }else{?>
        <li>
          <a rel="nofollow" href="#" class="dropdown-item">
          <div class="notification">
          <div class="notification-content"><i class="fa fa-envelope bg-green"></i>Tidak ada notifikasi</div>
          </div>
          </a>
        </li>
      <?php
      }
      ?>
        
    </ul>
</li>