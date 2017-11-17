function loading()
{
	base_url = $("#baseurl").val();
	bulan = $("#bulan").val();
	tahun = $("#tahun").val();
    var minDate = new Date(tahun,bulan-1,01); //one day next before month
    var maxDate =  new Date(tahun,bulan,0); //one day before next month
$('#tgl').Zebra_DatePicker({ format: 'd-m-Y' });
$('#tgljto').Zebra_DatePicker({ format: 'd-m-Y' });
	//$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,maxDate: maxDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
   // $('#tgljto').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
}

function keyShortcut(e,flag,obj) {
	//var e = window.event;
	if(window.event) // IE
	{
		var code = e.keyCode;
	}
	else if(e.which) // Netscape/Firefox/Opera
	{
		var code = e.which;
	}
	if (code == 13) { //checks for the escape key
		objek = obj.id;
		if(flag=='pcode'){
			id = parseFloat(objek.substr(5,objek.length-5));
			findPCode(id);
		}
		else if(flag=='qty'){
			id = parseFloat(objek.substr(3,objek.length-3));
			InputQty(id,'enter');
		}
		else if(flag=='order'){
			sumber=	document.querySelector('input[name="sumberMT"]:checked').value;
			//sumber = $("input[@name='sumberMT']:checked").val();
			if(sumber=="T")
			{
				noorderan = $("#noorder").val();
				$("#hiddennoorder").val(noorderan);
				setTimeout("getOrder()",1);
			}
			else
			{
				$("#nokirim").focus();
			}
		}
		else if(flag=='satuan'){
			id = parseFloat(objek.substr(6,objek.length-6));
			$("#qty"+id).focus();
		}
		else if(flag=='harga'){
			id = parseFloat(objek.substr(6,objek.length-6));
			InputHarga(id,'enter');
		}
		else if(flag=='disc1'){
			id = parseFloat(objek.substr(5,objek.length-5));
			InputDisc1(id,'enter');
		}
		else if(flag=='disc2'){
			id = parseFloat(objek.substr(5,objek.length-5));
			InputDisc2(id,'enter');
		}
		else if(flag=='ppnb'){
			id = parseFloat(objek.substr(4,objek.length-4));
			InputPPn(id,'enter');
		}
		else if(flag=='supplier'){
			findSupplier();
		}
		else if(flag=='top'){
			cektop();
		}
	}
}

function findSupplier()
{
	if(cekoption("gudang","Memasukkan Kode Gudang"))
	{
		if(cekoption("kdsupplier","Memasukkan Kode Supplier")){
			base_url = $("#baseurl").val();
			kdsupplier = $("#kdsupplier").val();
			$.post(base_url+"index.php/transaksi/konfirm_terima/getSupplier",{ kdsupplier:kdsupplier },
			function(data){
				if(data!="")
				{	
						result = data.split('*_*');
						$("#suppliername").val(result[0]);
						$("#hiddensupplier").val(kdsupplier);
						$("#top").val(result[2]);
						$("#limitkredit").val(result[3]);
						$("#limitfaktur").val(result[4]);
						$("#hiddensumber").val(result[1]);
						$("#ppn").val(result[5]);
						$("#kdgroupext").val(result[6]);
						if(result[1]=='C')
						{
							document.getElementById("sumberC").checked=true;
							document.getElementById("sumberK").checked=false;
							//document.getElementById("top").checked=true; //wieok
							$("#top").attr("disabled", true);
		
						}else
						{
							document.getElementById("sumberC").checked=false;
							document.getElementById("sumberK").checked=true;
							$("#top").attr("disabled", false);
						}
						cektop();
						$("#ket").focus();
				}
				else
				{
					pickSupplier();
				}
			});

		}
		else
		{
			pickSupplier();
		}
	}
}

function resetRow(id)
{
	$("#pcode"+id).focus();
	$("#tmppcode"+id).val("");
	$("#nama"+id).val("");
	$("#extcode"+id).val("");
	$("#hargab"+id).val("");
	$("#disc1"+id).val("");
   $("#disc2"+id).val("");	
	$("#jumlahb"+id).val("");
	$("#ppnb"+id).val("");
	$("#totalb"+id).val("");
	$("#tmpqty"+id).val("");
	$("#qty"+id).val("");
	$("#pcodebarang"+id).val("");
	$("#satuan"+id).val("");
	$("#satuanst"+id).val("");
	$("#konversi"+id).val("");
	$("#nilsatuan"+id).val("");
	$("#nilsatuanst"+id).val("");
}

function ubahsumberMT()
{
	sumberMT=	document.querySelector('input[name="sumberMT"]:checked').value;
	//sumberMT = $("input[@name='sumberMT']:checked").val();
	$("#hiddensumberMT").val(sumberMT);
	if(sumberMT=="M")
	{
		$("#btnorder").attr("disabled", "disabled");
      $("#noorder").val("");
		$("#noorder").attr("readonly", "readonly");
		$("#noorder").attr("disabled", "disabled");
	}
	else if(sumberMT=="T")
	{
		$("#btnorder").removeAttr("disabled");
		$("#noorder").removeAttr("readonly");
		$("#noorder").removeAttr("disabled");
	}
}

