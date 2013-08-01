<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the scroll texts.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		de.plugins-zum-selberbauen.scrollingText
 * @subpackage	system.cache
 * @category	Community Framework
 */
class CacheBuilderScrollText implements CacheBuilder {
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array('texts' => array());
		
		$sql = 'SELECT   text
		        FROM     wcf'.WCF_N.'_texts
		        ORDER BY created ASC';
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$data['texts'][] = $row['text'];
		}
		
		return $data;
	}
}
