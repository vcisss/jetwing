function ceksubsize(){
	if(cekoption("kode","Memasukkan Kode Sub Size"))
	if(cekoption("nama","Memasukkan Ukuran"))
	if(cekAngka("realsize","Total Ukuran"))
		document.getElementById("subsize").submit();
}
//////////////////****************user*************//////////
function cekuser(){
	if(cekoption("kode","Memasukkan Kode User"))
	if(cekoption("nama","Memasukkan Nama User"))
	if(cekPjgKode("nama","Nama User",3))
	if(cekoption("passw","Memasukkan Password"))
	if(cekPjgKode("passw","Password",3))
		document.getElementById("user").submit();
}

////////////////**********gudang************///////////

function cekgudang(){
	if(cekoption("kode","Memasukkan Kode Gudang"))
	if(cekoption("nama","Memasukkan Keterangan"))
		document.getElementById("gudang").submit();
}

//////////*****************contact**********///////////
function cekcontact()
{
	if(cekoption("tipe","Memasukkan Tipe Kontak"))
	if(cekoption("nama","Memasukkan Nama Contact"))
	if(cekoption("alm","Memasukkan Alamat"))
	if(cekoption("kota","Memasukkan Kota"))
	if(cekoption("telp","Memasukkan No. Telp"))
	if(cekoption("almkirim","Memasukkan Alamat Kirim"))
	if(cekoption("kotakirim","Memasukkan Kota Kirim"))
		document.getElementById("contact").submit();
}

//////////*****************supplier**********///////////
function ceksupplier()
{
	if(cekoption("tipe","Memasukkan Tipe Kontak"))
	if(cekoption("nama","Memasukkan Nama Contact"))
	if(cekoption("alm","Memasukkan Alamat"))
	if(cekoption("kota","Memasukkan Kota"))
	if(cekoption("telp","Memasukkan No. Telp"))
	if(cekoption("almkirim","Memasukkan Alamat Kirim"))
	if(cekoption("kotakirim","Memasukkan Kota Kirim"))
		document.getElementById("supplier").submit();
}

//////////*****************customer**********///////////
function cekcustomer()
{
	if(cekoption("tipe","Memasukkan Tipe Kontak"))
	if(cekoption("nama","Memasukkan Nama Contact"))
	if(cekoption("alm","Memasukkan Alamat"))
	if(cekoption("kota","Memasukkan Kota"))
	if(cekoption("telp","Memasukkan No. Telp"))
	if(cekoption("almkirim","Memasukkan Alamat Kirim"))
	if(cekoption("kotakirim","Memasukkan Kota Kirim"))
		document.getElementById("customer").submit();
}

function loading(url)
{
	$('#bdate').datepicker({ dateFormat: 'dd-mm-yy',mandatory: true,showOn: "both", buttonImage: url+ "public/images/calendar.png", buttonImageOnly: true } );
}
//////////////************voucher**************////////////
function cekvoucher(){
	if(cekoption("kode","Memasukkan Kode Voucher"))
	if(cekoption("nama","Memasukkan Keterangan"))
	if(cekAngka("nilai","Nominal"))
		document.getElementById("voucher").submit();
}

///////////////////**********************menu******************/////////////
function cekmenuroot(){
	if(cekoption("nama","Memasukkan Nama Root"))
		document.getElementById("root").submit();
}

function watchMenu(url)
{
 	 $("#nama").val($("#allmenu").val());

	$.post(url+"index.php/setup/menu/find_url",{ menu: $("#allmenu").val()},
	function(data){
	 	$("#url").val(data);
	 	document.getElementById("url").disabled = false;
		if(data=='')
		{
			document.getElementById("url").disabled = true;
		}
	});
	$.post(url+"index.php/setup/menu/GetRootSibling",{ menu: $("#allmenu").val()},
	function(data){
	   $("#menu").empty();
	   $("#menu").append("<option value='tetap'>Tetap</option>");
	   $("#menu").append("<option value=''>Baris Awal</option>");
	   $("#menu").append(data);
	});
}

function ambilsubs(url)
{
	$.post(url+"index.php/setup/menu/getSubMenuSibling",{ menu: $("#rootmenu").val()},
	function(data){
	   $("#menu").empty();
	   $("#menu").append("<option value=''>Baris Awal</option>");
	   $("#menu").append(data);
	});
}

function ambildebitno(url)
{
	
	//alert(url+" Hello World ");
	$.post(url+"index.php/transaksi/pemotongan_hutang/getDebitCreditNo", { KdSupplier: $("#KdSupplier").val()},
	function(data){
	   $("#debitno").empty();
	   $("#debitno").append(data);
	   $("#debitno2").empty();
	   $("#debitno2").append(data);
	});
}

