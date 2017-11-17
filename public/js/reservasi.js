function getGroupTravel(obj)
{
		base_url = $("#base_url").val();
		objek = obj.id;
		id = parseFloat(objek.substr(14,objek.length-14));
		url = base_url+"index.php/pop/pop_up_reservasi/index/"+id+"/";
		windowOpener(600, 1200, 'Cari Group Name', url, 'Cari Group Name')
		//window.open(url,'popuppage','width=1200,height=600,top=200,left=100');
}

//add_detail_menu yang lama
/*function addDetailPcode(obj)
{
		var nodok = document.getElementById("NoDokumen").value;
		base_url = $("#base_url").val();
		objek = obj.id;
		id = parseFloat(objek.substr(16,objek.length-16));
		//url = base_url+"index.php/pop/pop_up_detail_menu/index/"+id+"/"+nodok+"/";
		url = base_url+"index.php/pop/pop_up_detail_menu/index/"+nodok+"/";
		windowOpener(600, 1200, 'Add Detai Menu', url, 'Add Detai Menu')
		//window.open(url,'popuppage','width=1200,height=600,top=200,left=100');
}*/

function addDetailPcode(obj)
{
		var nodok = document.getElementById("NoDokumen").value;
		base_url = $("#base_url").val();
		
		//$('#pleaseWaitDialog').modal('show');
			
	    	$.ajax({
				type: "GET",
				url: base_url + "index.php/transaksi/reservasi/getDetailMenu/"+nodok,
				success: function(data) {
					$('#getDetailMenu').html(data);
					
						//$('#pleaseWaitDialog').modal('hide');
					
			
				}
			});
		
		//url = base_url+"index.php/pop/pop_up_detail_menu/index/"+nodok+"/";
}

function pickThis(obj)
{
		base_url = $("#base_url").val();
		objek = obj.id;
		id = parseFloat(objek.substr(9,objek.length-9));
		//alert(id);
		url = base_url+"index.php/pop/pop_up_permintaan_menu/index/"+id+"/";
		windowOpener(400, 1000, 'Cari Menu', url, 'Cari Menu')
		//window.open(url,'popuppage','width=1200,height=600,top=200,left=100');
}

function ClearBaris(id)
{
	//alert(id);
	$("#pcode"+id).focus();
	$("#pcode"+id).val("");
	$("#v_namabarang"+id).val("");
	$("#v_qty"+id).val("0");
	$("#v_hidden_qty"+id).val("0");
	
	$("#v_diskon"+id).val("0");
	$("#v_hidden_diskon"+id).val("0");
	
	$("#v_harga"+id).val("0");
	$("#v_hidden_harga"+id).val("0");
	$("#v_total"+id).val("0");
}

function addRow()
{
	var clonedRow = $("#TabelDetail tr:last").clone(true);
	var intCurrentRowId = parseFloat($('#TabelDetail tr').length )-2;
	nama = document.getElementsByName("pcode[]");
	temp = nama[intCurrentRowId].id;
	intCurrentRowId = temp.substr(5,temp.length-5);
	var intNewRowId = parseFloat(intCurrentRowId) + 1;
	$("#pcode" + intCurrentRowId , clonedRow ).attr( { "id" : "pcode" + intNewRowId,"value" : ""} );
	$("#get_pcode" + intCurrentRowId , clonedRow ).attr( { "id" : "get_pcode" + intNewRowId} );
	$("#v_namabarang" + intCurrentRowId , clonedRow ).attr( { "id" : "v_namabarang" + intNewRowId,"value" : ""} );
	$("#v_qty" + intCurrentRowId , clonedRow ).attr( { "id" : "v_qty" + intNewRowId,"value" : 0});
	$("#v_hidden_qty" + intCurrentRowId , clonedRow ).attr( { "id" : "v_hidden_qty" + intNewRowId,"value" : 0});
	
	$("#v_diskon" + intCurrentRowId , clonedRow ).attr( { "id" : "v_diskon" + intNewRowId,"value" : 0});
	$("#v_hidden_diskon" + intCurrentRowId , clonedRow ).attr( { "id" : "v_hidden_diskon" + intNewRowId,"value" : 0});
	
	$("#v_harga" + intCurrentRowId , clonedRow ).attr( { "id" : "v_harga" + intNewRowId,"value" : 0});
	$("#v_hidden_harga" + intCurrentRowId , clonedRow ).attr( { "id" : "v_hidden_harga" + intNewRowId,"value" : 0});
	$("#v_total" + intCurrentRowId , clonedRow ).attr( { "id" : "v_total" + intNewRowId,"value" : 0});
	$("#btn_del_detail_" + intCurrentRowId , clonedRow ).attr( { "id" : "btn_del_detail_" + intNewRowId} );
	$("#TabelDetail").append(clonedRow);
	$("#TabelDetail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#pcode" + intNewRowId).focus();
	ClearBaris(intNewRowId);
	document.getElementById("jml").value = intNewRowId;
	intNewRowId += 1;
}

