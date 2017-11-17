function getTotal(nilai){
	var hrg		= document.getElementById('jualm1'+nilai).value;
	var qty		= document.getElementById('qty1'+nilai).value;
	
	if(qty<0){
		document.getElementById('qty1'+nilai).value = 0;
	}
	
	var ttl	= document.getElementById('qty1'+nilai).value * hrg;

	document.getElementById('netto1'+nilai).value = ttl;
	
	var jml	= parseInt(document.getElementById('jml').value);
	var ttlnet = 0;
	var ttlchrg = 0;
	var ttlitem = 0;
	for(a=0;a<jml;a++){
		var b = document.getElementById('qty1'+a).value;
		var c = document.getElementById('jualm1'+a).value;
		var d = document.getElementById('charge'+a).value;
		ttlnet = ttlnet + parseInt(document.getElementById('netto1'+a).value);
		ttlchrg = ttlchrg + parseInt(((b * c) * d)/100);
		ttlitem = ttlitem + parseInt(b);
		var ttlbyr	= ttlnet + ttlchrg
	}
	document.getElementById('TotalItem').innerHTML = number_format(ttlitem,0,',','.');
	document.getElementById('TotalNetto').innerHTML = number_format(ttlnet,0,',','.');
	document.getElementById('TotalNettoHidde').value = ttlnet;
	document.getElementById('SerCharge').innerHTML = number_format(ttlchrg,0,',','.');
	document.getElementById('ttlall').innerHTML = number_format(ttlbyr,0,',','.');
	document.getElementById('total_biaya').value = ttlbyr;
	document.getElementById('TotalItem2').value = ttlitem;
	document.getElementById('SerCharge2').value = ttlchrg;
	document.getElementById('ttlall2').value = ttlbyr;
}

function resetQty(nilai){
	var nto = document.getElementById('TotalNettoHidde').value - document.getElementById('netto1'+nilai).value;
	document.getElementById('TotalNetto').innerHTML = number_format(nto,0,',','.');
	document.getElementById('TotalNettoHidde').value = nto;
	document.getElementById('netto1'+nilai).value = 0
	
	var itm = document.getElementById('TotalItem2').value - document.getElementById('qty1'+nilai).value;
	document.getElementById('TotalItem').innerHTML = itm;
	document.getElementById('TotalItem2').value = itm;
	
	var crg = document.getElementById('SerCharge2').value - ((((document.getElementById('qty1'+nilai).value)*document.getElementById('jualm1'+nilai).value)*document.getElementById('charge'+nilai).value)/100);
	document.getElementById('SerCharge').innerHTML = crg;
	document.getElementById('SerCharge2').value = crg;
	
	var ttl = document.getElementById('ttlall2').value - (document.getElementById('jualm1'+nilai).value * document.getElementById('qty1'+nilai).value) - ((((document.getElementById('qty1'+nilai).value)*document.getElementById('jualm1'+nilai).value)*document.getElementById('charge'+nilai).value)/100);
	document.getElementById('ttlall').innerHTML = ttl;
	document.getElementById('ttlall2').value = ttl;
	document.getElementById('total_biaya').value = ttl;
	
	document.getElementById('qty1'+nilai).value = 0;
}

function cheklist(nilai){
	var ck		= document.getElementById('ck'+nilai).checked;
	if(ck==true){
		document.getElementById('qty1'+nilai).disabled=false;
	}else{
		document.getElementById('qty1'+nilai).disabled=true;
	}
}

