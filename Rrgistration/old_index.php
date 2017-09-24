?>

    
 
} catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
}

phpinfo();

exit();

































if (isset($_GET["mentor"])){
    $mentor = $_GET["mentor"];
}else{
    $mentor = "";
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- begin content --><html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr" xmlns:fb="http://www.facebook.com/2008/fbml" >

<!-- Mirrored from www.aeriagames.com/playnow/syfr/darkfirev2 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Aug 2016 09:35:17 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
  <meta name="description" content="Shaiya vous invite à télécharger gratuitement, Shaiya, combat de l\&#039;Alliance de la lumière et de l\&#039;union de la fureur. Shaiya - Le jeu de rôle massivement multi joueur en ligne en francais!"/>  <meta name="keywords" content="Shaiya, Shaya, Shaia, Shaja, Shaiya.de, Shaiya.fr, download MMORPG, download MMOG, jeu en ligne gratuit, Free 2 Play, Free to Play, MMO fantaisie, jeu de role, aeriagames.com, aeriagames.eu. aeriagames.fr"/>  <link type="image/x-icon" rel="shortcut icon" href="http://de.shaiya.aeriagames.com/themes/shaiya_de/favicon.ico" /> 
  <title>Shaiya Europe - Free MMORPG</title><style type="text/css">
</style>




<style type="text/css">

#loginSubmit a, #loginSubmit a:hover {
    font: bold 15px/80px Arial !important;
}
html, body, #page, #container{
	background-color: 		#000;
	height:				1000px;	
}

#back{
	position: absolute;
	top: 2px;
	right: -200px;
	color: #999;
}
#gray{
	color:#999;
}
#video{
	left:		140px;
	top:		160px;
}

#registration{
	left:		610px;
	top:		140px;
	color:		#999;
	text-shadow:	none;
}

#registration a{
	color:		#ccc;
}

#registration label{
	color:		#999;
	text-shadow:	none;	
}

#registration legend{
	color:		#fff;
	text-shadow:	none;	
}

#registration button{
	color:		#FFF;
	text-shadow:	none;
	font-size: 15px;
}

.silo{
	font:		normal 13px/15px Arial;
	color:		#fff;
	text-align:	left;
	text-shadow:	none;
	width:		190px;
}

#silo1{
	left:		7px;
	top:		772px;
}

#silo2{
	left:		246px;
	top:		772px;
}

#silo3{
	left:		487px;
	top:		772px;
}

#silo4{
	left:	728px;
	top:	772px;
}
/* footer */
A:visited {
color: #ffffff;
text-decoration: none}
A:link {
color: #ffffff;
text-decoration: none}</style>
</head>
<body class="lang_fr" style="top:-10px;">
<style type="text/css" media="all">
a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,canvas,caption,center,cite,code,dd,del,details,dfn,dialog,div,dl,dt,em,embed,fieldset,figcaption,figure,font,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,hr,html,i,iframe,img,ins,kbd,label,legend,li,mark,menu,meter,nav,object,ol,output,p,pre,progress,q,rp,rt,ruby,s,samp,section,small,span,strike,strong,sub,summary,sup,table,tbody,td,tfoot,th,thead,time,tr,tt,u,ul,var,video,xmp{border:0;font-size:100%;margin:0;list-style-type:none;padding:0}html,body{height:100%}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}b,strong{font-weight:bold}img{font-size:0;vertical-align:middle;-ms-interpolation-mode:bicubic}li{display:list-item}table{border-collapse:collapse;border-spacing:0}th,td,caption{font-weight:normal;vertical-align:top;text-align:left}svg{overflow:hidden}

html,body,html > body,#page,#container{position:relative;z-index:0;}
#container{width:960px;margin:0 auto;}

#video,#registration,#silo1,#silo2,#silo3,#silo4{position:absolute;z-index:10;}
#video{width:400px;height:255px;}
#video.medium{width:520px;height:323px;}
#video.large{width:640px;height:390px;}

#registration{width:280px;height:400px;}


#registration a{color:#FFF;}

#registration legend{color:#FFF;text-shadow:none;}

#registration button{color:#FFF;text-shadow:none;}

.kill{position:absolute;top:-9999px;width:1px;height:1px;overflow:hidden;}

#overlay{background:#FFF;position:fixed;z-index:999999;top:0;left:0;bottom:0;width:100%;height:100%;}

html, body, #page, #container{background-image:url(img/20111021_SY_FR_darkfire_background.jpg);background-repeat:no-repeat;background-position:center top;}



#form3
{
	margin-left:32px;
	//color: rgb(255, 255, 255);
}

