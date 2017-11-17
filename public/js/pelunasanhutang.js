function loading()
{
	base_url = $("#baseurl").val();
	bulan = $("#bulan").val();
	tahun = $("#tahun").val();
    var minDate = new Date(tahun,bulan-1,01); //one day next before month
    var maxDate =  new Date(tahun,bulan,0); //one day before next month
	$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,maxDate: maxDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
	$('#tglcair').datepicker({ dateFormat: 'dd-mm-yyyy',mandatory: true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly: true } );
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
		if(flag=='kdrekening'){
			id = parseFloat(objek.substr(10,objek.length-10));
			findkdrekening(id);
		}
		else if(flag=='nobukti'){
			id = parseFloat(objek.substr(7,objek.length-7));
			findnobukti(id);
		}
		else if(flag=='jumlah'){
			id = parseFloat(objek.substr(6,objek.length-6));
			InputJumlah(id,'enter');
		}
		else if(flag=='discount'){
			id = parseFloat(objek.substr(8,objek.length-8));
			InputDiscount(id,'enter');
		}
		else if(flag=='biaya'){
			id = parseFloat(objek.substr(5,objek.length-5));
			InputBiaya(id,'enter');
		}
		else if(flag=='keterangan'){
			id = parseFloat(objek.substr(10,objek.length-10));
			InputKeterangan(id,'enter');
		}
	}
}

function pickSupplier()
{
	base_url = $("#baseurl").val();
	with1 = $("#kdsupplier").val();
	url = base_url+"index.php/pop/supplier/index/order/"+with1;
	window.open(url,'popuppage','scrollbars=yes,width=550,height=500,top=180,left=150');
	//cektop();
}

function simpanKasBank()
{
    $("#hidekasbank").val($("#kasbank").val());
	$("#costcenter").focus();
}

function simpanBankCair()
{
	$("#tglcair").focus();
}

function simpanCostCenter()
{
    $("#hidecostcenter").val($("#costcenter").val());
	$("#personal").focus();
}

function simpanPersonal()
{
    $("#hidepersonal").val($("#personal").val());
	$("#nogiro").focus();
}

function pickThis(obj)
{
	if(cekheader())
	{
		base_url = $("#baseurl").val();
		objek = obj.id;
		id = parseFloat(objek.substr(4,objek.length-4));
		url = base_url+"index.php/pop/rekening/index/"+id+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
	}
}

function pickNomor()
{
	base_url = $("#baseurl").val();
	nomor = $("#noreturcndn").val();
	kdsupplier = $("#kdsupplier").val();
	if(nomor=="")
	   nomor = '1234567890';
	url = base_url+"index.php/pop/nobukti/index/C0/"+nomor+"/"+kdsupplier+"/";
	window.open(url,'popuppage','scrollbars=yes,width=750,height=500,top=180,left=150');
}

function pick2This(obj)
{
	if(cekheader())
	{
		base_url = $("#baseurl").val();
		objek = obj.id;
		id = parseFloat(objek.substr(5,objek.length-5));
		nomor = $("#nobukti"+id).val();
		kdsupplier = $("#kdsupplier").val();
		if(nomor=="")
	       nomor = '1234567890';
		if($("#itemjenis"+id).val()=='2')
		{
		url = base_url+"index.php/pop/nobukti/index/H"+id+"/"+nomor+"/"+kdsupplier+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
		}else
		{
		   alert("Jenis umum tidak bisa browse nomor bukti");
		}
	}
}

