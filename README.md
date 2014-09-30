PHP Wake-on-LAN 
=======

Wake-on-LAN (WoL) is an Ethernet computer networking standard that allows a computer to be turned on or awakened by a network message. 

## Usage
Example PHP usage:
```php
/** Send WOL package
 * @param   string		$addr		- IP address
 * @param   string		$mac		- Media access control address (MAC)
 * @param   integer		$port		- Port number at which the data will be sent 
 * @return	boolean
 *
 * boolean send ( string $addr , string $mac [, integer $port = 9 ] )
 */
 
PHP_WOL::send('192.168.1.2', '01:23:45:67:89:ab', 9);
```

### Configure BIOS
Wake On LAN is usually disabled by default in most PCs, enable it in your BIOS.

### Configure router in order to work over internet
- Setup port forwarding eg. 192.168.1.255 (usualy port 9 or 7), protocol UDP.

### Linux
Install and configure earthquake package.
```sh
sudo aptitude install etherwake
```
