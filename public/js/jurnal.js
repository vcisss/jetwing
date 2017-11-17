function loading()
{
	base_url = $("#baseurl").val();
	bulan = $("#bulan").val();
	tahun = $("#tahun").val();
    var minDate = new Date(tahun,bulan-1,01); //one day next before month
    var maxDate =  new Date(tahun,bulan,0); //one day before next month
	//$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,maxDate: maxDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
	//$('#tglcair').datepicker({ dateFormat: 'dd-mm-yyyy',mandatory: true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly: true } );
//alert(minDate);
    //alert(maxDate);
    $('#tgl').Zebra_DatePicker({
        format: 'd-m-Y'
    });

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
		else if(flag=='debit'){
			id = parseFloat(objek.substr(5,objek.length-5));
			InputDebit(id);
		}
		else if(flag=='kredit'){
			id = parseFloat(objek.substr(6,objek.length-6));
			InputKredit(id);
		}
		else if(flag=='keterangan'){
			id = parseFloat(objek.substr(10,objek.length-10));
			InputKeterangan(id,'enter');
		}
	}
}

function simpanProject()
{
    $("#hidedept").val($("#dept").val());
	$("#project").focus();
}

function simpanProject()
{
    $("#hideproject").val($("#project").val());
	$("#costcenter").focus();
}

function simpanCostCenter()
{
    $("#hidecostcenter").val($("#costcenter").val());
	$("#notransaksi").focus();
}

function pickThis(obj)
{
    objek = obj.id;
    id = parseFloat(objek.substr(4,objek.length-4));
	//if(cekheader())
	//{
		base_url = $("#baseurl").val();
		code = "JRNX_X"+$("#kdrekening"+id).val();
		url = base_url+"index.php/pop/rekening/index/"+code+"/"+id+"/";
		window.open(url,'popuppage','width=750,height=500,top=100,left=150');
	//}
}

function findkdrekening(id)
{
	if(cekheader())
	{
		if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening")){
			base_url = $("#baseurl").val();
			kdrekening = $("#kdrekening"+id).val();
			$.post(base_url+"index.php/transaksi/jurnal/getkdrekening",{ kdrekening:kdrekening},
			function(data){
				if(data!=""){
				    result = data.split('*-*');
					kode = result[0];
					nama = result[1];
					var lastRow = document.getElementsByName("kdrekening[]").length;
					var dobel = false;
					var index = 0;
	                var indexs = 0;
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
						$("#debit"+id).focus();
					}
					else
					{
						pickThis(id);
					}
				}
				else
				{
					pickThis(id);
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
	$("#kdrekening"+id).val("");
	$("#namarekening"+id).val("");
	$("#debit"+id).val(0);
	$("#kredit"+id).val(0);
	$("#keterangan"+id).val("");
	$("#tmpkdrekening"+id).val("");
	$("#tmpdebit"+id).val(0);
	$("#tmpkredit"+id).val(0);
}


function InputDebit(id)
{
	if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening"))
	{
		if(validateForm("kdrekening"+id,"tmpkdrekening"+id,"Kode Rekening")){
			
			if(cekAngka("debit"+id,"Debit","zero","no minus"))
			{
			    
				//alert($("#jumlah"+id).val());
			    angka = bulatkan( $("#debit"+id).val(), 2 );
				//alert(angka);
				$("#debit"+id).val(angka)
			    $("#jumlahdebit").val(totalDebit());
				if(angka==0)
				    $("#kredit"+id).focus();
				else
				{
				    //$("#kredit"+id).val(0);
				    $("#keterangan"+id).focus();
				}
			}
		}
	}
	else
	{
		resetRow(id);
		$("#kdrekening"+id).focus();
	}
}

function InputKredit(id)
{
	if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening"))
	{
		if(validateForm("kdrekening"+id,"tmpkdrekening"+id,"Kode Rekening")){

			if(cekAngka("kredit"+id,"Kredit","zero","no minus"))
			{
				 
			    angka = bulatkan( $("#kredit"+id).val(), 2 );

				$("#kredit"+id).val(angka);
				$("#jumlahkredit").val(totalKredit());
				$("#keterangan"+id).focus();
			}
		}
	}
	else
	{
		resetRow(id);
		$("#kdrekening"+id).focus();
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
				   $("#jumlahdebit").val(totalDebit());
				   $("#jumlahkredit").val(totalKredit());
				   saveThis(id);
				}
			}
		}
	}
	else
	{
		resetRow(id);
		$("#kdrekening"+id).focus();
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
        document.getElementById("jurnal").submit();
		//$("#jurnal").submit();
	}
}

function cekheader()
{
	if(($("#jenistr").val()=='1')||($("#jenistr").val()=='2'))
	   return true;
	return false;
}

