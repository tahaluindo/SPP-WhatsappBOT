<html>
	<head>
		<title>JQuery Multiple Select</title>
		<script src="libs/jquery.min.js"></script>
		<script src="libs/jquery.multiple.select.js"></script>
		<link rel="stylesheet" href="libs/multiple-select.css"/>
		<script>
			$(document).ready(function(){
				$('#demo2').multipleSelect({
					placeholder: "Pilih Propinsi",
					filter:true
				});
			});
		</script>
	</head>
	<body>
		<h1>JQuery Multiple Select Demo</h1>
		<h2>Demo #2 : Combobox dengan Placeholder dan Filter</h2>
		<form action="" method="post">
		<h3>Multiple Combobox tanpa Plugin</h3>
		<select id="demo2a" name="demo2a[]" multiple="multiple" style="width:200px">
			<option value="JKT">DKI Jakarta</option>
			<option value="BTN">Banten</option>
			<option value="JABAR">Jawa Barat</option>
			<option value="JATENG">Jawa Tengah</option>
			<option value="JATIM">Jawa Timur</option>
			<option value="DIY">DI Yogyakarta</option>
		</select>
		<h3>Multiple Combobox dengan Plugin JQuery Multiple-Select</h3>
		<select id="demo2" name="demo2[]" multiple="multiple" style="width:200px">
			<option value="JKT">DKI Jakarta</option>
			<option value="BTN">Banten</option>
			<option value="JABAR">Jawa Barat</option>
			<option value="JATENG">Jawa Tengah</option>
			<option value="JATIM">Jawa Timur</option>
			<option value="DIY">DI Yogyakarta</option>
		</select>
		</form>
	</body>
</html>
