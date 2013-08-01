<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractSecureAction.class.php');

/**
 * Inserts new items into the database.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		de.plugins-zum-selberbauen.scrollingText
 * @subpackage	action
 * @category	Community Framework
 */
class ScrollTextAction extends AbstractSecureAction {
	/**
	 * the response
	 * @var string
	 */
	protected $response = '';
	
	/**
	 * the value of the new item
	 * @var string
	 */
	protected $newItem = '';
	
	/**
	 * @see Action::execute()
	 */
	public function execute() {
		parent::execute();
		$this->saveToDatabase();
		$this->resetCache();
		$this->generateResponse();
		
		$this->executed();
		
		$this->sendResponse();
	}
	
	/**
	 * @see Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		if (isset($_POST['value'])) $this->newItem = StringUtil::trim($_POST['value']);
	}
	
	/**
	 * Saves the new item into database.
	 */
	protected function saveToDatabase() {
		if (empty($this->newItem)) {
			$this->throwException();
		}
		
		$sql = 'INSERT INTO wcf'.WCF_N.'_texts
		        (text, created)
		        VALUES
		        (:text, :time)';
		$sql = str_replace(':text', "'".escapeString($this->newItem)."'", $sql);
		$sql = str_replace(':time', TIME_NOW, $sql);
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Resets the cache.
	 */
	protected function resetCache() {
		$cache = 'scrollText';
		$cacheFile = WCF_DIR.'cache/cache.'.$cache.'.php';
		$cacheBuilderFileName = WCF_DIR.'lib/system/cache/CacheBuilderScrollText.class.php';
		WCF::getCache()->addResource($cache, $cacheFile, $cacheBuilderFileName);
		WCF::getCache()->clearResource($cache);
	}
	
	/**
	 * Generates the response.
	 */
	protected function generateResponse() {
		$this->response = StringUtil::encodeHTML($this->newItem);
	}
	
	/**
	 * Sends JSON-Encoded response.
	 */
	protected function sendResponse() {
		header('Content-type: application/json');
		echo JSON::encode($this->response);
		exit;
	}
	
	/**
	 * 'Throws' an exception.
	 * 
	 * Effectively a failure in the AJAX request is intended.
	 */
	protected function throwException() {
		$responseData = array(
			'code' => 412,
			'message' => 'Empty input'
		);
		
		$statusHeader = 'HTTP/1.0 431 Bad Parameters';
		
		header($statusHeader);
		header('Content-type: application/json');
		echo JSON::encode($responseData);
		exit;
	}
}
