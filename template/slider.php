<!--img src="img/start.png" /-->
<script type="text/javascript" src="js/annonces-script.js"></script>
<style>
/* SLIDE */
.annonces-table
{position:relative;
}
.annonces-pagination
{width:75px;
float:left;
list-style:none;}
#annonces-slider
{	   
width: 620px;
height:340px;
position:relative;
float:left;
left:-86px;
}
#annonces-slider div
{position:relative;
width: 620px;
height:50px;
float:left;}
#annonces-slider li{	   
width: 620px;
height:340px;
float:left;
list-style:none;}
#annonces-slider font{
	background-color:rgba(0,0,0,0.7)
}
#slid-position  center font{
   position:absolute;
   top:30px;
   left:80px;   
   z-index:2;
   color:#cf9139;
   font-size:25px;
   font-family:MuseoSlab;
   display:block;
   font-variant:small-caps;
   text-align:left;
}
.rimg img, .rimg iframe, .rimg video{
	   padding:1px;
	   max-width: 577x;
	   max-height: 342px;
	   background-color:black;

}

</style>

<table class="annonces-table" border="0" cellspacing="0" cellpadding="0">
	<tbody><tr>
		<td id="annonces-pagination" class="annonces-pagination">
		
					<li class=""></li>
					<li class="annonces-title-hover"></li>
		</td>
				<td width="575" id="annonces-slider" class="annonces-slider" style="overflow: hidden;"> 
					<div style="left: -733px;"> 
                        <?
                        
                        foreach($SlidesArray as $Slide){
                            echo("<li>".$Slide."</li>");
                            
                        }
                        
                        ?>			
					</div> 
					
				</td>
			</tr> 
</tbody></table><br/><br/>
<script>
function pomme(){
    jQuery("iframe").each(function() {
  jQuery(this)[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*')
});
}
    setInterval(pomme,10000);
</script>
<script type="text/javascript">var slideshow=new TINY.slider.slide('slideshow',{id:'annonces-slider',auto:10,resume:true,vertical:false,navid:'annonces-pagination',activeclass:'annonces-title-hover',position:0});</script>