function getTotal(){
	var jml = parseInt(document.getElementById("jml").value);
	//alert(jml);
	var grandttl = 0;
	for(a=1;a<=jml;a++){
		var qty = reform(document.getElementById("v_qty"+a).value)*1;
		//alert(qty);
		var hrg = reform(document.getElementById("v_harga"+a).value)*1;
		total = qty * hrg;
		grandttl = grandttl + parseInt(total);
		document.getElementById("v_grand_total").value = format(Math.ceil(grandttl));
		document.getElementById("v_total"+a).value = format(total);
		document.getElementById("v_hidden_qty"+a).value = qty;
		document.getElementById("v_hidden_harga"+a).value = hrg;
		document.getElementById("v_hidden_grand_total").value = Math.ceil(grandttl);
	}
}

function getDiskon(){
	var jml = parseInt(document.getElementById("jml").value);
	//alert(jml);
	var grandttl = 0;
	for(a=1;a<=jml;a++){
		var qty = reform(document.getElementById("v_qty"+a).value)*1;
		var dsk= reform(document.getElementById("v_diskon"+a).value)*1;
		//alert(dsk);
		var hrg = reform(document.getElementById("v_harga"+a).value)*1;
		//total = qty * hrg;
		total = (hrg-(hrg*dsk/100))*qty;
		grandttl = grandttl + parseInt(total);
		document.getElementById("v_grand_total").value = format(grandttl);
		document.getElementById("v_total"+a).value = format(total);
		document.getElementById("v_hidden_qty"+a).value = qty;
		document.getElementById("v_hidden_diskon"+a).value = dsk;
		document.getElementById("v_hidden_harga"+a).value = hrg;
		document.getElementById("v_hidden_grand_total").value = grandttl;
	}
}

function getTotal2(){
	var jml = parseInt(document.getElementById("jml").value);
	//alert(jml);
	var grandttl = 0;
	for(a=1;a<=jml;a++){
		var qty = parseFloat(document.getElementById("v_qty"+a).value);
		var hrg = parseFloat(document.getElementById("v_harga"+a).value);
		total = qty * hrg;
		grandttl = grandttl + parseInt(total);
		document.getElementById("v_grand_total").value = format(grandttl);
		document.getElementById("v_total"+a).value = total;
	}
}

function deleteRow(obj)
{
	objek = obj.id;
	id = objek.substr(15,objek.length-3);
		
	var ttl = document.getElementById("v_total"+id).value;
	var grandttl = document.getElementById("v_grand_total").value;
	var ttl_kurang = grandttl - ttl;
	document.getElementById("v_grand_total").value = ttl_kurang;

	var lastRow = document.getElementsByName("pcode[]").length;
	
	if( lastRow > 1)
	{
		$('#baris'+id).remove();
		
	}else{
			alert("Baris ini tidak dapat dihapus\nMinimal harus ada 1 baris tersimpan");
	}
}

function deleteTrans(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/permintaan_barang/delete_trans/"+nodok;	
	}
	else
	{
  		return false;
	}
}

function deleteDetail(sid,pcode,nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus PCode "+pcode+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/permintaan_barang/delete_detail/"+sid+"/"+pcode+"/"+nodok+"";	
	}
	else
	{
  		return false;
	}
}

function closeWindow(elm){
	self.close() ;
    return; 
}

function cekTheform()
{
	if(document.getElementById("v_grand_total").value=="0")
    {
        alert("Belum ada menu yang diinput");
        return false;
    }else{
		document.getElementById("theform").submit();
		return true;
	}
}

function cekTheformReserv()
{
	if(document.getElementById("Total").value=="")
    {
        alert("Total transaksi masih kosong");
        return false;
    }else{
		document.getElementById("theform").submit();
		return true;
	}
}

function cekTheformReserv2()
{
	if(document.getElementById("Total").value=="")
    {
        alert("Total transaksi masih kosong");
        return false;
    }else{
    	document.getElementById("v_approve").value = '1';
		document.getElementById("theform").submit();
		return true;
	}
}

function approve()
{
	if(document.getElementById("Total").value=="")
    {
        alert("Total transaksi masih kosong");
        return false;
    }else{
    	document.getElementById("v_approve_head").value = '1';
		document.getElementById("theform").submit();
		return true;
	}
}

function reject()
{
	if(document.getElementById("Total").value=="")
    {
        alert("Total transaksi masih kosong");
        return false;
    }else{
    	document.getElementById("v_reject_head").value = '1';
		document.getElementById("theform").submit();
		return true;
	}
}


function edit_request()
{
	if(document.getElementById("ket_edit_request").value=="")
    {
        alert("Keterangan Edit Request masih kosong");
        return false;
    }else{
    	document.getElementById("v_edit_request").value = '1';
		document.getElementById("theform").submit();
		return true;
	}
}

function otherCheck(elm){
	$("#func_type_other_content").toggle();
}

