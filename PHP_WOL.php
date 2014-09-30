<?php
/******************************************************************
 * 
 * Projectname:   PHP_WOL - PHP Wake On Lan
 * Version:       1.0
 * Author:        Radovan Janjic <hi@radovanjanjic.com>
 * Last modified: 29 09 2014
 * Copyright (C): 2014 IT-radionica.com, All Rights Reserved
 * 
 * GNU General Public License (Version 2, June 1991)
 *
 * This program is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 * 
 ******************************************************************/
/** Example:
 * PHP_WOL::send('192.168.1.2', '01:23:45:67:89:ab', 9);
 */

class PHP_WOL {
	
	/** Socket
	 * @var resource
	 */
	private static $socket = 0;
	
	/** Error code
	 * @var integer
	 */
	private static $errCode = 0;
	
	/** Error description
	 * @var string
	 */
	private static $errMsg = NULL;
	
	/** Send WOL package
	 * @param	string		$addr		- IP address
	 * @param	string		$mac		- Media access control address (MAC)
	 * @param	integer		$port		- Port number at which the data will be sent
	 * @return	boolean
	 */
	public static function send($addr, $mac, $port = 9) {
	
		// Throw exception if extension is not loaded
		if (!extension_loaded('sockets')) {
			PHP_WOL::throwError("Error: The sockets extension is not loaded!");
		}
		
		$macHex = str_replace(array(':', '-'), NULL, $mac);
		
		// Throw exception if mac address is not valid
        if (!ctype_xdigit($macHex)) {
            PHP_WOL::throwError('Error: Mac address is invalid!');
        }
		
		// Magic packet
		$packet = str_repeat(chr(0xff), 6) . str_repeat(pack('H12', $macHex), 16);
		
		// Send to the broadcast address using UDP
		PHP_WOL::$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		
		if (is_resource(PHP_WOL::$socket)) {
		
			// Set socket option
			if (!socket_set_option(PHP_WOL::$socket, 1, 6, TRUE)) {
				PHP_WOL::throwError();
			}
			
			// Send magic packet
			if (socket_sendto(PHP_WOL::$socket, $packet, strlen($packet), 0, $addr, $port) !== FALSE) {
				socket_close(PHP_WOL::$socket);
				return TRUE;
			}
		}
		PHP_WOL::throwError();
	}
	
	/** Throw Last Error
	 * @param	string		$msg	- Error message
	 * @return	void
	 */
	private static function throwError($msg = NULL) {
		// Take last error if err msg is empty
		if (empty($msg)) {
			PHP_WOL::$errCode = socket_last_error(PHP_WOL::$socket);
			PHP_WOL::$errMsg = socket_strerror(PHP_WOL::$errCode);
			$msg = "Error (" . PHP_WOL::$errCode . "): " . PHP_WOL::$errMsg;
		}
		throw new Exception($msg);
	}
}