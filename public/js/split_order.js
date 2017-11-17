function complete(namabarang,pcode,notrans,search,url)
{
	var r=confirm("Apakah Anda Menu "+namabarang+" complete?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/pending_order/complete/"+notrans+"/"+pcode+"/"+search+"/";	
	}
	else
	{
  		return false;
	}
}

function cancel(namabarang,pcode,notrans,search,url)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : url+"index.php/transaksi/pending_order/cancel/"+notrans+"/"+pcode+"/",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="NoKassa"]').val(data.NoKassa);
            $('[name="NoTrans"]').val(data.NoTrans);
            $('[name="NoUrut"]').val(data.NoUrut);
            $('[name="PCode"]').val(data.PCode);
			$('[name="NamaBarang"]').val(data.NamaBarang);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Otorisasi User'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function save(url,search)
{
	var user=$("#username").val();
	var password=$("#password").val();
	var notrans=$("#notrans").val();
	var pcode=$("#pcode").val();
	
    $('#btnSave').text('confirm...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
	//alert(user+" - "+password+" - "+notrans+" - "+pcode);
    window.location = url+"index.php/transaksi/pending_order/done2/"+search+"/"+user+"/"+password+"/"+notrans+"/"+pcode+"/";    
}

function HitungJml(obj)
{
	objek = obj.id;
	id = objek.substr(5,objek.length-5);
	var res = id.substr(0, 1);
	var jmlsplit=$("#v_jml_split").val();
	var qty=$("#qty"+res).val();
	var totsplit=$("#v_sJumlah_"+res).val();
	
	/*if(qty==totsplit){
		alert("Melebihi Qty Item.");
		$("#split"+id).val("");
		}else{*/
		
	    tot_split=0;
		for(x = 0; x < jmlsplit; x++){
			y=x+1;
			var split=$("#split"+res+""+y).val();
			
				if(split==""){
					split_ = 0;
				}else{
					split_=parseInt(split);
				}
				tot_split+=split_;
			}
	//}	
		
		if(qty<tot_split){
		alert("Melebihi Qty Item.");
		$("#split"+id).val("");
		}else{
		$("#v_sJumlah_"+res).val(tot_split);
		total_jum_split();
       }
}

function total_jum_split()
{
    var lastRow = document.getElementsByName("v_sJumlah[]").length;
    var stotal = 0;//v_Jumalah atau total atas
    for (index = 0; index < lastRow; index++)
    {
        indexs = index - 1;
        nama = document.getElementsByName("v_sJumlah[]");
        temp = nama[index].id;
        temp1 = parseFloat(nama[index].value);
        stotal += temp1; 
    }
    $("#v_tot_sJumlah").val(Math.round(stotal));

}

function save_detail(url,obj)
{
	objek = obj.id;
	id = objek.substr(4,objek.length-4);
	
	var notrans=$("#v_trans").val();
	var kdmeja=$("#v_meja").val();
	var lastRow = document.getElementsByName("notrans[]").length;
		
		if($('#v_sum_save').val() == $("#v_jml_split").val()){
			if(parseInt($("#v_sJumlah_qty").val()) > parseInt($("#v_tot_sJumlah").val())){
				alert("Transaksi Terakhir Gagal, Karena Ada Item Yang Belum Ikut Dibayar.");
			}else{		
				$.ajax({
					url: url+"index.php/transaksi/split_order/save_header/",
					data: {no_trans:notrans,meja:kdmeja,id:id},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						notrans_ = data.notrans;
						
						
						for(x = 0; x < lastRow; x++){
							    no = x+1;
								var hasil_split=$("#split"+no+""+id).val();
								
								if(hasil_split!=""){				
									var pcode=$("#pcode"+no).val();
									var notrans=$("#notrans"+no).val();
									 //alert(pcode+" - "+hasil_split);
									 
									 //simpan dengan ajax				 
									 $.ajax({
										url: url+"index.php/transaksi/split_order/save_detail/",
										data: {no_trans_old:notrans,no_trans_new:notrans_,qty_split:hasil_split,pc:pcode,meja:kdmeja,id:id,no:no},
										type: "POST",
										dataType: 'json',					
										success: function(data)
										{
											
										},
										error: function(e) 
										{
											//alert(e);
										} 
									 });
								}
							}
						
						var sum_save = parseInt($('#v_sum_save').val());
						var sum_save_ = sum_save+1;
						$('#v_sum_save').val(sum_save_);
						
						alert("Sukses Split Order");
						$('#save'+id).val('DONE');
						$('#save'+id).attr('disabled',true);
						
						
					},
					error: function(e) 
					{
						//alert(e);
					} 
				 });
			}	 		 
		}else{		
				$.ajax({
					url: url+"index.php/transaksi/split_order/save_header/",
					data: {no_trans:notrans,meja:kdmeja,id:id},
					type: "POST",
					dataType: 'json',					
					success: function(data)
					{
						notrans_ = data.notrans;
						
						
						for(x = 0; x < lastRow; x++){
							    no = x+1;
								var hasil_split=$("#split"+no+""+id).val();
								
								if(hasil_split!=""){				
									var pcode=$("#pcode"+no).val();
									var notrans=$("#notrans"+no).val();
									 //alert(pcode+" - "+hasil_split);
									 
									 //simpan dengan ajax				 
									 $.ajax({
										url: url+"index.php/transaksi/split_order/save_detail/",
										data: {no_trans_old:notrans,no_trans_new:notrans_,qty_split:hasil_split,pc:pcode,meja:kdmeja,id:id,no:no},
										type: "POST",
										dataType: 'json',					
										success: function(data)
										{
											
										},
										error: function(e) 
										{
											//alert(e);
										} 
									 });
								}
							}
						
						var sum_save = parseInt($('#v_sum_save').val());
						var sum_save_ = sum_save+1;
						$('#v_sum_save').val(sum_save_);
						
						alert("Sukses Split Order");
						$('#save'+id).val('DONE');
						$('#save'+id).attr('disabled',true);
						
						
					},
					error: function(e) 
					{
						//alert(e);
					} 
				 });
			}
	
}

function done(kdmeja,url)
{
	var r=confirm("Order is Done?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/pending_order/done/"+kdmeja+"/";	
	}
	else
	{
  		return false;
	}
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

