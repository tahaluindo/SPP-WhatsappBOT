$(document).ready(function() {
	$("#tahun").change(function() {
		var tahun =$(this).val();
		var dataString = 'tahun='+tahun;
		$.ajax({
			type: "POST",
			url: "getJenisBayar.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$("#jenisBayar").html(html);
			} 
		});
	});
	
	$("#tahun1").change(function() {
		var tahun1 =$(this).val();
		var dataString = 'tahun1='+tahun1;
		$.ajax({
			type: "POST",
			url: "getJenisBayar1.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$("#jenisBayar1").html(html);
			} 
		});
	});
	
	$("#tahun2").change(function() {
		var tahun2 =$(this).val();
		var dataString = 'tahun2='+tahun2;
		$.ajax({
			type: "POST",
			url: "getJenisBayar2.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$("#jenisBayar2").html(html);
			} 
		});
	});
	
	$("#kelas").change(function() {
		var kelas =$(this).val();
		var dataString = 'kelas='+kelas;
		$.ajax({
			type: "POST",
			url: "getSiswa.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$("#siswa").html(html);
			} 
		});
	});
});