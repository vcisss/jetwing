function cekMaster(field1,field2,form,alert1,alert2){
	if(cekoption(field1,"Memasukkan " + alert1))
	if(cekPjgKode(field1,alert1,2))
	if(cekoption(field2,"Memasukkan " + alert2))
		document.getElementById(form).submit();
}

function cekMaster2(field1,field2,form,alert1,alert2){
	if(cekoption(field1,"Memasukkan " + alert1))
	if(cekoption(field2,"Memasukkan " + alert2))
		document.getElementById(form).submit();
}

function cekoption(elm1,ket){
	if (trimIt(document.getElementById(elm1).value)==''){
		alert("Anda Belum "+ ket);
		document.getElementById(elm1).focus();
	}
	else return true;
	return false;
}

function cekselected(elm1,ket){
	if (trimIt(document.getElementById(elm1).value)=='not selected'){
		alert("Anda Belum "+ ket);
		document.getElementById(elm1).focus();
	}
	else return true;
	return false;
}

function cekAngka(elm,ket){
 	var nilai = document.getElementById(elm);
	if(ubah(trimIt(nilai.value)) == ""){
		alert("Anda Belum Memasukkan "+ket);
		nilai.focus();
	}
	else{
		if(isNaN(ubah(trimIt(nilai.value)))){
			alert(ket + " Hanya Dapat Berupa Angka\nGunakan Tanda Koma Untuk Nilai Desimal");
			nilai.select();
			nilai.focus();
		}
		else if(!cekTitik(trimIt(nilai.value)))
		{
			alert(ket + " Hanya Dapat Berupa Angka\nGunakan Tanda Koma Untuk Nilai Desimal");
			nilai.select();
			nilai.focus();
		}
		else if(ubah(trimIt(nilai.value))<0){
			alert(ket + " Tidak Boleh Lebih Kecil Dari 0");
			nilai.select();
			nilai.focus();
		}
		else
			return true;
	}	
	return false;
}

function cekAngkaPas(elm,ket,flagnol,flagminus){
 	var nilai = document.getElementById(elm);
	if(ubah(trimIt(nilai.value)) == ""){
		alert("Anda Belum Memasukkan "+ket);
		nilai.focus();
	}
	else{
		if(isNaN(ubah(trimIt(nilai.value)))){
			alert(ket + " Hanya Dapat Berupa Angka");
			nilai.select();
			nilai.focus();
		}
		else if(!cekTitik2(trimIt(nilai.value)))
		{
			alert(ket + " Tidak Boleh Berupa Nilai Desimal");
			nilai.select();
			nilai.focus();
		}
		else if(flagnol=="no zero"&&flagminus=="no minus"){
			if(ubah(trimIt(nilai.value))<1){
				alert(ket + " Tidak Boleh Lebih Kecil Dari 1");
				nilai.select();
				nilai.focus();
			}
			else
			return true;
		}
		else if(flagnol=="zero"&&flagminus=="no minus"){
			if(ubah(trimIt(nilai.value))<0){
				alert(ket + " Tidak Boleh Lebih Kecil Dari 0");
				nilai.select();
				nilai.focus();
			}
			else
			return true;
		}
		else if(flagnol=="no zero"&&flagminus=="minus"){
			if(ubah(trimIt(nilai.value))!=0){
				alert(ket + " Tidak Boleh 0");
				nilai.select();
				nilai.focus();
			}
			else
			return true;
		}
		else
			return true;
	}	
	return false;
}

function trimIt( str ) { // http://kevin.vanzonneveld.net // + improved by: mdsjack (http://www.mdsjack.bo.it) // + improved by: Alexander Ermolaev (http://snippets.dzone.com/user/AlexanderErmolaev)

	//return str.replace(/(^[\s\xA0]+|[\s\xA0]+$)|[$\\@\\\#%\^\&\*\(\)\[\]\+\_\{\}\`\~\=\|\'\"\>\<\.\,\?\/\:\;\-\!]/g, '');
	return str.replace(/(^[\s\xA0]+|[\s\xA0]+$)/g, '');
}

function SetChecked(chk, elm) {	//chk ==nama cekall, elm nama cekbiasa
	dml=document.forms[0];
	
	len = dml.elements.length;
	var i=0;	
	for( i=0 ; i<len ; i++) {
 	    if (dml.elements[i].name==chk) {
			if(dml.elements[i].checked==1) val = 1;
			else val = 0;
		}	 	   
		if (dml.elements[i].name==elm) {
			dml.elements[i].checked=val;
		}
		
	}
}

function validateForm(elm1,elm2,ket){
	if(trimIt(document.getElementById(elm1).value)!=trimIt(document.getElementById(elm2).value)){
		alert(ket + " Ada Perubahan \nHarap Menekan Enter Untuk Validasi Pilihan Kode");
		document.getElementById(elm1).focus();
	}
	else return true;
	return false;
}