function findnobukti(id)
{
	if(cekheader())
	{
		if(cekoption("nobukti"+id,"Memasukkan Nomor Bukti")){
		    base_url = $("#baseurl").val();
			nobukti = $("#nobukti"+id).val();
			if($("#itemjenis"+id).val()=='2')
			{
				$.post(base_url+"index.php/transaksi/pelunasanhutang/getnobukti",{ nobukti:nobukti },
				function(data){
					if(data!=""){
						result = data.split('*-*');
						nobukti = result[0];
						sisa = result[1];
						rekening = result[2];
						nama = result[3];
						var lastRow = document.getElementsByName("nobukti[]").length;
						var dobel = false;
						for(index=0;index<lastRow;index++){
							nama = document.getElementsByName("nobukti[]");
							temp = nama[index].id;
							indexs = temp.substr(7,temp.length-7);
							if($("#tmpnobukti"+indexs).val()==nobukti)
							{
								if(index==lastRow-1||indexs==id){
									continue;
								}
								else{
									//dobel = true;
									//break;
								}
							}
						}
						if(!dobel){
							$("#nobukti"+id).val(result[0]);
							$("#tmpnobukti"+id).val(result[0]);
							$("#nama"+id).val(result[3]);
							$("#kdrekening"+id).val(result[2]);
							$("#tmpkdrekening"+id).val(result[2]);
							$("#hutang"+id).val(result[1]);
							$("#jumlah"+id).val(result[1]);
							$("#kdrekening"+id).focus();
						}
						else
						{
							alert("Nomor Bukti Sudah Ada");
							resetRow(id);
							$("#nobukti"+id).focus();
						}
					}
					else
					{
						alert("Data Tidak Ditemukan");
						resetRow(id);
						$("#nobukti"+id).focus();
					}
				});
			}else
			{
			   $("#nama"+id).val("=======");
			   $("#tmpnobukti"+id).val(nobukti);
			   $("#kdrekening"+id).focus();
			}
		}
		else
		{
			resetRow(id);
			$("#nobukti"+id).focus();
		}
	}
}

function findkdrekening(id)
{
	if(cekheader())
	{
		if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening")){
			base_url = $("#baseurl").val();
			kdrekening = $("#kdrekening"+id).val();
			$.post(base_url+"index.php/transaksi/pelunasanhutang/getkdrekening",{ kdrekening:kdrekening},
			function(data){
				if(data!=""){
				    result = data.split('*-*');
					kode = result[0];
					nama = result[1];
					var lastRow = document.getElementsByName("kdrekening[]").length;
					var dobel = false;
					for(index=0;index<lastRow;index++){
						nama = document.getElementsByName("kdrekening[]");
						temp = nama[index].id;
						indexs = temp.substr(10,temp.length-10);
						if($("#tmpkdrekening"+indexs).val()==kode)
						{
							if(index==lastRow-1||indexs==id){
								continue;
							}
							else{
								//dobel = true;
								//break;
							}
						}
					}
					if(!dobel){
						$("#kdrekening"+id).val(result[0]);
						$("#namarekening"+id).val(result[1]);
						$("#tmpkdrekening"+id).val(result[0]);
						$("#jumlah"+id).focus();
					}
					else
					{
						alert("Kode Rekening Sudah Ada");
						resetRow(id);
						$("#kdrekening"+id).focus();
					}
				}
				else
				{
					alert("Data Tidak Ditemukan");
					resetRow(id);
					$("#kdrekening"+id).focus();
				}
			});
		}
		else
		{
			resetRow(id);
			$("#kdrekening"+id).focus();
		}
	}
}

function resetRow(id)
{
	$("#nobukti"+id).focus();
	$("#itemjenis"+id).val("1");
	$("#tmpnobukti"+id).val("");
	$("#nama"+id).val("");
	$("#kdrekening"+id).val("");
	$("#namarekening"+id).val("");
	$("#hutang"+id).val(0);
	$("#jumlah"+id).val(0);
	$("#discount"+id).val(0);
	$("#biaya"+id).val(0);
	$("#keterangan"+id).val("");
	$("#tmpkdrekening"+id).val("");
	$("#tmpjumlah"+id).val(0);
	$("#tmpdiscount"+id).val(0);
	$("#tmpbiaya"+id).val(0);
}


