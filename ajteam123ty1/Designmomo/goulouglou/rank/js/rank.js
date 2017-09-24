$(document).ready(function(){
	$('.tooltip').each(function(){
		var CharID = $(this).attr('id').split('_')[1];
		$(this).qtip({
			content:{
				title:{
					text:$(this).text()
				},
				text:'<div class="ajaxLoaderContainer"><div class="ajaxLoader"></div></div>',
				ajax:{
					url:'characterTooltip.controller.php',
					type:'post',
					data:{CharID:CharID}
				}
			},
			show:{
				delay:100,
				event:'mouseenter',
				effect:function(){
					jQuery(this).stop(true,true).show();
				}
			},
			position:{
				viewport:jQuery(window),
				target:jQuery.browser.msie ? false : 'mouse',
				adjust:{
					x:8,
					y:8,
					mouse:true,
					screen:true
				},
				corner:{
					target:'bottomRight',
					tooltip:'topLeft'
				}
			},
			style:{
				tip:false,
				classes:'ui-tooltip-character-info'
			}
		}).show();
	});
});