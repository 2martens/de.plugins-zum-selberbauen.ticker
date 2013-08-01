<ul id="js-news" class="js-hidden">
{foreach from=$texts item='text'}
    <li class="news-item">{$text}</li>
{/foreach}
</ul>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($) {
		$('#js-news').ticker({
			speed: 0.10,           // The speed of the reveal
	        ajaxFeed: false,       // Populate jQuery News Ticker via a feed
	        feedUrl: false,        // The URL of the feed
		                       // MUST BE ON THE SAME DOMAIN AS THE TICKER
	        feedType: 'xml',       // Currently only XML
	        htmlFeed: true,        // Populate jQuery News Ticker via HTML
	        debugMode: false,       // Show some helpful errors in the console or as alerts
	  	                       // SHOULD BE SET TO FALSE FOR PRODUCTION SITES!
	        controls: true,        // Whether or not to show the jQuery News Ticker controls
	        titleText: 'Latest',   // To remove the title set this to an empty String
	        displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
	        direction: 'ltr',       // Ticker direction - current options are 'ltr' or 'rtl'
	        pauseOnItems: 10000,    // The pause on a news item before being replaced
	        fadeInSpeed: 600,      // Speed of fade in animation
	        fadeOutSpeed: 300      // Speed of fade out animation
		});
	]);
//]]>
</script>