function cekDetail(id)
{
	if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening"))
	if(validateForm("kdrekening"+id,"tmpkdrekening"+id,"Kode Rekening"))
	if(cekoption("debit"+id,"Memasukkan Debit Rupiah"))
	if(cekoption("kredit"+id,"Memasukkan Kredit Rupiah"))
	{
	   		angkad = bulatkan( $("#debit"+id).val(), 2 );
		    angka = bulatkan( $("#kredit"+id).val(), 2 );
			if((angkad==0)&&(angka==0))
			{
				alert("Debit dan Kredit tidak boleh 0 keduanya");
				$("#kredit"+id).focus();
			}
			else
			{
				if((angkad!=0)&&(angka!=0))
				{
					alert("Debit dan Kredit tidak boleh diisi keduanya");
					$("#kredit"+id).focus();
				}else
				{
					return true;
			    }
			}
	}
	return false;
}

function cekDetailAll()
{
	var lastRow = document.getElementsByName("kdrekening[]").length;
	var index = 0;
	var indexs = 0;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("kdrekening[]");
		temp = nama[index].id;
		indexs = temp.substr(10,temp.length-10);
		if(index<parseFloat(lastRow)-1||index==0){
			if(cekoption("kdrekening"+indexs ,"Memasukkan Kode Rekening"))
			if(validateForm("kdrekening"+indexs,"tmpkdrekening"+indexs,"Kode Rekening"))
			if(cekoption("debit"+indexs ,"Memasukkan Debit Rupiah"))
			if(cekoption("kredit"+indexs ,"Memasukkan Kredit Rupiah"))
			{
				InputDebit(indexs);
				InputKredit(indexs);
				angkad = bulatkan( $("#debit"+indexs).val(), 2 );
				angka = bulatkan( $("#kredit"+indexs).val(), 2 );
				if((angkad==0)&&(angka==0))
				{
					alert("Debit dan Kredit tidak boleh 0 keduanya");
					$("#debit"+indexs).focus();
					return false;
				}
				else
				{
					if((angkad!=0)&&(angka!=0))
					{
						alert("Debit dan Kredit tidak boleh diisi keduanya");
						$("#kredit"+indexs).focus();
						return false;
					}else
					{
						continue;
					}
				}
			}
			return false;
		}
		else if(index==parseFloat(lastRow)-1)
		{
			if($("#kdrekening"+indexs).val()==""&&$("#debit"+indexs).val()==0&&$("#kredit"+indexs).val()==0)
			{
				continue;
			}
			else
			{
				if(cekoption("kdrekening"+indexs ,"Memasukkan Kode Rekening"))
				if(validateForm("kdrekening"+indexs,"tmpkdrekening"+indexs,"Kode Rekening"))
				if(cekoption("debit"+indexs ,"Memasukkan Debit Rupiah"))
			    if(cekoption("kredit"+indexs ,"Memasukkan Kredit Rupiah"))
				{
					InputDebit(indexs);
					InputKredit(indexs);
					continue;
				}
				return false;
			}
		}
	}
	debit = bulatkan( $("#jumlahdebit").val(), 2 );
	kredit = bulatkan( $("#jumlahkredit").val(), 2 );
	if(debit!==kredit)
	{
		alert("Jurnal belum balance");
		return false;
	}
	
	return true;
	
	
}

function saveItem(id)
{
    //alert("save item");
	var index = 0;
	var indexs = 0;
	if($("#transaksi").val()=="no"){
		$("#transaksi").val("yes");
		no = $("#nodok").val();
		tgl = $("#tgl").val();
		jenistr = $("#jenistr").val();
		dept = $("#hidedept").val();
		project = $("#hideproject").val();
		costcenter = $("#hidecostcenter").val();
		notrans = $("#notrans").val();
		ket = $("#ket").val();
		flag = $("#flag").val();
		nama = $("#nama"+id).val(); 
		kdrekening = $("#kdrekening"+id).val();
		savekdrekening = $("#savekdrekening"+id).val(); 
		debit = $("#debit"+id).val();
		kredit = $("#kredit"+id).val();
		keterangan = $("#keterangan"+id).val();
		urutan = $("#urutan"+id).val(); 
		jumlahdebit = $("#jumlahdebit").val(); 
		jumlahkredit = $("#jumlahkredit").val(); 
		base_url = $("#baseurl").val();
		$.post(base_url+"index.php/transaksi/jurnal/save_new_item",{ 
			flag:flag,no:no,tgl:tgl,jenistr:jenistr,ket:ket,notrans:notrans,kdrekening:kdrekening,
			debit:debit,kredit:kredit,keterangan:keterangan,
			savekdrekening:savekdrekening,dept:dept,project:project,costcenter:costcenter,
			jumlahdebit:jumlahdebit,jumlahkredit:jumlahkredit,urutan:urutan
		},
		function(data){
		    //alert(data);
				if(flag=="add")
				{
					$("#nodok").val(data);
					$("#nodokumen").css("display","");
				}
				$("#savekdrekening"+id).val($("#kdrekening"+id).val());
				$('fieldset.disableMe :input').attr('disabled', false);
				var lastRow = document.getElementsByName("kdrekening[]").length-1;
				nama = document.getElementsByName("kdrekening[]");
				temp = nama[lastRow].id;
				indexs = temp.substr(10,temp.length-10);
				if($("#savekdrekening"+indexs).val()!=""){
					detailNew();
				}
				$("#Layer1").css("display","none");
				$("#transaksi").val("no");
		});
	}
}

