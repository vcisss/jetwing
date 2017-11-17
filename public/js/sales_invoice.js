function cekTheform()
{
	var pcode1 = document.getElementsByName("pcode[]").length;
	
	if(document.getElementById("v_customer").value=="")
    {
        alert("Customer harus dipilih");
        document.getElementById("v_customer").focus();
        return false;
    }
    else
    {
	
    	var yesSubmit = true;
    	        
        if(yesSubmit)
        {
			//alert("Hello");
			document.getElementById("theform").submit();	
		}
			
	}
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


function deleteTrans(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/sales_invoice/delete_trans/"+nodok;	
	}
	else
	{
  		return false;
	}
}
//add
function deleteDetail(sid,pcode,nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus PCode "+pcode+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/sales_invoice/delete_detail/"+sid+"/"+pcode+"/"+nodok+"";	
	}
	else
	{
  		return false;
	}
}//edit
function deleteDetail2(sid,pcode,nodok,url,si_number)
{
	var r=confirm("Apakah Anda Ingin Menghapus PCode "+pcode+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/sales_invoice/delete_detail2/"+sid+"/"+pcode+"/"+nodok+"/"+si_number+"/";	
	}
	else
	{
  		return false;
	}
}

function batal(url)
{
	var r=confirm("Apakah Anda Ingin membatalkan membuat Sales Invoice ini?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/sales_invoice/batal/";	
	}
	else
	{
  		return false;
	}
}



function pickThis(obj)
{
	//alert("Hello World");
	var v_invoiceno = $("#v_invoiceno").val();
	base_url = $("#base_url").val();
	
	if(v_invoiceno=="")
	{
        objek = obj.id;
		id = parseFloat(objek.substr(9,objek.length-9));
		//alert(id);
		//url = base_url+"index.php/pop/pop_up_sales_invoice/index/0/"+id+"/";
		url = base_url+"index.php/pop/pop_up_sales_invoice/index/00000/0/1/";
		windowOpener(525, 1000, 'Cari Delivery Order', url, 'Cari No DO')
	}
	else
	{
		objek = obj.id;
		id = parseFloat(objek.substr(9,objek.length-9));
		//alert(id);
		//url = base_url+"index.php/pop/pop_up_sales_invoice/index/0/"+id+"/";
		url = base_url+"index.php/pop/pop_up_sales_invoice/index/"+v_invoiceno+"/0/1/";
		windowOpener(525, 1000, 'Cari Delivery Order', url, 'Cari No DO')
	}
	
	    
	
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
    url = "index.php/transaksi/sales_invoice/vewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}

