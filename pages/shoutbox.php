<div id="Mcontainer">
   <center>    <div id="newsseparator"></div>
<br/><a href="Shoutbox"><h2>Shoutbox</h2></a><br/></center> 
    
    <!-- <center><span style="color:#922424;"> Boost Experience Activated! (during 48H) </span></center> <br> --->
    <style>
        #SBinput, .emoji-wysiwyg-editor {
     background-color:rgba(63, 191, 191, 0.44) !important;        
        }
    </style>
    <script>
        <? 
        if((int)$arg > 0){
        ?>
    function SetSBContent(){
        $.get( "core/showchat.call.php", function( data ) {
        $( ".result" ).html( data );
        });
    }
        <? }else{ 
        ?>
           function SetSBContent(){
        $.get( "core/showchat20.call.php", function( data ) {
        $( ".result" ).html( data );
        });
    } 
        <?
        } ?>
    SetSBContent();
    setInterval(SetSBContent, 1500);
    </script>
    <div class="result"></div>
    <br/>
    <?
    if($CurrentUser->IsLoggedIn()){
        ?>
     <form action="core/SendChat.call.php" method="POST">
        <center>
            <input name="message" id="SBinput" type="text" data-emojiable="true"/>
            <input type="submit"/>
        </center>
    </form>
    
    <?
    }else{
    ?>
        You must be logged in in order to post a message.
    <? } ?>
</div>
