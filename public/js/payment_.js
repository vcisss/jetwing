function loading()
{
	base_url = $("#baseurl").val();
	bulan = $("#bulan").val();
	tahun = $("#tahun").val();
    var minDate = new Date(tahun,bulan-1,01); //one day next before month
    var maxDate =  new Date(tahun,bulan,0); //one day before next month
	//$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,maxDate: maxDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
	//$('#tglcair').datepicker({ dateFormat: 'dd-mm-yyyy',mandatory: true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly: true } );
    $('#tgl').Zebra_DatePicker({
        format: 'd-m-Y'
    });
    $('#tglcair').Zebra_DatePicker({
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
	
	if (code == 13) { //checks for the enter key
		
		objek = obj.id;
		if(flag=='kdrekening'){
			id = parseFloat(objek.substr(10,objek.length-10));
			findkdrekening(id);
		}
		if(flag=='namarekening'){
			id = parseFloat(objek.substr(10,objek.length-10));
			findkdrekening(id);
		}
		else if(flag=='jumlah'){
			id = parseFloat(objek.substr(6,objek.length-6));
			InputJumlah(id,'enter');
		}
		else if(flag=='keterangan'){
			id = parseFloat(objek.substr(10,objek.length-10));
			InputKeterangan(id,'enter');
		}
		else if(flag=='subdivisi'){
			id = parseFloat(objek.substr(9,objek.length-9));
			$("#dept"+id).focus();
		}
		else if(flag=='dept'){
			id = parseFloat(objek.substr(4,objek.length-4));
			$("#keterangan"+id).focus();
		}
	}
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
    objek = obj.id;
    id = parseFloat(objek.substr(4,objek.length-4));
    if($("#cek"+id).val()!="Y"){
    	
		if(cekheader())
		{
			base_url = $("#baseurl").val();
			code = "PVX_X"+$("#kdrekening"+id).val();
			url = base_url+"index.php/pop/rekening/index/"+code+"/"+id+"/";
			window.open(url,'popuppage','width=750,height=500,top=100,left=150');
		}
		
	}else{
		alert("Maaf No. Vocher Payment Ini Ada di Pelunasan Hutang.");
	}
}

function findkdrekening(id)
{
	var index = 0;
	var indexs = 0;
	if(cekheader())
	{
		if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening")){
			base_url = $("#baseurl").val();
			kdrekening = $("#kdrekening"+id).val();
			$.post(base_url+"index.php/keuangan/payment/getkdrekening",{ kdrekening:kdrekening},
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
						pickThis(id);
					}
				}
				else
				{
					pickThis(id);
				}
			});
			$("#jumlah"+id).focus();
		}
		else
		{
			resetRow(id);
			$("#namarekening"+id).focus();
		}
	}
}

function resetRow(id)
{
	$("#kdrekening"+id).focus();
	$("#kdrekening"+id).val("");
	$("#namarekening"+id).val("");
	$("#jumlah"+id).val("");
	$("#keterangan"+id).val("");
	$("#tmpjumlah"+id).val(0);
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
				$("#jumlah"+id).val(angka)
			    $("#jumlahpayment").val(totalNetto());
				$("#subdivisi"+id).focus();
			}
		}
	}
	else
	{
		resetRow(id);
		$("#namarekening"+id).focus();
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
				   newid=id+1;
				   saveThis(id);
				   AddNew();
				}
			}
		}
	}
	else
	{
		resetRow(id);
		$("#namarekening"+id).focus();
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
        document.getElementById("payment").submit();
		//$("#payment").submit();
	}
}

function cekheader()
{
	if(cekoption("kasbank","Memilih Kas Bank"))
	   if($("#jenistr").val()=='2')
	   {
	      if($("#nogiro").val()!='')
		  {
		     if($("#bankcair").val()!='')
			 {
			    if($("#tglcair").val()!=''||$("#tglcair").val()!='0000-00-00')
			      return true;
				else
				{
				  alert("Tanggal cair harus diisi");
				  return false;
				}
			 }
		     else
			 {
			    alert("Bank cair harus diisi");
				return false;
			 }
		  }
		  else
		  {
		     alert("Nomor giro harus diisi");
			 return false;
		  }
	  }else return true;
	return false;
}