function ubahpayment()
{
	sumber = document.querySelector('input[name="sumber"]:checked').value;
	//sumber = $("input[@name='sumber']:checked").val();
	//alert(sumber);
	$("#hiddensumber").val(sumber);
	if(sumber=="C")
	{
	$("#top").attr("disabled", "disabled");
	$("#top").val("0");
	cektop();
	}
    else
	{
	$("#top").removeAttr("disabled");
	//$("#top").attr("disabled", "");
	cektop();
	}
}

function pickSupplier()
{
	base_url = $("#baseurl").val();
	with1 = $("#kdsupplier").val();
	url = base_url+"index.php/pop/supplier/index/orderbarang/"+with1;
	window.open(url,'popuppage','scrollbars=yes,width=550,height=500,top=180,left=150');
	cektop();
}


function CatatGudang()
{
	gudang = $("#gudang").val();
	$("#hiddengudang").val(gudang);
}

function getOrder()
{
	if(cekoption("noorder","Memasukkan Nomor Terima")){
		if(validateForm("noorder","hiddennoorder","No Terima")){
			noorderan = $("#noorder").val();
			base_url = $("#baseurl").val();
			$.post(base_url+"index.php/transaksi/konfirm_terima/getsumber",{ order:noorderan },
			function(data){
			    //alert(data);
				if(data=="")
				{
					alert("Penerimaan Barang Tidak Ditemukan\nPeriksa Kembali Nomor Penerimaan Barang");
					$("#noorder").focus();
					$("#hiddennoorder").val("");
				}
				else{
					$("#noorder").attr("readonly",true);
					$("#btnorder").attr("disabled","disabled");
					$("#gudang").attr("disabled","disabled");
					$("#kdsupplier").attr("disabled","disabled");
					Fill(data);
					$("#ket").focus();
				}
			});
		}
	}
}

function pickOrder()
{
	base_url = $("#baseurl").val();
	url = base_url+"index.php/pop/torder/index/";
	window.open(url,'popuppage','scrollbars=yes,width=750,height=500,top=180,left=150');
}

function Fill(data)
{
//15030200137-.-01-.-PT0002-.--.-K-.-0-.-TES-.-10000.00-.-0.00-.-0.00-.-10000.00-.-PT. MAJU JAYA LESTARI-.-010001
   parameter = data.split("-.-");
//alert(data);
	noorder 		= parameter[0];
	gudang 		= parameter[1];
	kdsupplier 	= parameter[2];
	kdgroupext 	= parameter[3];
	suppliername = parameter[11];
	payment 		= parameter[4];
	top 			= parameter[5];
	keterangan = parameter[6];
	jumlah 	= parameter[7];
	ppn 	= parameter[8];
	nilaippn = parameter[9];
	total = parameter[10];
	strdetail = parameter[12];
	baris = 0;
//alert(parameter[5]);
//alert(top);
	//window.opener.$("#newrow").css("display","none");
	param = strdetail.split("**");
	for(x=0;x<(param.length)-1;x++)
	{
		baris++;
		nilai = param[x].split("~");
		if(x>0)
		{
			detailNew();
		}
		$("#pcode"+baris).val(nilai[0]);
		$("#pcodebarang"+baris).val(nilai[6]);
		//$("#savepcode"+baris).val(nilai[0]);
		$("#tmppcode"+baris).val(nilai[0]);
		$("#nama"+baris).val(nilai[3]);
	
		$("#extcode"+baris).val(nilai[5]);
		
		$("#konversi"+baris).val(nilai[13]);  
		$("#satuanst"+baris).val(nilai[14]);  
		$("#nilsatuanst"+baris).val(nilai[15]); 
		$("#batasharga"+baris).val(nilai[9]);  
		$("#kdkategori"+baris).val(nilai[17]); 
		$("#kdbrand"+baris).val(nilai[16]);  
		$("#qty"+baris).val(nilai[1]);
		$("#tmpqty"+baris).val(nilai[1]);
		$("#disc1"+baris).val(nilai[7]);
		$("#disc2"+baris).val(nilai[8]);
		$("#hargab"+baris).val(nilai[9]);
		
		$("#jumlahb"+baris).val(nilai[10]);
		$("#ppnb"+baris).val(nilai[11]);
		
		$("#totalb"+baris).val(nilai[12]);
		
		$("#harga0b"+baris).val(nilai[9]); 
		$("#harga1b"+baris).val(nilai[9]); 
		$("#harga2b"+baris).val(nilai[9]); 
		$("#harga3b"+baris).val(nilai[9]); 
		$("#konv0st"+baris).val(nilai[13]);
		$("#konv1st"+baris).val(nilai[13]);
		$("#konv2st"+baris).val(nilai[13]); 
		$("#konv3st"+baris).val(nilai[13]); 
		$("#nilsatuan"+baris).val(nilai[18]); 
		$("#fromPO"+baris).val(1); 
		
		$("#satuan"+baris).empty();
		$("#satuan"+baris).append("<option selected='selected' value='"+nilai[4]+"'>"+nilai[18]+"</option>");
		$("#satuantmp"+baris).val(nilai[4]);
	}
	
	//$("#nodok").val(noorder);
	$("#noorder").val(noorder);
	$("#hiddennoorder").val(noorder);
	$("#noorder").attr("readonly",true);
	$("#gudang").val(gudang);
	$("#hiddengudang").val(gudang);
	$("#kdsupplier").val(kdsupplier);
	$("#kdgroupext").val(kdgroupext);
	$("#suppliername").val(suppliername);
	$("#hiddensupplier").val(kdsupplier);
	$("#gudang").attr("disabled","disabled");
	$("#kdsupplier").attr("disabled","disabled");
	$("#btnorder").attr("disabled","disabled");
	$("#ket").val(keterangan);
	$("#hiddensumber").val(payment);
	if(payment=='C')
	{
		document.getElementById("sumberC").checked=true;
		document.getElementById("sumberK").checked=false;
	}else
	{
		document.getElementById("sumberC").checked=false;
		document.getElementById("sumberK").checked=true;
	}
	//document.getElementById("sumberC").disabled=true;
	//document.getElementById("sumberK").disabled=true;
	jQuery("input[name='sumberMT']").each(function(i) {
		   jQuery(this).attr('disabled', 'disabled');
	});
	
	
	$("#top").val(parameter[5]);
	$("#jumlah").val(Math.round(jumlah));
	$("#ppn").val(Math.round(ppn));
	$("#nilaippn").val(Math.round(nilaippn));
	$("#total").val(Math.round(total));
	cektop();
	/*if(x>0)
	{
		detailNew();
	}*/
	$("#ket").focus();
}

