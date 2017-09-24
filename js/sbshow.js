function ShowSB() {
	if(document.getElementById("Shoutbox").style.right == "0px"){
		document.getElementById("Shoutbox").style.right = "-248px";	
		document.getElementById("ShoutboxMain").style.marginLeft = "0px";
		
	}else{
		document.getElementById("Shoutbox").style.right = "0px";
		document.getElementById("ShoutboxMain").style.marginLeft = "-244px";
	}			 
}
function ShowTS() {
	if(document.getElementById("Ts3").style.left == "0px"){
		document.getElementById("Ts3").style.left = "-248px";		
	}else{
		document.getElementById("Ts3").style.left = "0px";
	}			 
}