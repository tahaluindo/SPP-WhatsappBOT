<?php
if (isset($_GET['tampil'])) {
  $tahun = $_GET['tahun'];
  $kelas = $_GET['kelas'];
} else {
  $tahun = $ta['idTahunAjaran'];
  $kelas = '';
}

$dsiswa = mysqli_fetch_array(mysqli_query($conn,"SELECT siswa.*,  kelas_siswa.nmKelas FROM siswa  LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas  WHERE idSiswa='$siswa'"));
$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
?>
<div class="col-xs-12">
  <div class="box box-primary box-solid">
    <div class="box-header with-border">
      <h3 class="box-title"><span class="fa fa-file-text-o"></span> Riwayat Pembayaran <?php echo $nama; ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php
      //tagihan bebas
      $sqlTagihanBebas = mysqli_query($conn,"SELECT
									tagihan_bebas.*,
									jenis_bayar.idPosBayar,
									pos_bayar.nmPosBayar,
									jenis_bayar.idTahunAjaran,
									jenis_bayar.nmJenisBayar,
									jenis_bayar.tipeBayar,
								
									siswa.nisnSiswa,
									siswa.nmSiswa,
									siswa.jkSiswa,
								
									siswa.idKelas,
									siswa.statusSiswa,
									tahun_ajaran.nmTahunAjaran,
									kelas_siswa.nmKelas
								FROM
									tagihan_bebas
								INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
								INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
								INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
								INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
								INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
								WHERE siswa.idSiswa='$_SESSION[idsa]' ORDER BY tagihan_bebas.idTagihanBebas ASC");
      //AND jenis_bayar.idTahunAjaran='$_GET[idTahunAjaran]' 
      ?>
      
 
      <div class="col-xs-12">
        <!-- List Tagihan Bulanan -->
        <div class="box box-warning box-solid">
          <div class="box-header backg with-border">
            <h3 class="box-title">Gaji Bulanan</h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <form method="post" action="/data.php" id="form">
              <table class="table table-striped table-hover" style="cursor: pointer;">
                <thead>
                  <tr>
                   
                    <th>No.</th>
                    <th>Nama Pembayaran</th>
                    <th>Total</th>
                    <th>Sudah Dibayar</th>
                    <th>Kekurangan</th>
                    <th>Status</th>
                   

                  </tr>
                </thead>

                <?php
                $no = 1;
                $sqlListTGB = mysqli_query($conn,"SELECT
								jenis_bayar.idJenisBayar,
								jenis_bayar.nmJenisBayar,
								jenis_bayar.tipeBayar,
								jenis_bayar.idTahunAjaran,
								tahun_ajaran.nmTahunAjaran,
								Sum(tagihan_bulanan.jumlahBayar) AS jmlTagihanBulanan,
								kelas_siswa.nmKelas,
								siswa.idSiswa,
							
								siswa.nisnSiswa,
								siswa.nmSiswa,
								jenis_bayar.idPosBayar,
								pos_bayar.nmPosBayar,
								pos_bayar.ketPosBayar
								FROM
								jenis_bayar
								INNER JOIN tagihan_bulanan ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
								INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
								INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
								INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas
								INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
								WHERE siswa.idSiswa='$_SESSION[idsa]' 
								GROUP BY
								jenis_bayar.idJenisBayar");



                while ($rtgb = mysqli_fetch_array($sqlListTGB)) {
                  $dtgb = mysqli_fetch_array(mysqli_query($conn,"SELECT sum(jumlahBayar) as jmlDibayar FROM tagihan_bulanan WHERE idJenisBayar=$rtgb[idJenisBayar] AND idSiswa=$_SESSION[idsa] AND statusBayar='1'"));
                  $no = 1;
                  if ($dtgb['jmlDibayar'] == 0) {
                    $status = "<label class='label label-danger'>Belum diBayar</label>";
                    $icon = "fa-plus";
                    $btn = "btn-danger";
                    $color = "red";
                    $alt = "Bayar";
                  } elseif ($dtgb['jmlDibayar'] < $rtgb['jmlTagihanBulanan']) {
                    $status = "<label class='label label-warning'>Belum Lengkap</label>";
                    $icon = "fa-plus";
                    $btn = "btn-warning";
                    $color = "red";
                    $alt = "Bayar";
                  } else {
                    $status = "<label class='label label-success'>Lunas</label>";
                    $icon = "fa-search";
                    $btn = "btn-success";
                    $color = "green";
                    $alt = "Detil";
                  }
                  echo "<tbody><tr style='color:$color'  data-toggle='collapse' data-target='#demo" . $rtgb['idJenisBayar'] . "' >
                  
                                <td>" . $no++ . "</td>
                                <td>" . $rtgb['nmJenisBayar'] . " T.A. " . $rtgb['nmTahunAjaran'] . "</td>
                                <td>" . buatRp($rtgb['jmlTagihanBulanan']) . "</td>
                                <td>" . buatRp($dtgb['jmlDibayar']) . "</td>
                                <td>" . buatRp($rtgb['jmlTagihanBulanan'] - $dtgb['jmlDibayar']) . "</td>
                                <td>$status</td>
								<td></td>
						
									<td></td>
                                </tr></tbody>";


                  echo '<tbody  id="demo' . $rtgb['idJenisBayar'] . '" class="collapse">
                                      <tr>
                                        <td colspan="9" align="center" class="info">
                                            <h4>' . $rtgb[nmJenisBayar] . ' - T.A ' . $rtgb[nmTahunAjaran] . '</h4>
                                        </td>
                                      </tr>
                                      <tr>
                                    
                                        <th>No.</th> 
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Jumlah</th>
                                        <th colspan="2" style="text-align: center;">Status</th>
                                        <th colspan="2" style="text-align: center;">Cara Bayar</th>
                                      
                                       
                                      </tr>';

                  $no = 1;
                  $sqltbDetail = mysqli_query($conn,"SELECT tagihan_bulanan.*, bulan.nmBulan FROM tagihan_bulanan LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE idJenisBayar='$rtgb[idJenisBayar]' AND idSiswa='$_SESSION[idsa]' ORDER BY bulan.urutan ASC");


                  while ($tb = mysqli_fetch_array($sqltbDetail)) {
                    $pisah_TA = explode('/', $rtgb['nmTahunAjaran']);
                    if ($r['urutan'] <= 6) {
                      $tahun = $pisah_TA[0];
                    } else {
                      $tahun = $pisah_TA[1];
                    }
                    if ($tb['statusBayar'] == '1') {
                      $color = "success";
                      $status = 'Lunas';
                      $pay = null;
                      $cara = $tb['caraBayar'];
                    } else if ($tb['statusBayar'] == '2') {
                      $color = "warning";
                      $status = 'Pending';
                      $pay = null;
                      $cara = "";
                    } else {
                      $color = "danger";
                      $status = 'Belum Dibayar';
                      $cara = "";
                      $pay = '<input type="checkbox"  value="' . $tb['jumlahBayar'] . '" name="items[]"  onchange="checkTotal()">
                              <input type="checkbox" name="pay[]" value="' . $tb['idTagihanBulanan'] . '"> ';
                    }
                    echo '<tr class="' . $color . '">
                  
                            <td>' . $no++ . '</td>
                            <td>' . $tb['nmBulan'] . '</td>
                            <td>' . $tahun . '</td>
                            <td>' . buatRp($tb['jumlahBayar']) . '</td>
                            <td colspan="2" align="center">' . $status . ' </td>
                             <td colspan="2" align="center"> ' . $cara . '</td>
                            
                          </tr>';
                  }
                  echo '</tbody>';
                }
                ?>

              </table>
                </form>


          </div>
        </div>
     
        <div class="box box-danger box-solid">
          <div class="box-header backg with-border">
            <h3 class="box-title">Tunjangan/Bonus</h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <form method="post" action="/cs.php" id="frm">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                  
                    <th>No.</th>
                    <th>Jenis Pembayaran</th>
                    <th>Total</th>
                    <th>Dibayar</th>
                    <th>Kekurangan</th>
                    <th>Status</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlTagihanBebas = mysqli_query($conn,"SELECT
									tagihan_bebas.*,
									jenis_bayar.idPosBayar,
									pos_bayar.nmPosBayar,
									jenis_bayar.idTahunAjaran,
									jenis_bayar.nmJenisBayar,
									jenis_bayar.tipeBayar,
								
									siswa.nisnSiswa,
									siswa.nmSiswa,
									siswa.jkSiswa,
								
									siswa.idKelas,
									siswa.statusSiswa,
									tahun_ajaran.nmTahunAjaran,
									kelas_siswa.nmKelas
								FROM
									tagihan_bebas
								INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
								INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
								INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
								INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
								INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
								WHERE siswa.idSiswa='$_SESSION[idsa]' ORDER BY tagihan_bebas.idTagihanBebas ASC");

                  $no = 1;
                  while ($rtb = mysqli_fetch_array($sqlTagihanBebas)) {
                    $dtBayar = mysqli_fetch_array(mysqli_query($conn,"SELECT sum(jumlahBayar) as totalDibayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$rtb[idTagihanBebas]'"));

                    $sisa = $rtb['totalTagihan'] - $dtBayar['totalDibayar'];
                    $sisaRp = buatRp($sisa);

                    if ($rtb['statusBayar'] == '0') {
                      $status = "<label class='label label-danger'>Belum dibayar</label>";
                      $icon = "fa-plus";
                      $btn = "btn-danger";
                      $color = "red";
                      $alt = "Bayar";
                      $btncetak = "disabled";
                      $pa = '<input type="checkbox"  value="' . $rtb['totalTagihan'] . '" name="item[]" onchange="checkTot()">
                              <input type="checkbox" name="pa[]"   value="' . $rtb['idTagihanBebas'] . '"> ';
                    } elseif ($rtb['statusBayar'] == '2') {
                      $status = "<label class='label label-warning'>Pending</label>";
                      $icon = "fa-plus";
                      $btn = "btn-warning";
                      $color = "red";
                      $alt = "Bayar";
                      $btncetak = "";
                      $pa = '<input type="checkbox"  value="' . $sisa . '"  name="item[]"  onchange="checkTot()">
                              <input type="checkbox" name="pa[]"   value="' . $rtb['idTagihanBebas'] . '"> ';
                    } elseif ($rtb['statusBayar'] == '1') {
                      $status = "<label class='label label-success'>Lunas</label>";
                      $icon = "fa-search";
                      $btn = "btn-success";
                      $color = "green";
                      $alt = "Detil";
                      $btncetak = "";
                      $pa = null;
                    }
                    echo "<tr style='color:$color' >
                            
                            <td>" . $no++ . "</td>
                            <td>" . $rtb['nmJenisBayar'] . " T.A. " . $rtb['nmTahunAjaran'] . "</td>
                            <td>" . buatRp($rtb['totalTagihan']) . "</td>
                            <td>" . buatRp($dtBayar['totalDibayar']) . "</td>
                            <td>" . buatRp($rtb['totalTagihan'] - $dtBayar['totalDibayar']) . "</td>
                            <td>$status</td>      
                                
                          </tr>";
                  }
                  ?>
                </tbody>
              </table>
             </form>

          </div>
        </div>
      </div>
    </div>
  </div>





  </tr>
  </tbody>
  </table>
  </form>

</div><!-- /.box-body -->
</div><!-- /.box -->
<?php

$sqlSiswa = mysqli_query($conn,"SELECT *
								FROM
									view_detil_siswa
								WHERE idKelas AND statusSiswa='Aktif' ORDER BY nmSiswa ASC"); {
?>

  </div><!-- /.box-body -->

  </div><!-- /.box -->
<?php
}
?>
</div>
<form id="payment-form" method="post" action="https://jeckivhan.web.id/index-siswa.php?view=laptanggungan">
  <input type="hidden" name="result_type" id="result-type" value=""></div>
  <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<script src="<?php echo $idt['link']; ?>" data-client-key="<<?php echo $idt['nipBendahara']; ?>>"></script>

<script type="text/javascript">
  $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
    $("#check-all").click(function() { // Ketika user men-cek checkbox all
      if ($(this).is(":checked")) // Jika checkbox all diceklis
        $(".check-item").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"
      else // Jika checkbox all tidak diceklis
        $(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
    });

    $("#btn-delete").click(function() { // Ketika user mengklik tombol delete
      var confirm = window.confirm("Apakah Anda yakin ingin menghapus data-data ini?"); // Buat sebuah alert konfirmasi

      if (confirm) // Jika user mengklik tombol "Ok"
        $("#form-delete").submit(); // Submit form
    });
  });



  $(document).on("click", ".pay", function(e) {
    e.preventDefault();
    var d = $(this).attr('data-id');
    $(this).attr("disabled", "disabled");

    $.ajax({
      type: "POST",
      url: 'cs.php',
      data: {
        da: d
      },
      cache: false,

      success: function(data) {
        //location = data;

        console.log('token = ' + data);

        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type, data) {

          // location.reload();
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          resultType.innerHTML = type;
          resultData.innerHTML = JSON.stringify(data);
        }

        snap.pay(data, {

          onSuccess: function(result) {
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          onPending: function(result) {
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result) {
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      }
    });

  });



  function checkTotal() {
    var sum = 0;
    var n = $('input[name="items[]"]:checked');

    for (i = 0; i < n.length; i++) {
      if (n[i].checked) {
        sum += parseInt(n[i].value);
      }
    }
    $("#total").val(sum);
  }


  function checkTot() {
    var sum = 0;
    var n = $('input[name="item[]"]:checked');

    for (i = 0; i < n.length; i++) {
      if (n[i].checked) {
        sum += parseInt(n[i].value);
      }
    }
    $("#tot").val(sum);
  }



  $('#form').submit(function(e) {
    e.preventDefault();
    var n = $("#total").val();
    var formData = new FormData($("#form")[0]);


    if (n != 0) {
      $.ajax({
        url: $("#form").attr('action'),
        type: 'post',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {

          console.log('token = ' + data);

          var resultType = document.getElementById('result-type');
          var resultData = document.getElementById('result-data');

          function changeResult(type, data) {

            // location.reload();
            $("#result-type").val(type);
            $("#result-data").val(JSON.stringify(data));
            resultType.innerHTML = type;
            resultData.innerHTML = JSON.stringify(data);
          }

          snap.pay(data, {

            onSuccess: function(result) {
              changeResult('success', result);
              console.log(result.status_message);
              console.log(result);
              $("#payment-form").submit();
            },
            onPending: function(result) {
              changeResult('pending', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onError: function(result) {
              changeResult('error', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            }
          });
        }
      });

    } else {
      alert('Silahkan Pilih Bulan Pembayaran');
    }

  });


  $('#frm').submit(function(e) {
    e.preventDefault();
    var n = $("#tot").val();
    var formData = new FormData($("#frm")[0]);


    if (n != 0) {
      $.ajax({
        url: $("#frm").attr('action'),
        type: 'post',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {

          console.log('token = ' + data);

          var resultType = document.getElementById('result-type');
          var resultData = document.getElementById('result-data');

          function changeResult(type, data) {

            // location.reload();
            $("#result-type").val(type);
            $("#result-data").val(JSON.stringify(data));
            resultType.innerHTML = type;
            resultData.innerHTML = JSON.stringify(data);
          }

          snap.pay(data, {

            onSuccess: function(result) {
              changeResult('success', result);
              console.log(result.status_message);
              console.log(result);
              $("#payment-form").submit();
            },
            onPending: function(result) {
              changeResult('pending', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onError: function(result) {
              changeResult('error', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            }
          });
        }
      });

    } else {
      alert('Silahkan Pilih Tagihan Pembayaran');
    }

  });
</script>