function pickThis(obj)
{
		base_url = $("#baseurl").val();
		objek = obj.id;
		id = parseFloat(objek.substr(4,objek.length-4));
		pcode = $("#pcode"+id).val();
		kdgroupext = $("#kdgroupext").val();
		url = base_url+"index.php/pop/barangbeli/index/"+pcode+"/"+id+"/"+kdgroupext+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
}

function pickThis2(id)
{
		base_url = $("#baseurl").val();
		pcode = $("#pcode"+id).val();
		kdgroupext = $("#kdgroupext").val();
		url = base_url+"index.php/pop/barangbeli/index/"+pcode+"/"+id+"/"+"/"+kdgroupext+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
}

function findPCode(id)
{
    fromPO = $("#fromPO"+id).val();
	if (fromPO==0)
	{
		if(cekheader())
		{
			if(cekoption("pcode"+id,"Memasukkan Kode Barang")){
			    pcode = $("#pcode"+id).val();
				pcodesave = $("#savepcode"+id).val();
				if(pcode!=pcodesave)
				{
					base_url = $("#baseurl").val();
					var lastRow = document.getElementsByName("pcode[]").length;
					var dobel = false;
					for(index=0;index<lastRow;index++){
						nama = document.getElementsByName("pcode[]");
						temp = nama[index].id;
						indexs = temp.substr(5,temp.length-5);
						if($("#pcodebarang"+indexs).val()==pcode)
						{
							if(index==lastRow-1||indexs==id){
								continue;
							}
							else{
								dobel = true;
								break;
							}
						}
					}
					if(!dobel){
						pcodeawal = $("#tmppcode"+id).val();
						$("#tmppcode"+id).val(pcode);
						owner = $("#kdsupplier").val();
						kdgroupext = $("#kdgroupext").val();
						$.post(base_url+"index.php/transaksi/konfirm_terima/getPCode",{pcode:pcode,kdgroupext:kdgroupext},
						function(data){
							if(data!="")
							{	
									//alert(data);
									result = data.split('*_*');
									//$("#pcode"+brs).val(result[1]);
									$("#pcodebarang"+id).val(result[1]);
									$("#tmppcode"+id).val(result[1]);
									$("#nama"+id).val(result[2]);
									$("#konversi"+id).val(result[6]);
									$("#satuanst"+id).val(result[3]);
									$("#nilsatuanst"+id).val(result[4]);
									$("#batasharga"+id).val(0);
									$("#kdkategori"+id).val(result[13]);
									$("#kdbrand"+id).val(result[14]);
									$("#hargab"+id).val(result[5]);
									$("#totalb"+id).val(result[5]);
									$("#harga0b"+id).val(result[5]);
									$("#konv0st"+id).val(result[6]);  //wieok
									$("#harga1b"+id).val(result[7]);
									$("#konv1st"+id).val(result[8]);
									$("#harga2b"+id).val(result[9]);
									$("#konv2st"+id).val(result[10]);
									$("#harga3b"+id).val(result[11]);
									$("#konv3st"+id).val(result[12]);
									
									$("#ppnb"+id).val(result[24]);
									$("#extcode"+id).val(result[23]);

									$("#qty"+id).val("");
									$("#satuan"+id).empty();
									$("#nilsatuan"+id).val(result[16]);
									$("#satuan"+id).append("<option selected='selected' value='0|"+result[15]+"'>"+result[16]+"</option>"); //wieok
									$("#satuan"+id).append("<option value='1|"+result[17]+"'>"+result[18]+"</option>"); //wieok
									$("#satuan"+id).append("<option value='2|"+result[19]+"'>"+result[20]+"</option>");
									$("#satuan"+id).append("<option value='3|"+result[21]+"'>"+result[22]+"</option>");
									$("#satuantmp"+id).val($("#satuan"+id).val());
									$("#qty"+id).focus();
							}
							else
							{
								pickThis2(id);
							}
						});
					}
					else
					{
						pickThis2(id);
					}
				}else $("#qty"+id).focus();
			}
		}
	}
	else
	  $("#qty"+id).focus();
}

