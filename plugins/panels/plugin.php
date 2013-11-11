<?php
/* panel plugin */
include("settings.php");



onEvent('bodyEnd','panel');
function panel(){
	global $theme,$panelWidth, $panelColor, $panelDim, $preloadedPanels;
	echo "<div id='panel' style='max-width:".$panelWidth."px;right:-".$panelWidth."px;background-color:".$panelColor.";'>
	<img id='panelArrow' src='themes/".$theme."/img/panels/arrow.png' onClick='javascript:hidePanel();'>
	<img id='panelLoader' src='themes/".$theme."/img/panels/loader.gif'/>
	<div id='panelContent'>
	</div>
	";
	
	foreach($preloadedPanels as $panel){
		if(file_exists("panels/".$panel)){
			echo "<div class='preloadedPanel' id='panel_".str_replace("%","_",urlencode(str_replace("/","_slash-",str_replace(".","_",$panel))))."'>";
			include("panels/".$panel);
			echo "</div>";
		}
	}
	echo"</div>";
	if($panelDim){
		echo "<style>
		#catchScroll{
			background:rgb(30,30,30);
			-ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=00)';
			filter: alpha(opacity=00);
			-moz-opacity: 0;
			-khtml-opacity: 0;
			opacity:0;
		}
		</style>";
	}
}
$passToJS["panelDim"] = "panelDim";
$passToJS['hidePanelOnClick'] = 'hidePanelOnClick';
$passToJS['panelGroupScrolling'] = 'panelGroupScrolling';
?>