function validateForm2(elm1,elm2,elm3,ket){
	if(trimIt(document.getElementById(elm1).value)!=trimIt(document.getElementById(elm2).value)){
		alert(ket + " Ada Perubahan \nHarap Menekan Enter Untuk Validasi Pilihan Kode");
		document.getElementById(elm3).focus();
	}
	else return true;
	return false;
}

function cekReport(elm1,elm2,ket)
{
	if($("#"+elm1).val()==""&&$("#"+elm2).val()!=""||$("#"+elm1).val()!=""&&$("#"+elm2).val()=="")
	{
		alert("Pencarian dengan "+ket+" harus diisi keduanya");
		return false;
	}
	return true;
}

function cekPjgKode(elm1,ket,pjg){
 	elm = document.getElementById(elm1);
	if(elm.value.length<parseFloat(pjg)){
		alert("Panjang " + ket + " Minimal "+pjg + " Karakter");
		elm.focus();
	}
	else return true;
	return false;
}

function changeCursor(e,form1,obj) {
	if(window.event) // IE
	{
		var code = e.keyCode;
	}
	else if(e.which) // Netscape/Firefox/Opera
	{
		var code = e.which;
	}
	if (code == 13) { //checks for the escape key
	  	dml=document.forms[form1];
		len = dml.elements.length;
		//cari letak kursor ada di field mana
		for( i=0 ; i<len ; i++) {
		 	if(dml.elements[i].name==obj.name){
		 	 	break;
			}
		}

		//cari next field name
		for( y=i ; y<len ;y++) {
		 	if(dml.elements[y+1].type!="hidden"){
			 	if(dml.elements[y+1].readOnly==false||dml.elements[y+1].type=="select-one"){
			 	 	if(dml.elements[y+1].value=="Tambah Barang"||dml.elements[y+1].value=="Tambah"||dml.elements[y+1].value=="Delete"){			 	 	 
						y=y+1;
					}
					if(dml.elements[y+1].type!="hidden"){
						dml.elements[y+1].focus();
						break;
					}
				}
			}
		}
	}
}

function firstLoad(form1){
	dml=document.forms[form1];
	len = dml.elements.length;
	for( i=0 ; i<len ; i++) {
		if(dml.elements[i].type!="hidden"&&dml.elements[i].type!="checkbox"){
		 	if(dml.elements[i].readOnly==false||dml.elements[i].type=="select-one"){
				dml.elements[i].focus();
				break;
			}
		}
	}
}

function ubah (harga){
	 t = harga.split(".");
	 k = t.join("");
	 s = k.split(",");
	 s = s.join(".");
	 return s;
}

function ubah_harga(harga){
 	harga=parseFloat(harga);
	harga = harga.toFixed(2);
	s = addSeparatorsNF(harga, '.', ',', '.');
	return s;
}

function addSeparatorsNF(nStr, inD, outD, sep) //input decimal character, the output decimal character,
	//and the output separator character.
{
	nStr += '';
	var dpos = nStr.indexOf(inD);
	var nStrEnd = '';
	if (dpos != -1) {
		nStrEnd = outD + nStr.substring(dpos + 1, nStr.length);
		nStr = nStr.substring(0, dpos);
	}
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(nStr)) {
		nStr = nStr.replace(rgx, '$1' + sep + '$2');
	}
	return nStr + nStrEnd;
}

function cekTitik(angka)
{
	nol=true;
	for(i = 0; i < angka.length; i++)
	{
		if(angka.charAt(i) == '.' ){
			nol = false;
			break;
		}
	}
	return nol;
}

function cekTitik2(angka)
{
	nol=true;
	for(i = 0; i < angka.length; i++)
	{
		if(angka.charAt(i) == '.'||angka.charAt(i) == ','){
			nol = false;
			break;
		}
	}
	return nol;
}


function dodacheck(val){
	var mikExp = /[$\\@\\\#%\^\&\*\(\)\[\]\+\_\{\}\`\~\=\|\'\"\>\<\.\,\?\/\:\;\-\!]/;
	var strPass = val.value;
	var strLength = strPass.length;
	for(x=0;x<strLength;x++){
		//var lchar = val.value.charAt((strLength) - 1);
		var lchar = val.value.charAt(x);
		if(lchar.search(mikExp) != -1) {
		//var tst = val.value.substring(0, (strLength) - 1);
		//val.value = tst;
			val.value = val.value.replace(lchar,"");
			//strLength = val.value.length;
			x--;
	   }
	}
}
//popup window
    function PopupWindow(strURL,intHeight,intWidth){
            var newWindow;
            var intTop= (screen.height - intHeight) / 2;
            var intLeft= (screen.width - intWidth) / 2;
            var props = 
'scrollBars=yes,resizable=yes,toolbar=no,menubar=no,location=no,directories=no,width='+intWidth+',height='+intHeight+',left='+intLeft+',top='+intTop+'';
            self.name = "<%=strRandom%>"
            newWindow = window.open(strURL, "Popup", props);
        }
