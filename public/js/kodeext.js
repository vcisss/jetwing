function loading()
{
    base_url = $("#baseurl").val();
	bulan = $("#bulan").val();
	tahun = $("#tahun").val();
    var minDate = new Date(tahun,bulan-1,01); //one day next before month
    var maxDate =  new Date(tahun,bulan,0); //one day before next month
    $('#tgl').Zebra_DatePicker({ format: 'd-m-Y' });
//	$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,maxDate: maxDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
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
		else if(flag=='pcodeext'){
			id = parseFloat(objek.substr(8,objek.length-8));
			$("#namaext"+id).focus();
		}
		else if(flag=='namaext'){
			id = parseFloat(objek.substr(7,objek.length-7));
			InputNamaExt(id,'enter');
		}
	}
}

function pickThis(id)
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
				$.post(base_url+"index.php/master/kodeext/getPCode",{pcode:pcode},
				function(data){
					if(data!="")
					{	
							//alert(data);
							result = data.split('*_*');
							$("#pcode"+id).val(result[1]);
							$("#tmppcode"+id).val(result[1]);
							$("#nama"+id).val(result[2]);
							$("#pcodeext"+id).val("");
							$("#namaext"+id).val("");
							$("#pcodeext"+id).focus();
					}
					else
					{
						pickThis(id);
					}
				});
			}
			else
			{
				alert("Kode barang sudah ada");
				$("#pcode"+id).focus();
			}

		}
	}
}

function InputNamaExt(id,from)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	{
	    //alert($("#pcode"+id).val());
		//alert($("#tmppcode"+id).val());
		if(validateForm("pcode"+id,"tmppcode"+id,"Kode Barang")){
			{
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

function resetRow(id)
{
	$("#pcode"+id).focus();
	$("#tmppcode"+id).val("");
	$("#nama"+id).val("");
	$("#pcodeext"+id).val("");
	$("#namaext"+id).val("");
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
		$("#kodeext").submit();
	}
}

function cekheader()
{
	if(cekoption("namagrp","Memasukkan Nama Group"))
	   return true;
	return false;   
}

function cekDetail(id)
{
	if(cekoption("pcode"+id,"Memasukkan Kode Barang"))
	if(validateForm("pcode"+id,"tmppcode"+id,"Kode Barang"))
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
			   continue;
			return false;
		}
		else if(index==parseFloat(lastRow)-1)
		{
			if($("#pcode"+indexs).val()=="")
			{
				continue;
			}
			else
			{
				if(cekoption("pcode"+indexs ,"Memasukkan Kode Barang"))
				if(validateForm("pcode"+indexs,"tmppcode"+indexs,"Kode Barang"))
				   continue;
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
		namagrp = $("#namagrp").val();
		sumber = $("#hiddensumber").val();
		flag = $("#flag").val();
		pcode = $("#pcode"+id).val();
		pcodeext = $("#pcodeext"+id).val();
		pcodesave = $("#savepcode"+id).val();
		base_url = $("#baseurl").val();
		namaext = $("#namaext"+id).val();
		$.post(base_url+"index.php/master/kodeext/save_new_item",{ 
			flag:flag,no:no,tgl:tgl,namagrp:namagrp,sumber:sumber,
			pcode:pcode,pcodeext:pcodeext,namaext:namaext,
			pcodesave:pcodesave
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
	$("#pcodeext" + intCurrentRowId , clonedRow ).attr( { "id" : "pcodeext" + intNewRowId,"value" : ""});
	$("#namaext" + intCurrentRowId , clonedRow ).attr( { "id" : "namaext" + intNewRowId,"value" : ""} );
	$("#tmppcode" + intCurrentRowId , clonedRow ).attr( { "id" : "tmppcode" + intNewRowId,"value" : ""} );
	$("#savepcode" + intCurrentRowId , clonedRow ).attr( { "id" : "savepcode" + intNewRowId,"value" : ""} );
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
		$.post(base_url+"index.php/master/kodeext/delete_item",{ 
			no:no,pcode:pcode},
		function(data){
			$("#transaksi").val("no");
		});
	}
}

function ubahstatus()
{
	sumber = $("input[@name='sumber']:checked").val();
	//alert(sumber);
	$("#hiddensumber").val(sumber);
}