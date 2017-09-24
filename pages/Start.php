<div id="Mcontainer">
    <script type="text/javascript">
        $(document).ready(function(){
            $(".spoilerButton").click(function (e) { 
                e.preventDefault()
                var foo=$(this).attr('href')
                $('#'+foo).slideToggle(1000); 
            });
        });
    </script>
    <center>        <a href="/Home"><?=$SiteName?></a>
                                        →
                    <a href="/Infos">Infos</a>
                                        →
                    <a href="/<?=$pagename?>">Getting Started</a></center>

    <div class="block block-story follow-size" id="block-story-inside">
				<div class="block-head">
					<h1 class="title story-title">Getting Started</h1>
				</div>
				<div class="block-body" style="background-position: -760px -115px;">
					<div class="block-content" style="background-position: 0px -115px;">
																		<div class="clear"></div>
						<!-- begin content --><div class="node format ">
			

   <style>
.spoiler {
    display:none;
}
.contentBoxFooter{position:relative;bottom:10px;}
</style>                     
                        
<ul class="tabs javascript-tabs" rel="classes" style="margin-left:0px !important;">
    
  



<div class="clear">&nbsp;</div>

<div class="tab-content" id="classes">
        <input type="button" href="a1" class="spoilerButton" value="Logging In"/> 

    
    <div id="a1" class="spoiler">
        <div class="tab-panel tab-show" id="Login">
        <h2>Logging In</h2>

        <div class="image image-left" style="width:228px"><img src="img/Story/loginfinal.jpg"></div>

        <p>To login to Shaiya, you will need to use your Aeria Games account. If you have not registered for a free account, you can do so at any time <a href="/Register">here</a>.</p>

        <p>The first time you login to the game, you will have to choose between the <b>Alliance of Light</b> (Humans &amp; Elves) or the <b>Union of Fury</b> (Vails &amp; Deatheaters).</p>
        </div>
    </div>
        <input type="button" href="a2" class="spoilerButton" value="Character Creation"/>

    <div id="a2" class="spoiler">

        <div class="tab-panel " id="Creation">
        <h2>Creating Your First Character</h2>

        <div class="image image-right" style="width:228px"><img src="img/Story/Character_Creation_SSTEst.jpg"></div>

        <p>When creating a character, you need to select a name, Race, Sex and Class for your character. You will also have to choose the difficulty setting for your gameplay experience. The modes are as follows:</p>

        <ul style="margin-left:5px !important;"><br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>

            <li class="list"><strong>Basic</strong>: Standard Character with Normal Experience Level Requirements. This mode can not use Ultimate Mode Items.</li>
            <br>
            <li class="list"><strong>Ultimate</strong>: Level requirements are the same as in Basic mode; however Stats and Skill bonuses are increased and players can use exclusive items and skills only available to Ultimate characters.<br>
            <br>
            <span class="textcolor"><font color="#ff0000" size="2"><b><strong>WARNING</strong> Characters who die in Ultimate mode will be deleted. This mode is only for those players looking for the Ultimate experience.</b></font></span></li>
        </ul>
        </div>
    </div>
        <input type="button" href="a3" class="spoilerButton" value="Quests"/>

    <div id="a3" class="spoiler">

        <div class="tab-panel" id="Quests">
        <h2>Quest Overview</h2>

        <div class="image"><img src="img/quest-UIfinal.jpg"></div>

        <ol style="margin-left:5px !important;">
            <li><strong>Map Icons - Available Quests</strong><br>
            All available quests are displayed on the mini-map as yellow orbs.</li>
            <li><strong>NPC Icons - Available Quests</strong><br>
            NPCs offering quests at these locations will have a glowing symbol over their head.</li>
            <li><strong>Interacting with NPCs</strong><br>
            Double-clicking on these NPCs will bring up the option to "trade" or "talk to" the NPC. Select "talk to" to learn about any available quests.</li>
            <li><strong>Accepting &amp; Rejecting Quests</strong><br>
            Selecting "talk to" will bring up the NPC quest window. Here you can listen to news and stories of the lands you're adventuring in, and also learn of opportunities to perform tasks for rewards and experience. If you want to take on a particular quest, click on the "Accept" button. If you do not want to accept an available quest, click on the "Cancel" button.</li>
            <li><strong>Quests Window</strong><br>
            After accepting a quest, you can review the description and quest completion requirements by pressing the "U" key; this will bring up the "Quests" interface. Here, all active quests will be listed in green text, and quests that have all requirements fulfilled will be listed in yellow text.</li>
            <li><strong>Map Icons - Completed Quests</strong><br>
            Once you have fulfilled all of a quest’s requirements, look for a blue orb on your mini-map. This will usually be the NPC who first gave you the quest; now the NPC awaits your return so he/she may reward you for your effort.</li>
        </ol>
        </div>
    </div>
        <input type="button" href="a4" class="spoilerButton" value="Movement"/>

        <div id="a4" class="spoiler">

        <div class="tab-panel" id="Movement">
        <h2>Character Movement &amp; Navigation</h2>

        <div class="image"><img src="img/Story/Running_SS4.jpg"></div>

        <p>Movement within the world of Shaiya is fairly straightforward. To move your character to a location, you have two options.</p>

        <p><strong>Option 1</strong>: Point and Click Navigation. Simply click on the location you wish your character to move to, and they will travel to that desired point. Hold down the right mouse button to look around the world; you can also do this while using the arrow keys on your keyboard.</p>

        <p><strong>Option 2</strong>: Shaiya also supports WASD Keyboard Movement. Pressing "W" will move your character forward; "S" will move them backward; "A" will turn your character to the left; "D" will turn your character to the right; "Q" will make your character strafe left; and "E" will make your character strafe to the right.</p>

        <p><strong>Notes:</strong></p>

        <ul style="margin-left:5px !important;">
            <li>Double-tapping "W" will make your character run forward until you stop them by pressing another key.</li>
            <li>Double-tapping "Q," "S," or "E" will make your character perform a leaping action.</li>
            <li>Pressing the space bar makes your character jump.</li>
            <li>If your character ever becomes stuck, or you want to be instantly transported to the nearest city, simply type "/return" in your chat window and press "Enter."</li>
        </ul>
                    </div>
    </div>
    <input type="button" href="a5" class="spoilerButton" value="Combat"/>

            <div id="a5" class="spoiler">

                    <div class="tab-panel" id="Combat">
                    <h2>Combat Overview</h2>

                    <div class="image image-left" style="width:251px"><img src="img/Story/Attackfinal.jpg"></div>

                    <p>When an enemy is on the screen you can attack them by placing your mouse cursor over them. When the cursor turns into a sword you can click on them once to target them.</p>

                    <p>You can now either cast a spell or use a skill to attack your enemy, or simply click on them again to perform your normal attack.</p>
                    </div>
            </div>
    <input type="button" href="a6" class="spoilerButton" value="Chat"/>

            <div id="a6" class="spoiler">

            <div class="tab-panel" id="Chat">
            <h2>Chat Overview</h2>

            <div class="image image-right" style="width:380px"><img src="img/Story/chatfinal.jpg"></div>

            <p>Pressing "Enter" at any time will activate the chat window in Shaiya. Here, you can type in any text and have it displayed in game so you can communicate with other players.</p>

            <p>If you do not wish to broadcast your chat publicly, there are other options for chatting. These can be accessed from the drop down menu to the left of the chat box.<br>
            &nbsp;</p>

            <ul style="margin-left:5px !important;">
                <li class="list"><strong>Normal</strong>: Regular chat that broadcasts to any players within listening distance.</li>
                <li class="list"><strong>Whisper</strong>: This is a direct chat to another player. You will have to enter the player’s character name and then the message you would like to send.</li>
                <li class="list"><strong>Party</strong>: This message will only be heard by members of your party.</li>
                <li class="list"><strong>Guild</strong>: This message will only be heard by members of your guild.</li>
                <li class="list"><strong>Transaction</strong>: This is used when you would like to broadcast messages concerning the buying, selling or trading of items.</li>
            </ul>

            <p>&nbsp;</p>
            </div>
                </div>
        <input type="button" href="a7" class="spoilerButton" value="AP"/>

            <div id="a7" class="spoiler">

            <div class="tab-panel" id="AP">
            <h2>Purchasing AP</h2>

            <div class="image"><img src="img/Story/ap-buyer-highlight_small.jpg"></div>

            <p>Shaiya supports the purchase of items that can help you progress more quickly--and more easily--through the game. However, in order to purchase these items, you'll need to have Aeria Points (AP).</p>

            <ol style="margin-left:5px !important;">
                <li><strong>Finding The Shop</strong><br>
                Players can purchase AP in-game by clicking the Shop button on their Function Bar. The Function Bar is located in the lower right hand corner of the Shaiya interface. The Shop button is the left-most button on this bar.</li>
                <li><strong>The Shop Window</strong><br>
                The Shop Window displays all items available for purchase from within Shaiya. Players can find additional items on the <a href="/Donate">Aeria Games Item Mall</a>.</li>
                <li><strong>Purchasing AP</strong><br>
                In order to purchase items, both in-game and through the <a href="/Store">Aeria Games Item Mall</a>, players will need to purchase Aeria Points (AP). Clicking the button in the Shop Window labeled "Buy Points" will open the Aeria Games site in a browser window, through which players can purchase AP.</li>
            </ol>

            <p>When players purchase Aeria Points for the first time, there will be a slight delay as we verify billing information. After several minutes, however, players should see their supply of Aeria Points displayed in the upper right hand corner of the shop window.</p>
            </div>
</div></div>

<div class="clear">&nbsp;</div>
	
		
</div>
<!-- end content -->					</div>
				</div>
				<div class="block-foot"></div>
			</div>


</div>