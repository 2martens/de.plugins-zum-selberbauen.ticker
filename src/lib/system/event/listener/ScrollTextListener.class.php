<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Manages the scrolling text.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
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
		WCF::getCache()->addResource($cache, $cacheFile, $cacheBuilderClassFile);
		$texts = WCF::getCache()->get($cache, 'texts');
		
		WCF::getTPl()->assign('texts', $texts);
		$fetchedTemplate = WCF::getTPL()->fetch('scrollText');
		WCF::getTPL()->append('userMessages', $fetchedTemplate);
	}
}
