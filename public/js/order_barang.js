function loading()
{
	base_url = $("#baseurl").val();
	bulan = $("#bulan").val();
	tahun = $("#tahun").val();
    var minDate = new Date(tahun,bulan-1,01); //one day next before month
    var maxDate =  new Date(tahun,bulan,0); //one day before next month
//	$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,maxDate: maxDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
//	$('#tglkirim').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
	$('#tgl').Zebra_DatePicker({ format: 'd-m-Y' });
   $('#tglkirim').Zebra_DatePicker({ format: 'd-m-Y' });
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
		base_url = $("#baseurl").val();
		if(flag=='pcode'){
		    id = parseFloat(objek.substr(5,objek.length-5));
		    findPCode(id);
		}
		else if(flag=='satuan'){
			id = parseFloat(objek.substr(6,objek.length-6));
			$("#qty"+id).focus();
		}
		else if(flag=='qty'){
			id = parseFloat(objek.substr(3,objek.length-3));
			InputQty(id,'enter');
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
        else if(flag=='potongan'){
            id = parseFloat(objek.substr(8,objek.length-8));
            InputDisc2(id,'enter');
        }
		else if(flag=='ppnb'){
			id = parseFloat(objek.substr(4,objek.length-4));
			InputPPn(id,'enter');
		}
		else if(flag=='supplier'){
			findSupplier();
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
			$.post(base_url+"index.php/transaksi/order_barang/getSupplier",{ kdsupplier:kdsupplier },
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
						//alert(result[5]);
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

function storeSatuan(obj)
{
	objek = obj.id;
	id = parseFloat(objek.substr(6,objek.length-6));
	//alert(id);
	//alert($("#satuan"+id).val());
	//alert($("#satuantmp"+id).val());
	if($("#satuan"+id).val()!=""){
		$("#satuantmp"+id).val($("#satuan"+id).val());  //wieok
		idp = $("#satuan"+id).val().substr(0,1);
		$("#hargab"+id).val($("#harga"+idp+"b"+id).val());
		$("#tmphargab"+id).val($("#harga"+idp+"b"+id).val());
		$("#konversi"+id).val($("#konv"+idp+"st"+id).val());
		$("#nilsatuan"+id).val($("#satuan"+id+" option:selected").text());
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

function simpankdsupplier()
{
	kdsupplier = $("#kdsupplier").val();
	$("#hidesupplier").val(kdsupplier);
	resetRow(1);
	$("#ket").focus();
	$("#pcode1").val("");
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
		url = base_url+"index.php/pop/barangbeli/index/"+pcode+"/"+id+"/"+kdgroupext+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
}

function findPCode(id)
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
					kdgroupext = $("#kdgroupext").val();
					$.post(base_url+"index.php/transaksi/order_barang/getPCode",{pcode:pcode,kdgroupext:kdgroupext},
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
								$("#jumlahb"+id).val(result[5]);
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
								$("#satuan"+id).append("<option selected='selected' value='0'>--> pilih <--</option>"); //wieok
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

function resetRow(id)
{
	$("#pcode"+id).val("");
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
	$("#pcode"+id).focus();
}

function ClearBaris(id)
{
	//alert(id);
	$("#pcode"+id).focus();
	$("#tmppcode"+id).val("");
	$("#pcode"+id).val("");
	$("#nama"+id).val("");
	$("#extcode"+id).val("");
	$("#hargab"+id).val("");
	$("#disc1"+id).val("");
    $("#disc2"+id).val("");
    $("#potongan"+id).val("");
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
                    potongan = Number($("#potongan"+id).val());
                    jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100) - potongan;
					//jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
					
					$("#jumlahb"+id).val(jumlahb);
					ppn = Number($("#ppn").val());
					ppnb = Number($("#ppnb"+id).val());
					ppnhitung = Number(ppnb/100*jumlahb);
					$("#totalb"+id).val(jumlahb+ppnhitung);
					$("#tmphargab"+id).val($("#hargab"+id).val());
					totalNetto();
					$("#hargab"+id).focus();
					hitungTotal();
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
				if(cekAngka("hargab"+id,"Harga","no zero","no minus"))
				{
					harga = Number($("#hargab"+id).val());
					qty = Number($("#qty"+id).val());
					disc1 = Number($("#disc1"+id).val());
					disc2 = Number($("#disc2"+id).val());
                    potongan = Number($("#potongan"+id).val());
                    jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100) - potongan;
					//jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
					$("#jumlahb"+id).val(jumlahb);
					ppn = Number($("#ppn").val());
					ppnb = Number($("#ppnb"+id).val());
					ppnhitung = (ppnb/100*jumlahb);
					$("#totalb"+id).val(jumlahb+ppnhitung);
					$("#tmphargab"+id).val($("#hargab"+id).val());
					totalNetto();
					$("#disc1"+id).focus();
					hitungTotal();
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
        potongan = Number($("#potongan"+id).val());
        jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100) - potongan;
		//jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
		$("#jumlahb"+id).val(jumlahb);
		ppn = Number($("#ppn").val());
		ppnb = Number($("#ppnb"+id).val());
		ppnhitung = ppnb/100*jumlahb;
		$("#totalb"+id).val(jumlahb+ppnhitung);
		$("#tmphargab"+id).val($("#hargab"+id).val());
		totalNetto();
		$("#disc2"+id).focus();
		hitungTotal();
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
        potongan = Number($("#potongan"+id).val());
        jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100) - potongan;
		//jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
		$("#jumlahb"+id).val(jumlahb);
		ppn = Number($("#ppn").val());
		ppnb = Number($("#ppnb"+id).val());
		ppnhitung = ppnb/100*jumlahb;
		$("#totalb"+id).val(jumlahb+ppnhitung);
		$("#tmphargab"+id).val($("#hargab"+id).val());
		totalNetto();
		totalb = $("#totalb"+id).val();
		batas = $("#batasharga"+id).val();
		$("#ppnb"+id).focus();
		hitungTotal();
	}
	else
	{
		resetRow(id);
		$("#pcode"+id).focus();
	}
}
function potongan(id,from)
{
    if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
    {
        harga = Number($("#hargab"+id).val());
        qty = Number($("#qty"+id).val());
        disc1 = Number($("#disc1"+id).val());
        disc2 = Number($("#disc2"+id).val());
        potongan = Number($("#potongan"+id).val());
        jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100) - potongan;
        $("#jumlahb"+id).val(jumlahb);
        ppn = Number($("#ppn").val());
        ppnb = Number($("#ppnb"+id).val());
        ppnhitung = ppnb/100*jumlahb;
        $("#totalb"+id).val(jumlahb+ppnhitung);
        $("#tmphargab"+id).val($("#hargab"+id).val());
        totalNetto();
        totalb = $("#totalb"+id).val();
        batas = $("#batasharga"+id).val();
        $("#ppnb"+id).focus();
        hitungTotal();
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
		qty 	= Number($("#qty"+id).val());
		disc1 = Number($("#disc1"+id).val());
		disc2 = Number($("#disc2"+id).val());
        potongan = Number($("#potongan"+id).val());
        jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100) - potongan;
		//jumlahb = Number(qty*harga*(100-disc1)/100*(100-disc2)/100);
		$("#jumlahb"+id).val(jumlahb);
		ppn = Number($("#ppn").val());
		ppnb = Number($("#ppnb"+id).val());
		ppnhitung = (ppnb)/100*jumlahb;
		$("#totalb"+id).val(jumlahb+ppnhitung);
		$("#tmphargab"+id).val($("#hargab"+id).val());
		totalNetto();
		totalb = $("#totalb"+id).val();
		batas = $("#batasharga"+id).val();
		hitungTotal();
	}
	else
	{
		resetRow(id);
		$("#pcode"+id).focus();
	}
}

function hitungTotal() {
	banyakBaris = 0;
	var lastRow = document.getElementsByName("pcode[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("pcode[]");
		temp = nama[index].id;
		indexs = temp.substr(5,temp.length-5);
		banyakBaris = banyakBaris + 1;
	}
	jml = 0;
		ppn = 0;
	
	for (brs=1;brs < (banyakBaris + 1);brs++) {
		if(isNaN($("#jumlahb"+brs).val())){
			jml = jml + 0;
			ppn = ppn + 0;
		}else{
			jml = jml + Number($("#jumlahb"+brs).val());
			ppn = ppn + ((Number($("#jumlahb"+brs).val()))/100*(Number($("#ppnb"+brs).val())));
		}
	}	
	$("#jumlah").val(jml);
	$("#nilaippn").val(ppn);
	$("#total").val( jml + ppn );
}

function saveThis(id)
{
	if(cekheader())
	if(cekDetail(id)){
		$("#Layer1").css("display","");
		$('fieldset.disableMe :input').attr('disabled', true);
		//saveItem(id);
	}
}

function saveAll()
{
	if(cekheader())
	if(cekDetailAll()){
		//alert("A");
		document.getElementById("order").submit();
		//$("#order").submit();
	}
}

function cekheader()
{
	return true;
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
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("pcode[]");
		temp = nama[index].id;
		indexs = temp.substr(5,temp.length-5);
		if(index<parseFloat(lastRow)-1||index==0){
			if(cekoption("pcode"+indexs ,"Memasukkan Kode Barang"))
			if(validateForm("pcode"+indexs,"tmppcode"+indexs,"Kode Barang"))
			if(cekoption("qty"+indexs ,"Memasukkan Jumlah Barang"))
			if(validateForm("qty"+indexs,"tmpqty"+indexs,"Jumlah Barang"))
			{
				InputQty(indexs,'cek');
				continue;
			}
			return false;
		}
		else if(index==parseFloat(lastRow)-1)
		{
			if($("#pcode"+indexs).val()==""&&$("#qty"+indexs).val()=="")
			{
				continue;
			}
			else
			{
				if(cekoption("pcode"+indexs ,"Memasukkan Kode Barang"))
				if(validateForm("pcode"+indexs,"tmppcode"+indexs,"Kode Barang"))
				if(cekoption("qty"+indexs ,"Memasukkan Jumlah Barang"))
				if(validateForm("qty"+indexs,"tmpqty"+indexs,"Jumlah Barang"))
				{
					InputQty(indexs,'cek');
					continue;
				}
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
		tgl = $("#tgl").val();
		tglkirim = $("#tglkirim").val();
		kdsupplier = $("#kdsupplier").val();
		kdgroupext = $("#kdgroupext").val();
		gudang = $("#gudang").val();
		sumber = $("#hiddensumber").val();
		top = $("#top").val();
		keterangan = $("#ket").val();
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
		konversi = $("#konversi"+id).val();
		satuanst = $("#satuanst"+id).val();
		nilsatuan = $("#nilsatuan"+id).val();
		nilsatuanst = $("#nilsatuanst"+id).val();
		kdkategori = $("#kdkategori"+id).val();
		kdbrand = $("#kdbrand"+id).val();
		jumlah = $("#jumlah").val();
		ppn = $("#ppn").val();
		nilaippn = $("#nilaippn").val();
		total = $("#total").val();
		//alert(qtypcs);
		$.post(base_url+"index.php/transaksi/order_barang/save_new_item",{ 
			flag:flag,no:no,gudang:gudang,kdsupplier:kdsupplier,tgl:tgl,tglkirim:tglkirim,sumber:sumber,top:top,ket:keterangan,pcode:pcode,extcode:extcode,
			qty:qty,satuan:satuan,disc1:disc1,disc2:disc2,hargab:hargab,jumlahb:jumlahb,ppnb:ppnb,totalb:totalb,
			pcodesave:pcodesave,konversi:konversi,satuanst:satuanst,
			nilsatuan:nilsatuan,nilsatuanst:nilsatuanst,kdkategori:kdkategori,kdbrand:kdbrand,
			jumlah:jumlah,ppn:ppn,total:total,nilaippn:nilaippn,kdgroupext:kdgroupext
		},
		function(data){
		    //alert(data);
			if(flag=="add")
			{
				$("#nodok").val(data);
				$("#nodokumen").css("display","");
			}
			$("#savepcode"+id).val($("#pcode"+id).val());
			$('fieldset.disableMe :input').attr('disabled', false);
			var lastRow = document.getElementsByName("pcode[]").length-1;
			nama = document.getElementsByName("pcode[]");
			temp = nama[lastRow].id;
			indexs = temp.substr(5,temp.length-5);
			//$("#kdsupplier").attr("disabled",true);
			if($("#savepcode"+indexs).val()!=""){
				detailNew();
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
		saveItem(indexs);
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
	$("#hargab" + intCurrentRowId , clonedRow ).attr( { "id" : "hargab" + intNewRowId,"value" : ""} );
	$("#disc1" + intCurrentRowId , clonedRow ).attr( { "id" : "disc1" + intNewRowId,"value" : "0"} );
	$("#disc2" + intCurrentRowId , clonedRow ).attr( { "id" : "disc2" + intNewRowId,"value" : "0"} );
    $("#potongan" + intCurrentRowId , clonedRow ).attr( { "id" : "potongan" + intNewRowId,"value" : "0"} );
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
	$("#konv0st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv0st" + intNewRowId,"value" : ""} ); //wieok
	$("#konv1st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv1st" + intNewRowId,"value" : ""} );
	$("#konv2st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv2st" + intNewRowId,"value" : ""} );
	$("#konv3st" + intCurrentRowId , clonedRow ).attr( { "id" : "konv3st" + intNewRowId,"value" : ""} );
	$("#konversi" + intCurrentRowId , clonedRow ).attr( { "id" : "konversi" + intNewRowId,"value" : ""} );
	$("#satuanst" + intCurrentRowId , clonedRow ).attr( { "id" : "satuanst" + intNewRowId,"value" : ""} );
	$("#nilsatuan" + intCurrentRowId , clonedRow ).attr( { "id" : "nilsatuan" + intNewRowId,"value" : ""} );
	$("#nilsatuanst" + intCurrentRowId , clonedRow ).attr( { "id" : "nilsatuanst" + intNewRowId,"value" : ""} );
	$("#kdkategori" + intCurrentRowId , clonedRow ).attr( { "id" : "kdkategori" + intNewRowId,"value" : ""} );
	$("#kdbrand" + intCurrentRowId , clonedRow ).attr( { "id" : "kdbrand" + intNewRowId,"value" : ""} );
	$("#detail").append(clonedRow);
	$("#detail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#pcode" + intNewRowId).focus();
		ClearBaris(intNewRowId);
}

function deleteRow(obj)
{
	objek = obj.id;
	id = objek.substr(3,objek.length-3);
	
	var lastRow = document.getElementsByName("pcode[]").length;
	
	if( lastRow > 1)
	{
		$('#baris'+id).remove();
		hitungTotal();
	}else{
			alert("Baris ini tidak dapat dihapus\nMinimal harus ada 1 baris tersimpan");
	}
}

function deleteItem(pcode)
{
	if($("#transaksi").val()=="no"){
	   totalNetto();
		no = $("#nodok").val();
		$("#transaksi").val("yes");
		base_url = $("#baseurl").val();
		jumlah = $("#jumlah").val();
		ppn = $("#ppn").val();
		nilaippn = $("#nilaippn").val();
		total = $("#total").val();
		$.post(base_url+"index.php/transaksi/order_barang/delete_item",{ 
			no:no,pcode:pcode,jumlah:jumlah,nilaippn:nilaippn,ppn:ppn,total:total},
		function(data){
			$("#transaksi").val("no");
		});
	}
}

function totalNetto()
{
/*	var lastRow = document.getElementsByName("totalb[]").length;
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
   $("#jumlah").val(Math.round(jumlah));
	$("#total").val(Math.round(total));
	$("#nilaippn").val(Math.round(total-jumlah));*/
	banyakBaris = 0;
	var lastRow = document.getElementsByName("pcode[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("pcode[]");
		temp = nama[index].id;
		indexs = temp.substr(5,temp.length-5);
		banyakBaris = banyakBaris + 1;
	}
	//alert(banyakBaris);
	jml = 0;
	ppn = 0;
	//ttl = 0;
	
	for (brs=1;brs < (banyakBaris + 1);brs++) {
		jml = jml + Number($("#jumlahb"+brs).val());
		ppn = ppn + ((Number($("#jumlahb"+brs).val()))/100*(Number($("#ppnb"+brs).val())));
		//ttl = ((Number($("#jumlahb"+brs).val()))/100*(Number($("#ppnb"+brs).val()))) + Number($("#jumlahb"+brs).val());
	}	
	$("#jumlah").val(Math.round(jml));
	$("#nilaippn").val(Math.round(ppn));
	$("#total").val(Math.round( jml + ppn) );
}

function hitungPPN()
{
	jumlah = parseFloat($("#jumlah").val());
	total = parseFloat($("#total").val());
	ppn = parseFloat($("#ppn").val());
	$("#nilaippn").val(total-jumlah);				
}

function pickSupplier()
{
	base_url = $("#baseurl").val();
	//with1 = $("#kdsupplier").val();
	url = base_url+"index.php/pop/supplier/index/orderbarang/";
	window.open(url,'popuppage','scrollbars=yes,width=550,height=500,top=180,left=150');
}

function ubahpayment()
{
	sumber=	document.querySelector('input[name="sumber"]:checked').value;
	//sumber = $("input[@name='sumber']:checked").val();
	//alert(sumber);
	$("#hiddensumber").val(sumber);
	if(sumber=="C")
	{
	$("#top").attr("disabled", "disabled");
	$("#top").val("0");
	}
    else
	$("#top").removeAttr("disabled");
	//$("#top").attr("disabled", "");
}