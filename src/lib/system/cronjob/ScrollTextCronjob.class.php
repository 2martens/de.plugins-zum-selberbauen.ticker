<?php
//wcf imports
require_once(WCF_DIR.'lib/data/cronjobs/Cronjob.class.php');

/**
 * Resets the scrollText cache.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		de.plugins-zum-selberbauen.scrollingText
 * @subpackage	system.cronjob
 * @category	Community Framework
 */
class ScrollTextCronjob implements Cronjob {
	/**
	 * @see Cronjob::execute()
	 */
	public function execute($data) {
		if (!MODULE_SCROLLTEXT) return;
		
		$sql = 'DELETE FROM wcf'.WCF_N.'_texts
		        WHERE  created < ?';
		$timeNow = TIME_NOW;
		$oneDay = 86400;
		$latestAccepted = $timeNow - $oneDay;
		$sql = str_replace('?', $latestAccepted, $sql);
		WCF::getDB()->sendQuery($sql);
		
		$cache = 'scrollText';
		$cacheFile = WCF_DIR.'cache/cache.'.$cache.'.php';
		$cacheBuilderFileName = WCF_DIR.'lib/system/cache/CacheBuilderScrollText.class.php';
		WCF::getCache()->addResource($cache, $cacheFile, $cacheBuilderFileName);
		WCF::getCache()->clearResource($cache);
	}
}