#username{  
    border: none;
	background-color : rgba(0,0,0,0); 
  -webkit-appearance: none;
    position: absolute;
    bottom: 354px;
    z-index: 2;
	width: 217px;
	height: 22px;
}

#email{  
    border: none;
	background-color : rgba(0,0,0,0); 
  -webkit-appearance: none;
    position: absolute;
    bottom: 314px;
    z-index: 2;
	width: 217px;
	height: 22px;
}

#pass{  
    border: none;
	background-color : rgba(0,0,0,0); 
  -webkit-appearance: none;
    position: absolute;
    bottom: 274px;
    z-index: 2;
	width: 217px;
	height: 22px;
}

#date1{  
    border: none;
	background-color : rgba(0,0,0,0); 
  -webkit-appearance: none;
    position: absolute;
    bottom: 200px;
    z-index: 2;
	width: 217px;
	height: 22px;
}
#mTitle, #mTitleBirth {
    position: absolute;
    height: 30px;
    display: block;
    overflow: hidden;
    font: normal bold 18px/36px Arial;
    text-shadow: 0 2px 10px #000;
}
#mTitle{
	position: absolute;
    bottom: 379px;
    z-index: 2;
}
#mTitleBirth{
	position: absolute;
    bottom: 230px;
    z-index: 2;
}
#tos {
    position: absolute;
	right: 30px;
    bottom: 80px;
    z-index: 2;
}
.form-item {
    display: block;
    height: 30px;
    width: 220px;
}

#dobday {  
	left: -8px;
	position: absolute;
	right: 0px;
    bottom: -172px;
    z-index: 2;	
	height: 40px;
	width: 85px;
}

#dobmonth {  
	left: 33px;
	position: absolute;
	right: 0px;
    bottom: -172px;
    z-index: 2;	
	height: 40px;
	width: 75px;
}

#dobyear {  
	left: 63px;
	position: absolute;
	right: 0px;
    bottom: -172px;
    z-index: 2;
	height: 40px;
	width: 98px;
}

#submit {
	left: 29px;
   	border: none;
	background-color : rgba(0,0,0,0); 
	background : url(img/b1.jpg);
	-webkit-appearance: none;
	border: none; 
    position: absolute;
    bottom: 120px;
    z-index: 2;
	width: 220px;
	height: 60px;
	font: 20px Arial;
	color: #fff;
	}
	
#submit:hover {
	left: 29px;
   	border: none;
	background-color : rgba(0,0,0,0); 
	background : url(img/b2.jpg);
	-webkit-appearance: none;
	border: none; 
    position: absolute;
    bottom: 120px;
    z-index: 2;
	width: 220px;
	height: 60px;
	font: 20px Arial;
		color: #fff;
	}
input, textarea {
	border: 0;
	background: transparent;
	text-color: black;
}
#form-no {
    font: normal 11px/12px Arial;
}

/*FOOTER*/

#footer{
    background:url("img/LP_footer_pattern.png");
    background-position:center top;
    background-repeat:repeat-x;
    height: 200px;
    background-color: #000000;
    display: block;
    margin: auto;
    overflow: visible;
    position: relative;
    text-align: center;
    width:100%;
    line-height: 5px;
}

#footerlink a {
    text-decoration:none;
}

#footerlink {
    color: #cccccc;
    font-family: arial,tahoma,sans serif,sans;
    font-size: 12px;
    font-weight: normal;
    padding: 0 12px;
    line-height: 16px;
}

#legal {
    color: #666666;
    font-family: arial,tahoma,sans serif,sans;
    font-size: 10px;
}

#playfree {
    color: #FFFFFF;
    font-family: arial,tahoma,sans serif,sans;
    font-size: 14px;
    line-height: 21px;
}

/*FOOTER END*/

</style>
<link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/mootools-1.3.1-yui-compressed.js"></script>
<script type="text/javascript">
var video;
var reg;

window.addEvent("domready", function(){

	video = $('video');
	video.settings = {
		"url": 			"http://www.youtube.com/watch?v=GnTG9lhZNHM",
		"autoplay":			"true"
	};

	

});

window.addEvent('load', function(){
	var overlay = $('overlay');
	overlay.delay = 500;
	overlay.fx = new Fx.Tween('overlay', {property:'opacity', duration:overlay.delay, link:'cancel'}).start(0);


	var injectVideo = function (){
		// Parse then Build Correct Video URL
		video.settings.id = video.settings.url.split('?v=')[1].split('&')[0];
		if(video.settings.autoplay.toLowerCase() === "true")
			video.settings.autoplay = 'autoplay=1';
		else
			video.settings.autoplay = '';
		
		// Inject Video
		video.innerHTML = '<iframe title="YouTube video player" width="100%" height="100%" src="http://www.youtube.com/embed/' + video.settings.id + '?' + video.settings.autoplay + '&rel=0&iv_load_policy=3&showinfo=0" frameborder="0" allowfullscreen></iframe>';	
		
		overlay.setStyle('display', 'none');
	}.delay(overlay.delay);



});
</script>