function InputQty(id,from)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	{
		if(validateForm("pcode"+id,"tmppcode"+id,"Kode Barang")){
			{
				if(cekAngka("qty"+id,"Qty","no zero","no minus"))
				{
					$("#tmpqty"+id).val($("#qty"+id).val());
					harga = Number($("#hargab"+id).val());
					qty = Number($("#qty"+id).val());
					disc1 = Number($("#disc1"+id).val());
					disc2 = Number($("#disc2"+id).val());
					jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
					$("#jumlahb"+id).val(jumlahb);
					ppn = Number($("#ppn").val());
					ppnb = Number($("#ppnb"+id).val());
					ppnhitung = Number(Math.min(ppn,ppnb)/100*jumlahb);
					$("#totalb"+id).val(jumlahb+ppnhitung);
					$("#tmphargab"+id).val($("#hargab"+id).val());
					totalNetto();
					$("#hargab"+id).focus();
				}
			}
		}
	}
	else
	{
		resetRow(id);
		$("#pcode"+id).focus();
	}
}

function InputHarga(id,from)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	{
				if(cekAngka("hargab"+id,"Harga","zero","no minus"))
				{
					harga = Number($("#hargab"+id).val());
					qty = Number($("#qty"+id).val());
					disc1 = Number($("#disc1"+id).val());
					disc2 = Number($("#disc2"+id).val());
					jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
					$("#jumlahb"+id).val(jumlahb);
					ppn = Number($("#ppn").val());
					ppnb = Number($("#ppnb"+id).val());
					ppnhitung = Number(Math.min(ppn,ppnb)/100*jumlahb);
					$("#totalb"+id).val(jumlahb+ppnhitung);
					$("#tmphargab"+id).val($("#hargab"+id).val());
					totalNetto();
					$("#disc1"+id).focus();
				}
	}
	else
	{
		resetRow(id);
		$("#pcode"+id).focus();
	}
}

function InputDisc1(id,from)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	{
		harga = Number($("#hargab"+id).val());
		qty = Number($("#qty"+id).val());
		disc1 = Number($("#disc1"+id).val());
		disc2 = Number($("#disc2"+id).val());
		jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
		$("#jumlahb"+id).val(jumlahb);
		ppn = Number($("#ppn").val());
		ppnb = Number($("#ppnb"+id).val());
		ppnhitung = Number(Math.min(ppn,ppnb)/100*jumlahb);
		$("#totalb"+id).val(jumlahb+ppnhitung);
		$("#tmphargab"+id).val($("#hargab"+id).val());
		totalNetto();
		$("#disc2"+id).focus();
	}
	else
	{
		resetRow(id);
		$("#pcode"+id).focus();
	}
}

function InputDisc2(id,from)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	{
		harga = Number($("#hargab"+id).val());
		qty = Number($("#qty"+id).val());
		disc1 = Number($("#disc1"+id).val());
		disc2 = Number($("#disc2"+id).val());
		jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
		$("#jumlahb"+id).val(jumlahb);
		ppn = Number($("#ppn").val());
		ppnb = Number($("#ppnb"+id).val());
		ppnhitung = Number(Math.min(ppn,ppnb)/100*jumlahb);
		$("#totalb"+id).val(jumlahb+ppnhitung);
		$("#tmphargab"+id).val($("#hargab"+id).val());
		totalNetto();
		totalb = $("#totalb"+id).val();
		batas = $("#batasharga"+id).val();
		$("#ppnb"+id).focus();
		//if(from=="enter"){
		 //  saveThis(id);
		//}

	}
	else
	{
		resetRow(id);
		$("#pcode"+id).focus();
	}
}

function InputPPn(id,from)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	{
		harga = Number($("#hargab"+id).val());
		qty = Number($("#qty"+id).val());
		disc1 = Number($("#disc1"+id).val());
		disc2 = Number($("#disc2"+id).val());
		jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
		$("#jumlahb"+id).val(jumlahb);
		ppn = Number($("#ppn").val());
		ppnb = Number($("#ppnb"+id).val());
		ppnhitung = Number(Math.min(ppn,ppnb)/100*jumlahb);
		$("#totalb"+id).val(jumlahb+ppnhitung);
		$("#tmphargab"+id).val($("#hargab"+id).val());
		totalNetto();
		totalb = $("#totalb"+id).val();
		batas = $("#batasharga"+id).val();

		if(from=="enter"){
		   saveThis(id);
		}

	}
	else
	{
		resetRow(id);
		$("#pcode"+id).focus();
	}
}

