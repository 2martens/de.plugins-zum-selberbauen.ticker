<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Manages the scrolling text.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1 GNU Lesser General Public License, version 2.1
 * @package		de.plugins-zum-selberbauen.scrollingText
 * @subpackage	system.event.listener
 * @category	Community Framework
 */
class ScrollTextListener implements EventListener {
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_SCROLLTEXT) return;
		
		// read saved texts
		$cacheName = 'scrollText';
		$cacheBuilderClassFile = WCF_DIR.'lib/system/cache/CacheBuilderScrollText.class.php';
		$cacheFile = WCF_DIR.'cache/cache.'.$cacheName.'.php';
		WCF::getCache()->addResource($cacheName, $cacheFile, $cacheBuilderClassFile);
		$texts = WCF::getCache()->get($cacheName, 'texts');
		
		WCF::getTPl()->assign('texts', $texts);
		$fetchedTemplate = WCF::getTPL()->fetch('scrollText');
		WCF::getTPL()->append('userMessages', $fetchedTemplate);
		
		WCF::getTPL()->append('specialStyles', '<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript"></script>'
			.'<script type="text/javascript">'
			.'//<![CDATA['
			.'    jQuery.noConflict();'
			.'//]]>'
			.'</script>'
			.'<link href="'.RELATIVE_WCF_DIR.'style/3rdParty/ticker-style.css" rel="stylesheet" type="text/css" />'
			.'<script src="'.RELATIVE_WCF_DIR.'js/3rdParty/jquery.ticker.js" type="text/javascript"></script>'
		);
	}
}
