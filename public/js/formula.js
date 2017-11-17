function loading()
{
	base_url = $("#baseurl").val();
	$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',mandatory: true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly: true } );
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
			/*
			id = parseFloat(objek.substr(5,objek.length-5));
			pcode = $("#pcode"+id).val();
			url = base_url+"index.php/pop/barangowner/index/"+pcode+"/"+id+"/";
			window.open(url,'popuppage','width=750,height=400,top=200,left=150');
			*/
		}
		else if(flag=='satuan'){
			id = parseFloat(objek.substr(6,objek.length-6));
			$("#qty"+id).focus();
		}
		else if(flag=='qty'){
			id = parseFloat(objek.substr(3,objek.length-3));
			InputQty(id,'enter');
		}
		else if(flag=='pcodeatas'){
			findBarang();
		}
	}
}

function findBarang()
{
	if(cekoption("namaformula","Memasukkan Nama Formula"))
	{
		if(cekoption("pcodeatas","Memasukkan Kode Formula")){
			base_url = $("#baseurl").val();
			pcodeatas = $("#pcodeatas").val();
			$.post(base_url+"index.php/master/formula/getPCode",{pcode:pcodeatas},
				function(data){
					if(data!="")
					{	
					        //alert(data);
							result = data.split('*_*');
					        //$("#pcode"+brs).val(result[1]);
							$("#pcodeatas").val(result[1]);
							$("#hiddenbarang").val(result[1]);
							$("#barangname").val(result[2]);
							$("#satuanatas").val(result[3]);
							$("#qtyatas").focus();
					}
					else
					{
						pickBarang();
					}
				});

		}
		else
		{
			pickBarang();
		}
	}
}

