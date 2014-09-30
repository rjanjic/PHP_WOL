PHP_WOL
=======

Wake-on-LAN (WoL) is an Ethernet computer networking standard that allows a computer to be turned on or awakened by a network message. 

## Usage
Example PHP usage:
```php
PHP_WOL::send('192.168.1.2', '01:23:45:67:89:ab', 9);
```

### Configure BIOS
Wake On LAN is usually disabled by default in most PCs, enabled in your BIOS.

### Configure router in order to work over internet
- Setup port forwarding eg. 192.168.1.2 (usualy port 9 or 7).
- Setup port forwarding eg. 192.168.1.255 (usualy port 9 or 7).

### Linux
Install and configure earthquake package.
```sh
sudo aptitude install etherwake
```
