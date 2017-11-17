    //9: "tab",
    //13: "enter",
    //16: "shift",
    //18: "alt",
    //27: "esc",
    //33: "rePag",
    //34: "avPag",
    //35: "end",
    //36: "home",
    //37: "left",
    //38: "up",
    //39: "right",
    //40: "down",
    //112: "F1",
    //113: "F2",
    //114: "F3",
    //115: "F4",
    //116: "F5",
    //117: "F6",
    //118: "F7",
    //119: "F8",
    //120: "F9",
    //121: "F10",
$(document).ready(function () {
    $(document).keydown( function (e) {
        switch(e.keyCode)
        {
            // user presses the "F1"
            case 112: //alert("F1"); fokus produck
                document.getElementById('kdbrg1').focus();
                break;
            case 113: //alert("F2");cash bayar
                document.getElementById('cash_bayar').focus();
                break;
            case 120: //alert("F3");cetak
                cek_form();
                break;
            case 115: //alert("F1"); fokus produck
                document.getElementById('pelanggan').focus();
                break;
            case 116: //alert("F2");cash bayar
                document.getElementById('kdagent').focus();
                break;
        }
    });
});


function number_format(a, b, c, d)
{
	a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
	e = a + '';
	f = e.split('.');
	if (!f[0]) {
	f[0] = '0';
	}
	if (!f[1]) {
	f[1] = '';
	}
	if (f[1].length < b) {
	g = f[1];
	for (i=f[1].length + 1; i <= b; i++) {
	g += '0';
	}
	f[1] = g;
	}
	if(d != '' && f[0].length > 3) {
	h = f[0];
	f[0] = '';
	for(j = 3; j < h.length; j+=3) {
	i = h.slice(h.length - j, h.length - j + 3);
	f[0] = d + i +  f[0] + '';
	}
	j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
	f[0] = j + f[0];
	}
	c = (b <= 0) ? '' : c;
	
	return f[0] + c + f[1];
}

