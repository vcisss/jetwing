
function keyShortcut(e, flag, obj) {
    //var e = window.event;
    if (window.event) // IE
    {
        var code = e.keyCode;
    }
    else if (e.which) // Netscape/Firefox/Opera
    {
        var code = e.which;
    }
    if (code == 13) { //checks for the escape key
        objek = obj.id;//alert(objek);
        if (flag == 'kdagent') {
            id = parseFloat(objek.substr(7, objek.length - 7));
            //                        alert(pcode+id);
          //  generateList(id);
        }
        else if (flag == 'qty') {
            id = parseFloat(objek.substr(3, objek.length - 3));
            if (cekoption("pcode" + id, "Memasukkan Rekening") && cekAngka("qty" + id, "Memasukkan Qty")) {
                detailNew();
                sumTotal();
            }
            //InputQty(id,'enter');
        }
        else if (flag == 'order') {
            sumber = $("input[@name='sumber']:checked").val();
            if (sumber == "O")
            {
                noorderan = $("#noorder").val();
                $("#hiddennoorder").val(noorderan);
                setTimeout("getOrder()", 1);
            }
            else
            {
                $("#nokirim").focus();
            }
        }
        else if (flag == 'kirim') {
            sumber = $("input[@name='sumber']:checked").val();
            if (sumber == "P")
            {
                nokirim = $("#nokirim").val();
                $("#hiddennokirim").val(nokirim);
                setTimeout("getKirim()", 1);
            }
            else
            {
                if (sumber == "M" || sumber == "R") {
                    $("#kontak").focus();
                }
                else
                {
                    $("#kendaraan").focus();
                }
            }
        }
        else if (flag == 'satuan') {
            id = parseFloat(objek.substr(6, objek.length - 6));
            $("#qty" + id).focus();
        }
    }
}

function resetRow(id)
{
    $("#pcode" + id).val("");
    $("#pcode" + id).focus();
    $("#komisi1" + id).val("");
    $("#komisi2" + id).val("");
    $("#komisi3" + id).val("");
    $("#komisi4" + id).val("");
}


function getOrder()
{
    noorderan = $("#noorder").val();
    base_url = $("#baseurl").val();
    $.post(base_url + "index.php/transaksi/retur_barang/getsumber", {
        order: noorderan,
        kirim: ""
    },
    function (data) {
        if (data == "+")
        {
            alert("No Order Tidak Ditemukan\nPeriksa Kembali No Order");
            $("#noorder").focus();
            $("#hiddennoorder").val("");
        }
        else {
            $("#noorder").attr("readonly", true);
            $("#btnorder").attr("disabled", "disabled");
            $("#kontak").attr("disabled", "disabled");
            Fill(data);
            $("#nokirim").focus();
        }
    });
}

function pickOrder()
{
    base_url = $("#baseurl").val();
    url = base_url + "index.php/pop/order/index/";
    window.open(url, 'popuppage', 'scrollbars=yes,width=550,height=500,top=180,left=150');
}

function pickKirim()
{
    base_url = $("#baseurl").val();
    url = base_url + "index.php/pop/kirim/index/";
    window.open(url, 'popuppage', 'scrollbars=yes,width=550,height=500,top=180,left=150');
}

function getKirim()
{
    base_url = $("#baseurl").val();
    $.post(base_url + "index.php/transaksi/retur_barang/getsumber", {
        order: "",
        kirim: nokirim
    },
    function (data) {
        if (data == "^&&^+")
        {
            alert("No Pengiriman Tidak Ditemukan\nPeriksa Kembali No Pengiriman");
            $("#nokirim").focus();
            $("#hiddennokirim").val("");
        }
        else {
            $("#nokirim").attr("readonly", true);
            $("#btnkirim").attr("disabled", "disabled");
            $("#kontak").attr("disabled", "disabled");
            var ajax = data.split("^&&^");
            Fill(ajax[1]);
            $("#ket").focus();
        }
    });
}

