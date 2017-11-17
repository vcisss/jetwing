function cekTheform()
{
	if($('#flag').val()=="edit"){
	var grdTotal = document.getElementById('grdTotal');
				if(grdTotal.value==0){
					alert("Grand Total = 0 , Silahkan enter disalah satu kolom Harga untuk mendapatkan Grand Total.");
					document.getElementById("harga1").focus();
				}
	}			
	if(document.getElementById("v_supplier").value=="")
    {
        alert("Supplier harus dipilih");
        document.getElementById("v_supplier").focus();
        return false;
    }else if(document.getElementById("pono").value=="")
    {
        alert("Purchase Order harus dipilih");
        document.getElementById("pono").focus();
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

function UpdateItemID(obj){

		objek = obj.id;
	    lastrow = objek.substr(5,objek.length-3);
		
		 var url = $("#base_url").val();
	     var PCode = $('#pcode'+lastrow).val();
	     
			  $.ajax({
					url: url+"index.php/transaksi/sales_return/satuan/"+PCode+"/",
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
	$("#v_note_detail" + intCurrentRowId , clonedRow ).attr( { "id" : "v_note_detail" + intNewRowId,"value" : ""});
	$("#btn_del_detail_" + intCurrentRowId , clonedRow ).attr( { "id" : "btn_del_detail_" + intNewRowId} );
	$("#TabelDetail").append(clonedRow);
	$("#TabelDetail tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
	//$("#pcode" + intNewRowId).focus();
	ClearBaris(intNewRowId);
}

function ClearBaris(id)
{
	//alert(id);
	//$("#pcode"+id).focus();
	$("#pcode"+id).val("");
	$("#v_namabarang"+id).val("");
	$("#v_qty"+id).val("");
	$("#v_satuan"+id).val(" -- Pilih -- ");
	$("#v_note_detail"+id).val("");
}


function deleteTrans(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/rg_marketing/delete_trans/"+nodok;	
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
		window.location = url+"index.php/transaksi/sales_return/delete_detail/"+sid+"/"+pcode+"/"+nodok+"";	
	}
	else
	{
  		return false;
	}
}


function pickThis()
{
	    base_url = $("#base_url").val();
		url = base_url+"index.php/pop/pop_up_po_marketing/index/0/1/";
		windowOpener(525, 1000, 'Cari PO', url, 'Cari PO')
	
}

function HitungHarga(e, flag, obj) {
    	
    	//var e = window.event;
        if (window.event) // IE
        {
            var code = e.keyCode;
        }
        else if (e.which) // Netscape/Firefox/Opera
        {
            var code = e.which;
        }
        if (code == 13) {
            objek = obj.id;
            if (flag == 'harga') {
                grdTotal = 0;
                id = parseFloat(objek.substr(8, objek.length - 8));

                hrg = parseFloat($("#v_Harga_" + id).val());
                qty = parseFloat($("#v_Qty_" + id).val());
                ppn = parseFloat($("#v_PPn_" + id).val());
 			
				$("#v_subtotal_" + id).val(hrg * qty);
                subtot = $("#v_subtotal_" + id).val();
                ppnhitung = parseFloat(subtot * ppn/100);
                hslppn = parseFloat(subtot) + parseFloat(ppnhitung);
				//alert(hrg+" - "+qty+" - "+ppn+" - "+subtot+" ; "+ppnhitung+" ; "+hslppn);
                $("#v_sJumlah_" + id).val(hslppn);
                totalNetto();
            }

        }
    }
    
    
    function HitungHarga2(e, flag, obj) {
    	
    	//var e = window.event;
        if (window.event) // IE
        {
            var code = e.keyCode;
        }
        else if (e.which) // Netscape/Firefox/Opera
        {
            var code = e.which;
        }
        if (code == 13) {
            objek = obj.id;
            if (flag == 'harga') {
                grdTotal = 0;
                id = parseFloat(objek.substr(6, objek.length - 6));

                hrg = parseFloat($("#v_Harga_" + id).val());
                qty = parseFloat($("#v_Qty_" + id).val());
                ppn = parseFloat($("#v_PPn_" + id).val());
 			
				$("#v_subtotal_" + id).val(hrg * qty);
                subtot = $("#v_subtotal_" + id).val();
                ppnhitung = parseFloat(subtot * ppn/100);
                hslppn = parseFloat(subtot) + parseFloat(ppnhitung);
				//alert(hrg+" - "+qty+" - "+ppn+" - "+subtot+" ; "+ppnhitung+" ; "+hslppn);
				$("#ppn_" + id).val(ppnhitung);
                $("#v_sJumlah_" + id).val(hslppn);
                totalNetto();
            }

        }
    }
    
    
    function HitungHarga3(flag, obj) {
    	
            objek = obj.id;
            if (flag == 'harga') {
                grdTotal = 0;
                id = parseFloat(objek.substr(6, objek.length - 6));

                hrg = parseFloat($("#v_Harga_" + id).val());
                qty = parseFloat($("#v_Qty_" + id).val());
                ppn = parseFloat($("#v_PPn_" + id).val());
 			
				$("#v_subtotal_" + id).val(hrg * qty);
                subtot = $("#v_subtotal_" + id).val();
                ppnhitung = parseFloat(subtot * ppn/100);
                hslppn = parseFloat(subtot) + parseFloat(ppnhitung);
				//alert(hrg+" - "+qty+" - "+ppn+" - "+subtot+" ; "+ppnhitung+" ; "+hslppn);
				$("#ppn_" + id).val(ppnhitung);
                $("#v_sJumlah_" + id).val(hslppn);
                //totalNetto();
            }

    }
    
    
    function totalNetto()
{
    var lastRow = document.getElementsByName("v_subtotal[]").length;
    var total = 0; //grand total
    var sppn = 0; //ppn
    var stotal = 0; //total biasa
    for (index = 0; index < lastRow; index++)
    {
        indexs = index - 1;
        nama = document.getElementsByName("v_subtotal[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        stotal += temp1;
        
        /*nama = document.getElementsByName("v_PPn[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        sppn += temp1;*/
        
        nama = document.getElementsByName("ppn_[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        sppn += temp1;
        
        nama = document.getElementsByName("v_sJumlah[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        total += temp1;
    }
    $("#v_Jumlah").val(Math.round(stotal));
    //$("#v_NilaiPPn").val(Math.round(total-stotal));
    $("#v_NilaiPPn").val(Math.round(sppn));
    $("#grdTotal").val(Math.round(total));
    $("#v_Total").val(Math.round(total));

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
    url = "index.php/transaksi/sales_return/vewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}

