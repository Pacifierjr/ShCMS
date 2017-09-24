<link type="text/css" rel="stylesheet" href="core/chat/style.css" />
<div id="chatbox" style="word-wrap: break-word;"></div>
<?

if($uid == 0){    
        echo '<center><span class="error">You must be logged in to post a message.</span></center>';
} else {
$query = $conn->prepare("SELECT UserID FROM PS_UserData.dbo.Users_Master WHERE UserUID= ?");
$query->bindValue(1, $uid, PDO::PARAM_INT);
$query->execute();    
$row = $query->fetch(PDO::FETCH_NUM);
$name = $row[0];


$query1 = $conn->prepare("SELECT Grade FROM PS_UserData.dbo.Users_Master WHERE UserUID= ?");
$query1->bindValue(1, $uid, PDO::PARAM_INT);
$query1->execute();
$row1 = $query1->fetch(PDO::FETCH_NUM);
?>
    <div class="normal">
        <input class="input" name="usermsg" type="text" id="usermsg" size="63"  style="margin-left:20px;width:195px;text-align:center;" placeholder="Type a text.." />
     
        <center><input type="submit" value="Submit" id="shoutbox_submit" style="width:100px;"><br/>
		<? if($row1[0] != NULL){ ?><a onclick='javascript:removeall("<? echo $row1; ?>");' style="font-size:10px;color:red;cursor:pointer;">Remove All Messages</a><? } ?></center>
    </div>
<? if($row1[0] != NULL){ ?>
<? } ?>
<script type="text/javascript">
function removeall(id){
          if (window.XMLHttpRequest) {
            xmlhttp=new XMLHttpRequest();
          } else {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            }
          }
          
          xmlhttp.open("GET","core/chat/remove-all.php?row="+id,true);
          xmlhttp.send();
}
</script><? } ?>
<script>
// jQuery Document
$(document).ready(function(){
	//If user submits the form
	$("#shoutbox_submit").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("core/chat/post.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		return false;
	});
	
	//Load the file containing the chat log
	function loadLog(){	

		$.ajax({
			url: "core/chat/log.php",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div				
		  	},
		});
	}
	
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").prop("scrollHeight") - 20; //Scroll height before the request
		$.ajax({
			url: "core/chat/log.php",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
				//Auto-scroll			
				var newscrollHeight = $("#chatbox").prop("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
	setInterval (loadLog, 1000);	//Reload file every 2500 ms or x ms if you w
});
</script>
