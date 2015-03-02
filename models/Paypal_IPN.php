<?php
/**
 * Paypal IPN Class (Testing Only)
 *
 * @author		JREAM
 * @link		http://jream.com
 * @copyright		2011 Jesse Boyer (contact@jream.com)
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/
 */
 
class Paypal_IPN
{
	/** @var string $_url The paypal url to go to through cURL
	private $_url;

	/**
	* @param string $mode 'live' or 'sandbox' 
	*/
	public function __construct($mode = 'live')
	{
		if ($mode == 'live')
		$this->_url = 'https://www.paypal.com/cgi-bin/webscr';
		
		else
		$this->_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}

	public function run()
	{
		$postFields = 'cmd=_notify-validate';
		
		foreach($_POST as $key => $value)
		{
			$postFields .= "&$key=".urlencode($value);
		}
	
		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_URL => $this->_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postFields
		));
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		$fh = fopen('result.txt', 'w');
		fwrite($fh, $result . ' -- ' . $postFields);
		fclose($fh);
		
		echo $result;
	}
}

?>