function Fill(data)
{
    var ajax = data.split("+");
    var baris = 0;
    $("#newrow").css("display", "none");
    var param = ajax[0].split("~");
    var msatuan = ajax[1].split("**");
    for (x = 0; x < (param.length) - 1; x++)
    {
        baris++;
        nilai = param[x].split("*&^%");
        if (x > 0)
        {
            detailNew();
        }
        kdkontak = nilai[12];
        $("#pcode" + baris).val(nilai[0]);
        $("#tmppcode" + baris).val(nilai[0]);
        $("#qty" + baris).val(nilai[1]);
        $("#tmpqty" + baris).val(nilai[1]);
        $("#qtydisplay" + baris).val(nilai[2]);
        $("#qtypcs" + baris).val(nilai[3]);
        $("#nama" + baris).val(nilai[4]);
        $("#konverjk" + baris).val(nilai[5]);
        $("#konverbk" + baris).val(nilai[6]);
        $("#konvertk" + baris).val(nilai[7]);
        $("#kdsatuanj" + baris).val(nilai[8]);
        $("#satuanj" + baris).val(nilai[9]);
        $("#pcodebarang" + baris).val(nilai[11]);
        $("#pcode" + baris).attr("readonly", true);
        $("#del" + baris).css("display", "none");
        $("#pick" + baris).css("display", "none");
        $("#pcode" + baris).attr("readonly", true);
        $("#del" + baris).css("display", "none");
        $("#pick" + baris).css("display", "none");

        $("#satuan" + baris).empty();
        $("#satuan" + baris).append("<option value=''>--> Pilih <--</option>");
        $("#satuan" + baris).append(msatuan[x]);
        if (nilai[13] == "bar")
        {
            $("#satuan" + baris).attr("disabled", "disabled");
        }
        $("#satuantmp" + baris).val($("#satuan" + baris).val());
        jQuery("input[name='sumber']").each(function (i) {
            jQuery(this).attr('disabled', 'disabled');
        });
    }
    $("#kontak").val(kdkontak);
    $("#hidecontact").val(kdkontak);
}

function pickThis(obj)
{
    if (cekheader())
    {
        base_url = $("#baseurl").val();
        objek = obj.id;
        id = parseFloat(objek.substr(4, objek.length - 4));
        url = base_url + "index.php/pop/rekpaymentv/index/" + id + "/";
        window.open(url, 'popuppage', 'scrollbars=yes,width=750,height=400,top=200,left=150');
    }
}

function findPCode(id)
{
    if (cekheader())
    { //alert(id);
        if (cekoption("pcode" + id, "Memasukkan Kode Rekening")) {
            base_url = $("#baseurl").val();
            pcode = $("#pcode" + id).val();
            tgl = $("#tgl").val();
            $.post(base_url + "index.php/finance/paymentv/getRealPCode", {
                pcode: pcode
            },
            function (datakode) {
                if (datakode != "") {
                    var lastRow = document.getElementsByName("pcode[]").length;
                    var exist = false;
                    for (var t = 1; t < lastRow; t++) {
                        if (t == lastRow) {
                            break;
                        }
                        cekno = "pcode" + t;
                        if (document.getElementById(cekno) != null) {
                            if (trimIt(document.getElementById(cekno).value) == datakode) {
                                exist = true;
                                break;
                            }
                        }
                        else
                        {
                            break;
                        }
                    }

                    if (exist) {
                        alert("Kode Rekening Yang Dipilih Sudah Ada");
                    } else {

                        $("#pcode" + id).val(datakode);

                        $("#tmppcode" + id).val(pcode);
                        $.post(base_url + "index.php/finance/paymentv/getPCode", {
                            pcode: datakode,
                            tgl: tgl
                        },
                        function (data) {
                            if (data != "")
                            {
                                result = data.split("*&^%");
                                $("#nama" + id).val(result[0]);
                                $("#pcoderekening" + id).val(result[1]);
                                $("#qty" + id).val("");
                                $("#ketdet" + id).focus();
                                //$("#qty"+id).focus();
                            }
                            else
                            {
                                alert("Rekening / Data Tidak Ditemukan");
                                resetRow(id);
                                $("#pcode" + id).focus();
                            }
                        });
                    }
                }
                else
                {
                    alert("Data Tidak Ditemukan");
                    resetRow(id);
                    $("#pcode" + id).focus();
                }
            });
        }
        else
        {
            resetRow(id);
            $("#pcode" + id).focus();
        }
    }
}