function getTotalBayar(){
	var biayatambahan = reform(document.getElementById("Biaya_tambahan").value)*1;
	var total = reform(document.getElementById("Total").value)*1;
	var dp = reform(document.getElementById("dp").value)*1;
	var tobay = (biayatambahan + total) - dp;
	document.getElementById("sisa_pembayaran").value = format(tobay);
	document.getElementById("hidden_sisa_pembayaran").value = tobay;
}

function getDPBayar(){
	var biayatambahan = reform(document.getElementById("Biaya_tambahan").value)*1;
	var total = reform(document.getElementById("Total").value)*1;
	var dp = reform(document.getElementById("dp").value)*1;
	var tobay = (biayatambahan + total) - dp;
	document.getElementById("sisa_pembayaran").value = format(tobay);
	document.getElementById("hidden_biaya_tambahan").value = biayatambahan;
	document.getElementById("hidden_dp").value = dp;
	document.getElementById("hidden_sisa_pembayaran").value = tobay;
	
}

//ini adalah getDPBayar_dengan uang_muka_beo
/*function getDPBayar(){
	var pilihdp = document.getElementById("pilihdp").value;
	var hasil=pilihdp.split('#');
    var id = hasil[0];
    var nilai  = hasil[1];
	
	document.getElementById("hidden_dp").value = nilai;
	document.getElementById("dp").value = format(nilai);
	
	var biayatambahan = reform(document.getElementById("Biaya_tambahan").value)*1;
	var total = reform(document.getElementById("Total").value)*1;
	var dp = reform(document.getElementById("hidden_dp").value)*1;
	var tobay = (biayatambahan + total) - dp;
	document.getElementById("sisa_pembayaran").value = format(tobay);
	document.getElementById("hidden_biaya_tambahan").value = biayatambahan;
	document.getElementById("hidden_sisa_pembayaran").value = tobay;
	
}*/

function getDPBayar_booking(){
	
	var biayatambahan = reform(document.getElementById("Biaya_tambahan").value)*1;
	var total = reform(document.getElementById("Total").value)*1;
	var tobay = (biayatambahan + total);
	document.getElementById("sisa_pembayaran").value = format(tobay);
	document.getElementById("hidden_biaya_tambahan").value = biayatambahan;
	document.getElementById("hidden_sisa_pembayaran").value = tobay;
	
}

function getVoucher(){
	var pilihdp = document.getElementById("pilihvoucher").value;
	var hasil=pilihdp.split('#');
    var id = hasil[0];
    var pocer  = hasil[1];
	document.getElementById("voucher").value = pocer;	
}

function getTambahanBiaya(){
	var biayatambahan = reform(document.getElementById("Biaya_tambahan").value)*1;
	var total = reform(document.getElementById("Total").value)*1;
	var dp = reform(document.getElementById("dp").value)*1;
	var tobay = (biayatambahan + total) - dp;
	var tobays = (biayatambahan + total);
	document.getElementById("sisa_pembayaran").value = format(tobay);
	document.getElementById("hidden_biaya_tambahan").value = biayatambahan;
	document.getElementById("hidden_dp").value = dp;
	document.getElementById("hidden_sisa_pembayaran").value = tobay;
	
	document.getElementById("setTotal").value = format(tobays);
	document.getElementById("hidden_settotal").value = tobays;
	
}

function jml_hidden_total(){
	var hidden_tambah = reform(document.getElementById("hidden_biaya_tambahan").value)*1;
	var hidden_total= reform(document.getElementById("hidden_total").value)*1;
	var jumlah = hidden_tambah + hidden_total;
	document.getElementById("hidden_total").value = jumlah;
}

function refresh(){
	//alert("test");
	location.reload();
}

function formReset(elm) {
    document.getElementById("theform").reset();
	location.reload();
}

function tutup_detail_beo() {
	$('#getDetailMenu').fadeIn('veryslow');
	
	var v_hidden_grand_total= reform(document.getElementById("v_hidden_grand_total").value)*1;
	
	var total_x= reform(document.getElementById("hidden_total").value)*1;
	
	total_v_hidden_grand_total=total_x+v_hidden_grand_total;
	
	document.getElementById("hidden_total").value = total_v_hidden_grand_total;
	document.getElementById("Total").value = format(total_v_hidden_grand_total);
	
	getTotalBayar();
	getTambahanBiaya();
	
	document.getElementById("add_detail_pcode").style.display = "";
    document.getElementById("getDetailMenu").style.display = "none";
}

function tutup_detail_beo2() {
	$('#getDetailMenu').fadeIn('veryslow');
	document.getElementById("add_detail_pcode").style.display = "";
    document.getElementById("getDetailMenu").style.display = "none";
}

function buka_detail_beo() {
	$('#getDetailMenu').fadeIn('veryslow');
	document.getElementById("add_detail_pcode").style.display = "none";
    document.getElementById("getDetailMenu").style.display = "";
}