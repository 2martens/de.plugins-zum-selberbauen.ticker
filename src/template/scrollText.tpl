<p id="scrollText" class="scrollText"></p>
<script type="text/javascript">
	//<![CDATA[
	document.observe("dom:loaded", function() {
		var texts = [{implode from=$texts item=text glue=', '}'{$text}'{/implode}];
		var maxTests = texts.length;
		var text = texts[0];
		var begin = 0;
		var end = text.length;
		var timePassed = 0;
		var i = 0;
		function scrollText() {
			if (timePassed == 60000) {
				i++;
				if (i == maxTests) {
					i = 0;
				}
				text = texts[i];
				begin = 0;
				end = text.length;
				timePassed = 0;
			}
			document.getElementById("scrollText").innerHTML = "" +
			text.substring(begin,end) + " " + text.substring(0,begin);
			begin++;
			if(begin >= end)
			{ 
				begin = 0; 
			}
			timePassed = 3000;
			window.setTimeout("scrollText()", 3000);
		}	
	});
	//]]>
</script>