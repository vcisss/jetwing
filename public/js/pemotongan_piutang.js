function cekTheform()
{
	
	if(document.getElementById("KdCustomer").value=="")
    {
        alert("Customer No harus dipilih");
        document.getElementById("KdCustomer").focus();
        return false;
    }
    else
    {
	
    	var yesSubmit = true;
    	        
        if(yesSubmit)
        {
			//alert("Hello");
			document.getElementById("theform").submit();	
		}
	}		
	
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
	$("#pcode" + intNewRowId).focus();
	ClearBaris(intNewRowId);
}


function deleteTrans(cnno,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus No Dokumen "+cnno+" ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/pemotongan_piutang/delete_trans/"+cnno;	
	}
	else
	{
  		return false;
	}
}
//add
function deleteDetail(dndid,coano,adduser,url)
{
	var r=confirm("Apakah Anda Ingin Menghapus Dokument "+coano+" ini ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/pemotongan_hutang/delete_detail/"+dndid+"/"+coano+"/"+adduser+"";	
	}
	else
	{
  		return false;
	}
}
//edit
function deleteDetail2(cnadetailid,cnallocationno,url)
{
	var r=confirm(".Apakah Anda Ingin Menghapus No Dokumen "+cnallocationno+" ini ?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/pemotongan_piutang/delete_detail2/"+cnadetailid+"/"+cnallocationno+"/";	
	}
	else
	{
  		return false;
	}
}

function batal(url)
{
	var r=confirm("Apakah Anda Ingin membatalkan membuat Credit Note ini?")
	if (r==true)
	{
		window.location = url+"index.php/transaksi/credit_note/batal/";	
	}
	else
	{
  		return false;
	}
}



function pickThis(obj)
{
	//alert("Hello World");
	var v_dnno = $("#v_cnno").val();
	base_url = $("#base_url").val();
	
	if(v_dnno=="")
	{
        objek = obj.id;
		id = parseFloat(objek.substr(9,objek.length-9));
		//alert(id);
		//url = base_url+"index.php/pop/pop_up_sales_invoice/index/0/"+id+"/";
		url = base_url+"index.php/pop/pop_up_pemotongan_hutang/index/00000/0/1/";
		windowOpener(650, 600, 'Cari Account Pick List', url, 'Cari Account Pick List')
	}
	else
	{
		objek = obj.id;
		id = parseFloat(objek.substr(9,objek.length-9));
		//alert(id);
		//url = base_url+"index.php/pop/pop_up_sales_invoice/index/0/"+id+"/";
		url = base_url+"index.php/pop/pop_up_pemotongan_hutang/index/"+v_dnno+"/0/1/";
		windowOpener(650, 600, 'Cari Account Pick List', url, 'Cari Account Pick List')
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

function PopUpPrint(nodok, baseurl)
{
    url = "index.php/transaksi/sales_invoice/vewPrint/" + escape(nodok);
    window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
}

function hitung(event,i){
			
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		
	if(document.getElementById("diskon").value=="")
    {
        alert("diskon tidak boleh kosong.");
        document.getElementById("diskon").focus();
        return false;
    }

	var amount 		= $('#v_amount'+i).val();
	var total		= $('#total').val();
	var diskon		= $('#diskon').val();
	var ppn 		= $('#ppn').val();
	
	//alert(amount+" - "+total+" - "+i);
	var total1=Number(amount)+Number(RemCommas(total));
	     if(Number(diskon)==0){
		 	var potongan_diskon=0;
		 } else{
		 	var potongan_diskon=(Number(diskon)/100)*total1;
		 }
   
    var potongan_ppn = (10/100)*total1;
    var grandtotal=(total1-potongan_diskon)+potongan_ppn;
    
    //alert(total1+" - "+potongan_diskon+" - "+potongan_ppn+" - "+grandtotal);
    
    $("#total").val(total1);
    $("#potongan_diskon").val(potongan_diskon);
    $("#potongan_ppn").val(potongan_ppn);
    $("#grandtotal").val(grandtotal);
    $("#grandtotalhidden").val(grandtotal);

					}
					 
										
						
			}

function number_format(angka){
					var rupiah = '';
					var angkarev = angka.toString().split('').reverse().join('');
					for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+',';
					return rupiah.split('',rupiah.length-1).reverse().join('');
				}

function hilang_spasi(string) {
            return string.split(' ').join('');
        }
        
function RemCommas(nStr){
			var string 	= nStr;
			var str = string.replace(/,/g,"");
			return str;
		}