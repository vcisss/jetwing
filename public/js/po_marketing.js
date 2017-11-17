function cekTheform()
{
    
		
	if($('#flag').val()=="edit"){
	
				var grdTotal = document.getElementById('grdTotal');
				if(grdTotal.value==0){
					alert("Grand Total = 0 , Silahkan enter disalah satu kolom Harga untuk mendapatkan Grand Total.");
					document.getElementById("harga1").focus();
				}
	
	
				//jumlah yang ada di proposal
				var Jml_pro = parseInt(RemCommas($('#v_jml_proposal').val()));
				
				//jumlah yang ada di PO
				var Jml_po = parseInt(RemCommas($('#v_Jumlah').val()));
				
				//cek apakah proposal tersebut yang sama sudah di gunakan untuk PO lain
				var cek_penggunaan = $('#v_cek_penggunaan_proposal').val();
				
				//total_penggunaan
				var cek = parseInt(Jml_po) + parseInt(cek_penggunaan);
				
				var yesSubmit = true;
				//alert(cek_penggunaan);
					if(cek_penggunaan>Jml_pro){
							 
								if(cek>Jml_pro){
									alert("Jumlah PO ini dan PO lain dengan No Proposal Yang Sama melebih Jumlah Nilai Proposal "+number_format(Jml_pro)+"");	
									document.getElementById("v_Qty_1").focus();
									
									yesSubmit = false;
									
									return false;
								}else{
									alert("Jumlah PO "+number_format(Jml_po)+" melebih Jumlah Proposal "+number_format(Jml_pro)+"");	
									document.getElementById("v_Qty_1").focus();
									
									yesSubmit = false;
									
									return false;								
								}
								
					}else{
							if(Jml_po>Jml_pro)
								{
									alert("Jumlah PO "+number_format(Jml_po)+" melebih Jumlah Proposal "+number_format(Jml_pro)+"");	
									document.getElementById("v_Qty_1").focus();
									
									yesSubmit = false;
									
									return false;
								}
					}
					
					if(yesSubmit)
					{
						document.getElementById("theform").submit();	
					}
		}else{
			var yesSubmit = true;
			if(yesSubmit)
					{
						document.getElementById("theform").submit();	
					}

		}		
	}


function approve_po(po,url){
	var r = confirm("Anda yakin ingin Approve PO dengan nomor "+po+" ? ");
            if(r)
            {
                $.ajax({
					url: url+"index.php/transaksi/po_marketing/approve/"+po+"/",
					data: {id:po},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						if(data){
							alert("Berhasil Approve PO dengan Nomor "+po);
							$('#approve_').attr('hidden',true);
						}
					},
					error: function(e) 
					{
						alert(e);
					} 
				 });
            }
}

function reject_po(po,url){
	var alasan = $('#v_alasan_reject').val();
	var r = confirm("Anda yakin ingin Reject PO dengan nomor "+po+" ? ");
            if(r)
            {
                $.ajax({
					url: url+"index.php/transaksi/po_marketing/reject/"+po+"/",
					data: {id:po,al:alasan},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						if(data){
							alert("Berhasil Reject PO dengan Nomor "+po);
							$('#approve_').attr('hidden',true);
						}
					},
					error: function(e) 
					{
						alert(e);
					} 
				 });
            }
}


function deleteTrans(nodok,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+nodok+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/po_marketing/delete_trans/"+nodok;	
	}
	else
	{
  		return false;
	}
}

function number_format(angka){
					var rupiah = '';
					var angkarev = angka.toString().split('').reverse().join('');
					for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+',';
					return rupiah.split('',rupiah.length-1).reverse().join('');
				}
				
function RemCommas(nStr){
			var string 	= nStr;
			var str = string.replace(/,/g,"");
			return str;
		}

function pop_search_pr()
{
	    base_url = $("#base_url").val();
		url = base_url+"index.php/pop/pop_up_pr_marketing/index/0/1/";
		windowOpener(400, 600, 'Cari Purchase Order', url, 'Cari Purchase Order')
	
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
    url = "index.php/transaksi/po_marketing/vewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
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
				qty = parseFloat($("#v_Qty_" + id).val());
                hrg = parseFloat($("#v_Harga_" + id).val());                
                disc = parseFloat($("#v_Disc_" + id).val());
				pot = parseFloat($("#v_Potongan_" + id).val());
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
                disc = parseFloat($("#v_Disc_" + id).val());
				pot = parseFloat($("#v_Potongan_" + id).val());
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
                disc = parseFloat($("#v_Disc_" + id).val());
				pot = parseFloat($("#v_Potongan_" + id).val());
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
    for (index = 0; index < lastRow; index++)
    {
        indexs = index - 1;
        nama = document.getElementsByName("v_subtotal[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        stotal += temp1;
        
         nama = document.getElementsByName("v_sJumlah[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        total += temp1;
    }
    $("#v_Jumlah").val(Math.round(stotal));
	//alert($("#v_Jumlah").val(Math.round(stotal)));
    $("#grdTotal").val(Math.round(total));
    $("#v_Total").val(Math.round(total));

}

