function loading()
{
	base_url = $("#baseurl").val();
	bulan = $("#bulan").val();
	tahun = $("#tahun").val();
    var minDate = new Date(tahun,bulan-1,01); //one day next before month
    var maxDate =  new Date(tahun,bulan,0); //one day before next month
	$('#tgl').datepicker({ dateFormat: 'dd-mm-yyyy',minDate: minDate,maxDate: maxDate,hideIfNoPrevNext:true,mandatory:true,showOn: "both", buttonImage: base_url+ "public/images/calendar.png", buttonImageOnly:true});
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
		if(flag=='nogiro'){
			id = parseFloat(objek.substr(6,objek.length-6));
			//alert(objek);
			//alert(id);
			findnogiro(id);
		}
		else if(flag=='jumlah'){
			id = parseFloat(objek.substr(6,objek.length-6));
			InputJumlah(id,'enter');
		}
		else if(flag=='keterangan'){
			id = parseFloat(objek.substr(10,objek.length-10));
			InputKeterangan(id,'enter');
		}
	}
}

function simpanKasBank()
{
    $("#hidekasbank").val($("#kasbank").val());
}

function simpanBankCair()
{
	$("#keterangan").focus();
}

function pickThis(obj)
{
	if(cekheader())
	{
		base_url = $("#baseurl").val();
		objek = obj.id;
		id = parseFloat(objek.substr(4,objek.length-4));
		jenis = $("#jenistr").val();
		bank = $("#bankcair").val();
		url = base_url+"index.php/pop/nogiro/index/"+id+"/"+jenis+"/"+bank+"/";
		window.open(url,'popuppage','width=750,height=400,top=200,left=150');
	}
}

function findnogiro(id)
{
	if(cekheader())
	{
		if(cekoption("nogiro"+id,"Memasukkan Nomor Giro")){
			base_url = $("#baseurl").val();
			nogiro = $("#nogiro"+id).val();
			jenistr = $("#jenistr").val();
			bankcair = $("#bankcair").val();
			$.post(base_url+"index.php/transaksi/pencairan/getnogiro",{ nogiro:nogiro,
			jenistr:jenistr,bankcair:bankcair},
			function(data){
				if(data!=""){
				    result = data.split('*-*');
					kode = result[0];
					var lastRow = document.getElementsByName("nogiro[]").length;
					var dobel = false;
					for(index=0;index<lastRow;index++){
						nama = document.getElementsByName("nogiro[]");
						temp = nama[index].id;
						indexs = temp.substr(6,temp.length-6);
						if($("#tmpnogiro"+indexs).val()==kode)
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
						$("#nogiro"+id).val(result[0]);
						$("#tglbuka"+id).val(result[1]);
						$("#tgljto"+id).val(result[2]);
						$("#jumlah"+id).val(result[3]);
						$("#tmpnogiro"+id).val(result[0]);
						$("#jumlah"+id).focus();
					}
					else
					{
						alert("Nomor Giro Sudah Ada");
						resetRow(id);
						$("#nogiro"+id).focus();
					}
				}
				else
				{
					alert("Data Tidak Ditemukan");
					resetRow(id);
					$("#nogiro"+id).focus();
				}
			});
		}
		else
		{
			resetRow(id);
			$("#nogiro"+id).focus();
		}
	}
}

function resetRow(id)
{
	$("#nogiro"+id).focus();
	$("#tglbuka"+id).val("");
	$("#tgljto"+id).val("");
	$("#jumlah"+id).val("");
	$("#tmpnogiro"+id).val("");
	$("#tmpjumlah"+id).val("");
}


function InputJumlah(id,from)
{
	if(cekoption("nogiro"+id,"Memasukkan Nomor Giro"))
	{
		if(validateForm("nogiro"+id,"tmpnogiro"+id,"Nomor Giro")){

			if(cekAngka("jumlah"+id,"Jumlah","no zero","no minus"))
			{
			    
				//alert($("#jumlah"+id).val());
			    angka = bulatkan( $("#jumlah"+id).val(), 2 );
				//alert(angka);
				$("#jumlah"+id).val(angka)
			    $("#jumlahpencairan").val(totalNetto());
				if(from=="enter"){
				   saveThis(id);
				}
			}
		}
	}
	else
	{
		resetRow(id);
		$("#nogiro"+id).focus();
	}
}