function InputJumlah(id,from)
{
	if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening"))
	{
		if(validateForm("kdrekening"+id,"tmpkdrekening"+id,"Kode Rekening")){

			if(cekAngka("jumlah"+id,"Jumlah","no zero","no minus"))
			{
			    
				//alert($("#jumlah"+id).val());
			    angka = bulatkan( $("#jumlah"+id).val(), 2 );
				
				//alert(angka);
				$("#jumlah"+id).val(angka);
			    $("#jumlahpayment").val(totalNetto());
				
				hutang = $("#hutang"+id).val();
				jumlah = $("#jumlah"+id).val();
				jumlahpayment = $("#jumlahpayment").val();
				sisa = $("#sisaretur").val();
				if(jumlahpayment>sisa)
				{
			       alert("Total pembayaran tidak boleh lebih besar dari sisa retur");
				   $("#jumlah"+id).focus();
				}else if(jumlah>hutang)
				{
			       alert("Total pembayaran tidak boleh lebih besar dari sisa hutang");
				   $("#jumlah"+id).focus();
				}else
				   $("#keterangan"+id).focus();
			}
		}
	}
	else
	{
		resetRow(id);
		$("#nobukti"+id).focus();
	}
}

function InputDiscount(id,from)
{
	if(cekoption("nobukti"+id,"Memasukkan Nomor Bukti"))
	{
		if(validateForm("nobukti"+id,"tmpnobukti"+id,"Nomor Bukti")){
			    angka = bulatkan( $("#discount"+id).val(), 2 );
				//alert(angka);
				$("#discount"+id).val(angka)
				if($("#itemjenis"+id).val()=='2')
				   $("#biaya"+id).focus();
				else
				   $("#keterangan"+id).focus();
		}
	}
	else
	{
		resetRow(id);
		$("#nobukti"+id).focus();
	}
}

function InputBiaya(id,from)
{
	if(cekoption("nobukti"+id,"Memasukkan Nomor Bukti"))
	{
		if(validateForm("nobukti"+id,"tmpnobukti"+id,"Nomor Bukti")){

			    angka = bulatkan( $("#biaya"+id).val(), 2 );
				//alert(angka);
				$("#biaya"+id).val(angka)
				$("#keterangan"+id).focus();
		}
	}
	else
	{
		resetRow(id);
		$("#nobukti"+id).focus();
	}
}

function InputKeterangan(id,from)
{
	if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening"))
	{
		if(validateForm("kdrekening"+id,"tmpkdrekening"+id,"Kode Rekening")){
			if(cekoption("keterangan"+id,"Isi Keterangan"))
			{
				if(from=="enter"){
				   $("#jumlahpayment").val(totalNetto());
				   saveThis(id);
				}
			}
		}
	}
	else
	{
		resetRow(id);
		$("#nobukti"+id).focus();
	}
}

function saveThis(id)
{
	if(cekheader())
	if(cekDetail(id)){
		$("#Layer1").css("display","");
		$('fieldset.disableMe :input').attr('disabled', true);
		saveItem(id);
	}
}

function saveAll()
{
	if(cekheader())
	if(cekDetailAll()){
		$("#pelunasanhutang").submit();
	}
}

function cekheader()
{
	if(cekoption("kdsupplier","Memilih Supplier"))
    {
	      if($("#noreturcndn").val()=='')
		  {
		     alert("Nomor return/cn/dn harus diisi");
			 return false;
		  }
		  else 
		     return true;
	}
	return false;
}

function cekDetail(id)
{
    if(cekoption("nobukti"+id,"Memasukkan Nomor Bukti"))
	if(validateForm("nobukti"+id,"tmpnobukti"+id,"Nomor Bukti"))
	if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening"))
	if(validateForm("kdrekening"+id,"tmpkdrekening"+id,"Kode Rekening"))
	if(cekoption("jumlah"+id,"Memasukkan Jumlah Rupiah"))
		return true;
	return false;
}