function ambilcreditno(url)
{
	//var pelanggan = $("#KdCustomer").val()
	//alert(url+" Hello World "+pelanggan);
	
	$.post(url+"index.php/transaksi/pemotongan_piutang/getCreditNoteNo", { KdCustomer: $("#KdCustomer").val()},
	function(data){
	   $("#creditno").empty();
	   $("#creditno").append(data);
	});
}

//*******************user permission*************//
function setpermission(){
    /*
	dml=document.forms[0];
	len = dml.elements.length;
	document.getElementById("addhidden").value="";
	document.getElementById("edithidden").value="";
	document.getElementById("delhidden").value="";
	document.getElementById("viewhidden").value="";
	document.getElementById("namahidden").value="";
	add = "";
	edit = "";
	del = "";
	view = "";
	nama="";
 	for(i=0;i<dml.add.length;i++){
 	 	nama = nama + "|" +dml.nama[i].value;
 	 	if(dml.add[i].checked==true)
		{
			add = add+"Y";
		}
		else
		{
			add = add+"T";
		}
		if(dml.edit[i].checked==true)
		{
			edit = edit+"Y";
		}
		else
		{
			edit = edit+"T";
		}
		if(dml.del[i].checked==true)
		{
			del = del+"Y";
		}
		else
		{
			del = del+"T";
		}
		if(dml.view[i].checked==true)
		{
			view = view+"Y";
		}
		else
		{
			view = view+"T";
		}
 	}
	document.getElementById("addhidden").value=add;
	document.getElementById("edithidden").value=edit;
	document.getElementById("delhidden").value=del;
	document.getElementById("viewhidden").value=view;
	document.getElementById("namahidden").value=nama;
	*/
	document.getElementById("permisssion").submit();
	
}

function cek_tgl_approve_so(url){
	tanggal = document.getElementById("v_tgl_dokumen").value;
	gudang = document.getElementById("v_gudang").value;
	
	$.ajax({
					url: url+"index.php/transaksi/all_cek/cek_tgl_approve_so/",
					data: {tgl:tanggal,gdg:gudang},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						
						if(data=='0'){
							alert("Tanggal Dokumen harus lebih dari tanggal Approve SO Gudang ini.");
							document.getElementById('v_tgl_dokumen').focus();
							$("#v_gudang").val("");
						}else{
							document.getElementById('v_keterangan').focus();
						}	
					    						
					},
					error: function(e) 
					{
						//alert(e);
					} 
			});
}



function cek_tgl_approve_so_type2(url){
	tanggal = document.getElementById("v_tgl_dokumen").value;
	gudang_from = document.getElementById("v_gudang_from").value;
	gudang_to = document.getElementById("v_gudang_to").value;
	
	$.ajax({
					url: url+"index.php/transaksi/all_cek/cek_tgl_approve_so_type2/",
					data: {tgl:tanggal,gdg1:gudang_from,gdg2:gudang_to},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						
						if(data=='0'){
							alert("Tanggal Dokumen harus lebih dari tanggal Approve SO Gudang ini.");
							document.getElementById('v_tgl_dokumen').focus();
							$("#v_gudang_from").val("");
							$("#v_gudang_to").val("");
						}else{
							document.getElementById('v_keterangan').focus();
						}	
					    						
					},
					error: function(e) 
					{
						//alert(e);
					} 
			});
}

function cek_tgl_approve_so_type3(url){
	tanggal = document.getElementById("tanggal").value;
	gudang = document.getElementById("gd").value;
	
	$.ajax({
					url: url+"index.php/transaksi/all_cek/cek_tgl_approve_so/",
					data: {tgl:tanggal,gdg:gudang},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						
						if(data=='0'){
							alert("Tanggal Dokumen harus lebih dari tanggal Approve SO Gudang ini.");
							document.getElementById('tanggal').focus();
							$("#gd").val("");
						}else{
							document.getElementById('ket').focus();
						}	
					    						
					},
					error: function(e) 
					{
						//alert(e);
					} 
			});
}

function cek_tgl_approve_so_type4(url){
	tanggal = document.getElementById("v_tgl_dokumen").value;
	gudang = document.getElementById("v_gudang").value;
	
	$.ajax({
					url: url+"index.php/transaksi/all_cek/cek_tgl_approve_so/",
					data: {tgl:tanggal,gdg:gudang},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						
						if(data=='0'){
							alert("Tanggal Dokumen harus lebih dari tanggal Approve SO Gudang ini.");
							document.getElementById('v_tgl_dokumen').focus();
							$("#v_gudang").val("");
						}else{
							document.getElementById('v_note').focus();
						}	
					    						
					},
					error: function(e) 
					{
						//alert(e);
					} 
			});
}

function reset_gudang(){
	//alert("Silahkan Pilih Gudang Kembali.");
	$("#v_gudang").val("");
}

function reset_gudang_type2(){
	//alert("Silahkan Pilih Gudang Kembali.");
	$("#v_gudang_from").val("");
	$("#v_gudang_to").val("");
}
