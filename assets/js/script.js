$(document).ready(function(){
 	var i=1;
	$("#add_row").click(function(){
 		//$('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='ket"+i+"' type='text' placeholder='Keterangan' class='form-control input-md'  /> </td><td><input  name='penerimaan"+i+"' type='text' id='uang' placeholder='Jumlah Penerimaan'  class='form-control input-md'></td><td><input  name='pengeluaran"+i+"' type='text' id='uang' placeholder='JumlahPengeluaran'  class='form-control input-md'></td>");
    $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='ket[]' type='text' placeholder='Keterangan' class='form-control input-md' required/> </td><td><input  name='penerimaan[]' type='text' id='uang' placeholder='Jumlah Penerimaan'  class='form-control input-md' onkeypress='return isNumber(event)' required></td><td><input  name='pengeluaran[]' type='text' id='uang' placeholder='JumlahPengeluaran'  class='form-control input-md' onkeypress='return isNumber(event)' required></td>");

 		$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
 		i++;
	});

	$("#delete_row").click(function(){
		if(i>1){
			$("#addr"+(i-1)).html('');
			i--;
		}
	});
});