function storeSatuan(obj)
{
	objek = obj.id;
	id = parseFloat(objek.substr(6,objek.length-6));
	//alert(id);
	//alert($("#satuan"+id).val());
	//alert($("#satuantmp"+id).val());
	if($("#satuan"+id).val()!=""){
		$("#satuantmp"+id).val($("#satuan"+id).val());
		idp = $("#satuan"+id).val().substr(0,1);

		$("#hargab"+id).val($("#harga"+idp+"b"+id).val());
		$("#tmphargab"+id).val($("#tmphargab"+idp+"b"+id).val());
	
		$("#konversi"+id).val($("#konv"+idp+"st"+id).val());
		$("#nilsatuan"+id).val($("#satuan"+id+" option:selected").text());
		//sumber = $("input[@name='sumber']:checked").val();
		if($("#qty"+id).val()!=""){
			InputQty(id,"enter");
		}
	}
	else
	{
		$("#satuantmp"+id).val("");
		$("#tmpqty"+id).val("");
		$("#qty"+id).val("");
		$("#qty"+id).focus();
	}
}

function saveThis(id)
{
	if(cekheader())
	if(cekDetail(id))
	{
		//$('fieldset.disableMe :input').attr('disabled', true);
		//saveItem(id);
	}
}

function saveAll()
{
   if(cekheader())
	if(cekDetailAll()){
		alert("K")
        document.getElementById("konfirmterima").submit();
		//$("#konfirmterima").submit();
	}
}

function cekheader()
{
	//if(cekoption("gudang","Memilih Lokasi"))
	//if(cekoption("tgljto","Mengisi Tanggal Jatuh Tempo"))
	if(cekoption("gudang","Memilih Gudang"))
	if(cekoption("kdsupplier","Memilih Supplier"))
	if(cektanggal())
	if(ceksumberorder())
		return true;
	return false;
}

function ceksumberorder()
{
	sumberMT=	document.querySelector('input[name="sumberMT"]:checked').value;
	//sumberMT = $("input[@name='sumberMT']:checked").val();
	hiddenorder = $("#hiddennoorder").val();
	if(sumberMT=="T" && hiddenorder=="")
	{
		alert("Anda Belum Meng-enter No Terima");
		$("#noorder").focus();
		return false;
	}
	else if(sumberMT=="T"  && hiddenorder!="")
	{
		if(validateForm("noorder","hiddennoorder","No Terima"))
			return true;
		return false;
	}
	return true;
}

function cektop()
{
	var d1 = $("#tgl").val().split("-");
	var top = $("#top").val();
    
	var date1 = new Date();
	date1.setFullYear(d1[2],parseFloat(d1[1])-1,d1[0])
	var date2 = new Date(date1.getTime() + parseFloat(top)*24*60*60*1000);
	var tgljto = pad(date2.getDate(),2)+"-"+pad((date2.getMonth()+1),2)+"-"+date2.getFullYear(); 
	$("#tgljto").val(tgljto);
	//alert($("#tgljto").val());
	
	if(date1 > date2){
		alert("Tanggal Jatuh Tempo Harus Sama atau Lebih Besar Dari Tanggal Faktur");
		$("#top").focus();
	}
	else $("#ket").focus();
}

function pad(num, size) {
    var s = "000000000" + num;
    return s.substr(s.length-size);
}

function cektanggal()
{
	var d1 = $("#tgl").val().split("-");
	var d2 = $("#tgljto").val().split("-");

	var date1 = new Date();
	date1.setFullYear(d1[2],parseFloat(d1[1])-1,d1[0])
	var date2 = new Date();
	date2.setFullYear(d2[2],parseFloat(d2[1])-1,d2[0])

	if(date1 > date2){
		alert("Tanggal Jatuh Tempo Harus Lebih Besar Dari Tanggal Penerimaan");
		$("#tgljto").focus();
		return false;
	}
	else return true;
}

function cekDetail(id)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	if(validateForm("pcode"+id,"tmppcode"+id,"Kode Barang"))
	if(cekoption("qty"+id,"Memasukkan Jumlah Barang"))
	if(validateForm("qty"+id,"tmpqty"+id,"Jumlah Barang"))
		return true;
	return false;
}