function storeSatuan(obj)
{
	objek = obj.id;
	id = parseFloat(objek.substr(6,objek.length-6));
	if($("#satuan"+id).val()!=""){
		$("#satuantmp"+id).val($("#satuan"+id).val());
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

function pickThis(obj)
{
		base_url = $("#baseurl").val();
		objek = obj.id;
		id = parseFloat(objek.substr(4,objek.length-4));
		pcode = $("#pcode"+id).val();
		url = base_url+"index.php/pop/barangbeli/index/"+pcode+"/"+id+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
}

function pickThis2(id)
{
		base_url = $("#baseurl").val();
		pcode = $("#pcode"+id).val();
		url = base_url+"index.php/pop/barangbeli/index/"+pcode+"/"+id+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
}

function findPCode(id)
{
	if(cekheader())
	{
		if(cekoption("pcode"+id,"Memasukkan Kode Barang")){
			base_url = $("#baseurl").val();
			pcode = $("#pcode"+id).val();
			pcodeatas = $("#pcodeatas").val();
			if(pcode!=pcodeatas)
			{
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
					$.post(base_url+"index.php/master/formula/getPCode",{pcode:pcode},
					function(data){
						if(data!="")
						{	
								//alert(data);
								result = data.split('*_*');
								//$("#pcode"+brs).val(result[1]);
								$("#pcodebarang"+id).val(result[1]);
								$("#tmppcode"+id).val(result[1]);
								$("#nama"+id).val(result[2]);
								$("#satuantmp"+id).val(result[3]);
								$("#qty"+id).val("1");
								$("#satuan"+id).empty();
								$("#nilsatuan"+id).val(result[3]);
								//$("#satuan"+id).append("<option value=''>--> Pilih <--</option>");
								$("#satuan"+id).append("<option selected='selected' value='"+result[5]+"'>"+result[6]+"</option>");
								$("#satuan"+id).append("<option value='"+result[7]+"'>"+result[8]+"</option>");
								$("#satuan"+id).append("<option value='"+result[9]+"'>"+result[10]+"</option>");
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
					alert("Kode barang sudah ada");
					$("#pcode"+id).focus();
				}
			}else
			{
			    alert("Kode barang tidak boleh sama dengan kode barang induk");
			    $("#pcode"+id).focus();
			}
		}
	}
}

function resetRow(id)
{
	$("#pcode"+id).focus();
	$("#tmppcode"+id).val("");
	$("#nama"+id).val("");
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
	    //alert($("#pcode"+id).val());
		//alert($("#tmppcode"+id).val());
		if(validateForm("pcode"+id,"tmppcode"+id,"Kode Barang")){
			{
				if(cekAngka("qty"+id,"Qty","no zero","no minus"))
				{
					$("#tmpqty"+id).val($("#qty"+id).val());
				}
				if(from=="enter"){
			      saveThis(id);
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
		//alert("A");
		$("#formula").submit();
	}
}

function cekheader()
{
	if(cekoption("pcodeatas","Memilih Kode Barang Induk"))
	   return true;
	return false;   
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
		pcodeatas = $("#pcodeatas").val();
		qtyatas = $("#qtyatas").val();
		satuanatas = $("#satuanatas").val();
		namaformula = $("#namaformula").val();
		sumber = $("#hiddensumber").val();
		keterangan = $("#ket").val();
		flag = $("#flag").val();
		pcode = $("#pcode"+id).val();
		qty = $("#qty"+id).val();
		pcodesave = $("#savepcode"+id).val();
		base_url = $("#baseurl").val();
		satuan = $("#satuan"+id).val();
		nilsatuan = $("#nilsatuan"+id).val();
		$.post(base_url+"index.php/master/formula/save_new_item",{ 
			flag:flag,no:no,tgl:tgl,namaformula:namaformula,pcodeatas:pcodeatas,qtyatas:qtyatas,sumber:sumber,
			satuanatas:satuanatas,ket:keterangan,pcode:pcode,
			qty:qty,satuan:satuan,
			pcodesave:pcodesave,
			nilsatuan:nilsatuan
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
			//$("#kdcustomer").attr("disabled",true);
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
	$("#qty" + intCurrentRowId , clonedRow ).attr( { "id" : "qty" + intNewRowId,"value" : ""} );
	$("#tmppcode" + intCurrentRowId , clonedRow ).attr( { "id" : "tmppcode" + intNewRowId,"value" : ""} );
	$("#tmpqty" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpqty" + intNewRowId,"value" : ""} );
	$("#savepcode" + intCurrentRowId , clonedRow ).attr( { "id" : "savepcode" + intNewRowId,"value" : ""} );
	$("#pcodebarang" + intCurrentRowId , clonedRow ).attr( { "id" : "pcodebarang" + intNewRowId,"value" : ""} );
	$("#nilsatuantmp" + intCurrentRowId , clonedRow ).attr( { "id" : "nilsatuantmp" + intNewRowId,"value" : ""} );
	$("#nilsatuan" + intCurrentRowId , clonedRow ).attr( { "id" : "nilsatuan" + intNewRowId,"value" : ""} );
	$("#detail").append(clonedRow);
	$("#detail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
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
	if($("#savepcode"+id).val()==""&&banyakBaris>1){
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
		no = $("#nodok").val();
		$("#transaksi").val("yes");
		base_url = $("#baseurl").val();
		pcodeatas = $("#pcodeatas").val();
		alert(no+" "+pcodeatas);
		$.post(base_url+"index.php/master/formula/delete_item",{ 
			no:no,pcodeatas:pcodeatas,pcode:pcode},
		function(data){
			$("#transaksi").val("no");
		});
	}
}

function pickBarang()
{
	base_url = $("#baseurl").val();
	with1 = $("#pcodeatas").val();
	url = base_url+"index.php/pop/barang/index/"+with1;
	window.open(url,'popuppage','scrollbars=yes,width=550,height=500,top=180,left=150');
}

function ubahstatus()
{
	sumber = $("input[@name='sumber']:checked").val();
	//alert(sumber);
	$("#hiddensumber").val(sumber);
}