<?php 

/* 1. DEBUG MODE (0 = off | 1 = on) */
$isdbg = 0;					 //	(bit) Use of debug mode		     - default: False (0)

/* 2. SITE NAME */
$SiteName = "Shaiya Europe"; //	(string) Website Title			 - default: Shaiya Europe

/* 3. SQL SERVER ADMIN ACCOUNT */
$sqlUser = 'sa';		     //	(string) User Name               - default: Shaiya
$sqlPass = '5eWA5rAH6zUcRus#?dat';	     //	(string) Password                - default: Shaiya123
$database = 'PS_GameDefs';   // (string) Default Database Name   - default: PS_UserData
$databasee = 'PS_GameDefs';  // (string) Unactived, pls ingnore  - default: PS_GameDefs
$sqlHost = '151.80.177.114';      // (string) Default Database IP     - default: 127.0.0.1

/* 4. SLIDER CONFIG */       // (array) Slider content           - default: $SlidesArray[0] = '<div style="position:relative;"><div class="rimg" style="position:absolute;z-index:1"><img src="img/annonces-img/2.jpg"></div><div id="slid-position"><center><font color="white" style="top:200px;">Shaiya Europe is almost here..... <br></font></center></div></div>';

$SlidesArray[0] = '<div id="theiframe" style="position:relative;">
								    <div class="rimg" style="position:absolute;z-index:1">
                                        
									<iframe id="playeryt" width="670" height="240" src="https://www.youtube.com/embed/Eyfc5mkC3n0?version=3&enablejsapi=1" frameborder="0" allowfullscreen></iframe> 
								</div>
								<div id="slid-position">
									<center>
										<font onclick="pomme();" color="white" style="text-align:right;left:1px;">
													<center>More information </center>
													<br> about Shaiya Europe: <a href="Infos">Here!</a>
										</font>
									</center>
								</div>
							</div>';
$SlidesArray[1] = '<div style="position:relative;">
								<div class="rimg" style="position:absolute;z-index:1">
									<img src="img/annonces-img/2.jpg">    
								</div>
								<div id="slid-position">
									<center>
										<font color="white" style="top:200px;">
											Shaiya Europe is almost here..... <br>
										</font>
									</center>
								</div>
							</div>';

/* 5. Index Container Blacklist (pages with custom or muliple containers) */ // (array) Non-Container pages    -default: array("Home" ,"ForumThread","ForumSection","Forum","Message","Shoutbox","GRBRank","PvPRank","Features","Story","Start","Interface","Races","Classes","Modes","Blessing","Combat","ItemMall");

$container_blacklist  = array("Home" ,"ForumThread","ForumSection","Forum","Message","Shoutbox","GRBRank","PvPRank","Features","Story","Start","Interface","Races","Classes","Modes","Blessing","Combat","ItemMall");

/* 6. Date PHP */           

$date_region = 'Europe/Paris'; // (string) Time Zone Region        - default:   Europe/Paris

/* 7. FORUM CONFIG */

$FORUM_THREADSPERPAGE = 10;    // (int) Number of thread per page in forum - default: 10

/* 8. DEFAULT ADMIN ACCOUNT FOR PM AND OTHER */

define('DEFAULT_ADM',1);       // (int) Admin Account UserUID       - default: 1

/* 9.  NEW MESSAGE SEND TO EACH NEW PLAYER (string x2) - LEAVE EMPTY TO DISABLE*/


define('NEW_PLAYER_PM_TITLE',"Welcome <userid> on Shaiya Europe!");


define('NEW_PLAYER_PM_MESSAGE', 'Hello, and welcome on Shaiya Europe, you can find all the needed informations about the game, and about our server on our <a href="infos">informations</a> page. The game can be downloaded <a href="/Download">here</a>. Have fun in the Teos World!                             Regards, The Shaiya Europe Dev Team.');

/* 10. DROP FINDER V3 CONFIG */

                    /*-----------CHANGE BELLOW--------------*/
                    //leave $item_blacklist = ''; if you don't want to use it
$item_blacklist = '(98005,98006,98007,98009,98012,98018,98019,98020,98025,98022,98013,98010,98011,98001,98002,98014,98015,98026,98023,98024,98004,98008,98021,98017,98003,98016,38147,38149,38151,38150,38148,72037,87037,87017,87057,72017,72057,38170,38170,44032,44039,44033,44034,44035,44036,44037,44038,44040,44041,41164,44138,44141)';
                    /*--------------------------------------*/


/* 11. Vote System   */

$WaitHours = 12;            // (int) hours beteween each votes - defafult: 12
$PointsPerVote = 25;        // (int) Points given at each vote - default: 25



$vote_site["nr1"] = "http://www.xtremetop100.com/in.php?site=1132363163"; // (string) xtrem url
$vote_site["nr2"] = "http://www.oxigen-top100.com/in-456082.html"; // (string) oxygen url
$vote_site["nr3"] = "http://www.gamingtop100.net/in-16496"; // (string) oxygen url
$vote_site["nr4"] = "http://topofgames.com/index.php?do=votes&id=83638"; // (string) top of game url

/* 12. HTTPS (SSL) */

$UseSSL = 1;                // (bit) Force use of SSL ?       - default: 0 (False)
$DomainSSL = "www.shaiya.eu";// (string) SSL domain name       - default: www.shaiya.eu
$NonSSLip = array("193.70.122.73");

?>