function cekDetailAll()
{
	var lastRow = document.getElementsByName("pcode[]").length;
	//alert(lastRow);
	for(indexc=0;indexc<lastRow;indexc++){
		nama = document.getElementsByName("pcode[]");
		temp = nama[indexc].id;
		indexs = temp.substr(5,temp.length-5);
		//alert(indexc+" continue "+indexs);
		if(indexc<parseFloat(lastRow)-1||indexc==0){
			if(cekoption("pcode"+indexs ,"Memasukkan Kode Barang"))
			if(validateForm("pcode"+indexs,"tmppcode"+indexs,"Kode Barang"))
			if(cekoption("qty"+indexs ,"Memasukkan Jumlah Barang"))
			if(validateForm("qty"+indexs,"tmpqty"+indexs,"Jumlah Barang"))
			//if(cekstring("tersimpan"+indexs ,"konfirmasi per item"))
			{
				InputQty(indexs,'cek');
				//alert(indexc+" continue0");
				continue;
			}
			//alert(indexc+" false0");
			return false;
		}
		else if(indexc==parseFloat(lastRow)-1)
		{
			if($("#pcode"+indexs).val()==""&&$("#qty"+indexs).val()=="")
			{
			    //alert(indexc+" continue1");
				continue;
			}
			else
			{
				if(cekoption("pcode"+indexs ,"Memasukkan Kode Barang"))
				if(validateForm("pcode"+indexs,"tmppcode"+indexs,"Kode Barang"))
				if(cekoption("qty"+indexs ,"Memasukkan Jumlah Barang"))
				if(validateForm("qty"+indexs,"tmpqty"+indexs,"Jumlah Barang"))
				//if(cekstring("tersimpan"+indexs ,"konfirmasi per item"))
				{
					InputQty(indexs,'cek');
					//alert(indexc+" continue2");
					continue;
				}
				//alert(indexc+" false1");
				return false;
			}
		}
	}
	return true;
}

function saveItem(id)
{
	if($("#transaksi").val()=="no"){
		$("#transaksi").val("yes");
		no = $("#nodok").val();
		gudang = $("#hiddengudang").val();
		tgl = $("#tgl").val();
		tgljto = $("#tgljto").val();
		sumberMT = $("#hiddensumberMT").val();
      	noorder = $("#hiddennoorder").val();
		sumber = $("#hiddensumber").val();
		keterangan = $("#ket").val();
		kdsupplier = $("#hiddensupplier").val();
		kdgroupext = $("#kdgroupext").val();
		flag = $("#flag").val();	
		pcode = $("#pcode"+id).val();
		extcode = $("#extcode"+id).val();
		qty = $("#qty"+id).val();
		pcodesave = $("#savepcode"+id).val();
		base_url = $("#baseurl").val();
		satuan = $("#satuan"+id).val();
		hargab = $("#hargab"+id).val();
		disc1 = $("#disc1"+id).val();
		disc2 = $("#disc2"+id).val();
		jumlahb = $("#jumlahb"+id).val();
		ppnb = $("#ppnb"+id).val();
		totalb = $("#totalb"+id).val();
		fromPO = $("#fromPO"+id).val();
		konversi = $("#konversi"+id).val();
		satuanst = $("#satuanst"+id).val();
		nilsatuan = $("#nilsatuan"+id).val();
		nilsatuanst = $("#nilsatuanst"+id).val();
		kdkategori = $("#kdkategori"+id).val();
		kdbrand = $("#kdbrand"+id).val();
		jumlah = $("#jumlah").val();
		ppn = $("#ppn").val();
		nilaippn = $("#nilaippn").val();
		pembulatan = $("#pembulatan").val();
		total = $("#total").val();
		top = $("#top").val();
		//alert(gudang);
		//alert(kdsupplier);
		$.post(base_url+"index.php/transaksi/konfirm_terima/save_new_item",{ 
			flag:flag,no:no,tgl:tgl,kdsupplier:kdsupplier,kdgroupext:kdgroupext,ket:keterangan,jumlah:jumlah,total:total,
			gudang:gudang,tgljto:tgljto,sumber:sumber,sumberMT:sumberMT,
			noorder:noorder,pcode:pcode,
			qty:qty,pcodesave:pcodesave,satuan:satuan,extcode:extcode,hargab:hargab,disc1:disc1,disc2:disc2,jumlahb:jumlahb,ppnb:ppnb,
			totalb:totalb,konversi:konversi,satuanst:satuanst,nilsatuan:nilsatuan,nilsatuanst:nilsatuanst,
			kdkategori:kdkategori,kdbrand:kdbrand,jumlah:jumlah,ppn:ppn,total:total,top:top,nilaippn:nilaippn,fromPO:fromPO,pembulatan:pembulatan
		},
		function(data){
		    message = data.substr(0,2);
			if(message=="st")
			   alert(data);
			else
			{
			    if(data!="kosong")
				{
					if(flag=="add")
					{
						$("#nodok").val(data);
						$("#nodokumen").css("display","");
						$("#noorder").attr('disabled', 'disabled');
						$("#gudang").attr('disabled', 'disabled');
						$("#kdsupplier").attr('disabled', 'disabled');
						jQuery("input[name='sumberMT']").each(function(i) {
							jQuery(this).attr('disabled', 'disabled');
						});
					}
					//$('fieldset.disableMe :input').attr('disabled', false);
					$("#savepcode"+id).val($("#pcode"+id).val());
					$("#tersimpan"+id).val("tersimpan");
				}
					
					var lastRow = document.getElementsByName("pcode[]").length-1;
					nama = document.getElementsByName("pcode[]");
					temp = nama[lastRow].id;
					indexs = temp.substr(5,temp.length-5);
					
					if($("#savepcode"+indexs).val()!=""){
						detailNew();
					}
					else
					{
						nama = document.getElementsByName("pcode[]");
						for(index=0;index<lastRow;index++)
						{
							temp1 = nama[index].value;
							if(temp1==pcode)
							   break;
						}
						var id2 = parseFloat(index) + 1;
						temp = nama[id2].id;
						indexs = temp.substr(5,temp.length-5);
						//alert(indexs);
						$("#pcode"+indexs).focus();
					}
			}
			$("#Layer1").css("display","none");
			$("#transaksi").val("no");
		});
	}
}

