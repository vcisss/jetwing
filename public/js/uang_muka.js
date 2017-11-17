function cekTheform()
{	
    if(document.getElementById("v_kas_bank").value=="")
    {
        alert("Kas Bank harus dipilih");
        document.getElementById("v_kas_bank").focus();
        return false;
    }
	else if(document.getElementById("v_no_ref").value=="")
    {
        alert("No. Referensi harus diisi.");
        document.getElementById("v_no_ref").focus();
        return false;
    }
	else if(document.getElementById("v_employee").value=="")
    {
        alert("Nama Karyawan harus dipilih");
        document.getElementById("v_employee").focus();
        return false;
    }
    
    else if(document.getElementById("v_jumlah").value=="")
    {
        alert("Jumlah harus diisi.");
        document.getElementById("v_jumlah").focus();
        return false;
    }
    else if(document.getElementById("v_no_rek").value=="")
    {
        alert("No. Rekening harus diisi.");
        document.getElementById("v_no_rek").focus();
        return false;
    }
    else if(document.getElementById("v_subdivisi").value=="")
    {
        alert("Sub Divisi harus dipilih");
        document.getElementById("v_subdivisi").focus();
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

function deleteTrans(nodok, nopv, url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/keuangan/uang_muka/delete_trans/"+nodok+"/"+nopv;	
	}
	else
	{
  		return false;
	}
}