function InputKeterangan(id,from)
{
	if(cekoption("nogiro"+id,"Memasukkan Nomor Giro"))
	{
		if(validateForm("nogiro"+id,"tmpnogiro"+id,"Nomor Giro")){
			if(cekoption("keterangan"+id,"Isi Keterangan"))
			{
				if(from=="enter"){
				   $("#jumlahpencairan").val(totalNetto());
				   saveThis(id);
				}
			}
		}
	}
	else
	{
		resetRow(id);
		$("#nogiro"+id).focus();
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
		$("#pencairan").submit();
	}
}

function cekheader()
{
    if(cekoption("jenistr","Memilih Jenis Giro"))
	    if(cekoption("kasbank","Memilih Kas Bank"))
		    if(cekoption("bankcair","Memilih Bank Cair"))
	return true;
}

function cekDetail(id)
{
	if(cekoption("nogiro"+id,"Memasukkan Nomor Giro"))
	if(validateForm("nogiro"+id,"tmpnogiro"+id,"Nomor Giro"))
	if(cekoption("jumlah"+id,"Memasukkan Jumlah Rupiah"))
		return true;
	return false;
}

function cekDetailAll()
{
	var lastRow = document.getElementsByName("nogiro[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("nogiro[]");
		temp = nama[index].id;
		indexs = temp.substr(6,temp.length-6);
		if(index<parseFloat(lastRow)-1||index==0){
			if(cekoption("nogiro"+indexs ,"Memasukkan Nomor Giro"))
			if(validateForm("nogiro"+indexs,"tmpnogiro"+indexs,"Nomor Giro"))
			if(cekoption("jumlah"+indexs ,"Memasukkan Jumlah Rupiah"))
			{
				InputJumlah(indexs,'cek');
				continue;
			}
			return false;
		}
		else if(index==parseFloat(lastRow)-1)
		{
			if($("#nogiro"+indexs).val()==""&&$("#jumlah"+indexs).val()=="")
			{
				continue;
			}
			else
			{
				if(cekoption("nogiro"+indexs ,"Memasukkan Nomor Giro"))
				if(validateForm("nogiro"+indexs,"tmpnogiro"+indexs,"Nomor Giro"))
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
		bankcair = $("#bankcair").val();
		ket = $("#ket").val();
		flag = $("#flag").val();
		nogiro = $("#nogiro"+id).val();
		jumlah = $("#jumlah"+id).val();
		tglbuka = $("#tglbuka"+id).val();
		tgljto = $("#tgljto"+id).val();
		savenogiro = $("#savenogiro"+id).val(); 
		urutan = $("#urutan"+id).val(); 
		jumlahpencairan = $("#jumlahpencairan").val(); 
		base_url = $("#baseurl").val();
		$.post(base_url+"index.php/transaksi/pencairan/save_new_item",{ 
			flag:flag,no:no,tgl:tgl,jenistr:jenistr,ket:ket,jumlah:jumlah,tglbuka:tglbuka,tgljto:tgljto,
			nogiro:nogiro,bankcair:bankcair,savenogiro:savenogiro,kasbank:kasbank,
			jumlahpencairan:jumlahpencairan,urutan:urutan
		},
		function(data){
		    //alert(data);
			if(flag=="add")
			{
				$("#nodok").val(data);
				$("#nodokumen").css("display","");
			}
			$("#nogiro").attr({"readonly":"readonly"})
			$("#savenogiro"+id).val($("#nogiro"+id).val());
			$('fieldset.disableMe :input').attr('disabled', false);
			var lastRow = document.getElementsByName("nogiro[]").length-1;
			nama = document.getElementsByName("nogiro[]");
			temp = nama[lastRow].id;
			indexs = temp.substr(6,temp.length-6);
			$("#kontak").attr("disabled",true);
			if($("#savenogiro"+indexs).val()!=""){
				detailNew();
			}
			$("#Layer1").css("display","none");
			changeJenis();
			$("#transaksi").val("no");
		});
	}
}

function AddNew()
{
	var lastRow = document.getElementsByName("nogiro[]").length-1;
	nama = document.getElementsByName("nogiro[]");
	temp = nama[lastRow].id;
	indexs = temp.substr(6,temp.length-6);
	if(cekDetail(indexs)){
		saveItem(indexs);
	}
}

function detailNew()
{
	var clonedRow = $("#detail tr:last").clone(true);
	var intCurrentRowId = parseFloat($('#detail tr').length )-2;
	nama = document.getElementsByName("nogiro[]");
	temp = nama[intCurrentRowId].id;
	intCurrentRowId = temp.substr(6,temp.length-6);
	var intNewRowId = parseFloat(intCurrentRowId) + 1;
	$("#nogiro" + intCurrentRowId , clonedRow ).attr( { "id" : "nogiro" + intNewRowId,"value" : ""} );
	$("#pick" + intCurrentRowId , clonedRow ).attr( { "id" : "pick" + intNewRowId} );
	$("#del" + intCurrentRowId , clonedRow ).attr( { "id" : "del" + intNewRowId} );
	$("#tglbuka" + intCurrentRowId , clonedRow ).attr( { "id" : "tglbuka" + intNewRowId,"value" : ""} );
	$("#jumlah" + intCurrentRowId , clonedRow ).attr( { "id" : "jumlah" + intNewRowId,"value" : 0} );
	$("#tgljto" + intCurrentRowId , clonedRow ).attr( { "id" : "tgljto" + intNewRowId,"value" : ""} );
	$("#tmpnogiro" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpnogiro" + intNewRowId,"value" : ""} );	
	$("#savenogiro" + intCurrentRowId , clonedRow ).attr( { "id" : "savenogiro" + intNewRowId,"value" : ""} );
	$("#tmpjumlah" + intCurrentRowId , clonedRow ).attr( { "id" : "tmpjumlah" + intNewRowId,"value" : 0} );
	$("#urutan" + intCurrentRowId , clonedRow ).attr( { "id" : "urutan" + intNewRowId,"value" : intNewRowId} );
	$("#detail").append(clonedRow);
	$("#detail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#nogiro" + intNewRowId).focus();
}

function deleteRow(obj)
{
	objek = obj.id;
	id = objek.substr(3,objek.length-3);
	nogiro = $("#nogiro"+id).val();
	var banyakBaris = 1;
	var lastRow = document.getElementsByName("nogiro[]").length;
	for(index=0;index<lastRow;index++){
		nama = document.getElementsByName("nogiro[]");
		temp = nama[index].id;
		indexs = temp.substr(6,temp.length-6);
		if($("#savenogiro"+indexs).val()!=""){
			banyakBaris++;
		}
	}
	if($("#savenogiro"+id).val()==""&&banyakBaris>1){
		$('#baris'+id).remove();
	}
	else if($("#savenogiro"+id).val()==""&&banyakBaris==1){
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
			if(nogiro!=""){
				var r=confirm("Apakah Anda Ingin Menghapus Nomor Giro "+nogiro+" ?");
				if(r==true){
					$('#baris'+id).remove();
					if(no!=""){
						deleteItem(nogiro,id);
					}
				}
			}
		}
	}
}

function deleteItem(nogiro,id)
{
	if($("#transaksi").val()=="no"){
		no = $("#nodok").val();
		$("#transaksi").val("yes");
		base_url = $("#baseurl").val();
		$.post(base_url+"index.php/transaksi/pencairan/delete_item",{ 
			no:no,nogiro:nogiro,urutan:id},
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

function changeJenis()
{
   jenis=$("#jenistr").val();
   if(jenis=='P')
   {
	  $("#kasbank").val("HGM");
	  $("#hidekasbank").val("HGM");
   }else
   {
	  $("#kasbank").val("PGM");
	  $("#hidekasbank").val("HGM");
   }
}