function AddNew()
{
	var lastRow = document.getElementsByName("pcode[]").length-1;
	nama = document.getElementsByName("pcode[]");
	temp = nama[lastRow].id;
	indexs = temp.substr(5,temp.length-5);
	if(cekDetail(indexs)){
		//saveItem(indexs);
	}
}

function detailNew()
{
	var clonedRow = $("#detail tr:last").clone(true);
	var intCurrentRowId = parseFloat($('#detail tr').length )-2;
	nama = document.getElementsByName("pcode[]");
	temp = nama[intCurrentRowId].id;
	intCurrentRowId = temp.substr(5,temp.length-5);
	var intNewRowId = parseFloat(intCurrentRowId) + 1;
	$("#pcode" + intCurrentRowId , clonedRow ).attr( { "id" : "pcode" + intNewRowId,"value" : ""} );
	$("#pick" + intCurrentRowId , clonedRow ).attr( { "id" : "pick" + intNewRowId} );
	$("#del" + intCurrentRowId , clonedRow ).attr( { "id" : "del" + intNewRowId} );
	$("#nama" + intCurrentRowId , clonedRow ).attr( { "id" : "nama" + intNewRowId,"value" : ""} );
	$("#satuan" + intCurrentRowId , clonedRow ).attr( { "id" : "satuan" + intNewRowId,"value" : ""});
	$("#extcode" + intCurrentRowId , clonedRow ).attr( { "id" : "extcode" + intNewRowId,"value" : ""});
	$("#qty" + intCurrentRowId , clonedRow ).attr( { "id" : "qty" + intNewRowId,"value" : ""} );
	$("#hargab" + intCurrentRowId , clonedRow ).attr( { "id" : "hargab" + intNewRowId,"value" : "0.00"} );
	$("#disc1" + intCurrentRowId , clonedRow ).attr( { "id" : "disc1" + intNewRowId,"value" : "0.00"} );
	$("#disc2" + intCurrentRowId , clonedRow ).attr( { "id" : "disc2" + intNewRowId,"value" : "0.00"} );
	$("#tmphargab" + intCurrentRowId , clonedRow ).attr( { "id" : "tmphargab" + intNewRowId,"value" : ""} );
	$("#jumlahb" + intCurrentRowId , clonedRow ).attr( { "id" : "jumlahb" + intNewRowId,"value" : 0} );
	$("#ppnb" + intCurrentRowId , clonedRow ).attr( { "id" : "ppnb" + intNewRowId,"value" : 0} );
	$("#totalb" + intCurrentRowId , clonedRow ).attr( { "id" : "totalb" + intNewRowId,"value" : 0} );
	$("#tmppcode" + intCurrentRowId , clonedRow ).attr( { "id" : "tmppcode" + intNewRowId,"value" : ""} );
	$("#tmpqty" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpqty" + intNewRowId,"value" : ""} );
	$("#savepcode" + intCurrentRowId , clonedRow ).attr( { "id" : "savepcode" + intNewRowId,"value" : ""} );
	$("#pcodebarang" + intCurrentRowId , clonedRow ).attr( { "id" : "pcodebarang" + intNewRowId,"value" : ""} );
	$("#satuantmp" + intCurrentRowId , clonedRow ).attr( { "id" : "satuantmp" + intNewRowId,"value" : ""} );
	$("#batasharga" + intCurrentRowId , clonedRow ).attr( { "id" : "batasharga" + intNewRowId,"value" : ""} );
	$("#harga0b" + intCurrentRowId , clonedRow ).attr( { "id" : "harga0b" + intNewRowId,"value" : ""} );
	$("#harga1b" + intCurrentRowId , clonedRow ).attr( { "id" : "harga1b" + intNewRowId,"value" : ""} );
	$("#harga2b" + intCurrentRowId , clonedRow ).attr( { "id" : "harga2b" + intNewRowId,"value" : ""} );
	$("#harga3b" + intCurrentRowId , clonedRow ).attr( { "id" : "harga3b" + intNewRowId,"value" : ""} );
	$("#konv0st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv0st" + intNewRowId,"value" : ""} );
	$("#konv1st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv1st" + intNewRowId,"value" : ""} );
	$("#konv2st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv2st" + intNewRowId,"value" : ""} );
	$("#konv3st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv3st" + intNewRowId,"value" : ""} );
	$("#konversi" + intCurrentRowId , clonedRow ).attr( { "id" : "konversi" + intNewRowId,"value" : ""} );
	$("#satuanst" + intCurrentRowId , clonedRow ).attr( { "id" : "satuanst" + intNewRowId,"value" : ""} );
	$("#nilsatuan" + intCurrentRowId , clonedRow ).attr( { "id" : "nilsatuan" + intNewRowId,"value" : ""} );
	$("#nilsatuanst" + intCurrentRowId , clonedRow ).attr( { "id" : "nilsatuanst" + intNewRowId,"value" : ""} );
	$("#kdkategori" + intCurrentRowId , clonedRow ).attr( { "id" : "kdkategori" + intNewRowId,"value" : ""} );
	$("#kdbrand" + intCurrentRowId , clonedRow ).attr( { "id" : "kdbrand" + intNewRowId,"value" : ""} );
	$("#fromPO" + intCurrentRowId , clonedRow ).attr( { "id" : "fromPO" + intNewRowId,"value" : ""} );
	$("#tersimpan" + intCurrentRowId , clonedRow ).attr( { "id" : "tersimpan" + intNewRowId,"value" : ""} );
	$("#detail").append(clonedRow);
	$("#detail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#satuan"+intNewRowId).empty();
	$("#fromPO"+intNewRowId).val(0);
	$("#pcode" + intNewRowId).focus();
}