<div id="overlay"></div>
<div id="page">
	<div id="container">
                <a href="#" id="extra-button-01"></a>
                <a href="http://miguelzuleta.com/" id="extra-button-02"></a>
                <div id="extra-block-01"></div>
                <div id="extra-block-02"></div>
		<div id="video" class="small"></div>
		<div id="registration">
            <form id="form3" action="registration/" method="post">
                <input type="text" style="display:none;" name="mentor" value="<?php 
                                                                              if($mentor != ""){
                                                                                  echo($mentor);
                                                                              }
                                                                            ?>">
                </input>
                    <label id="mTitle">One-Step Registration</label><br>
                      <input type="text" name="username" placeholder="Username" id="username" />
                      <input type="email" name="email" placeholder="E-mail adress" id="email" />
                      <input type="password" name="pass" placeholder="Password" id="pass" />
                    <label id="mTitleBirth">Date of Birth</label><br>
                      <div class="row">
                        <div class="col-xs-2">
                        <select name="day" id="dobday" class="form-control input-lg"><option value=""></option></select>
                        </div>
                        <div class="col-xs-2">
                        <select name="month" id="dobmonth" class="form-control input-lg"><option value=""></option></select>
                        </div>
                        <div class="col-xs-2">
                        <select name="year" id="dobyear" class="form-control input-lg"><option value=""></option></select>
                        </div>
                      </div>

                   <strong> <h3><input id="submit" type="submit" name="send" value="PLAY FREE" /></h3></strong>


				
		  </form>
		   <div id="tos">
			<div class="form-item">
				<span id="form-no">By clicking this button, I accept the <a href="/policy/terms" target="_blank">Terms of Service</a> 
										   and confirm that I have read the <a href="/policy/privacy" target="_blank">Privacy Policy</a>.
				</span>
			</div>	
		   </div>

		</div>
		<ul id="silos">
			<li id="silo1" class="silo"><br/><br/><br/>Take on Teos' foes as one of twelve unique classes and four races. Level up and amass power at your own pace. Meet your foes on the battlefield, and bring your friends to join the war effort! Compete in unique Battlegrounds with set objectives, or fight to the bitter end for glory and honor in the Arena.</li>
			<li id="silo2" class="silo"><br/><br/><br/> Dungeons hidden all over the world pit those who’d enter them against the most vicious creatures and villains in Teos. Do you have what it takes to triumph and claim the ancestral relics they possess?</li>
			<li id="silo3" class="silo"><br/><br/><br/>Explore the world of Teos, a place of never-ending adventure and action. Experience epic stories and quests. Face deadly dragons, find mythical artifacts, or just visit a nice, quiet corner of the world to do some fishing.</li>
			<li id="silo4" class="silo"><br/><br/><br/>Pledge allegiance to one of two warring factions, the Alliance or the Union. Join or create a hand-picked group or guild of adventurers like yourself.</li>
		</ul>
		<div id="back"><p><small><a href="http://shaiya-legacy.lyrosgames.com/" style="color: #999;" >> Acces to the Website directly</div></a></small></p></div>
	</div>
</div>

<div id="footer">
         <div id="footerlink">
         <a rel="footerlink" href="http://www.lyrosgames.com/" target="_blank"><img src="img/logo.png"/></a>
         </div>
                <div id="legal">
                <br/>©2016 Lyros Games Europe GmbH<br>
                <br>
                </div>
</div><!-- end content -->
<!-- End Google Tag Manager -->
<!-- end content -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/dobPicker.min.js"></script>
<script>
jQuery(document).ready(function(){
  jQuery.dobPicker({
    daySelector: '#dobday', /* Required */
    monthSelector: '#dobmonth', /* Required */
    yearSelector: '#dobyear', /* Required */
    dayDefault: 'Day', /* Optional */
    monthDefault: 'Month', /* Optional */
    yearDefault: 'Year', /* Optional */
    minimumAge: 8, /* Optional */
    maximumAge: 100 /* Optional */
  });
});
</script>
</body>

<!-- Mirrored from www.aeriagames.com/playnow/syfr/darkfirev2 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Aug 2016 09:35:23 GMT -->
</html>
