<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/excel_reader.php";
include "config/fungsi_seo.php";
include "config/fungsi_thumb.php";
include "config/variabel_default.php";
if (isset($_SESSION[id])) {
  if ($_SESSION[status] == 'Aktif') {
  }
  $iden = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM siswa where username='$_SESSION[id]'"));
  $nama =  $iden[nmSiswa];
  $level = 'TIM';
  $foto = './dist/img/avatar5.png';

  $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));

  $ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where aktif='Y'"));
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Finance System | Juragan It Web</title>

    <link rel="shortcut icon" href="img/loh.png" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="./assets/ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/datetimepicker/bootstrap-datetimepicker.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.8/font-awesome-animation.min.css"/>
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="assets/bootstrap-select/css/bootstrap-select.min.css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin="" />

    <style type="text/css">
      .files {
        position: absolute;
        z-index: 2;
        top: 0;
        left: 0;
        filter: alpha(opacity=0);
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        opacity: 0;
        background-color: transparent;
        color: transparent;
      }
    </style>
    <script type="text/javascript" src="plugins/jQuery/jquery-1.12.3.min.js"></script>
    <script language="javascript" type="text/javascript">
      var maxAmount = 160;

      function textCounter(textField, showCountField) {
        if (textField.value.length > maxAmount) {
          textField.value = textField.value.substring(0, maxAmount);
        } else {
          showCountField.value = maxAmount - textField.value.length;
        }
      }
    </script>
    <script type="text/javascript" src="getDataCombo.js"></script>

  </head>

   <body class="hold-transition skin-<?php echo $idt['tema']; ?> sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <?php include "main-headers.php"; ?>
      </header>

      <aside class="main-sidebar">
        <?php
        include "menu-tim.php";
        ?>
      </aside>

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $judul; ?>
          </h1>
        </section>

        <section class="content">
          <?php include 'main-tim.php'; ?>

        </section>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <?php include "footer.php"; ?>
      </footer>
    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="plugins/highcharts/js/highcharts.js"></script>
    <script src="plugins/highcharts/js/modules/data.js"></script>
    <script src="plugins/highcharts/js/modules/exporting.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <script src="assets/js/script.js"></script>
    <script src="assets/app.js"></script>

    <script src="assets/bootstrap-select/js/bootstrap-select.min.js"></script>
    <?php if (isset($_GET['view']) && $_GET['view'] == 'absentim') { ?>
      <script src="https://unpkg.com/leaflet@0.7.3/dist/leaflet.js"></script>

      <script>
        $(document).ready(function() {
          var localstream = null;
          var vd;

          function initCam() {
            const video = document.createElement('video');
            video.id = 'video-cam';
            video.autoplay = 'true';
            video.style = 'width: 100%; height: auto;'

            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

            if (navigator.getUserMedia) {
              navigator.getUserMedia({
                video: true
              }, function(stream) {
                video.srcObject = stream;
                localstream = stream;
              }, function(error) {
                alert('CAM ERROR : ' + error);
              })
            }

            const parent = document.getElementById('vid-cam');
            parent.append(video);
            vd = video;
          }

          initCam();

          document.getElementById('take').addEventListener('click', function(e) {
            e.preventDefault();
            var width = vd.offsetWidth;
            var height = vd.offsetHeight;

            var canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            var context = canvas.getContext('2d');
            context.drawImage(vd, 0, 0, width, height);

            var img = document.createElement('img');
            img.width = width;
            img.height = height;
            img.src = canvas.toDataURL('image/png');

            const parent = document.getElementById('vid-cam');
            parent.innerHTML = '';
            parent.append(img);
            document.getElementById('file-cam').files = base64ImageToBlob(img.src);
            // console.log(base64ImageToBlob(img.src))

            if (localstream != null) {
              localstream.getTracks()[0].stop()
              this.style.display = 'none'
              document.getElementById('reCam').style.display = 'block'
            }

          })

          document.getElementById('reCam').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('vid-cam').innerHTML = '';
            initCam();
            this.style.display = 'none'
            document.getElementById('take').style.display = 'block'
          })

          // function take() {
          //   var width = vd.offsetWidth;
          //   var height = vd.offsetHeight;

          //   var canvas = document.createElement('canvas');
          //   canvas.width = width;
          //   canvas.height = height;
          //   var context = canvas.getContext('2d');
          //   context.drawImage(vd, 0, 0, width, height);

          //   var img = document.getElementById('target-cam');
          //   img.src = canvas.toDataURL('image/png');
          //   // document.getElementById('filer').files = base64ImageToBlob(img.src);
          //   // console.log(base64ImageToBlob(img.src))

          //   if (localstream != null) {
          //     localstream.getTracks()[0].stop()
          //     document.getElementById('take').style.display = 'none'
          //     document.getElementById('reCam').style.display = 'block'
          //   }
          // }


          function base64ImageToBlob(str) {
            var pos = str.indexOf(';base64,');
            var type = str.substring(5, pos);
            var b64 = str.substr(pos + 8);

            var imageContent = atob(b64);

            var buffer = new ArrayBuffer(imageContent.length);
            var view = new Uint8Array(buffer);

            for (var n = 0; n < imageContent.length; n++) {
              view[n] = imageContent.charCodeAt(n);
            }

            var blob = new Blob([buffer], {
              type: type
            });

            let fileName = new Date().getTime() + '.' + type.split('/')[1]
            let file = new File([blob], fileName, {
              type: "image/jpeg",
              lastModified: new Date().getTime()
            }, 'utf-8');
            let container = new DataTransfer();
            container.items.add(file);

            return container.files;
          }

          // MAPS
          // Creating map options
          var mapOptions = {
            // center: [112.35400252810952, 112.35400252810952],
            maxZoom: 18
          }
          var map = new L.map('map', mapOptions);
          // Creating a Layer object
          var layer = new L.TileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
              '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
              'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/satellite-v9'
          });

          // Adding layer to the map
          map.addLayer(layer);
          map.on('click', function(position) {
            console.log([position.latlng.lat, position.latlng.lng]);
          })

        var polygon = new L.polygon([
            [-8.416183965446299, 114.25075615226704],
            [-8.41649291750506, 114.25079850012929],
            [-8.416440552766694, 114.25048794913958],
            [-8.416299167937709, 114.25033620263326],
            [-8.416136837144483, 114.25050559408218]
          ]);

          polygon.addTo(map);

          function isMarkerInsidePolygon(marker, poly) {
            var polyPoints = poly.getLatLngs();
            var x = marker.getLatLng().lat,
              y = marker.getLatLng().lng;

            var inside = false;
            for (var i = 0, j = polyPoints.length - 1; i < polyPoints.length; j = i++) {
              var xi = polyPoints[i].lat,
                yi = polyPoints[i].lng;
              var xj = polyPoints[j].lat,
                yj = polyPoints[j].lng;

              var intersect = ((yi > y) != (yj > y)) &&
                (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
              if (intersect) inside = !inside;
            }

            return inside;
          };

          let start = false;
          var interval;

          let mymarker = null;

          // if (navigator.geolocation) {
          //   navigator.geolocation.getCurrentPosition(function(position) {
          //     document.getElementById('latlng').value = `${position.coords.latitude}, ${position.coords.longitude}`;
          //   })
          // }


          function get() {
            interval = setInterval(function() {
              clearInterval(interval);

              if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                  //document.getElementById("text").innerHTML = `LATITUDE : ${position.coords.latitude} <br>
                  //LONGITUDE : ${position.coords.longitude}`;
                  if (mymarker != null) {
                    mymarker.setLatLng([position.coords.latitude, position.coords.longitude]);
                    map.setView([position.coords.latitude, position.coords.longitude], 18, {
                      animation: true
                    });
                  } else {
                    mymarker = new L.Marker([position.coords.latitude, position.coords.longitude]);
                    mymarker.addTo(map);
                    map.setView([position.coords.latitude, position.coords.longitude], 18, {
                      animation: true
                    });
                  }

                  if (isMarkerInsidePolygon(mymarker, polygon)) {
                    //console.log("MASUK");
                    polygon.setStyle({
                      fillColor: '#38db21',
                      color: '#38db21',
                      weight: 2
                    });
                    $('#toSubmit').css({
                      'display': 'block'
                    });
                  } else {
                    polygon.setStyle({
                      fillColor: '#db2121',
                      color: '#db2121',
                      weight: 2
                    })
                    $('#toSubmit').css({
                      'display': 'none'
                    });
                  }
                  // axios.get(`https://nominatim.openstreetmap.org/reverse?lat=${position.coords.latitude}&lon=${position.coords.longitude}&format=json`).then(res => {
                  //   if(res.status == 200){
                  //     document.getElementById('tempat').value = res.data.display_name
                  //   } else{
                  //     document.getElementById('tempat').value = 'NO ADDRESS'
                  //   }               
                  // }).catch(err => {
                  //   console.log(err)
                  // });
                  document.getElementById('latlng').value = `${position.coords.latitude}, ${position.coords.longitude}`;
                })
              }
              get();
            }, 5000);
          }

          get();
        })
      </script>
    <?php } ?>
    <script>
      $('.textarea').wysihtml5();

      $(function() {
        // datepicker plugin
        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd'
        });

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        $('#example3').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#mastersiswa').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#example5').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200,
          "order": [
            [5, "desc"]
          ]
        });
      });

      //$('.datepicker').datepicker();

      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
      });

      $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1
      });

      $(".harusAngka").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
      });

      $("#parent").click(function() {
        $(".child").prop("checked", this.checked);
      });

      $('.child').click(function() {
        if ($('.child:checked').length == $('.child').length) {
          $('#parent').prop('checked', true);
        } else {
          $('#parent').prop('checked', false);
        }
      });

      //hitung
      /*
      $('#hitungBayaran').keyup(function(){
      	if ($(this).val() > $("#sisa").val()){
      		alert('Anda memasukkan nilai melebihi total tagihan!');
      		$(this).val($("#sisa").val());
      	}
      });
      */

      $("#allTarif").keypress(function(e) {
        var allTarif = $("#allTarif").val();
        if (e.which == 13) {
          $("#n1").val(allTarif);
          $("#n2").val(allTarif);
          $("#n3").val(allTarif);
          $("#n4").val(allTarif);
          $("#n5").val(allTarif);
          $("#n6").val(allTarif);
          $("#n7").val(allTarif);
          $("#n8").val(allTarif);
          $("#n9").val(allTarif);
          $("#n10").val(allTarif);
          $("#n11").val(allTarif);
          $("#n12").val(allTarif);
        }
      });
      $("#allTarifBebas").keypress(function(e) {
        var allTarif = $("#allTarifBebas").val();
        if (e.which == 13) {
          $(".nTagihan").val(allTarif);
        }
      });
    </script>

  </body>

  </html>

<?php
} else {
  include "login.php";
}
?>