function cekDetail(id)
{
	if(cekoption("kdrekening"+id,"Memasukkan Kode Rekening"))
	if(validateForm("kdrekening"+id,"tmpkdrekening"+id,"Kode Rekening"))
	if(cekoption("jumlah"+id,"Memasukkan Jumlah Rupiah"))
		return true;
	return false;
}

function cekDetailAll()
{
	var index = 0;
	var indexs = 0;
	var lastRow = document.getElementsByName("kdrekening[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("kdrekening[]");
		temp = nama[index].id;
		indexs = temp.substr(10,temp.length-10);
		if(index<parseFloat(lastRow)-1||index==0){
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
			if($("#kdrekening"+indexs).val()==""&&$("#jumlah"+indexs).val()==0)
			{
				continue;
			}
			else
			{
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
		jenistr = $("#jenistr").val();
		kasbank = $("#hidekasbank").val();
		personal = $("#hidepersonal").val();
		costcenter = $("#hidecostcenter").val();
		nogiro = $("#nogiro").val();
		tglcair = $("#tglcair").val();
		bankcair = $("#bankcair").val();
		nobukti = $("#nobukti").val();
		ket = $("#ket").val();
		flag = $("#flag").val();
		nama = $("#nama"+id).val(); 
		kdrekening = $("#kdrekening"+id).val();
		savekdrekening = $("#savekdrekening"+id).val(); 
		jumlah = $("#jumlah"+id).val();
		keterangan = $("#keterangan"+id).val();
		urutan = $("#urutan"+id).val(); 
		jumlahpayment = $("#jumlahpayment").val();
        dept = $("#dept"+id).val();
        subdivisi = $("#subdivisi"+id).val();
        penerima = $("#penerima").val();
		base_url = $("#baseurl").val();
		
		var formData = new FormData();
		formData.append('flag', flag);
		formData.append('no', no);
		formData.append('tgl', tgl);
		formData.append('jenistr', jenistr);
		formData.append('ket', ket);
		formData.append('kdrekening', kdrekening);
		formData.append('jumlah', jumlah);
		formData.append('keterangan', keterangan);
		formData.append('nogiro', nogiro);
		formData.append('bankcair', bankcair);
		formData.append('tglcair', tglcair);
		formData.append('savekdrekening', savekdrekening);
		formData.append('kasbank', kasbank);
		formData.append('costcenter', costcenter);
		formData.append('personal', personal);
		formData.append('jumlahpayment', jumlahpayment);
		formData.append('urutan', urutan);
		formData.append('penerima', penerima);
		formData.append('dept', dept);
		formData.append('subdivisi', subdivisi);
		//$.each($('#file')[0].files, function(i, file) {
    	//	formData.append('file'+i, file);
		//});
		formData.append('file1', $("input:file")[0].files[0]); 
		formData.append('file2', $("input:file")[1].files[0]); 
		
		//$.post(base_url+"index.php/keuangan/payment/save_new_item",{
		//	flag:flag,no:no,tgl:tgl,jenistr:jenistr,ket:ket,kdrekening:kdrekening,
		//	jumlah:jumlah,keterangan:keterangan,nogiro:nogiro,bankcair:bankcair,tglcair:tglcair,
		//	savekdrekening:savekdrekening,kasbank:kasbank,costcenter:costcenter,personal:personal,jumlahpayment:jumlahpayment,
		//	urutan:urutan,penerima:penerima,dept:dept,subdivisi:subdivisi
		//},
		$.ajax({
  			url: base_url+"index.php/keuangan/payment/save_new_item",
    		data: formData,
    		type: 'POST',
    	    contentType: false,
    		processData: false,
    		success:function(data){
				if(data=="adagiro")
				{
				   alert("nomor giro sudah ada");
				   resetRow(id);
				   $("#transaksi").val("no");
				   $("#Layer1").css("display","none");
			       $('fieldset.disableMe :input').attr('disabled', false);
				   changeJenis();
				   $("#nogiro").focus();
				}else
				{
					if(flag=="add")
					{
						$("#nodok").val(data);
						$("#nodokumen").css("display","");
					}
				    $("#nogiro").attr({"readonly":"readonly"})
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
				}
			}
		});
	}
}

function AddNew()
{
	var lastRow = document.getElementsByName("kdrekening[]").length-1;
	nama = document.getElementsByName("kdrekening[]");
	temp = nama[lastRow].id;
	indexs = temp.substr(10,temp.length-10);
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
	$("#jumlah" + intCurrentRowId , clonedRow ).attr( { "id" : "jumlah" + intNewRowId,"value" : ""} );
	$("#keterangan" + intCurrentRowId , clonedRow ).attr( { "id" : "keterangan" + intNewRowId,"value" : ""} );
	$("#tmpkdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpkdrekening" + intNewRowId,"value" : ""} );	
	$("#savekdrekening" + intCurrentRowId , clonedRow ).attr( { "id" : "savekdrekening" + intNewRowId,"value" : ""} );
	$("#tmpjumlah" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpjumlah" + intNewRowId,"value" : ""} );
    $("#subdivisi" + intCurrentRowId , clonedRow ).attr( { "id" : "subdivisi" + intNewRowId,"value" : 0} );
    $("#dept" + intCurrentRowId , clonedRow ).attr( { "id" : "dept" + intNewRowId,"value" : 0} );
	$("#urutan" + intCurrentRowId , clonedRow ).attr( { "id" : "urutan" + intNewRowId,"value" : intNewRowId} );
	$("#detail").append(clonedRow);
	$("#detail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#namarekening" + intNewRowId).focus();
    resetRow(intNewRowId);
}

function deleteRow(obj)
{
	var index = 0;
	var indexs = 0;
	objek = obj.id;
	id = objek.substr(3,objek.length-3);
	kdrekening = $("#kdrekening"+id).val();
	
	if($("#cek"+id).val()!="Y"){
	
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
								deleteItem(kdrekening,id);
							}
						}
					}
				}
			}
	
	}else{
		alert("Maaf tidak bisa di delete karena No. Vocher ini ada di pelunasan hutang.");
	}
}