function deleteRow(obj)
{
	objek = obj.id;
	id = objek.substr(3,objek.length-3);
	pcode = $("#pcode"+id).val();
	var banyakBaris = 1;
	var lastRow = document.getElementsByName("pcode[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("pcode[]");
		temp = nama[index].id;
		indexs = temp.substr(5,temp.length-5);
		if($("#savepcode"+indexs).val()!=""){
			banyakBaris++;
		}
	}
	sumberMT = $("input[@name='sumberMT']:checked").val();
	hiddenorder = $("#hiddennoorder").val();
	if(sumberMT=="T"  && hiddenorder!="")
	{
	    alert("Tidak dapat menghapus detail konfirmasi dari penerimaan barang.");
	}
	else if($("#savepcode"+id).val()==""){
		$('#baris'+id).remove();
	}
	else if($("#savepcode"+id).val()==""&&banyakBaris==1){
		alert("Baris ini tidak dapat dihapus\nMinimal harus ada 1 baris");
	}
	else{
		if(banyakBaris==2)
		{
			alert("Baris ini tidak dapat dihapus\nMinimal harus ada 1 baris tersimpan");
		}
		else
		{
			no = $("#nodok").val();
			objek = obj.id;
			id = objek.substr(3,objek.length-3);
			pcode = $("#pcode"+id).val();
			if(pcode!=""){
				var r=confirm("Apakah Anda Ingin Menghapus Kode Barang "+pcode+" ?");
				if(r==true){
					$('#baris'+id).remove();
					if(no!=""){
						deleteItem(pcode);
					}
				}
			}
		}
	}
}

function deleteItem(pcode)
{
	if($("#transaksi").val()=="no"){
	    totalNetto();
		no = $("#nodok").val();
		sumberMT = $("#hiddensumberMT").val();
      	noorder = $("#hiddennoorder").val();
		gudang = $("#gudang").val();
		jumlah = $("#jumlah").val();
		ppn = $("#ppn").val();
		nilaippn = $("#nilaippn").val();
		pembulatan = $("#pembulatan").val();
		total = $("#total").val();
		$("#transaksi").val("yes");
		base_url = $("#baseurl").val();
		$.post(base_url+"index.php/transaksi/konfirm_terima/delete_item",{ 
			no:no,sumberMT:sumberMT,noorder:noorder,pcode:pcode,gudang:gudang,jumlah:jumlah,ppn:ppn,nilaippn:nilaippn,total:total,pembulatan:pembulatan},
		function(data){
			$("#transaksi").val("no");
		});
	}
}

function totalNetto()
{
	var lastRow = document.getElementsByName("totalb[]").length;
	var total = 0;
	var jumlah = 0;
	for(index=0;index<lastRow;index++)
	{
		indexs = index-1; 
		nama = document.getElementsByName("totalb[]");
		temp = nama[index].id;
		temp1 = parseFloat(nama[index].value);
		total += temp1;
		nama = document.getElementsByName("jumlahb[]");
		temp = nama[index].id;
		temp1 = parseFloat(nama[index].value);
		jumlah += temp1;
	}
	//alert(total);
	//total = number_format(total, 0, ',', '.');
	ppn = parseFloat($("#ppn").val());
	pembulatan = parseFloat($("#pembulatan").val());
    $("#jumlah").val(jumlah);
	$("#total").val(Math.round(total-pembulatan));
	$("#nilaippn").val(Math.round(total-jumlah));
}

function hitungPPN()
{
	jumlah = parseFloat($("#jumlah").val());
	total = parseFloat($("#total").val());
	ppn = parseFloat($("#ppn").val());
	$("#nilaippn").val(total-jumlah);				
}