function AddNew()
{
	var lastRow = document.getElementsByName("kdrekening[]").length-1;
	var nama = document.getElementsByName("kdrekening[]");
	var temp = nama[lastRow].id;
	var indexs = temp.substr(10,temp.length-10);
	if(cekDetail(indexs)){
		saveItem(indexs);
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
	$("#kdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "kdrekening" + intNewRowId,"value" : ""} );
	$("#pick" + intCurrentRowId , clonedRow ).attr( { "id" : "pick" + intNewRowId} );
	$("#del" + intCurrentRowId , clonedRow ).attr( { "id" : "del" + intNewRowId} );
	$("#namarekening" + intCurrentRowId , clonedRow ).attr( { "id" : "namarekening" + intNewRowId,"value" : ""} );
	$("#debit" + intCurrentRowId , clonedRow ).attr( { "id" : "debit" + intNewRowId,"value" : 0} );
	$("#kredit" + intCurrentRowId , clonedRow ).attr( { "id" : "kredit" + intNewRowId,"value" : 0} );
	$("#keterangan" + intCurrentRowId , clonedRow ).attr( { "id" : "keterangan" + intNewRowId,"value" : ""} );
	$("#tmpkdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpkdrekening" + intNewRowId,"value" : ""} );	
	$("#savekdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "savekdrekening" + intNewRowId,"value" : ""} );
	$("#tmpdebit" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpdebit" + intNewRowId,"value" : 0} );
	$("#tmpkredit" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpkredit" + intNewRowId,"value" : 0} );
	$("#urutan" + intCurrentRowId , clonedRow ).attr( { "id" : "urutan" + intNewRowId,"value" : intNewRowId} );
	$("#detail").append(clonedRow);
	$("#detail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
    resetRow(intNewRowId);
	$("#kdrekening" + intNewRowId).focus();
}

function deleteRow(obj)
{
	objek = obj.id;
	id = objek.substr(3,objek.length-3);
	kdrekening = $("#kdrekening"+id).val();
	var banyakBaris = 1;
	var lastRow = document.getElementsByName("kdrekening[]").length;
	var index = 0;
	var indexs = 0;
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
						deleteItem(kdrekening,id);
					}
				}
			}
		}
	}
}

function deleteItem(kdrekening,id)
{
	if($("#transaksi").val()=="no"){
		$("#jumlahdebit").val(totalDebit());
		$("#jumlahkredit").val(totalKredit());
		no = $("#nodok").val();
		$("#transaksi").val("yes");
		base_url = $("#baseurl").val();
		jumlahdebit = $("#jumlahdebit").val();
		jumlahkredit = $("#jumlahdebit").val();
		$.post(base_url+"index.php/transaksi/jurnal/delete_item",{ 
			no:no,kdrekening:kdrekening,urutan:id,jumlahdebit:jumlahdebit,jumlahkredit:jumlahkredit},
		function(data){
			$("#transaksi").val("no");
		});
	}
}

function totalDebit()
{
	var lastRow = document.getElementsByName("debit[]").length;
	var total = 0;
	var index = 0;
	var indexs = 0;
	for(index=0;index<lastRow;index++)
	{
		indexs = index-1; 
		nama = document.getElementsByName("debit[]");
		temp = nama[index].id;
		temp1 = parseFloat(nama[index].value);
		total += temp1;
	}
	total = bulatkan( total, 2);
	return total;
}

function totalKredit()
{
	var lastRow = document.getElementsByName("kredit[]").length;
	var total = 0;
	var index = 0;
	var indexs = 0;
	for(index=0;index<lastRow;index++)
	{
		indexs = index-1; 
		nama = document.getElementsByName("kredit[]");
		temp = nama[index].id;
		temp1 = parseFloat(nama[index].value);
		total += temp1;
	}
	total = bulatkan( total, 2);
	return total;
}

