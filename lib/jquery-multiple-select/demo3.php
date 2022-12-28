<?php
#koneksi
$conn = mysqli_connect("localhost", "root", "qwerty", "demo");
#akhir-koneksi 

#ambil data propinsi
$query = "SELECT kode, nama FROM propinsi ORDER BY nama";
$sql = mysqli_query($conn, $query);
$arrpropinsi = array();
while ($row = mysqli_fetch_assoc($sql)) {
	$arrpropinsi [ $row['kode'] ] = $row['nama'];
}
?>
<html>
	<head>
		<title>JQuery Multiple Select</title>
		<script src="libs/jquery.min.js"></script>
		<script src="libs/jquery.multiple.select.js"></script>
		<link rel="stylesheet" href="libs/multiple-select.css"/>
		<script>
			$(document).ready(function(){
				$('#demo3').multipleSelect({
					placeholder: "Pilih Propinsi",
					filter:true
				});
			});
		</script>
	</head>
	<body>
		<h1>JQuery Multiple Select Demo</h1>
		<h2>Demo #3 : Combobox dengan Placeholder dan Filter</h2>
		<form action="" method="post">
		<select id="demo3" name="demo3[]" multiple="multiple" style="width:300px">
			<?php
			foreach($arrpropinsi as $kode=>$nama) {
				echo "<option value='$nama'>$nama</option>";
			}
			?>
		</select>
		<input type="submit" name="Pilih" value="Pilih"/>
		</form>
		<?php
		if(isset($_POST['Pilih'])) {
			echo "Propinsi yang Anda pilih: <br/>";
			echo implode(", ", $_POST['demo3']);
		}
		?>
	</body>
</html>