function InQty(obj)
{
    objek = obj.id;
    id = parseFloat(objek.substr(3, objek.length - 3));
    //    alert(id);
    if (cekheader())
    {
        if (cekoption("pcode" + id, "Memasukkan Kode Rekening"))
        {
            var qty = parseFloat($("#qty" + id).val());
            var hrg = parseFloat($("#hrg" + id).val());
            ttl = hrg * qty;
            $("#ttl" + id).val(ttl);
        }
        else
        {
            resetRow(id);
            $("#pcode" + id).focus();
        }
    }
}

function sumTotal()
{
    var arr = document.getElementsByName('qty[]');
    var tot = 0;
    for (var i = 0; i < arr.length; i++) {
        if (parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    document.getElementById('total').value = tot;
}


function convert(id)
{
    var qty = parseFloat($("#qty" + id).val());
    satuan = $("#satuan" + id).val().split("|");
    ;
    satuanj = $("#kdsatuanj" + id).val();
    konver = $("#konverjk" + id).val();
    SatuanFlg = satuan[0];
    if (SatuanFlg == "B")
    {
        qty = parseFloat($("#konverbk" + id).val()) * parseFloat(qty);
    }
    else if (SatuanFlg == "T")
    {
        qty = parseFloat($("#konvertk" + id).val()) * parseFloat(qty);
    }
    else if (SatuanFlg == "K")
    {
        qty = qty;
    }
    $("#qtypcs" + id).val(qty);
    if (konver == 1)
    {
        nilai = qty + ".0";
    }
    else
    {
        if (parseFloat(qty) >= parseFloat(konver))
        {
            karton = Math.floor(parseFloat(qty) / parseFloat(konver));
            sisa = parseFloat(qty) % parseFloat(konver);
            nilai = karton + "." + sisa;
        }
        else
        {
            nilai = "0." + qty;
        }
    }
    return nilai;
}


function saveThis(id)
{
    if (cekheader())
        if (cekDetail(id))
        {
            $('fieldset.disableMe :input').attr('disabled', true);
            saveItem(id);
        }
}

function saveAll() {
    //{ alert("Tets ");
    if (cekheader()) {
        //	if(cekDetailAll()){
        //	alert("K")
        $("#paymentv").submit();
    }
}

function cekheader()
{
    if (cekoption("nobukti", "Mengisi NoBukti"))
        if (cekoption("ket", "Mengisi Keterangan"))
            return true;
}


function cekDetail(id)
{
    if (cekoption("pcode" + id, "Memasukkan Kode Rekening"))
        if (cekoption("qty" + id, "Memasukkan Jumlah Rekening"))
            return true;
}

function cekDetailAll()
{
    var lastRow = document.getElementsByName("pcode[]").length;
    for (index = 0; index < lastRow; index++) {
        nama = document.getElementsByName("pcode[]");
        temp = nama[index].id;
        indexs = temp.substr(5, temp.length - 5);
        if (index < parseFloat(lastRow) - 1 || index == 0) {
            if (cekoption("pcode" + indexs, "Memasukkan Kode Rekening"))
                if (cekoption("qty" + indexs, "Memasukkan Jumlah Rekening"))
                    return false;
        }
        else if (index == parseFloat(lastRow) - 1)
        {
            if ($("#pcode" + indexs).val() == "" && $("#qty" + indexs).val() == "")
            {
                continue;
            }
            else
            {
                if (cekoption("pcode" + indexs, "Memasukkan Kode Rekening"))
                    if (cekoption("qty" + indexs, "Memasukkan Jumlah Rekening"))
                        return false;
            }
        }
    }
    return true;
}

function saveItem(id)
{
    detailNew();
}

function AddNew()
{
    var lastRow = document.getElementsByName("pcode[]").length - 1;
    nama = document.getElementsByName("pcode[]");
    temp = nama[lastRow].id;
    indexs = temp.substr(5, temp.length - 5);

    if (cekDetail(indexs)) {
        saveItem(indexs);
    }
}

function detailNew()
{
    var clonedRow = $("#detail tr:last").clone(true);
    var intCurrentRowId = parseFloat($('#detail tr').length) - 2;
    nama = document.getElementsByName("pcode[]");
    temp = nama[intCurrentRowId].id;
    intCurrentRowId = temp.substr(5, temp.length - 5);
    var intNewRowId = parseFloat(intCurrentRowId) + 1;
    $("#nostruk" + intCurrentRowId, clonedRow).attr({
        "id": "nostruk" + intNewRowId,
        "value": ""
    });
    $("#tgljual" + intCurrentRowId, clonedRow).attr({
        "id": "tgljual" + intNewRowId,
        "value": ""
    });
    $("#pcode" + intCurrentRowId, clonedRow).attr({
        "id": "pcode" + intNewRowId,
        "value": ""
    });
    $("#pick" + intCurrentRowId, clonedRow).attr({
        "id": "pick" + intNewRowId,
        "value": ""
    });
    $("#del" + intCurrentRowId, clonedRow).attr({
        "id": "del" + intNewRowId
    });
    $("#nama" + intCurrentRowId, clonedRow).attr({
        "id": "nama" + intNewRowId,
        "value": ""
    });
    $("#qty" + intCurrentRowId, clonedRow).attr({
        "id": "qty" + intNewRowId,
        "value": ""
    });
    $("#persentase" + intCurrentRowId, clonedRow).attr({
        "id": "persentase" + intNewRowId,
        "value": ""
    });
    $("#harga" + intCurrentRowId, clonedRow).attr({
        "id": "harga" + intNewRowId,
        "value": ""
    });
    $("#harga_temp" + intCurrentRowId, clonedRow).attr({
        "id": "harga_temp" + intNewRowId,
        "value": ""
    });
    $("#nilai" + intCurrentRowId, clonedRow).attr({
        "id": "nilai" + intNewRowId,
        "value": ""
    });
    $("#qtypcs" + intCurrentRowId, clonedRow).attr({
        "id": "qtypcs" + intNewRowId,
        "value": ""
    });
	 $("#hrgPPN" + intCurrentRowId, clonedRow).attr({
        "id": "hrgPPN" + intNewRowId,
        "value": ""
    });
	$("#netto" + intCurrentRowId, clonedRow).attr({
        "id": "netto" + intNewRowId,
        "value": ""
    });
    $("#komisia" + intCurrentRowId, clonedRow).attr({
        "id": "komisia" + intNewRowId,
        "value": ""
    });
    $("#komisib" + intCurrentRowId, clonedRow).attr({
        "id": "komisib" + intNewRowId,
        "value": ""
    });
    $("#komisic" + intCurrentRowId, clonedRow).attr({
        "id": "komisic" + intNewRowId,
        "value": ""
    });
    $("#komisid" + intCurrentRowId, clonedRow).attr({
        "id": "komisid" + intNewRowId,
        "value": ""
    });
	$("#potongan" + intCurrentRowId, clonedRow).attr({
        "id": "potongan" + intNewRowId,
        "value": ""
    });
    $("#savepcode" + intCurrentRowId, clonedRow).attr({
        "id": "savepcode" + intNewRowId,
        "value": ""
    });
    $("#pcodebarang" + intCurrentRowId, clonedRow).attr({
        "id": "pcodebarang" + intNewRowId,
        "value": ""
    });
    
    $("#detail").append(clonedRow);
//    $("#detail tr:last").attr("id", "baris" + intNewRowId); // change id of last row
//    $("#pcode" + intNewRowId).focus();

}

function deleteRow(obj)
{
    objek = obj.id;
    id = objek.substr(3, objek.length - 3);
    pcode = $("#pcode" + id).val();
    var banyakBaris = 1;
    var lastRow = document.getElementsByName("pcode[]").length;
    for (index = 0; index < lastRow; index++) {
        nama = document.getElementsByName("pcode[]");
        temp = nama[index].id;
        indexs = temp.substr(5, temp.length - 5);
        if ($("#savepcode" + indexs).val() != "") {
            banyakBaris++;
        }
    }
    if ($("#savepcode" + id).val() == "") {
        $('#baris' + id).remove();
    }
    else if ($("#savepcode" + id).val() == "" && banyakBaris == 1) {
        alert("Baris ini tidak dapat dihapus\nMinimal harus ada 1 baris");
    }
    else {
        if (banyakBaris == 2)
        {
            alert("Baris ini tidak dapat dihapus\nMinimal harus ada 1 baris tersimpan");
        }
        else
        {
            no = $("#nodok").val();
            tgl = $("#tgl").val();
            objek = obj.id;
            id = objek.substr(3, objek.length - 3);
            pcode = $("#pcode" + id).val();
            pcodesave = $("#savepcode" + id).val();
            ketdet = $("#ketdet" + id).val();
            qty = $("#qty" + id).val();
            if (pcode != "") {
                var r = confirm("Apakah Anda Ingin Menghapus Kode Rekening " + pcode + " ?");
                if (r == true) {
                    $('#baris' + id).remove();
                    if (no != "") {
                        //                                                ($flag,$no,$tgl,$pcode,$pcodebarang,$qtyretur)
                        deleteItem(no, tgl, pcode, pcodesave, ketdet, qty);
                    }
                }
            }
        }
    }
}

function deleteItem(no, tgl, pcode, pcodesave, qty)
{
    if ($("#transaksi").val() == "no") {
        //		no = $("#nodok").val();
        //		flag = $("#flag").val();
        $("#transaksi").val("yes");
        base_url = $("#baseurl").val();
        $.post(base_url + "index.php/transaksi/retur_barang/delete_item", {
            no: no,
            tgl: tgl,
            pcode: pcode,
            pcodesave: pcodesave,
            qty: qty
        },
        function (data) {
            $("#transaksi").val("no");
        });
    }
}

function deleteAllRow() {
     var rowCount = myTable.rows.length; 
     while(--rowCount) myTable.deleteRow(rowCount); 
}

/*
function generateList(id) {
    base_url = $("#baseurl").val();
    kdagent = $("#kdagent").val();
    nosticker = $("#nosticker").val();
    $.ajax({
			type: "POST",
			url: base_url + "index.php/keuangan/komisi/getlistBarang/",
			data : {kdagent: kdagent, nosticker: nosticker},
			success: function(data) {
				console.log(data);
				$('#UpdateDetail').html(data);
			}
		});
    
    
    if (kdagent == ""){
		alert("Masukan No Member");
		return;
	}

    $.post(base_url + "index.php/keuangan/komisi/getlistBarang", {kdagent: kdagent, nosticker: nosticker},
    	function (data) {
			$('#UpdateDetail').html(data);
		}
	});
        if (kdagent != "") {
            if (data != "0##")
            {
               // alert(data);
                sp = data.split("##");
                ar = sp[1].split("**");
                var totaljual = 0;
                var totalkomisi_temp = 0;
                var totalkomisi =0;
                var nilai =0;
               // alert(ar[0]);
                id = 1;
                $('#baris' + id).remove();
                for (by = 0; by < sp[0]; by++) {
                    det = ar[by].split("||");
                    detailNew();
						

                    nilai = (det[7] * det[4]);
                    document.getElementById('nostruk' + id).value = det[0];
                    document.getElementById('tgljual' + id).value = det[1];
                    document.getElementById('pcode' + id).value = det[2];
                    document.getElementById('nama' + id).value = det[3];
                    document.getElementById('qty' + id).value = det[4];
                    document.getElementById('persentase' + id).value = det[5];
                    document.getElementById('harga' + id).value = det[6];
                    document.getElementById('harga_temp' + id).value = format_num(det[6]);
                    document.getElementById('nilai' + id).value = format_num(det[7]);
					document.getElementById('netto' + id).value = (det[8]);
					document.getElementById('potongan' + id).value = (det[9]);
					document.getElementById('komisia' + id).value = (det[10]);
					document.getElementById('komisib' + id).value = (det[11]);
					document.getElementById('komisic' + id).value = (det[12]);
					document.getElementById('komisid' + id).value = (det[13]);
					document.getElementById('hrgPPN' + id).value = (det[14]);
					
                    //document.getElementById('waktu' + id).value = det[8];
					totaljual += parseInt(det[14]);
                    totalkomisi += parseInt(det[7]);
                    totalkomisi_temp += parseInt(det[7]);
                    id++;
                }
                tot2 = totaljual.toFixed(0);
                tot_temp = totalkomisi_temp.toFixed(0);
                document.getElementById('total').value = totalkomisi;
                document.getElementById('total_temp').value = format_num(tot_temp);
                document.getElementById('totjual').value = totaljual;
                document.getElementById('totjual_temp').value = format_num(tot2);
                document.getElementById('btngenerate').disabled = true;
                
            } else {
                alert("Tidak ada transaksi untuk komisi");
            }
            document.getElementById('transaksi').value="save";
        } else {
            alert("Masukan No Member")
        }
    })
    
}
*/

function format_num(nStr){
 nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}