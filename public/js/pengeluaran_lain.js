function cek(obj){

		objek = obj.id;
		
	    s = objek.substr(5,objek.length-5);
	
        	pcode = $("#pcode"+s).val();
        	v_qty = $("#v_qty"+s).val();
			gudang = $("#v_gudang").val();
			tgl_dok = $("#v_tgl_dokumen").val();
            var hasil=tgl_dok.split('-');
            var bulan = hasil[1];
			var tahun  = hasil[2];
           
				var	url = $("#base_url").val();
        		$.ajax({
					url: url+"index.php/transaksi/pengeluaran_lain/cek_stock/",
					data: {id:pcode,qty:v_qty,gdg:gudang,tgl:tgl_dok},
					type: "POST",
					dataType: "json",
			        success: function(data)
					{
						if(data.status)
						{
							alert(pcode+" ini stocknya tidak cukup");
							$("#v_qty"+s).val("");
							$("#v_qty"+s).focus();
							
							//pop up tampil mutasi
							url = url+"index.php/pop/pop_up_mutasi_barang/index/"+pcode+"/"+bulan+"/"+tahun+"/"+gudang+"/gdg/";
		                    windowOpener(600, 600, 'Mutasi Barang', url, 'Mutasi Barang')
		
							return false;
						}						
					} 
				});	
				
		   
}



function cekTheform()
{
	//banyaknya PCode detail dalam array
	var pcode1 = document.getElementsByName("pcode[]").length;
	
	if(document.getElementById("v_tgl_dokumen").value=="")
    {
        alert("Tanggal MS harus diisi");
        document.getElementById("form-control-new").focus();
        return false;
    }
    else if(document.getElementById("v_type").value=="")
    {
        alert("Type harus dipilih");
        document.getElementById("v_type").focus();
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
		
		//cek untuk validasi apakah sudah diisi
		for (var s = 1; s <=pcode1; s++)
        {
        	pcode = $("#pcode"+s).val();
        	v_qty = $("#v_qty"+s).val();
        	ket = $("#v_keterangan_pcode"+s).val();
        	
        	if(pcode)
        	{
        		if(v_qty*1==0)
	        	{
					alert("Qty PCode "+pcode+" harus diisi.");	
					document.getElementById("v_qty"+s).focus();
					
					yesSubmit = false;
					
					return false;
				}
				
				if(ket=="")
			    {
			        alert("Keterangan "+pcode+" harus diisi");
			        document.getElementById("v_keterangan_pcode"+s).focus();
			        yesSubmit = false;
			        return false;
			    }	
			}
        }
        
        if(yesSubmit)
        {
			//alert("submit");
			document.getElementById("theform").submit();	
			return false;
		}  
	}
}

function UpdateItemID(obj){

		objek = obj.id;
	    lastrow = objek.substr(5,objek.length-3);
		
		 var url = $("#base_url").val();
	     var PCode = $('#pcode'+lastrow).val();
	     
			  $.ajax({
					url: url+"index.php/transaksi/pengeluaran_lain/satuan/"+PCode+"/",
					data: {pcode:PCode},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						$('#v_satuan'+lastrow).html(res);
					},
					error: function(e) 
					{
						alert(e);
					} 
					   });    	
}

function pickThis(obj)
{
	var v_gudang = $("#v_gudang").val();
	var	base_url = $("#base_url").val();
	
	if(v_gudang=="")
	{
        alert("Gudang harus dipilih");
        document.getElementById("v_gudang").focus();
		
		return false;
	}
	else
	{
		objek = obj.id;
		id = parseFloat(objek.substr(9,objek.length-9));
		url = base_url+"index.php/pop/pop_up_pengeluaran_lain/index/"+v_gudang+"/"+id+"/";
		
		windowOpener(600, 1200, 'Cari PCode', url, 'Cari PCode')
	}
}

function ClearBaris(id)
{
	//alert(id);
	//$("#pcode"+id).focus();
	$("#pcode"+id).val("");
	$("#v_namabarang"+id).val("");
	$("#v_qty"+id).val("");
	$("#v_satuan"+id).val(" -- Pilih -- ");
	$("#v_keterangan_pcode"+id).val("");
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
	$("#v_keterangan_pcode" + intCurrentRowId , clonedRow ).attr( { "id" : "v_keterangan_pcode" + intNewRowId,"value" : ""});
	$("#btn_del_detail_" + intCurrentRowId , clonedRow ).attr( { "id" : "btn_del_detail_" + intNewRowId} );
	$("#TabelDetail").append(clonedRow);
	$("#TabelDetail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	//$("#pcode" + intNewRowId).focus();
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
		window.location = url+"index.php/transaksi/pengeluaran_lain/delete_trans/"+nodok;	
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
		window.location = url+"index.php/transaksi/pengeluaran_lain/delete_detail/"+sid+"/"+pcode+"/"+nodok+"";	
	}
	else
	{
  		return false;
	}
}

function PopUpPrint(kode, baseurl)
{
    url = "index.php/transaksi/pengeluaran_lain/viewPrint/" + escape(kode);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}