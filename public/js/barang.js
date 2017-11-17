function keyShortcut(e,flag,obj) {
    //var e = window.event;
    if(window.event) // IE
    {
        var code = e.keyCode;
    }
    else if(e.which) // Netscape/Firefox/Opera
    {
        var code = e.which;
    }
    if (code == 13) { //checks for the escape key
        objek = obj.id;
        base_url = $("#baseurl").val();

        if(flag=='konv2st'){
            konv2   = $("#konv2st").val();
            hrgJ    = $("#harga1c").val();
            hrgB    = $("#harga1b").val();
            $("#harga2c").val(hrgJ * konv2);
            $("#harga2b").val(hrgB * konv2);
        }else if(flag=='konv3st'){
            konv2   = $("#konv3st").val();
            hrgJ    = $("#harga1c").val();
            hrgB    = $("#harga1b").val();
            $("#harga3c").val(hrgJ * konv2);
            $("#harga3b").val(hrgB * konv2);
        }
    }
}

function getSubDiv()
{
	url = $("#base_url").val();
	$.post(url+"index.php/master/barang/getSubDivisiBy",{ divisi: $("#divisi").val()},
	function(data){
	   $("#subdivisi").empty();
	   $("#subdivisi").append("<option value=''>--Please Select--</option>");
	   $("#subdivisi").append(data);
	});
}
function getSubKat()
{
	url = $("#base_url").val();
	$.post(url+"index.php/master/barang/getSubKategoriBy",{ kategori: $("#kategori").val()},
	function(data){
	   $("#subkategori").empty();
	   $("#subkategori").append("<option value=''>--Please Select--</option>");
	   $("#subkategori").append(data);
	});
}
function getSubBrand()
{
	url = $("#base_url").val();
	$.post(url+"index.php/master/barang/getSubBrandBy",{ brand: $("#brand").val()},
	function(data){
	   $("#subbrand").empty();
	   $("#subbrand").append("<option value=''>--Please Select--</option>");
	   $("#subbrand").append(data);
	});
}
function getSubSize()
{
	url = $("#base_url").val();
	$.post(url+"index.php/master/barang/getSubSizeBy",{ size: $("#size").val()},
	function(data){
	   $("#subsize").empty();
	   $("#subsize").append("<option value=''>--Please Select--</option>");
	   $("#subsize").append(data);
	});
}
function cekbarang()
{
    satuanst = $("#satuanst").val();
	satuanbl = $("#satuanbl").val();
	
	var v_gudang_from = $("#v_gudang_from").val();
	var	base_url = $("#base_url").val();
	
	if($("#nstruk").val()=="")
	{
        alert("Nama Barang harus diisi.");
        $("#nstruk").focus();
		
		return false;
	}
	if($("#divisi").val()=="")
	{
        alert("Divisi harus dipilih.");
        $("#divisi").focus();
		
		return false;
	}
	if($("#subdivisi").val()=="")
	{
        alert("Sub Divisi harus dipilih.");
        $("#subdivisi").focus();
		
		return false;
	}
	if($("#kategori").val()=="")
	{
        alert("Kategori harus dipilih.");
        $("#kategori").focus();
		
		return false;
	}
	if($("#subkategori").val()=="")
	{
        alert("Sub Kategori harus dipilih.");
        $("#subkategori").focus();
		
		return false;
	}
	if($("#brand").val()=="")
	{
        alert("Brand harus dipilih.");
        $("#brand").focus();
		
		return false;
	}
	
    
	//if(cekoption("nstruk","Memasukkan Nama Barang"))
	//if(cekoption("divisi","Memilih Divisi"))
	//if(cekoption("subdivisi","Memilih Sub Divisi"))
	//if(cekoption("kategori","Memilih Kategori"))
	//if(cekoption("brand","Memilih Brand"))
	//if(cekAngka("konvblst","Konversi Beli ke Stock","no zero","no minus"))
	//if(cekAngka("konv1st","Konversi Satuan 1","no zero","no minus"))
	if(cekAngka("harga1c","Harga Jual Cash","zero","no minus"))
	if(cekAngka("harga1b","Harga Jual TOP","zero","no minus"))
	document.getElementById("barang").submit();
}

function cekKonv()
{
	big = $("#konvbk").val();
	mid = $("#konvtk").val();
	if(parseFloat(mid)>=parseFloat(big))
	{
		alert("Konversi besar ke kecil harus lebih besar dari konversi tengah ke kecil");
		$("#konvtk").focus();
		return false;
	}
	return true;
}
function cekflag()
{
	if($("#flag").val()=="add"){
		if(cekoption("satuanb","Memilih Satuan Besar"))
		if(cekoption("satuant","Memilih Satuan Tengah"))
		if(cekoption("satuank","Memilih Satuan Kecil"))
		if(cekoption("satuanj","Memilih Satuan Jual/Stock"))
		if(cekoption("satuanbl","Memilih Satuan Beli"))
			return true;
		return false;
	}
	else{
		return true
	}
}