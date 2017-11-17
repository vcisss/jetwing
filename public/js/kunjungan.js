function cekTheform()
{
	var pcode1 = document.getElementsByName("kdtour[]").length;
	
    if(document.getElementById("v_salesman").value=="")
    {
        alert("Salesman harus dipilih");
        document.getElementById("v_salesman").focus();
        return false;
    }
    else
    {
	
    	var yesSubmit = true;
    	
        if(yesSubmit)
        {
			document.getElementById("theform").submit();	
		}  
	}
}

function detailNew()
{
	var clonedRow = $("#TabelDetail tr:last").clone(true);
	var intCurrentRowId = parseFloat($('#TabelDetail tr').length )-2;
	nama = document.getElementsByName("kdtour[]");
	temp = nama[intCurrentRowId].id;
	intCurrentRowId = temp.substr(6,temp.length-6);
	var intNewRowId = parseFloat(intCurrentRowId) + 1;
	$("#kdtour" + intCurrentRowId , clonedRow ).attr( { "id" : "kdtour" + intNewRowId,"value" : ""} );
	$("#get_kdtour" + intCurrentRowId , clonedRow ).attr( { "id" : "get_kdtour" + intNewRowId} );
	$("#v_namatour" + intCurrentRowId , clonedRow ).attr( { "id" : "v_namatour" + intNewRowId,"value" : ""} );
	$("#v_contact" + intCurrentRowId , clonedRow ).attr( { "id" : "v_contact" + intNewRowId,"value" : ""} );
	$("#v_phone" + intCurrentRowId , clonedRow ).attr( { "id" : "v_phone" + intNewRowId,"value" : ""} );
	$("#btn_del_detail_" + intCurrentRowId , clonedRow ).attr( { "id" : "btn_del_detail_" + intNewRowId} );
	$("#TabelDetail").append(clonedRow);
	$("#TabelDetail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	$("#kdtour" + intNewRowId).focus();
	ClearBaris(intNewRowId);
}

function ClearBaris(id)
{
	
	$("#kdtour"+id).focus();
	$("#kdtour"+id).val("");
	$("#v_namatour"+id).val("");
	$("#v_contact"+id).val("");
	$("#v_phone"+id).val("");
}


function deleteTrans(noku,url)
{
	var r=confirm("Apakah Anda Ingin Membatalkan No Kunjungan "+noku+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/kunjungan/delete_trans/"+noku;	
	}
	else
	{
  		return false;
	}
}

function deleteDetail(sid,kdtour,noku,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus Kode Travel "+kdtour+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/kunjungan/delete_detail/"+sid+"/"+kdtour+"/"+noku+"";	
	}
	else
	{
  		return false;
	}
}


function pickThis(obj)
{
	base_url = $("#base_url").val();

	    objek = obj.id;
		
		id = parseFloat(objek.substr(10,objek.length-10));

		url = base_url+"index.php/pop/pop_up_kunjungan/index/0/"+id+"/";
		windowOpener(525, 1000, 'Cari Kode Tour Travel', url, 'Cari Kode Tour Travel')
	
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
			alert("Baris ini tidak dapat dihapus \n Minimal harus ada 1 baris tersimpan");
	}
}

function PopUpPrint(nodok, baseurl)
{
    url = "index.php/transaksi/delivery_order/vewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}