function SetNetto()
	{ 							
		document.getElementById('qtym1').focus();
		
		qty1              = Number(document.getElementById('qtym1').value);
		jualmtanpaformat1 = Number(document.getElementById('jualmtanpaformat1').value);
		
		netto1            = qty1 * jualmtanpaformat1;
		
		document.getElementById('nettom1').value = number_format(netto1, 0, ',', '.');
		document.getElementById('nettotanpaformat1').value = netto1;		
	}
		
	function clear_trans(url)
	{
		if(confirm("Anda yakin ingin menghapus transaksi ini"))
			{
                setCookies("penjualanPOS", "", 1) ;
				//document.forms["pindah"].submit();
				location.reload(); 
				document.getElementById('id_voucher').value = "";
				document.getElementById('keterangan').value = "";
				document.getElementById('jenisvoucher').value = "";
                document.getElementById('qtym1').value="";
				document.getElementById('nettom1').value="";
				document.getElementById('kdbrg1').focus();
			}
		else{
				return false;
			}
	}

	function oncek()
	{
		
		
		if(document.form1.pilihan[0].checked == true){
			document.getElementById('pilihan').value = "cash";
		}
		else if(document.form1.pilihan[1].checked == true){
			document.getElementById('pilihan').value = "kredit";
		}
		else if(document.form1.pilihan[2].checked == true){
			document.getElementById('pilihan').value = "debit";
		}
		else if(document.form1.pilihan[3].checked == true){	
			document.getElementById('pilihan').value = "voucher";	
		}	
		else if(document.form1.pilihan[4].checked == true){
			document.getElementById('pilihan').value = "compliment";			
		}	

		/*
		if(document.form1.pilihan[0].checked == true){
			document.getElementById('cash_bayar').disabled=false;
			document.getElementById('cash_bayar').focus();
		
			if(document.getElementById('id_kredit').value == "")
			{ document.getElementById('id_kredit').disabled=true;}
			else { document.getElementById('id_kredit').disabled=false;}
			
			if(document.getElementById('id_debet').value == "")
			{ document.getElementById('id_debet').disabled=true;}
			else{document.getElementById('id_debet').disabled=false;}
			
			if(document.getElementById('id_voucher').value == "")
			{ document.getElementById('id_voucher').disabled=true;}
			else{document.getElementById('id_voucher').disabled=false;}
			
			if(document.getElementById('kredit_bayar').value == "")
			{document.getElementById('kredit_bayar').disabled = true;}
			else{document.getElementById('kredit_bayar').disabled = false;}
			
			if(document.getElementById('debet_bayar').value == "")
			{document.getElementById('debet_bayar').disabled = true;}
			else{document.getElementById('debet_bayar').disabled = false;}
			
			if(document.getElementById('voucher_bayar').value == "")
			{document.getElementById('voucher_bayar').disabled = true;}
			else{document.getElementById('voucher_bayar').disabled = false;}
	}
	else if(document.form1.pilihan[1].checked == true){
			if(document.getElementById('cash_bayar').value == "")
			{ document.getElementById('cash_bayar').disabled=true;}
			else { document.getElementById('cash_bayar').disabled=false;}
			
			document.getElementById('id_kredit').disabled=false;
			document.getElementById('id_kredit').focus();
		
			if(document.getElementById('id_debet').value == "")
			{ document.getElementById('id_debet').disabled=true;}
			else{document.getElementById('id_debet').disabled=false;}
			
			if(document.getElementById('id_voucher').value == "")
			{ document.getElementById('id_voucher').disabled=true;}
			else{document.getElementById('id_voucher').disabled=false;}
			
			if(document.getElementById('debet_bayar').value == "")
			{document.getElementById('debet_bayar').disabled = true;}
			else{document.getElementById('debet_bayar').disabled = false;}
			
			if(document.getElementById('voucher_bayar').value == "")
			{document.getElementById('voucher_bayar').disabled = true;}
			else{document.getElementById('voucher_bayar').disabled = false;}
	}
	else if(document.form1.pilihan[2].checked == true){
			if(document.getElementById('cash_bayar').value == "")
			{ document.getElementById('cash_bayar').disabled=true;}
			else { document.getElementById('cash_bayar').disabled=false;}
			
			if(document.getElementById('id_kredit').value == "")
			{ document.getElementById('id_kredit').disabled=true;}
			else { document.getElementById('id_kredit').disabled=false;}
			
			document.getElementById('id_debet').disabled=false;
			document.getElementById('id_debet').focus();
		
			if(document.getElementById('id_voucher').value == "")
			{ document.getElementById('id_voucher').disabled=true;}
			else{document.getElementById('id_voucher').disabled=false;}
			
			if(document.getElementById('kredit_bayar').value == "")
			{document.getElementById('kredit_bayar').disabled = true;}
			else{document.getElementById('kredit_bayar').disabled = false;}
			
			if(document.getElementById('voucher_bayar').value == "")
			{document.getElementById('voucher_bayar').disabled = true;}
			else{document.getElementById('voucher_bayar').disabled = false;}	
		}
	else if(document.form1.pilihan[3].checked == true){
			if(document.getElementById('cash_bayar').value == "")
			{ document.getElementById('cash_bayar').disabled=true;}
			else { document.getElementById('cash_bayar').disabled=false;}
			
			if(document.getElementById('id_kredit').value == "")
			{ document.getElementById('id_kredit').disabled=true;}
			else { document.getElementById('id_kredit').disabled=false;}
			
			if(document.getElementById('id_debet').value == "")
			{ document.getElementById('id_debet').disabled=true;}
			else{document.getElementById('id_debet').disabled=false;}
			
			document.getElementById('id_voucher').disabled=false;
			document.getElementById('id_voucher').focus();
			
			if(document.getElementById('kredit_bayar').value == "")
			{document.getElementById('kredit_bayar').disabled = true;}
			else{document.getElementById('kredit_bayar').disabled = false;}
			
			if(document.getElementById('debet_bayar').value == "")
			{document.getElementById('debet_bayar').disabled = true;}
			else{document.getElementById('debet_bayar').disabled = false;}			
		}	
		*/
	}
	
	function SetKembali()
	{
        var e = document.getElementById("Uang");
        var kurs = e.options[e.selectedIndex].value;
        var myarr = kurs.split("-");

		total_biaya 			= Number(document.getElementById('total_biaya').value);
		cash_bayar        		= Number(document.getElementById('cash_bayar').value);
        cash_bayar2             = cash_bayar * Number(myarr[1]);
		kredit_bayar			= Number(document.getElementById('kredit_bayar').value);
		debet_bayar				= Number(document.getElementById('debet_bayar').value);
		voucher_bayar			= Number(document.getElementById('voucher_bayar').value);
		valas_bayar				= Number(document.getElementById('valas_bayar').value);
		id_kurs					= Number(document.getElementById('id_kurs').value);
		total_bayar				= cash_bayar2 + kredit_bayar + debet_bayar + voucher_bayar + (valas_bayar*id_kurs);
        service_charge			= Number(document.getElementById('service_charge').value);
		kembali					= total_bayar - (total_biaya );
        //alert(service_charge);
		document.getElementById('total_bayar_hide').value = total_bayar;
		document.getElementById('total_bayar').innerHTML = number_format(total_bayar, 0, ',', '.');
		document.getElementById('cash_kembali').innerHTML = number_format(kembali, 0, ',', '.');
	}
	
	function KreditCustomer(e,row,url)
	{
		if(window.event)
		{
			var code = e.keyCode;
		}
		else if(e.which)
		{
			var code = e.which;
		}
		
		if (code == 13)
		{
			if(document.getElementById('id_kredit').value !== "")
			{
				document.getElementById('kredit_bayar').disabled=false;
				document.getElementById('kredit_bayar').focus();
			}
			else{
				document.getElementById('kredit_bayar').disabled=true;
				}
		}
	
	}
	
	function DebetCustomer(e,row,url)
	{
		if(window.event)
		{
			var code = e.keyCode;
		}
		else if(e.which)
		{
			var code = e.which;
		}
		
		if (code == 13)
		{
			if(document.getElementById('id_debet').value !== "")
			{
				document.getElementById('debet_bayar').disabled=false;
				document
                    .getElementById('debet_bayar').focus();
			}
			else{
				document.getElementById('debet_bayar').disabled=true;
				}
		}
	
	}
	
	function ValasCustomer(e,row,url)
	{
		if(window.event)
		{
			var code = e.keyCode;
		}
		else if(e.which)
		{
			var code = e.which;
		}
		
		if (code == 13)
		{
			if(document.getElementById('id_valas').value !== "")
			{
				id_valas = document.getElementById('id_valas').value;
			//alert(pcode0);
			
				$.ajax({
					type: "POST",
					url: url+"index.php/transaksi/pos/cekvalas/"+id_valas,
					success: function(msg){
						//alert(msg);alert(PCode);

						if((msg=="salah")||(msg<=1)){
							alert("Kode valas salah atau belum di set kurs!");
							$("#valas_bayar").val(0);
							document.getElementById('id_valas').value = "";
							document.getElementById('id_valas').focus();
							SetKembali();
						}else{
							var jsdata = msg;
							$("#id_kurs").val(parseFloat(jsdata));
							$("#id_valasasli").val(id_valas);
							document.getElementById('valas_bayar').disabled=false;
							document.getElementById('valas_bayar').focus();
						}
					}
				});	
			}
			else{
				$("#valas_bayar").val(0);
				document.getElementById('valas_bayar').disabled=true;
				SetKembali();
				}
		}
	
	}
	
