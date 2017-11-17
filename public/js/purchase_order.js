function cekTheform()
{
	var pcode1 = document.getElementsByName("pcode[]").length;
	
    if(document.getElementById("v_gudang").value=="")
    {
        alert("Gudang harus dipilih");
        document.getElementById("v_gudang").focus();
        return false;
    }
	else if(document.getElementById("v_supplier").value=="")
    {
        alert("Supplier harus dipilih");
        document.getElementById("v_supplier").focus();
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

function UpdateItemID(obj){

		objek = obj.id;
	    lastrow = objek.substr(5,objek.length-3);
		
		 var url = $("#base_url").val();
	     var PCode = $('#pcode'+lastrow).val();
	     
			  $.ajax({
					url: url+"index.php/transaksi/delivery_order/satuan/"+PCode+"/",
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
}


function deleteTrans(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/delivery_order/delete_trans/"+nodok;	
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
		window.location = url+"index.php/transaksi/delivery_order/delete_detail/"+sid+"/"+pcode+"/"+nodok+"";	
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
		id = parseFloat(objek.substr(9,objek.length-9));
		url = base_url+"index.php/pop/pop_up_cari_purchase_request/index/0/1/";
		windowOpener(525, 1000, 'Cari Purchase Request No', url, 'Cari Purchase Request No')
	
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
    url = "index.php/transaksi/purchase_order/vewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}


/*function HitungHarga(e, flag, obj) {
		alert("test");
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
				qty = parseFloat($("#v_Qty_" + id).val());
                hrg = parseFloat($("#v_Harga_" + id).val());                
                discx = $("#v_Disc_" + id).val();
				potx = $("#v_Potongan_" + id).val();
				
				if(discx==""){
					disc=0;
				}else{
					disc = parseFloat($("#v_Disc_" + id).val());
				}
				
				if(potx==""){
					pot=0;
				}else{
					pot = parseFloat($("#v_Potongan_" + id).val());
				}
				
				
				//hasil diskon
				nil_dis = (disc/100)*(hrg * qty);
				//hitung
                $("#v_subtotal_" + id).val(((hrg * qty)-nil_dis)-pot);
                subtot = $("#v_subtotal_" + id).val();
                $("#v_sJumlah_" + id).val(subtot);
                totalNetto();
            }else if (flag == 'diskon') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
            }else if (flag == 'ppn') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
            }

        }
    }*/
	
	function HitungHarga(e, flag, obj) {
    	
            objek = obj.id;
            if (flag == 'harga') {
                grdTotal = 0;
                id = parseFloat(objek.substr(8, objek.length - 8));
				qty = parseFloat($("#v_Qty_" + id).val());
                hrg = parseFloat($("#v_Harga_" + id).val());                
                discx = $("#v_Disc_" + id).val();
				potx = $("#v_Potongan_" + id).val();
				
				if(discx==""){
					disc=0;
				}else{
					disc = parseFloat($("#v_Disc_" + id).val());
				}
				
				if(potx==""){
					pot=0;
				}else{
					pot = parseFloat($("#v_Potongan_" + id).val());
				}
				
				
				//hasil diskon
				nil_dis = (disc/100)*(hrg * qty);
				//hitung
                $("#v_subtotal_" + id).val(((hrg * qty)-nil_dis)-pot);
                subtot = $("#v_subtotal_" + id).val();
                $("#v_sJumlah_" + id).val(subtot);
                totalNetto();
            }else if (flag == 'diskon') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
            }else if (flag == 'ppn') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
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
                id = parseFloat(objek.substr(7, objek.length - 7));
				qty = parseFloat($("#v_Qty_" + id).val());
                hrg = parseFloat($("#v_Harga_" + id).val());                
                
                discx = $("#v_Disc_" + id).val();
				potx = $("#v_Potongan_" + id).val();
				
				if(discx==""){
					disc=0;
				}else{
					disc = parseFloat($("#v_Disc_" + id).val());
				}
				
				if(potx==""){
					pot=0;
				}else{
					pot = parseFloat($("#v_Potongan_" + id).val());
				}
				
				//hasil diskon
				nil_dis = (disc/100)*(hrg * qty);
				//hitung
                $("#v_subtotal_" + id).val(((hrg * qty)-nil_dis)-pot);
                subtot = $("#v_subtotal_" + id).val();
                $("#v_sJumlah_" + id).val(subtot);
                totalNetto();
            }else if (flag == 'diskon') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
            }else if (flag == 'ppn') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
            }

        }
    }
    
    
    function HitungHarga3(e, flag, obj) {
	
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
                id = parseFloat(objek.substr(11, objek.length - 11));
				qty = parseFloat($("#v_Qty_" + id).val());
                hrg = parseFloat($("#v_Harga_" + id).val());                
                discx = $("#v_Disc_" + id).val();
				potx = $("#v_Potongan_" + id).val();
				
				if(discx==""){
					disc=0;
				}else{
					disc = parseFloat($("#v_Disc_" + id).val());
				}
				
				if(potx==""){
					pot=0;
				}else{
					pot = parseFloat($("#v_Potongan_" + id).val());
				}
				//hasil diskon
				nil_dis = (disc/100)*(hrg * qty);
				//hitung
                $("#v_subtotal_" + id).val(((hrg * qty)-nil_dis)-pot);
                subtot = $("#v_subtotal_" + id).val();
                $("#v_sJumlah_" + id).val(subtot);
                totalNetto();
            }else if (flag == 'diskon') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
            }else if (flag == 'ppn') {
				jml = parseFloat($("#v_Jumlah").val());
				discharga = parseFloat($("#v_DiscHarga").val());                
                ppn = parseFloat($("#v_PPn").val());
				
				//hasil diskon
				nil_dis = (discharga/100)*(jml);
				$("#v_pot_disc").val(nil_dis);
				//hitung ppn
				nil_ppn = (ppn/100)*(jml);
				$("#v_NilaiPPn").val(nil_ppn);
				
				
                $("#v_Total").val((jml-nil_dis)+nil_ppn);
            }

        }
    }
    
    
    
    function totalNetto()
	{
	    var lastRow = document.getElementsByName("v_subtotal[]").length;
	    var total = 0;//grand total
	    var stotal = 0;//v_Jumalah atau total atas
	    
	    //alert(lastRow+" - "+total+" - "+stotal);
	    for (index = 0; index < lastRow; index++)
	    {
	        indexs = index - 1;
	        nama = document.getElementsByName("v_subtotal[]");
	        temp = nama[index].id;
	        temp1x = nama[index].value;
	        if(temp1x==""){
				temp1=0;
			}else{
				temp1=parseFloat(nama[index].value);;
			}
			//alert(temp1);
	        stotal += temp1;
	        
	         nama = document.getElementsByName("v_sJumlah[]");
	        temp = nama[index].id;
	        temp1x = nama[index].value;
	        if(temp1x==""){
				temp1=0;
			}else{
				temp1=parseFloat(nama[index].value);
			}
	        total += temp1;
	    }
	    $("#v_Jumlah").val(Math.round(stotal));
	    $("#grdTotal").val(Math.round(total));
	    $("#v_Total").val(Math.round(total));

	}

