function cekTheform()
{	var tot_realisasi = parseInt($('#v_tot_realisasi').val()); //x
    var tot_pv = parseInt($('#v_tot_pv').val()); //y
	
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
    }else if(tot_realisasi != tot_pv){
		alert("Total Realisasi Harus sama Total Payment.");
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

function deleteTrans(nodok, url)
{	
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/keuangan/realisasi_uang_muka/delete_trans/"+nodok+"/";	
	}
	else
	{
  		return false;
	}
}