function deleteItem(kdrekening,id)
{
	if($("#transaksi").val()=="no"){
		$("#jumlahpayment").val(totalNetto());
		no = $("#nodok").val();
		$("#transaksi").val("yes");
		base_url = $("#baseurl").val();
		jumlahpayment = $("#jumlahpayment").val();
		$.post(base_url+"index.php/keuangan/payment/delete_item",{
			no:no,kdrekening:kdrekening,urutan:id,jumlahpayment:jumlahpayment},
		function(data){
			$("#transaksi").val("no");
		});
	}
}

function totalNetto()
{
	var index = 0;
	var indexs = 0;
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
		if(nama[index].value != '')
			total += temp1;
	}
	total = bulatkan( total, 2);
	//alert(total);
	//total = number_format(total, 0, ',', '.');
	return total;
}

function changeJenis()
{
   jenis=$("#jenistr").val();
   kasbank=$("#kasbank").val();
   if(jenis=='1')
   {
      $("#nogiro").attr("disabled",true);
	  $("#bankcair").attr("disabled",true);
	  $("#tglcair").attr("disabled",true);
	  if(kasbank=='')
	  {
	  $("#kasbank").val("BCA1");
	  $("#hidekasbank").val("BCA1");
	  }
   }else
   {
      $("#nogiro").attr("disabled",false);
	  $("#bankcair").attr("disabled",false);
	  $("#tglcair").attr("disabled",false);
	  if(kasbank=='')
	  {
	  $("#kasbank").val("HGM");
	  $("#hidekasbank").val("HGM");
	  }
   }
}
