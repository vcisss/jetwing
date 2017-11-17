function cekTheform()
{
	var pcode1 = document.getElementsByName("pb_pcode[]").length;
	
	if(document.getElementById("v_tgl_dokumen").value=="")
    {
        alert("Tanggal PB harus diisi");
        document.getElementById("v_tgl_dokumen").focus();
        return false;
    }
	else if(document.getElementById("v_est_terima").value=="")
    {
        alert("Estimasi Tanggal Terima harus diisi");
        document.getElementById("v_est_terima").focus();
        return false;
    }
    else if(document.getElementById("v_gudang").value=="")
    {
        alert("Gudang harus dipilih");
        document.getElementById("v_gudang").focus();
        return false;
    }
    else
    {
    	var yesSubmit = true;
    	
    	/*for (var s = 1; s <=pcode1; s++)
        {
        	pb_pcode = $("#pb_pcode"+s).val();
        	v_qty = reform($("#v_qty"+s).val())*1;
        	
        	if(v_qty*1>0)
        	{
				alert("Qty PCode "+pb_pcode+" harus diisi.");	
				document.getElementById("v_qty"+s).focus();
				
				yesSubmit = false;
				
				return false;
			}
        }*/
        
        if(yesSubmit)
        {
			document.getElementById("theform").submit();	
		}  
	}
}

function deleteRow(obj)
{
	var r=confirm("Apakah Anda Ingin Menghapus ?")
    if(r === true) 
    {
		objek = obj.id;
		id = objek.substr(15,objek.length-3);
		
		var lastRow = document.getElementsByName("pb_pcode[]").length;
		
		if( lastRow > 1)
		{
			$('#baris'+id).remove();
		}
		else
		{
				alert("Baris ini tidak dapat dihapus\nMinimal harus ada 1 baris tersimpan");
		}
    }
    else
    {
		return false;
	}
}

function deleteTrans(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/purchase_request/delete_trans/"+nodok;	
	}
	else
	{
  		return false;
	}
}

function PopUpPrint(nodok, baseurl)
{
    url = "index.php/transaksi/purchase_request/viewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}