function getCodeForSales(e,row,url,action)
{
    if(window.event)
    {
        var code = e.keyCode;
    }
    else if(e.which)
    {
        var code = e.which;
    }
    if (code == 13)
    {
		if(action == 'insert')
        {
            PCode = document.getElementById('kdbrg' + row).value;
                                                //alert(PCode);
            //document.getElementById('temp_pos2').style.display = "block";
            //document.getElementById('temp_pos1').style.display = "none";
			tgl0 = document.getElementById('tgltrans').value;
            pcode0 = PCode.replace('*','~')+"~"+tgl0;
			//alert(pcode0);
			
            $.ajax({
                type: "POST",
                url: url+"index.php/transaksi/pos/DetailItemForSales/"+pcode0,
                success: function(msg){
                    if(msg=="salah" || msg=="non aktif"){
                        alert("Kode / Barcode " + pcode0 + " " + msg + " !!!");
                        document.getElementById('kdbrg1').value = "";
                        document.getElementById('kdbrg1').focus();
                        if (isNaN(PCode))
                        {
                            //alert("Must input numbers");
                            index = 1;
                            url = url + "index.php/pop/grup_barang/index/sales/";
                            window.open(url + (index), 'popuppage', 'width=750,height=500,top=100,left=150');
                        }
                    }else{
                        var jsdata = msg;
                        barisPOS(url);
                    }
                }
            });
        }
        else
        {
            if(document.getElementById('qtym1').value == "")
            {
                alert('Qty tidak boleh kosong');
            }
            else
            {
                PCode = document.getElementById('kdbrg1').value;
                Qty = document.getElementById('qtym1').value;
                $.post(url + "index.php/transaksi/pos/EditDetailItemForSales", {
                        PCode: PCode, Qty: Qty},
                    function (msg) {
                            window.location.reload(true);
                });
            }
        }
    }
}
    function objectLength(obj) {
        var result = 0;
        for(var prop in obj) {
            if (obj.hasOwnProperty(prop)) {
                // or Object.prototype.hasOwnProperty.call(obj, prop)
                result++;
            }
        }
        return result;
    }

	String.prototype.replaceAll = function(search, replace)
	{
		//if replace is not sent, return original string otherwise it will
		//replace search string with 'undefined'.
		if (replace === undefined) {
			return this.toString();
		}

		return this.replace(new RegExp('[' + search + ']', 'g'), replace);
	};
	
    function barisPOS(url){
        //alert ("masuk");
        //deleteAll();
        //document.getElementById('temp_pos1').style.display = "none";
        //document.getElementById('temp_pos2').style.display = "block";

        dt = (getCookie("penjualanPOS"));

        //eval(dt);
        //alert(dt.length);
        dt2 = eval(dt);
        ttl = dt2.length;
		
		pcode = dt2[0]['PCode'];
		namalengkap = dt2[0]['NamaLengkap'].replaceAll('+',' ');
		qty = parseFloat(dt2[0]['Qty']);
		harga = Math.round(dt2[0]['Harga1c']);
		disc = 0;//parseFloat(dt2[0]['disc']);
		netto = qty*Math.round(dt2[0]['Netto']);
		sc = parseFloat(dt2[0]['Service_charge']);
		komisi = parseFloat(dt2[0]['Komisi']);
		pdisc = parseFloat(dt2[0]['Disc']);
		komisilokal = parseFloat(dt2[0]['KomisiLokal']);
		pdisclokal = parseFloat(dt2[0]['DiscLokal']);
		jenisdisc = dt2[0]['jenisdisc'];
		nilaidisc = parseFloat(dt2[0]['nilaidisc']);
		khusus = dt2[0]['khusus'];
		//alert(jenisdisc);
		//alert(nilaidisc);
		
		jenisvoucher  = $("#jenisvoucher").val();
		if(jenisvoucher=='1')
		{
		   $("#jenistiket").val(jenisvoucher);
		}
		
		jenistiket  = $("#jenistiket").val();
		
		//====================================================
		
		//var tbl = document.getElementById("detail1");
        //var lastRow = tbl.rows.length;
		var lastRow = document.getElementsByName("pcode00[]").length;
		//alert(lastRow);
		datadouble = false;
		for(index=1;index<=lastRow;index++)
		{
			indexs = index; 
			if($("#lkodebarang"+indexs).val()==pcode)
			{
			   datadouble = true;
			   break;
			}
			
		}
		
		id_discount = $("#iddiscountasli").val();
		iduserdiscount = $("#iduserdiscount").val();
		minimum = $("#minimum").val();
		nil_disc = $("#nil_disc").val();
		

		//alert(indexs);
		if(datadouble)
		{
			qtyasli = parseFloat($("#ljumlahqty" + indexs).val());
			hargaasli  = parseFloat($("#ljumlahharga" + indexs).val());
			discasli = parseFloat($("#ldisc" + indexs).val());
			persenasli = 0;
			if((qtyasli!=0)&&(hargaasli!=0))
			{
			   persenasli = discasli/(qtyasli*hargaasli);
			}
			qtybaru = parseFloat(qtyasli)+parseFloat(qty);
			if(qtybaru<0)
			  qtybaru=0;
		    //alert(persenasli);
			//alert(discasli);
			//alert(qtyasli);
			nettobaru = (qtybaru*hargaasli)*(1-persenasli);
			//alert(qtybaru);
			//alert(hargaasli);
			//alert(persenasli);
			//alert(disc);
			disc = (qtybaru*hargaasli)-nettobaru;
	
			$("#ljumlahqty" + indexs).val(qtybaru);
			$("#ljumlahnetto" + indexs).val(nettobaru);
			$("#disc" + indexs).val(disc);
			$("#ldisc" + indexs).val(disc);
			document.getElementById('ljumlahqty'+indexs).innerHTML = qtybaru;
			document.getElementById('ldisc'+indexs).innerHTML = disc;
			document.getElementById('ljumlahnetto'+indexs).innerHTML = nettobaru;
			$("#qty" + indexs).val(qtybaru);
			$("#netto" + indexs).val(nettobaru);
			$("#pdisc" + indexs).val(pdisc);
			$("#komisi" + indexs).val(komisi);
			$("#pdisclokal" + indexs).val(pdisclokal);
			$("#komisilokal" + indexs).val(komisilokal);
			$("#jenisdisc" + indexs).val(jenisdisc);
			$("#nilaidisc" + indexs).val(nilaidisc);
			$("#khusus" + indexs).val(khusus);
			
			if(jenisvoucher=="3")
			{
				disc = pdisc/100*(qtybaru*hargaasli);
				
			}else if(jenistiket=="1") //tiket lokal
			{
				disc = pdisclokal/100*(qtybaru*hargaasli);
				$("#komisi" + indexs).val(komisilokal);
			}
			if(jenisdisc=="P") //discount persentage
			{
				disc = nilaidisc/100*(qtybaru*hargaasli);
				if((jenistiket=="1")&&(pdisclokal>nilaidisc))
				{
				   disc = pdisclokal/100*(qtybaru*hargaasli);
				}
				if((jenisvoucher=="3")&&(pdisc>nilaidisc))
				{
				   disc = parseFloat(pdisc/100*(qtybaru*hargaasli));
				}
			}
			if((id_discount>0)&&(iduserdiscount!=''))
			{
				discid = id_discount/100*(qtybaru*hargaasli);
				if(discid>disc)
				{
					disc = discid;
				}
			}
			disc = Math.round(disc);
			
			netto = (qtybaru*hargaasli)-disc;
			$("#netto" + indexs).val(netto);
			$("#disc" + indexs).val(disc);
			document.getElementById('ldisc'+indexs).innerHTML = disc;
			document.getElementById('ljumlahnetto'+indexs).innerHTML = netto;
			$("#ldisc" + indexs).val(disc);
			$("#ljumlahnetto" + indexs).val(netto);
			
			//alert(disc);
		}else
		{
			indexs = lastRow;
			//alert($("#lkodebarang1").val());
			if(!(($("#lkodebarang1").val()=="")||($("#lkodebarang1").val()==null)))
			{
				indexs = lastRow+1;
				cloneRow(indexs);
				//alert("masuk");
				//alert(indexs);
			}
			
			$("#lfield_sales_temp" + indexs).val(indexs);
			$("#lkodebarang" + indexs).val(pcode);
			$("#lnamabarang" + indexs).val(namalengkap);
			$("#ljumlahqty" + indexs).val(qty);
			$("#ljumlahharga" + indexs).val(harga);
			$("#ldisc" + indexs).val(disc);
			$("#ljumlahnetto" + indexs).val(netto);
			
			$("#pcode" + indexs).val(pcode);
			$("#qty" + indexs).val(qty);
			$("#harga" + indexs).val(harga);
			$("#disc" + indexs).val(disc);
			$("#netto" + indexs).val(netto);
			$("#pdisc" + indexs).val(pdisc);
			$("#komisi" + indexs).val(komisi);
			$("#pdisclokal" + indexs).val(pdisclokal);
			$("#komisilokal" + indexs).val(komisilokal);
			$("#jenisdisc" + indexs).val(jenisdisc);
			$("#nilaidisc" + indexs).val(nilaidisc);
			$("#khusus" + indexs).val(khusus);
			//alert(pdisc);
			
			if(jenisvoucher=="3")
			{
				disc = parseFloat(pdisc/100*(qty*harga));
			}else if(jenistiket=="1") //tiket lokal
			{
				disc = parseFloat(pdisclokal/100*(qty*harga));
				$("#komisi" + indexs).val(komisilokal);
			} 
			if(jenisdisc=="P") //discount promo
			{
				disc = parseFloat(nilaidisc/100*(qty*harga));
				if((jenistiket=="1")&&(pdisclokal>nilaidisc))
				{
				   disc = parseFloat(pdisclokal/100*(qty*harga));
				}
				if((jenisvoucher=="3")&&(pdisc>nilaidisc))
				{
				   disc = parseFloat(pdisc/100*(qty*harga));
				}
				
			}
			
			if((id_discount>0)&&(iduserdiscount!=''))
			{
				discid = id_discount/100*(qty*harga);
				if(discid>disc)
				{
					disc = discid;
				}
			}
			disc = Math.round(disc);
			
			netto = (qty*harga)-disc;
			$("#netto" + indexs).val(netto);
			$("#disc" + indexs).val(disc);
			$("#ldisc" + indexs).val(disc);
			$("#ljumlahnetto" + indexs).val(netto);

			document.getElementById('lfield_sales_temp'+indexs).innerHTML  = indexs;
            document.getElementById('lkodebarang'+indexs).innerHTML  = pcode;
            document.getElementById('lnamabarang'+indexs).innerHTML = namalengkap;
            document.getElementById('ljumlahqty'+indexs).innerHTML = qty;
            document.getElementById('ljumlahharga'+indexs).innerHTML =  harga;
            document.getElementById('ldisc'+indexs).innerHTML = disc;
            document.getElementById('ljumlahnetto'+indexs).innerHTML = netto;
		}
		
		var tbl = document.getElementById("detail1");
        var lastRow = tbl.rows.length;
		netto = 0;
		totaldisc = 0;
		nettoxx = 0;
		totaldiscxx = 0;
		var listpcode="";
		var listqty="";
		var listharga="";
		var listdisc="";
		var listnetto="";
		var listpdisc="";
		var listkomisi="";
		var listpdisclokal="";
		var listkomisilokal="";
		var listjenisdisc="";
		var listnilaidisc="";
		var listkhusus="";
		for(index=1;index<=lastRow;index++)
		{
			netto = netto + parseFloat($("#ljumlahnetto" + index).val());
			totaldisc = totaldisc + parseFloat($("#ldisc" + index).val());
			if($("#khusus" + index).val()=="X"){
				nettoxx = nettoxx + parseFloat($("#ljumlahnetto" + index).val());
				totaldiscxx = totaldiscxx + parseFloat($("#ldisc" + index).val());
				//alert(nettoxx+" + "+totaldiscxx);
			}
			/*
			listpcode = listpcode + $("#lkodebarang" + index).val() + "##";
			listqty = listqty + $("#ljumlahqty" + index).val() + "##";
			listharga = listharga + $("#ljumlahharga" + index).val() + "##";
			listdisc = listdisc + $("#ldisc" + index).val() + "##";
			listnetto = listnetto + $("#ljumlahnetto" + index).val() + "##";
			*/
			listpcode = listpcode + $("#pcode" + index).val() + "##";
			listqty = listqty + $("#qty" + index).val() + "##";
			listharga = listharga + $("#harga" + index).val() + "##";
			listdisc = listdisc + $("#disc" + index).val() + "##";
			listnetto = listnetto + $("#netto" + index).val() + "##";
			listpdisc = listpdisc + $("#pdisc" + index).val() + "##";
			listkomisi = listkomisi + $("#komisi" + index).val() + "##";
			listpdisclokal = listpdisclokal + $("#pdisclokal" + index).val() + "##";
			listkomisilokal = listkomisilokal + $("#komisilokal" + index).val() + "##";
			listjenisdisc = listjenisdisc + $("#jenisdisc" + index).val() + "##";
			listnilaidisc = listnilaidisc + $("#nilaidisc" + index).val() + "##";
			listkhusus = listkhusus + $("#khusus" + index).val() + "##";
			//alert($("#ljumlahnetto" + index).val());
			//alert(index);
		}
		$("#listpcode").val(listpcode);
		$("#listqty").val(listqty);
		$("#listharga").val(listharga);
		$("#listdisc").val(listdisc);
		$("#listnetto").val(listnetto);
		$("#listpdisc").val(listpdisc);
		$("#listkomisi").val(listkomisi);
		$("#listpdisclokal").val(listpdisclokal);
		$("#listkomisilokal").val(listkomisilokal);
		$("#listjenisdisc").val(listjenisdisc);
		$("#listnilaidisc").val(listnilaidisc);
		$("#listkhusus").val(listkhusus);
		$("#discount_bayar").val(totaldisc);
		tax = Math.floor(netto / 11);
		dpp = netto - tax;
		//ppn = Math.floor(netto*0.1);
		total = Math.floor(netto);
		totalxx = Math.floor(nettoxx);
		document.getElementById('TotalItem').innerHTML = number_format(lastRow,0,',','.');// TotalItem in cart
		document.getElementById('TotalItem2').value = (lastRow) ;// TotalItem in cart
		document.getElementById('dpp').value = Math.floor(dpp)  ;// dpp
		document.getElementById('tax').value =  Math.floor(tax) ;// tax
		document.getElementById('ttlall').innerHTML = number_format(total,0,',','.'); //  total setelah service charge
		document.getElementById('TotalNetto').innerHTML = number_format(total,0,',','.');
		document.getElementById('service_charge').value = 0;// TotalItem in cart
		//document.getElementById('Charge').innerHTML = number_format(0 ,0,',','.');;// TotalItem service charge
		document.getElementById('total_biaya').value = total  ;
		
		tgltrans = document.getElementById('tgltrans').value;
		kassa = document.getElementById('kassa').value;
		//alert(tgltrans);
		//alert(kassa);
		if(minimum!=""){
			document.getElementById('ttlpromo').innerHTML = number_format(totalxx+totaldiscxx,0,',','.'); //  total promo khusus
			if((totalxx+totaldiscxx>=minimum)){
				//$("#iddiscountasli").val(nil_disc);
				//$("#id_discount").val(nil_disc);
				
				$("#iddiscountasli").val(0);
				$("#id_discount").val(0);
				$("#iduserdiscount").val("DISCKHUSUS");
				HitungNetto();			
			}
			else{
				$("#iddiscountasli").val(0);
				$("#id_discount").val(0);
				$("#iduserdiscount").val("");
				HitungNetto();				
			}
		}
		else if((total+totaldisc>=500000)&&(tgltrans=='2016-08-17')&&(kassa<='26'))
		{
			//wieok
		     $("#iddiscountasli").val(17);
			 $("#id_discount").val(17);
		     $("#iduserdiscount").val("PROMO17");
			 HitungNetto();
		}else
		{
			 tipepromo = $("#iduserdiscount").val();
			 if(tipepromo=="PROMO17")
			 {
				$("#iddiscountasli").val(0);
				$("#id_discount").val(0);
				$("#iduserdiscount").val("");
				HitungNetto();
			 }
			 
		}
		
		//=======================================
		
		SetKembali();
		toLCD(namalengkap, harga, netto);
		/*
		kirim = namalengkap+'~'+harga+"~"+netto;
		$.ajax({
			type: "POST",
			url: url+"index.php/transaksi/pos/displaycust/"+kirim,
			success: function(msg){
			}
		});
		*/
		
        document.getElementById('kdbrg1').value = "" ;
		document.getElementById('nmbrg1').value = "" ;
		document.getElementById('qtym1').value = 0 ;
		document.getElementById('jualm1').value = 0 ;
		document.getElementById('discm1').value = 0 ;
		document.getElementById('nettom1').value = 0 ;
		document.getElementById('jualmtanpaformat1').value = 0 ;
		document.getElementById('nettotanpaformat1').value = 0 ;
		
        document.getElementById('kdbrg1').focus();
    }

    function setCookies(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function getCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1) {
                    c_end = document.cookie.length;
                }
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    }


    function cloneRow(nbaru) {
			
        nomor = nbaru-1;
		//alert("baru");
		//alert(nbaru);
		/*
        var row = document.getElementById("newID" + nomor); // find row to copy
        var table = document.getElementById("detail1"); // find table to append to
        var clonedRow = row.cloneNode(true); // copy children too
		*/
		
		var clonedRow = $("#detail1 tr:last").clone(true);
	    //var intCurrentRowId = parseFloat($('#detail1 tr').length)-1;
	    //lastRow = document.getElementsByName("pcode00[]").length;
		//var intNewRowId = nbaru;
		
        $("#lfield_sales_temp" + nomor, clonedRow).attr({"id": "lfield_sales_temp" + nbaru});
        $("#lkodebarang" + nomor, clonedRow).attr({"id": "lkodebarang" + nbaru});
        $("#lnamabarang" + nomor, clonedRow).attr({"id": "lnamabarang" + nbaru});
        $("#ldisc" + nomor, clonedRow).attr({"id": "ldisc" + nbaru});
        $("#ljumlahqty" + nomor, clonedRow).attr({"id": "ljumlahqty" + nbaru});
        $("#ljumlahharga" + nomor, clonedRow).attr({"id": "ljumlahharga" + nbaru});
        $("#ljumlahnetto" + nomor, clonedRow).attr({"id": "ljumlahnetto" + nbaru});
        $("#field_sales_temp" + nomor, clonedRow).attr({"id": "field_sales_temp" + nbaru});
	
		$("#pcode" + nomor, clonedRow).attr( { "id" : "pcode" + nbaru, "value" : ""} );
		$("#qty" + nomor, clonedRow).attr( { "id" : "qty" + nbaru, "value" : 0} );
		$("#harga" + nomor, clonedRow).attr( { "id" : "harga" + nbaru, "value" : 0} );
		$("#disc" + nomor, clonedRow).attr( { "id" : "disc" + nbaru, "value" : 0} );
		$("#netto" + nomor, clonedRow).attr( { "id" : "netto" + nbaru, "value" : 0} );
		$("#pdisc" + nomor, clonedRow).attr( { "id" : "pdisc" + nbaru, "value" : 0} );
		$("#komisi" + nomor, clonedRow).attr( { "id" : "komisi" + nbaru, "value" : ""} );
		$("#pdisclokal" + nomor, clonedRow).attr( { "id" : "pdisclokal" + nbaru, "value" : 0} );
		$("#komisilokal" + nomor, clonedRow).attr( { "id" : "komisilokal" + nbaru, "value" : ""} );
		$("#jenisdisc" + nomor, clonedRow).attr( { "id" : "jenisdisc" + nbaru, "value" : ""} );
		$("#nilaidisc" + nomor, clonedRow).attr( { "id" : "nilaidisc" + nbaru, "value" : 0} );
		$("#khusus" + nomor, clonedRow).attr( { "id" : "khusus" + nbaru, "value" : ""} );
		
		$("#detail1").append(clonedRow);
	    $("#detail1 tr:last" ).attr( "id", "baris" +nbaru ); // change id of last row
	
        //clone.id = "newID"+nbaru; // change id or other attributes/contents
        //row.appendChild(clone); // add new row to end of table
    }

    function deleteAll() {
        var tbl = document.getElementById("detail1");
        var rowLen = tbl.rows.length - 1;
        //alert(rowLen);
        for (var idx = rowLen; idx > 0; idx--)
        tbl.deleteRow(idx)
    }

