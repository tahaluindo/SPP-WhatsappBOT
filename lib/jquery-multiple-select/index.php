<html>
	<head>
		<title>JQuery Multiple Select</title>
		<script src="libs/jquery.min.js"></script>
		<script src="libs/jquery.multiple.select.js"></script>
		<link rel="stylesheet" href="libs/multiple-select.css"/>
		<script>
			$(document).ready(function(){
				$('#demo1').multipleSelect();
			});
		</script>
	</head>
	<body>
		<h1>JQuery Multiple Select Demo</h1>
		<h2>Demo #1 : Contoh Sederhana</h2>
		<form action="" method="post">
		<select id="demo1" name="demo1[]" multiple="multiple" style="width:200px">
			<option value="JKT">DKI Jakarta</option>
			<option value="BTN">Banten</option>
			<option value="JABAR">Jawa Barat</option>
			<option value="JATENG">Jawa Tengah</option>
			<option value="JATIM">Jawa Timur</option>
			<option value="DIY">DI Yogyakarta</option>
		</select>
		<input type="submit" value="Submit" name="Demo1"/>
		</form>
		<?php
		if(isset($_POST['Demo1'])) {
			echo "<pre>"; print_r($_POST); echo "</pre>";
		}
		?>
	</body>
</html>
