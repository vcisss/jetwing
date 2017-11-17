function createRequestObject()
{
	var ro;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	}else
	{
		ro = new XMLHttpRequest();
	}
	return ro;
}

var xmlhttp = createRequestObject();

function java_mktime(hour,minute,month,day,year)
{
	return new Date(year, month - 1, day, hour, minute, 0, 0).getTime() / 1000;
}

function CallAjax(vari,param1)
{
	if (param1 == undefined) param1 = '';

	document.getElementById('show_image_ajax').style.display = '';

	if (vari == 'hide_menu')
	{
		var variabel;

		xmlhttp.open('get', 'ajax.php?ajax=hide_menu&'+variabel, true);
		xmlhttp.onreadystatechange = function()
		{
			if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
			{
				document.getElementById('hidden_ajax').innerHTML = xmlhttp.responseText;
				document.getElementById('v_show_menu').style.display = 'none';
				document.getElementById('show_menu').innerHTML = "<span onclick=\"CallAjax('show_menu')\" style=\"cursor: pointer;\" title='Show Menu'><img src=\"images/elbow-minus.gif\" ></span>";
				document.getElementById('show_image_ajax').style.display = 'none';
			}
			return false;
		}
		xmlhttp.send(null);
	}

	else if(vari == 'show_menu')
	{
		var variabel;

		xmlhttp.open('get', 'ajax.php?ajax=show_menu&'+variabel, true);
		xmlhttp.onreadystatechange = function()
		{
			if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
			{
				document.getElementById('hidden_ajax').innerHTML = xmlhttp.responseText;
				document.getElementById('v_show_menu').style.display = '';
				document.getElementById('show_menu').innerHTML = "<span onclick=\"CallAjax('hide_menu')\" style=\"cursor: pointer;\" title='Hide Menu'><img src=\"images/elbow-plus.gif\" ></span>";
				document.getElementById('show_image_ajax').style.display = 'none';
			}
			return false;
		}
		xmlhttp.send(null);
	}
}

function change_onMouseOver (id)
{
	document.getElementById(id).style.background = '#d1e5ff';
}

function change_onMouseOut (id)
{
	if(id%2==0)
	{
		document.getElementById(id).style.background = '#f7f7f7';
	}
	else
	{
		document.getElementById(id).style.background = '#FFFFFF';
	}
}

function CheckAll(param, target)
{
	var field = document.getElementsByName(target);
	var chkall = document.getElementById(param);
	if (chkall.checked == true)
	{
		for (i = 0; i < field.length; i++)
		field[i].checked = true ;
	}else
	{
		for (i = 0; i < field.length; i++)
		field[i].checked = false ;
	}
}

function get_logout()
{
	var r = confirm("Anda yakin ingin Logout ?");
	if(r)
	{
		window.location = 'logout.php';
	}
}

function confirm_delete(url)
{
	var r = confirm("Anda yakin ingin menghapus ?");
	if(r)
	{
		window.location = url;
	}
}

function confirm_url(url)
{
	var r = confirm("Anda yakin ingin keluar ?");
	if(r)
	{
		window.location = url;
	}
}

function confirm_delete_folder(url,nilai)
{
	var r = confirm("Anda yakin ingin menghapus folder "+nilai+", \nsemua data di folder "+nilai+" akan ikut terhapus ?");
	if(r)
	{
		window.location = url;
	}
}

function confirm_reset(url)
{
	var r = confirm("Anda yakin ingin mengganti password ?");
	if(r)
	{
		window.location = url;
	}
}

function confirm_global_user(url)
{
	var r = confirm("Anda yakin ingin Global User ?");
	if(r)
	{
		window.location = url;
	}
}

function get_url(url)
{
	window.location = url;
}


