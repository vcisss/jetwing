function cekTheform()
{
	
	if($('#flag').val()=="edit"){
	var grdTotal = document.getElementById('grdTotal');
				if(grdTotal.value==0){
					alert("Grand Total = 0 , Silahkan enter disalah satu kolom Harga untuk mendapatkan Grand Total.");
					document.getElementById("v_Harga_1").focus();
					return false;
				}
	
    var TotalRek = document.getElementById('v_Total_rek');	
				if(grdTotal.value!=TotalRek.value){
					alert("Total Detail Tidak Sama dengan Total Rekning");
					document.getElementById("v_Harga_1").focus();
					return false;
				}
				
	}	
	
	if(document.getElementById("v_supplier").value=="")
    {
        alert("Supplier harus dipilih");
        document.getElementById("v_supplier").focus();
        return false;
    }else if(document.getElementById("rgno").value=="")
    {
        alert("Purchase Order harus dipilih");
        document.getElementById("rgno").focus();
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
            var clonedRow = $("#TabelDetail2 tr:last").clone(true);
			var intCurrentRowId = parseFloat($('#TabelDetail2 tr').length )-2;
			nama = document.getElementsByName("v_kd_rek[]");
			temp = nama[intCurrentRowId].id;
			intCurrentRowId = temp.substr(8,temp.length-8);
			var intNewRowId = parseFloat(intCurrentRowId) + 1;
			$("#v_kd_rek" + intCurrentRowId , clonedRow ).attr( { "id" : "v_kd_rek" + intNewRowId,"value" : ""} );
			$("#get_norek" + intCurrentRowId , clonedRow ).attr( { "id" : "get_norek" + intNewRowId,"value" : ""} );
			$("#v_nm_rek" + intCurrentRowId , clonedRow ).attr( { "id" : "v_nm_rek" + intNewRowId,"value" : ""} );
			$("#v_subdivisi" + intCurrentRowId , clonedRow ).attr( { "id" : "v_subdivisi" + intNewRowId,"value" : 0} );
			$("#v_deskripsi" + intCurrentRowId , clonedRow ).attr( { "id" : "v_deskripsi" + intNewRowId} );
			$("#v_jml" + intCurrentRowId , clonedRow ).attr( { "id" : "v_jml" + intNewRowId} );
			$("#btn_del_detail_target_" + intCurrentRowId , clonedRow ).attr( { "id" : "btn_del_detail_target_" + intNewRowId} );
			$("#TabelDetail2").append(clonedRow);
			$("#TabelDetail2 tr:last" ).attr( "id", "baris" +intNewRowId ); // change id of last row
			$("#v_kd_rek" + intNewRowId).focus();
			ClearBaris(intNewRowId);
}

function ClearBaris(id)
{
	        $("#v_kd_rek"+id).val("");
			$("#v_nm_rek"+id).val("");
			$("#v_subdivisi"+id).val("");
			$("#v_deskripsi"+id).val("");
			$("#v_jml"+id).val("");
}


function deleteTrans(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/pi_marketing/delete_trans/"+nodok;	
	}
	else
	{
  		return false;
	}
}

function deleteDetail(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Rekening tersebut dan mengulang kembali?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/pi_marketing/delete_detail/"+nodok+"";	
	}
	else
	{
  		return false;
	}
}


function pickThis()
{
	    base_url = $("#base_url").val();
		url = base_url+"index.php/pop/pop_up_rg_marketing/index/0/1/";
		windowOpener(525, 1000, 'Cari RG', url, 'Cari RG')
	
}

function pickThis2(obj)
{
		
	    base_url = $("#base_url").val();
		objek = obj.id;
		id = parseFloat(objek.substr(9,objek.length-9));
		url = base_url+"index.php/pop/pop_up_no_rek/index/0/"+id+"/";
		windowOpener(525, 600, 'Cari List Rekening', url, 'Cari List Rekening')
	
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
        
        nama = document.getElementsByName("v_PPn[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        sppn += temp1;
        
        nama = document.getElementsByName("v_sJumlah[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        total += temp1;
    }
    $("#v_Jumlah").val(Math.round(stotal));
    $("#v_NilaiPPn").val(Math.round(total-stotal));
    $("#grdTotal").val(Math.round(total));
    $("#v_Total").val(Math.round(total));

}
    
    function HitungHarga2()
{
    var lastRow = document.getElementsByName("v_kd_rek[]").length;
    var stotal = 0; //total biasa
    for (index = 0; index < lastRow; index++)
    {
        indexs = index - 1;
        nama = document.getElementsByName("v_jml[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        stotal += temp1;
    }
    $("#v_Total_rek").val(Math.round(stotal));
}

function deleteRow(obj)
		{
			objek = obj.id;
			id = objek.substr(22,objek.length-3);
			
			var lastRow = document.getElementsByName("v_kd_rek[]").length;
			
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

