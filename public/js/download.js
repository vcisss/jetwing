$(document).ready(function(){
	StartClock();
});

function timer() {
	window.blur();
	$("#Layer1").attr("style","display:");
	url = $("#posturl").val();
	$.post(url,{theTime:$("#theTime").val()},
	function(data){
		window.focus();
		$("#Layer1").attr("style","display:none");
		//window.location= $("#baseurl").val() + "index.php/setup/download/";
	});
}

var clockID = 0;

function UpdateClock() {
   if(clockID) {
      clearTimeout(clockID);
      clockID  = 0;
   }

   var tDate = new Date();
   h=tDate.getHours();
   m=tDate.getMinutes();
   s=tDate.getSeconds();
   if(s<=9) s="0"+s;
   if(m<=9) m="0"+m;
   if(h<=9) h="0"+h;
   time =h+":"+m+":"+s;
   $("#theTime").val(time);
	if(parseFloat(h)%1==0&&m=="00"&&s=="00"){timer();};
	//if(parseFloat(m)%1==0&&s=="00"){timer();};
	clockID = setTimeout("UpdateClock()", 1000);
}
function StartClock() {
   clockID = setTimeout("UpdateClock()", 500);
}

function KillClock() {
   if(clockID) {
      clearTimeout(clockID);
      clockID  = 0;
   }
}
