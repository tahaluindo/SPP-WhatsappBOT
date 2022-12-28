<?php
error_reporting(0);
session_start();
include "config/conn.php";
include 'config/rupiah.php';
if (empty($_SESSION['namauser']) and empty($_SESSION['passuser'])) {
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
} else {

    include 'lib/function.php';
    ob_start(); ?>
    <link rel="stylesheet" href="bootstrap/css/printer.css">
    <html>

    <head>

    <body onload="window.print()">
        <title>Cetak Rekap Data Rekap Kas</title>

        <style type="text/css">
            body {
                font-family: sans-serif;
            }

            table {
                border-collapse: collapse;
                font-family: sans-serif;
            }

            th {
                height: 30px;
                font-size: 12px;
                font-family: sans-serif;
            }

            table,
            th,
            td {
                border: 1px solid black;
                font-size: 11px;
                padding: 5px;
            }

            h3 {
                padding-bottom: -15px;
                font-family: sans-serif;
                text-align: center;
                text-transform: uppercase;

            }

            p {
                font-size: 12px;
                text-align: center;
                padding-bottom: -8px;
            }

            .divider-dashed {
                border-top: 1px dashed #ccc;
                background-color: #fff;
                height: 1px;
                margin: 10px 0;
            }

            #kiri {
                width: 50%;
                height: 100px;
                background-color: #FF0;
                float: left;
            }

            #kanan {
                width: 50%;
                height: 100px;
                background-color: #0C0;
                float: right;
            }
        </style>
        </head>

        <body>

            <?php
            $nama_file = 'lap_transaksi_nasabah';
            $query = mysqli_query($conn, "SELECT * FROM pengaturan LIMIT 1");
            $r2 = mysqli_fetch_array($query);

            ?>

            <h3>Rekap Data Kas <br><?php echo $r2[nama_sekolah]; ?></h3>
            <p><?php echo $r2[alamat]; ?> </p>
            <p><?php echo $r2[telephone]; ?> - <?php echo $r2[situs]; ?> </p>
            <hr />


            <table width="100%">

                <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Masuk</th>
                    <th>Jenis</th>
                    <th>Keluar</th>
                </tr>
                <?php

                $no = 1;
                $sql = mysqli_query($conn, "SELECT * FROM kas");
                while ($data = mysqli_fetch_assoc($sql)) {

                ?>
                    <tr class="odd gradeX">
                        <td>
                            <?php echo $no++; ?>
                        </td>
                        <td>
                            <?php echo $data['kode']; ?>
                        </td>
                        <td>
                            <?php echo date('d F Y', strtotime($data['tgl'])); ?>
                        </td>
                        <td>
                            <?php echo $data['keterangan']; ?>
                        </td>
                        <td align="right">
                            <?php echo number_format($data['jumlah']) . ",-"; ?>
                        </td>
                        <td>
                            <?php echo $data['jenis']; ?>
                        </td>
                        <td align="right">
                            <?php echo number_format($data['keluar']) . ",-"; ?>
                        </td>
                    </tr>
                <?php
                    $total = $total + $data['jumlah'];
                    $total_keluar = $total_keluar + $data['keluar'];

                    $saldo_akhir = $total - $total_keluar;
                }
                ?>
                </tbody>

                <tr>
                    <td colspan="4" style="text-align: left; font-size: 16px; color: maroon;">Total Kas Masuk :</td>
                    <td style="font-size: 17px; text-align: right; ">
                        <font style="color: green;"><?php echo " Rp." . number_format($total) . ",-"; ?></font>
                    </td>
                </tr>

                <tr>
                    <td colspan="6" style="text-align: left; font-size: 16px; color: maroon;">Total Kas Keluar :</td>
                    <td style="font-size: 17px; text-align: right; ">
                        <font style="color: red;"><?php echo " Rp." . number_format($total_keluar) . ",-"; ?></font>
                    </td>
                </tr>

                <tr>
                    <td colspan="5" style="text-align: left; font-size: 16px; color: red;">Saldo Akhir :</td>
                    <th style="font-size: 17px; text-align: right;">
                        <font style="color: purple;"><?php echo " Rp." . number_format($saldo_akhir) . ",-"; ?></font>
                    </th>
                </tr>
            <?php } ?>






            </table><br>
            <div class="col-lg-12 col-md-4" align="right" style="font-style:italic;">
                Cluring , <?php

                            function hari_ini()
                            {
                                $hari = date("D");

                                switch ($hari) {
                                    case 'Sun':
                                        $hari_ini = "Minggu";
                                        break;

                                    case 'Mon':
                                        $hari_ini = "Senin";
                                        break;

                                    case 'Tue':
                                        $hari_ini = "Selasa";
                                        break;

                                    case 'Wed':
                                        $hari_ini = "Rabu";
                                        break;

                                    case 'Thu':
                                        $hari_ini = "Kamis";
                                        break;

                                    case 'Fri':
                                        $hari_ini = "Jumat";
                                        break;

                                    case 'Sat':
                                        $hari_ini = "Sabtu";
                                        break;

                                    default:
                                        $hari_ini = "Tidak di ketahui";
                                        break;
                                }

                                return "" . $hari_ini . "";
                            }

                            echo " " . hari_ini();
                            $tgl = date(', d-m-Y');
                            echo $tgl;
                            ?>
                <br>
                Bendahara, <br><br><br><br><br><br>
                <?php echo $_SESSION['namalengkap']; ?>
            </div>
        </body>

    </html>