function PopupCenter(pageURL, title,w,h)
{
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function targetBlank (url)
{
	blankWin = window.open(url,'_blank','menubar=yes,toolbar=yes,location=yes,directories=yes,fullscreen=no,titlebar=yes,hotkeys=yes,status=yes,scrollbars=yes,resizable=yes');
}


/** menu horizontal **/
<!--
var timeout         = 500;
var closetimer        = 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose;
// -->
/** menu horizontal **/

/** clock **/

function open_pop(nilai)
{
	//alert(nilai);
	$("#"+nilai).dialog('open');
}

function validasiEmail(email)
{
	var validEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; //regex untuk cek email
	if(validEmail.test(email))
	{
		return true;
	}
	return false;
}


function windowOpener(windowHeight, windowWidth, windowName, windowUri, name)
{
	var centerWidth = (window.screen.width - windowWidth) / 2;
	var centerHeight = (window.screen.height - windowHeight) / 2;
	//alert('aaaa');

	newWindow = window.open(windowUri, windowName, 'resizable=yes,scrollbars=yes,width=' + windowWidth +
		',height=' + windowHeight +
		',left=' + centerWidth +
		',top=' + centerHeight
	);

	newWindow.focus();
	return newWindow.name;
}

function updateClock ( )
{
	var currentTime = new Date ( );

	var currentHours = currentTime.getHours ( );
	var currentMinutes = currentTime.getMinutes ( );
	var currentSeconds = currentTime.getSeconds ( );

	// Pad the minutes and seconds with leading zeros, if required
	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

	// Choose either "AM" or "PM" as appropriate
	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

	// Convert the hours component to 12-hour format if needed
	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

	// Convert an hours component of "0" to "12"
	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

	// Compose the string for display
	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

	// Update the time display
	document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}


function ambil_nilai(nama_field)
{
	return(document.getElementById(nama_field).value);
}
function reform(val)
{
	var a = val.split(",");
	var b = a.join("");
	//alert(b);
	return b;
}

function format(harga)
{
	harga=parseFloat(harga);
	harga=harga.toFixed(0);
	//alert(harga);
	s = addSeparatorsNF(harga, '.', '.', ',');
	return s;
}

function format2(harga)
{
	harga=parseFloat(harga);
	harga=harga.toFixed(2);
	//alert(harga);
	s = addSeparatorsNF(harga, '.', '.', ',');
	return s;
}

function format4(harga)
{
	harga=parseFloat(harga);
	harga=harga.toFixed(4);
	//alert(harga);
	s = addSeparatorsNF(harga, '.', '.', ',');
	return s;
}

function format6(harga)
{
	harga=parseFloat(harga);
	harga=harga.toFixed(6);
	//alert(harga);
	s = addSeparatorsNF(harga, '.', '.', ',');
	return s;
}

function addSeparatorsNF(nStr, inD, outD, sep)
{
	nStr += '';
	var dpos = nStr.indexOf(inD);
	var nStrEnd = '';
	if (dpos != -1)
	{
		nStrEnd = outD + nStr.substring(dpos + 1, nStr.length);
		nStr = nStr.substring(0, dpos);
	}
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(nStr))
	{
		nStr = nStr.replace(rgx, '$1' + sep + '$2');
	}
	return nStr + nStrEnd;
}

function toFormat(id)
{
	//alert(document.getElementById(id).value);
	if ((!isFinite(reform(document.getElementById(id).value)))||(document.getElementById(id).value.length==0))
	{
		//alert("That's not a number.")
		document.getElementById(id).value=0;
		//document.getElementById(id).focus();
	}
	document.getElementById(id).value=reform(document.getElementById(id).value);
	document.getElementById(id).value=format(document.getElementById(id).value);
}

function toFormat2(id)
{
	//alert(document.getElementById(id).value);
	if ((!isFinite(reform(document.getElementById(id).value)))||(document.getElementById(id).value.length==0))
	{
		//alert("That's not a number.")
		document.getElementById(id).value=0;
		//document.getElementById(id).focus();
	}
	document.getElementById(id).value=reform(document.getElementById(id).value);
	document.getElementById(id).value=format2(document.getElementById(id).value);
}

function toFormat4(id)
{
	//alert(document.getElementById(id).value);
	if ((!isFinite(reform(document.getElementById(id).value)))||(document.getElementById(id).value.length==0))
	{
		//alert("That's not a number.")
		document.getElementById(id).value=0;
		//document.getElementById(id).focus();
	}
	document.getElementById(id).value=reform(document.getElementById(id).value);
	document.getElementById(id).value=format4(document.getElementById(id).value);
}
function toFormat6(id)
{
	//alert(document.getElementById(id).value);
	if ((!isFinite(reform(document.getElementById(id).value)))||(document.getElementById(id).value.length==0))
	{
		//alert("That's not a number.")
		document.getElementById(id).value=0;
		//document.getElementById(id).focus();
	}
	document.getElementById(id).value=reform(document.getElementById(id).value);
	document.getElementById(id).value=format6(document.getElementById(id).value);
}
function isanumber(id)
{
	if ((!isFinite(reform(document.getElementById(id).value)))||(document.getElementById(id).value.length==0))
	{
		document.getElementById(id).value=0;
	}
	else
	{
		document.getElementById(id).value=parseFloat(reform(document.getElementById(id).value));
	}
}

function mouseover(target)
{  
    if(target.bgColor!="#cafdb5"){        
        if (target.bgColor=='#ccccff')
            target.bgColor='#ccccff';
        else
            target.bgColor='#c1cdd8';
    }
}
    
function mouseout(target)
{
    if(target.bgColor!="#cafdb5"){ 
        if (target.bgColor=='#ccccff')
            target.bgColor='#ccccff';
        else
            target.bgColor='#FFFFFF';
    }    
}

function mouseclick(target, idobject, num)
{
                   
    //var pjg = document.getElementById(idobject + '_sum').innerHTML;            
    for(i=0;i<num;i++){
        if (document.getElementById(idobject+'_'+i) != undefined){
            document.getElementById(idobject+'_'+i).bgColor='#f5faff';
            if (target.id == idobject+'_'+i)
                target.bgColor='#ccccff';
        }
    }
}

function mouseclick1(target)
{
    //var pjg = document.getElementById(idobject + '_sum').innerHTML;  
    if(target.bgColor!="#cafdb5")
    {
        target.bgColor="#cafdb5";
    }
    else
    {
        target.bgColor="#FFFFFF";
    }
} 
