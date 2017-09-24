function httpGet(theUrl,NewID)
{
  $.post(theUrl,{ID: NewID}, 
         function(data) {
               SetDone(data,NewID);
  });
}
	
function ToggleLike(NewID){
	httpGet('core/doLike.call.php',NewID);
}

function SetDone(data, NewID){
	var ret = data;
		ret = "(function(){return " + ret + ";})()";
		ret = eval(ret);
		var msg = ret.msg;
		var newcnt = ret.likecnt;
		var NewID = ret.newid;

	if(msg != "0"){
		if (document.getElementById('b'+NewID).className == "Like0")
			{
				document.getElementById('b'+NewID).className = "Like1";
			}
			else{
				document.getElementById('b'+NewID).className = "Like0";
			}
			document.getElementById('l'+NewID).innerText = newcnt;
	}else{
		alert("Please login to put a like.");	
	}
}