function cekDetailAll()
{
	var lastRow = document.getElementsByName("kdrekening[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("kdrekening[]");
		temp = nama[index].id;
		indexs = temp.substr(10,temp.length-10);
		if(index<parseFloat(lastRow)-1||index==0){
		    if(cekoption("nobukti"+indexs ,"Memasukkan Nomor Bukti"))
			if(validateForm("nobukti"+indexs,"tmpnobukti"+indexs,"Nomor Bukti"))
			if(cekoption("kdrekening"+indexs ,"Memasukkan Kode Rekening"))
			if(validateForm("kdrekening"+indexs,"tmpkdrekening"+indexs,"Kode Rekening"))
			if(cekoption("jumlah"+indexs ,"Memasukkan Jumlah Rupiah"))
			{
				InputJumlah(indexs,'cek');
				continue;
			}
			return false;
		}
		else if(index==parseFloat(lastRow)-1)
		{
			if($("#kdrekening"+indexs).val()==""&&$("#jumlah"+indexs).val()=="")
			{
				continue;
			}
			else
			{
			    if(cekoption("nobukti"+indexs ,"Memasukkan Nomor Bukti"))
			    if(validateForm("nobukti"+indexs,"tmpnobukti"+indexs,"Nomor Bukti"))
				if(cekoption("kdrekening"+indexs ,"Memasukkan Kode Rekening"))
				if(validateForm("kdrekening"+indexs,"tmpkdrekening"+indexs,"Kode Rekening"))
				if(cekoption("jumlah"+indexs ,"Memasukkan Jumlah Rupiah"))
				{
					InputJumlah(indexs,'cek');
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
		jenis = $("#jenis").val();
		kdsupplier = $("#hiddensupplier").val();
		noreturcndn = $("#hiddennoreturcndn").val();
		tglretur = $("#tglretur").val();
		jumlahretur = $("#jumlahretur").val();
		sisaretur = $("#sisaretur").val();
		ket = $("#ket").val();
		flag = $("#flag").val();
		itemjenis = $("#itemjenis"+id).val();
		nobukti = $("#nobukti"+id).val();
		savenobukti = $("#savenobukti"+id).val(); 
		nama = $("#nama"+id).val(); 
		kdrekening = $("#kdrekening"+id).val();
		savekdrekening = $("#savekdrekening"+id).val(); 
		hutang = $("#hutang"+id).val();
		jumlah = $("#jumlah"+id).val();
		keterangan = $("#keterangan"+id).val();
		urutan = $("#urutan"+id).val(); 
		jumlahpayment = $("#jumlahpayment").val(); 
		base_url = $("#baseurl").val();
		$.post(base_url+"index.php/transaksi/pelunasanhutang/save_new_item",{ 
			flag:flag,no:no,tgl:tgl,jenis:jenis,ket:ket,jumlah:jumlah,keterangan:keterangan,
			jumlahretur:jumlahretur,sisaretur:sisaretur,
			kdsupplier:kdsupplier,noreturcndn:noreturcndn,tglretur:tglretur,
			kdrekening:kdrekening,savekdrekening:savekdrekening,jumlahpayment:jumlahpayment,
			urutan:urutan,itemjenis:itemjenis,nobukti:nobukti,hutang:hutang,nama:nama
		},
		function(data){
		    //alert(data);
			if(flag=="add")
			{
				$("#nodok").val(data);
				$("#nodokumen").css("display","");
			}
			$("#nogiro").attr({"readonly":"readonly"})
			$("#savenobukti"+id).val($("#nobukti"+id).val());
			$("#savekdrekening"+id).val($("#kdrekening"+id).val());
			$('fieldset.disableMe :input').attr('disabled', false);
			var lastRow = document.getElementsByName("kdrekening[]").length-1;
			nama = document.getElementsByName("kdrekening[]");
			temp = nama[lastRow].id;
			indexs = temp.substr(10,temp.length-10);
			$("#kontak").attr("disabled",true);
			if($("#savekdrekening"+indexs).val()!=""){
				detailNew();
			}
			$("#Layer1").css("display","none");
			$("#transaksi").val("no");
		});
	}
}

function detailNew()
{
	var clonedRow = $("#detail tr:last").clone(true);
	var intCurrentRowId = parseFloat($('#detail tr').length )-2;
	nama = document.getElementsByName("kdrekening[]");
	temp = nama[intCurrentRowId].id;
	intCurrentRowId = temp.substr(10,temp.length-10);
	var intNewRowId = parseFloat(intCurrentRowId) + 1;
	$("#itemjenis" + intCurrentRowId , clonedRow ).attr( { "id" : "itemjenis" + intNewRowId,"value" : "1"} );
	$("#nobukti" + intCurrentRowId , clonedRow ).attr( { "id" : "nobukti" + intNewRowId,"value" : ""} );
	$("#pick2" + intCurrentRowId , clonedRow ).attr( { "id" : "pick2" + intNewRowId} );
	$("#nama" + intCurrentRowId , clonedRow ).attr( { "id" : "nama" + intNewRowId,"value" : ""} );
	$("#kdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "kdrekening" + intNewRowId,"value" : ""} );
	$("#pick" + intCurrentRowId , clonedRow ).attr( { "id" : "pick" + intNewRowId} );
	$("#del" + intCurrentRowId , clonedRow ).attr( { "id" : "del" + intNewRowId} );
	$("#namarekening" + intCurrentRowId , clonedRow ).attr( { "id" : "namarekening" + intNewRowId,"value" : ""} );
	$("#hutang" + intCurrentRowId , clonedRow ).attr( { "id" : "hutang" + intNewRowId,"value" : 0} );
	$("#jumlah" + intCurrentRowId , clonedRow ).attr( { "id" : "jumlah" + intNewRowId,"value" : 0} );
	$("#discount" + intCurrentRowId , clonedRow ).attr( { "id" : "discount" + intNewRowId,"value" : 0} );
	$("#biaya" + intCurrentRowId , clonedRow ).attr( { "id" : "biaya" + intNewRowId,"value" : 0} );
	$("#keterangan" + intCurrentRowId , clonedRow ).attr( { "id" : "keterangan" + intNewRowId,"value" : ""} );
	$("#tmpnobukti" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpnobukti" + intNewRowId,"value" : ""} );	
	$("#savenobukti" + intCurrentRowId , clonedRow ).attr( { "id" : "savenobukti" + intNewRowId,"value" : ""} );
	$("#tmpkdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpkdrekening" + intNewRowId,"value" : ""} );	
	$("#savekdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "savekdrekening" + intNewRowId,"value" : ""} );
	$("#tmpjumlah" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpjumlah" + intNewRowId,"value" : 0} );
	$("#tmpdiscount" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpdiscount" + intNewRowId,"value" : 0} );
	$("#tmpbiaya" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpbiaya" + intNewRowId,"value" : 0} );
	$("#urutan" + intCurrentRowId , clonedRow ).attr( { "id" : "urutan" + intNewRowId,"value" : intNewRowId} );
	$("#detail").append(clonedRow);
	$("#detail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#nobukti" + intNewRowId).focus();
}

function deleteRow(obj)
{
	objek = obj.id;
	id = objek.substr(3,objek.length-3);
	kdrekening = $("#kdrekening"+id).val();
	var banyakBaris = 1;
	var lastRow = document.getElementsByName("kdrekening[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("kdrekening[]");
		temp = nama[index].id;
		indexs = temp.substr(10,temp.length-10);
		if($("#savekdrekening"+indexs).val()!=""){
			banyakBaris++;
		}
	}
	if($("#savekdrekening"+id).val()==""&&banyakBaris>1){
		$('#baris'+id).remove();
	}
	else if($("#savekdrekening"+id).val()==""&&banyakBaris==1){
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
			if(kdrekening!=""){
				var r=confirm("Apakah Anda Ingin Menghapus Kode Rekening "+kdrekening+" ?");
				if(r==true){
					$('#baris'+id).remove();
					if(no!=""){
						deleteItem(id);
					}
				}
			}
		}
	}
}

function deleteItem(id)
{
	if($("#transaksi").val()=="no"){
		no = $("#nodok").val();
		noreturcndn = $("#noreturcndn").val();
		$("#transaksi").val("yes");
		base_url = $("#baseurl").val();
		$.post(base_url+"index.php/transaksi/pelunasanhutang/delete_item",{ 
			no:no,noreturcndn:noreturcndn,urutan:id},
		function(data){
			$("#transaksi").val("no");
		});
	}
}

function totalNetto()
{
	var lastRow = document.getElementsByName("jumlah[]").length;
	var total = 0;
	for(index=0;index<lastRow;index++)
	{
		indexs = index-1; 
		nama = document.getElementsByName("jumlah[]");
		temp = nama[index].id;
		temp1 = parseFloat(nama[index].value);
		//totalb = parseFloat($(temp).val());
		//alert(lastRow+" "+temp+" "+temp1);
		total += temp1;
	}
	total = bulatkan( total, 2);
	//alert(total);
	//total = number_format(total, 0, ',', '.');
	return total;
}

