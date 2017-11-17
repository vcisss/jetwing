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

