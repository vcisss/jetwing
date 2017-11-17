function cekTheform()
{
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
    	
    	for (var s = 1; s <=pcode1; s++)
        {
        	pcode = $("#pcode"+s).val();
        	v_qty = $("#v_qty"+s).val();
        	
        	if(pcode)
        	{
        		if(v_qty*1==0)
	        	{
					alert("Qty PCode "+pcode+" harus diisi.");	
					document.getElementById("v_qty"+s).focus();
					
					yesSubmit = false;
					
					return false;
				}	
			}
        }
        
        if(yesSubmit)
        {
			document.getElementById("theform").submit();	
		}  
	}
}

/*function UpdateItemID(lastrow){
	   var	url = $("#base_url").val();
       var PCode = $('#pcode'+lastrow).val();
       $.post(url+"index.php/transaksi/penerimaan_lain/satuan/"+PCode+"/", function(data){
              alert(data);
              });
    	
}*/

function UpdateItemID(obj){

		objek = obj.id;
	    lastrow = objek.substr(5,objek.length-3);
		
		 var url = $("#base_url").val();
	     var PCode = $('#pcode'+lastrow).val();
	     
			  $.ajax({
					url: url+"index.php/transaksi/penerimaan_lain/satuan/"+PCode+"/",
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
		url = base_url+"index.php/pop/pop_up_penerimaan_lain/index/"+v_gudang+"/"+id+"/";
		
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
	alert(id);
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
		window.location = url+"index.php/transaksi/penerimaan_lain/delete_trans/"+nodok;	
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
		window.location = url+"index.php/transaksi/penerimaan_lain/delete_detail/"+sid+"/"+pcode+"/"+nodok+"";	
	}
	else
	{
  		return false;
	}
}

function PopUpPrint(kode, baseurl)
{
    url = "index.php/transaksi/penerimaan_lain/viewPrint/" + escape(kode);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}