function oncheked()
{
	if(document.form1.pilihan[0].checked == true){
		document.getElementById('cash_bayar').disabled=false;
		document.getElementById('cash_bayar').focus();
		
		if(document.getElementById('id_kredit').value == "")
		{ document.getElementById('id_kredit').disabled=true;}
		else { document.getElementById('id_kredit').disabled=false;}
		
		if(document.getElementById('id_debet').value == "")
		{ document.getElementById('id_debet').disabled=true;}
		else{document.getElementById('id_debet').disabled=false;}
		
		if(document.getElementById('id_voucher').value == "")
		{ document.getElementById('id_voucher').disabled=true;}
		else{document.getElementById('id_voucher').disabled=false;}
		
		if(document.getElementById('kredit_bayar').value == "")
		{document.getElementById('kredit_bayar').disabled = true;}
		else{document.getElementById('kredit_bayar').disabled = false;}
		
		if(document.getElementById('debet_bayar').value == "")
		{document.getElementById('debet_bayar').disabled = true;}
		else{document.getElementById('debet_bayar').disabled = false;}
		
		if(document.getElementById('voucher_bayar').value == "")
		{document.getElementById('voucher_bayar').disabled = true;}
		else{document.getElementById('voucher_bayar').disabled = false;}
		
		if(document.getElementById('id_tunai').value == "")
		{document.getElementById('id_tunai').disabled = true;}
		else{document.getElementById('id_tunai').disabled = false;}
}
else if(document.form1.pilihan[1].checked == true){
		if(document.getElementById('cash_bayar').value == "")
		{ document.getElementById('cash_bayar').disabled=true;}
		else { document.getElementById('cash_bayar').disabled=false;}
		
		document.getElementById('kredit_bayar').disabled=false;
		document.getElementById('kredit_bayar').focus();
		
		if(document.getElementById('id_tunai').value == "")
		{ document.getElementById('id_tunai').disabled=true;}
		else{document.getElementById('id_tunai').disabled=false;}
		
		if(document.getElementById('id_kredit').value == "")
		{ document.getElementById('id_kredit').disabled=true;}
		else{document.getElementById('id_kredit').disabled=false;}
	
		if(document.getElementById('id_debet').value == "")
		{ document.getElementById('id_debet').disabled=true;}
		else{document.getElementById('id_debet').disabled=false;}
		
		if(document.getElementById('id_voucher').value == "")
		{ document.getElementById('id_voucher').disabled=true;}
		else{document.getElementById('id_voucher').disabled=false;}
		
		if(document.getElementById('debet_bayar').value == "")
		{document.getElementById('debet_bayar').disabled = true;}
		else{document.getElementById('debet_bayar').disabled = false;}
		
		if(document.getElementById('voucher_bayar').value == "")
		{document.getElementById('voucher_bayar').disabled = true;}
		else{document.getElementById('voucher_bayar').disabled = false;}
}
else if(document.form1.pilihan[2].checked == true){
		if(document.getElementById('cash_bayar').value == "")
		{ document.getElementById('cash_bayar').disabled=true;}
		else { document.getElementById('cash_bayar').disabled=false;}
		
		document.getElementById('debet_bayar').disabled=false;
		document.getElementById('debet_bayar').focus();
		
		if(document.getElementById('id_tunai').value == "")
		{ document.getElementById('id_tunai').disabled=true;}
		else{document.getElementById('id_tunai').disabled=false;}
		
		if(document.getElementById('id_kredit').value == "")
		{ document.getElementById('id_kredit').disabled=true;}
		else{document.getElementById('id_kredit').disabled=false;}
	
		if(document.getElementById('id_debet').value == "")
		{ document.getElementById('id_debet').disabled=true;}
		else{document.getElementById('id_debet').disabled=false;}
		
		if(document.getElementById('id_voucher').value == "")
		{ document.getElementById('id_voucher').disabled=true;}
		else{document.getElementById('id_voucher').disabled=false;}
		
		if(document.getElementById('kredit_bayar').value == "")
		{document.getElementById('kredit_bayar').disabled = true;}
		else{document.getElementById('kredit_bayar').disabled = false;}
		
		if(document.getElementById('voucher_bayar').value == "")
		{document.getElementById('voucher_bayar').disabled = true;}
		else{document.getElementById('voucher_bayar').disabled = false;}	
	}
else if(document.form1.pilihan[3].checked == true){
		if(document.getElementById('cash_bayar').value == "")
		{ document.getElementById('cash_bayar').disabled=true;}
		else { document.getElementById('cash_bayar').disabled=false;}
		
		if(document.getElementById('id_tunai').value == "")
		{ document.getElementById('id_tunai').disabled=true;}
		else{document.getElementById('id_tunai').disabled=false;}
		
		if(document.getElementById('id_kredit').value == "")
		{ document.getElementById('id_kredit').disabled=true;}
		else { document.getElementById('id_kredit').disabled=false;}
		
		if(document.getElementById('id_debet').value == "")
		{ document.getElementById('id_debet').disabled=true;}
		else{document.getElementById('id_debet').disabled=false;}
		
		document.getElementById('voucher_bayar').disabled=false;
		document.getElementById('voucher_bayar').focus();
		
		if(document.getElementById('kredit_bayar').value == "")
		{document.getElementById('kredit_bayar').disabled = true;}
		else{document.getElementById('kredit_bayar').disabled = false;}
		
		if(document.getElementById('debet_bayar').value == "")
		{document.getElementById('debet_bayar').disabled = true;}
		else{document.getElementById('debet_bayar').disabled = false;}

		if(document.getElementById('id_voucher').value == "")
		{document.getElementById('id_voucher').disabled = true;}
		else{document.getElementById('id_voucher').disabled = false;}			
	}	
}

function SetKembali()
{
	var e = document.getElementById("Uang");
	var kurs = e.options[e.selectedIndex].value;
	var myarr = kurs.split("-");

	total_biaya 			= Number(document.getElementById('total_biaya').value);
	cash_bayar        		= Number(document.getElementById('cash_bayar').value);
	cash_bayar2             = cash_bayar * Number(myarr[1]);
	kredit_bayar			= Number(document.getElementById('kredit_bayar').value);
	debet_bayar				= Number(document.getElementById('debet_bayar').value);
	voucher_bayar			= Number(document.getElementById('voucher_bayar').value);
	total_bayar				= cash_bayar2 + kredit_bayar + debet_bayar + voucher_bayar;
	service_charge			= Number(document.getElementById('service_charge').value);
	kembali					= total_bayar - (total_biaya );
	//alert(service_charge);
	document.getElementById('total_bayar_hide').value = total_bayar;
	document.getElementById('total_bayar').innerHTML = number_format(total_bayar, 0, ',', '.');
	document.getElementById('cash_kembali').innerHTML = number_format(kembali, 0, ',', '.');		
	document.getElementById('cash_kembali_hide').value = kembali;		
}

function refresh(){
	//alert("test");
	location.reload();
}