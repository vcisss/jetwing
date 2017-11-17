function CallAjax(tipenya,param1,param2,param3,param4,param5)
{
    try{    
        if (!tipenya) return false;
        
        if (param1 == undefined) param1 = '';
        if (param2 == undefined) param2 = '';
        if (param3 == undefined) param3 = '';
        if (param4 == undefined) param4 = '';
        if (param5 == undefined) param5 = '';
        
        var variabel;
        variabel = "";
        
        var	base_url = $("#base_url").val();
              
        if(tipenya=='search_keyword_noreservasi')
        {  
    		$("#span_loading").css("display","");
    		document.getElementById("span_noreservasi").innerHTML = "... ";
            
            $.post(base_url + "index.php/transaksi/reservasi_konfirmasi/getAjax/", {ajax:tipenya, v_keyword:param1},
    		function (data) {
    			document.getElementById("span_noreservasi").innerHTML = data;	
    			
    			$("#span_loading").css("display","none");
    		});
        }
        else if(tipenya=='ajax_noreservasi')
        {  
        	$("#span_loading").css("display","");
        	
            $.post(base_url + "index.php/transaksi/reservasi_konfirmasi/getAjax/", {ajax:tipenya, v_nodok:param1},
    		function (data) {
    			
    			arr_data = data.split('||');
    			
    			if(arr_data[0])
    			{
	        		document.getElementById("v_tourtravel").value = arr_data[0];
	    			document.getElementById("td_tourgroup").innerHTML = arr_data[1];
	    			document.getElementById("td_tourpic").innerHTML = arr_data[2];
	    			document.getElementById("td_tourtelp").innerHTML = arr_data[3];
	    			document.getElementById("td_touremail").innerHTML = arr_data[4];
	    			document.getElementById("td_touralamat").innerHTML = arr_data[5];
	    			document.getElementById("v_dewasa").innerHTML = arr_data[6];
	    			document.getElementById("v_anak").innerHTML = arr_data[7];
	    			document.getElementById("v_batita").innerHTML = arr_data[8];
				}
				else
				{
					document.getElementById("v_tourtravel").value = "";
	    			document.getElementById("td_tourgroup").innerHTML = "";
	    			document.getElementById("td_tourpic").innerHTML = "";
	    			document.getElementById("td_tourtelp").innerHTML = "";
	    			document.getElementById("td_touremail").innerHTML = "";
	    			document.getElementById("td_touralamat").innerHTML = "";
	    			document.getElementById("v_dewasa").innerHTML = "";
	    			document.getElementById("v_anak").innerHTML = "";
	    			document.getElementById("v_batita").innerHTML = "";
				}
				
				$("#span_loading").css("display","none");
				//document.getElementById("v_tourleader").focus();	
				
    		});
        }
    	else if(tipenya=='search_keyword_tourleader')
        {  
    		$("#span_loading").css("display","");
    		document.getElementById("span_tourleader").innerHTML = "... ";
            
            $.post(base_url + "index.php/transaksi/reservasi_konfirmasi/getAjax/", {ajax:tipenya, v_keyword:param1},
    		function (data) {
    			document.getElementById("span_tourleader").innerHTML = data;	
    			
    			$("#span_loading").css("display","none");
    		});
        }
    }
    catch(err)
    {
        txt  = "There was an error on this page.\n\n";
        txt += "Error description AJAX : "+ err.message +"\n\n";
        txt += "Click OK to continue\n\n";
        alert(txt);
    }  
}

function cekTheform()
{
	if(document.getElementById("v_tgl_dokumen").value=="")
    {
        alert("Tanggal harus diisi");
        document.getElementById("v_tgl_dokumen").focus();
        return false;
    }
    else if(document.getElementById("v_jam").value=="")
    {
        alert("Jam harus dipilih");
        document.getElementById("v_jam").focus();
        return false;
    }
    else if(document.getElementById("v_noreservasi").value=="")
    {
        alert("No Reservasi harus dipilih");
        return false;
    }
    /*else if(document.getElementById("chk_tourleader").checked && document.getElementById("v_tourleader_new").value=="")
    {
        alert("Tour Leader harus diisi");
        document.getElementById("v_tourleader_new").focus();
        return false;
    }
    else if(!document.getElementById("chk_tourleader").checked && document.getElementById("v_tourleader").value=="")
    {
        alert("Tour Leader harus dipilih");
        return false;
	}*/
	
	else if(document.getElementById("v_tl").value=="")
    {
        alert("Jumlah Tour Leader");
        document.getElementById("v_tl").focus();
        return false;
    }	
	
	else if(document.getElementById("v_tg").value=="")
    {
        alert("Jumlah Tour Guide");
        document.getElementById("v_tg").focus();
        return false;
    }
		
    else if(document.getElementById("v_dewasa").value=="")
    {
        alert("Dewasa");
        document.getElementById("v_dewasa").focus();
        return false;
    }
    else if(document.getElementById("v_anak").value=="")
    {
        alert("Dewasa");
        document.getElementById("v_anak").focus();
        return false;
    }
    else if(document.getElementById("v_batita").value=="")
    {
        alert("Batita");
        document.getElementById("v_batita").focus();
        return false;
    }
    
    /*else if(document.getElementById("v_nostiker").value=="")
    {
        alert("No Stiker harus diisi");
        document.getElementById("v_nostiker").focus();
        return false;
    }*/
    else
    {
	    
    	document.getElementById("theform").submit();	
	}
}

function change_tourleader()
{
	var chk_tourleader = document.getElementById("chk_tourleader").checked;

	if(chk_tourleader)
	{
		document.getElementById('span_keyword_tourleader').style.display = 'none';
		document.getElementById('span_tourleader').style.display = 'none';
		document.getElementById('span_tourleader_text').style.display = '';
    
		document.getElementById('v_tourleader_new').focus();
	}
	else
	{
		document.getElementById('span_keyword_tourleader').style.display = '';
		document.getElementById('span_tourleader').style.display = '';
		document.getElementById('span_tourleader_text').style.display = 'none';
	} 
}

function PopUpPrint(kode, baseurl)
{
    url = "index.php/transaksi/reservasi_konfirmasi/viewPrintPdf/" + escape(kode);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}