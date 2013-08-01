<div id="tickerDiv">
	<ul id="js-news" class="js-hidden">
	{foreach from=$texts item='text'}
	    <li class="news-item">{$text}</li>
	{/foreach}
	</ul>
</div>
{if $this->user->userID}
<form id="news-item-form">
	<div class="border content">
        <div class="container-1">
            <fieldset>
                <div class="formElement" id="newsItemDiv">
                    <div class="formFieldLabel">
                        <label for="newsItem">{lang}wcf.global.addNewsItem{/lang}</label>
                    </div>
                    <div class="formField">
                        <input type="text" class="inputText" id="newsItem" name="newsItem" value="" />                        
                        <p class="innerError">{lang}wcf.global.error.empty{/lang}</p>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="formSubmit" style="float: right;">
        <input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" tabindex="{counter name='tabindex'}" />
        {@SID_INPUT_TAG}
    </div>
</form>
{/if}
<script type="text/javascript">
//<![CDATA[
	var emptyError = '{lang}wcf.global.error.empty{/lang}';
	var texts = [{implode from=$texts item='text' glue=', '}'{$text}'{/implode}];
	jQuery(document).ready(function($) {
		{if $this->user->userID}
			$('#newsItemDiv .innerError').hide();
		    var lastRequest = null;
			$('#news-item-form').submit(function(event) {
				event.preventDefault();
				var $value = $('#newsItem').val();
				var options = {
					data: {
						value: $value 
					},
					dataType: 'json',
					jsonp: 'callback',
					async: true,
					failure: function(data, textStatus, jqXHR) {
						$('#newsItemDiv .innerError').show();
						$('#newsItemDiv').addClass('formError');
					},
					success: function(data, textStatus, jqXHR) {
						$('#tickerDiv').children().remove();
						texts[texts.length] = data;
						var $newHtml = '<ul id="js-news" class="js-hidden">';
						for (var i = 0; i < texts.length; i++) {
							$newHtml = $newHtml + '<li class="news-item">' + texts[i] + '</li>';
						}
						$newHtml = $newHtml + '</ul>';
						$('#tickerDiv').html($newHtml);
						$('#js-news').ticker({
							speed: 0.10,           // The speed of the reveal
					        ajaxFeed: false,       // Populate jQuery News Ticker via a feed
					        feedUrl: false,        // The URL of the feed
						                       // MUST BE ON THE SAME DOMAIN AS THE TICKER
					        feedType: 'xml',       // Currently only XML
					        htmlFeed: true,        // Populate jQuery News Ticker via HTML
					        debugMode: true,       // Show some helpful errors in the console or as alerts
					  	                       // SHOULD BE SET TO FALSE FOR PRODUCTION SITES!
					        controls: true,        // Whether or not to show the jQuery News Ticker controls
					        titleText: '',   // To remove the title set this to an empty String
					        displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
					        direction: 'ltr',       // Ticker direction - current options are 'ltr' or 'rtl'
					        pauseOnItems: {@GENERAL_SCROLLTEXT_SHOWTIME}000,    // The pause on a news item before being replaced
					        fadeInSpeed: 600,      // Speed of fade in animation
					        fadeOutSpeed: 300      // Speed of fade out animation
						});
						
						// reset error status
						$('#newsItemDiv .innerError').hide();
						$('#newsItemDiv').removeClass('formError');
						$('#newsItem').val('');
					},
					type: 'POST',
					url: 'index.php?action=ScrollText&t=' + SECURITY_TOKEN + SID_ARG_2ND
				};
				lastRequest = $.ajax({
					data: options.data,
					dataType: options.dataType,
					jsonp: options.jsonp,
					async: options.async,
					type: options.type,
					url: options.url,
					success: options.success,
					error: options.failure
				});
			});
		{/if}
		$('#js-news').ticker({
			speed: 0.10,           // The speed of the reveal
	        ajaxFeed: false,       // Populate jQuery News Ticker via a feed
	        feedUrl: false,        // The URL of the feed
		                       // MUST BE ON THE SAME DOMAIN AS THE TICKER
	        feedType: 'xml',       // Currently only XML
	        htmlFeed: true,        // Populate jQuery News Ticker via HTML
	        debugMode: true,       // Show some helpful errors in the console or as alerts
	  	                       // SHOULD BE SET TO FALSE FOR PRODUCTION SITES!
	        controls: true,        // Whether or not to show the jQuery News Ticker controls
	        titleText: '',   // To remove the title set this to an empty String
	        displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
	        direction: 'ltr',       // Ticker direction - current options are 'ltr' or 'rtl'
	        pauseOnItems: {@GENERAL_SCROLLTEXT_SHOWTIME}000,    // The pause on a news item before being replaced
	        fadeInSpeed: 600,      // Speed of fade in animation
	        fadeOutSpeed: 300      // Speed of fade out animation
		});
	});
//]]>
</script>