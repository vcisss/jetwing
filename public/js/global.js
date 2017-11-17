function cekMaster(field1,field2,form,alert1,alert2){
	if(cekoption(field1,"Memasukkan " + alert1))
	if(cekPjgKode(field1,alert1,1))
	if(cekoption(field2,"Memasukkan " + alert2))
		document.getElementById(form).submit();
}

function cekMaster2(field1,field2,form,alert1,alert2){
	if(cekoption(field1,"Memasukkan " + alert1))
	if(cekoption(field2,"Memasukkan " + alert2))
		document.getElementById(form).submit();
}

function cekMaster3(field1,field2,field3,form,alert1,alert2,alert3){
	if(cekoption(field1,"Memasukkan " + alert1))
	if(cekoption(field2,"Memasukkan " + alert2))
	if(cekoption(field3,"Memasukkan " + alert3))
		document.getElementById(form).submit();
}

function cekMaster4(field1,field2,field3,field4,form,alert1,alert2,alert3,alert4){
	if(cekoption(field1,"Memasukkan " + alert1))
	if(cekoption(field2,"Memasukkan " + alert2))
	if(cekoption(field3,"Memasukkan " + alert3))
	if(cekoption(field4,"Memasukkan " + alert4))
		document.getElementById(form).submit();
}

function cekMaster5(field1,field2,field3,field4,field5,form,alert1,alert2,alert3,alert4,alert5){
	if(cekoption(field1,"Memasukkan " + alert1))
	if(cekoption(field2,"Memasukkan " + alert2))
	if(cekoption(field3,"Memasukkan " + alert3))
	if(cekoption(field4,"Memasukkan " + alert4))
	if(cekoption(field5,"Memasukkan " + alert5))
		document.getElementById(form).submit();
}


function cekoption2(elm1,ket,form){
    //alert(elm1);
	if (trimIt(document.getElementById(elm1).value)==''){
		alert("Anda Belum "+ ket);
		document.getElementById(elm1).focus();
	}
	else document.getElementById(form).submit();
	return false;
}

function cekoption(elm1,ket){
    //alert(elm1);
	//alert(document.getElementById(elm1).value);
	if (trimIt(document.getElementById(elm1).value)==''){
		alert("Anda Belum "+ ket);
		document.getElementById(elm1).focus();
	}
	else return true;
	return false;
}

function cekstring(elm1,ket){
    //alert(elm1);
	if (trimIt(document.getElementById(elm1).value)==''){
		alert("Anda Belum "+ ket);
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

function cekAngka(elm,ket,flagnol,flagminus){
 	var nilai = document.getElementById(elm);
	if(ubah(trimIt(nilai.value)) == ""){
		alert("Anda Belum Memasukkan "+ket);
		nilai.focus();
	}
	else{
		if(isNaN(ubah(trimIt(nilai.value)))){
			alert(ket + " Hanya Dapat Berupa Angka\nGunakan Tanda Titik Untuk Nilai Desimal");
			nilai.select();
			nilai.focus();
		}
		else if(!cekKoma(trimIt(nilai.value)))
		{
			alert(ket + " Hanya Dapat Berupa Angka\nGunakan Tanda Titik Untuk Nilai Desimal");
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

function bulatkan( angka, desimal ) {
    //alert(Math.pow(10,desimal));
	return Math.round(angka*Math.pow(10,desimal))/Math.pow(10,desimal);
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

function ubah(harga){
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

function cekKoma(angka)
{
	nol=true;
	for(i = 0; i < angka.length; i++)
	{
		if(angka.charAt(i) == ',' ){
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
	//alert(val);
	//alert(val.value);
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

function jam(){
	var waktu = new Date();
	var jam = waktu.getHours();
	var menit = waktu.getMinutes();
	var detik = waktu.getSeconds();
	 
	if (jam < 10){
	jam = "0" + jam;
	}
	if (menit < 10){
	menit = "0" + menit;
	}
	if (detik < 10){
	detik = "0" + detik;
	}
	var jam_div = document.getElementById('jam');
	jam_div.innerHTML = jam + ":" + menit + ":" + detik;
	setTimeout("jam()", 1000);
	}
	
function popbrg(index,base_url)
{
	if(cekheader())
	{
		url = base_url+"index.php/pop/grup_barang/index/master/";
		window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
	}
}

function popbrgFromOrder(index,base_url)
{
	url = base_url+"index.php/pop/grup_barang/index/order/";
	window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function popbrgFromSales(index,base_url)
{
	url = base_url+"index.php/pop/grup_barang/index/sales/";
	window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function popcontact(index,base_url)
{
	url = base_url+"index.php/pop/contact/index/sales/";
	window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function popmember(index,base_url)
{
	url = base_url+"index.php/pop/member/index/sales/";
	window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function poppersonal(index,base_url)
{
	url = base_url+"index.php/pop/personal/index/sales/";
	window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function popnumber(index,base_url)
{
	url = base_url+"index.php/pop/number/index/";
	window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function poptable(index,base_url)
{
	url = base_url+"index.php/pop/table/index/";
	window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function popordertable(index,base_url)
{
	url = base_url+"index.php/pop/ordertable/index/";
	window.open(url+(index),'popuppage','width=750,height=750,top=100,left=150');
}

function popdiscount(index,base_url)
{
	//url = base_url+"index.php/pop/discount/index/sales/";
	//window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function popmeja(index,base_url)
{
	//url = base_url+"index.php/pop/personal/index/sales/";
	//window.open(url+(index),'popuppage','width=750,height=500,top=100,left=150');
}

function popsalesorder(base_url)
{
	url = base_url+"index.php/pop/salesorder/index/";
	window.open(url,'popuppage','width=750,height=500,top=100,left=150');
}

/**
*
*  MD5 (Message-Digest Algorithm)
*  http://www.webtoolkit.info/
*
**/
 
function md5(string) {
 
	function RotateLeft(lValue, iShiftBits) {
		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
	}
 
	function AddUnsigned(lX,lY) {
		var lX4,lY4,lX8,lY8,lResult;
		lX8 = (lX & 0x80000000);
		lY8 = (lY & 0x80000000);
		lX4 = (lX & 0x40000000);
		lY4 = (lY & 0x40000000);
		lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		if (lX4 & lY4) {
			return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		}
		if (lX4 | lY4) {
			if (lResult & 0x40000000) {
				return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			}
		} else {
			return (lResult ^ lX8 ^ lY8);
		}
 	}
 
 	function F(x,y,z) { return (x & y) | ((~x) & z); }
 	function G(x,y,z) { return (x & z) | (y & (~z)); }
 	function H(x,y,z) { return (x ^ y ^ z); }
	function I(x,y,z) { return (y ^ (x | (~z))); }
 
	function FF(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function ConvertToWordArray(string) {
		var lWordCount;
		var lMessageLength = string.length;
		var lNumberOfWords_temp1=lMessageLength + 8;
		var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		var lWordArray=Array(lNumberOfWords-1);
		var lBytePosition = 0;
		var lByteCount = 0;
		while ( lByteCount < lMessageLength ) {
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
			lByteCount++;
		}
		lWordCount = (lByteCount-(lByteCount % 4))/4;
		lBytePosition = (lByteCount % 4)*8;
		lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		return lWordArray;
	};
 
	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	};
 
	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	};
 
	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;
 
	string = Utf8Encode(string);
 
	x = ConvertToWordArray(string);
 
	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
 
	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}
 
	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
 
	return temp.toLowerCase();
}