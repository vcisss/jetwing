function cekTheform()
{
	var v_user_level = document.getElementsByName("v_user_level[]").length;
	
	if(document.getElementById("v_market_list_name").value=="")
    {
        alert("Market List Name harus diisi");
        document.getElementById("v_market_list_name").focus();
        return false;
    }
    else
    {
		document.getElementById("theform").submit();
	}
}

function pickThis(obj)
{
	var base_url = $("#base_url").val();
	
	objek = obj.id;
	id = parseFloat(objek.substr(9,objek.length-9));
	url = base_url+"index.php/pop/pop_up_market_list/index/"+id+"/";
	windowOpener(600, 1200, 'Cari PCode', url, 'Cari PCode')
	
}

function ClearBaris(id)
{
	//alert(id);
	$("#pcode"+id).focus();
	$("#pcode"+id).val("");
	$("#v_namabarang"+id).val("");
	$("#v_qty"+id).val("");
}

function detailNew()
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
	$("#v_qty" + intCurrentRowId , clonedRow ).attr( { "id" : "v_qty" + intNewRowId,"value" : 0} );
	$("#v_satuan" + intCurrentRowId , clonedRow ).attr( { "id" : "v_satuan" + intNewRowId,"value" : "Karton"});
	$("#btn_del_detail_" + intCurrentRowId , clonedRow ).attr( { "id" : "btn_del_detail_" + intNewRowId} );
	$("#TabelDetail").append(clonedRow);
	$("#TabelDetail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#pcode" + intNewRowId).focus();
		ClearBaris(intNewRowId);
}

function deleteRow(obj)
{
	objek = obj.id;
	id = objek.substr(15,objek.length-3);
	
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
		window.location = url+"index.php/master/market_list/delete_detail/"+sid+"/"+pcode+"/"+nodok+"";	
	}
	else
	{
  		return false;
	}
}

function PopUpPrint(nodok, baseurl)
{
    url = "index.php/transaksi/permintaan_barang/vewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}