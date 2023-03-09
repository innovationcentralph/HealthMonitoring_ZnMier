You can use the source code and database structure to test the system locally. Note that your local data will not reflect in your actual online system.

To access your database remotely, go to 
https://webphpmyadmin.com/index.php?fbclid=IwAR2gfcvYy10Y3Rrwcx53wcHf6aABM7O8jc4SAsAQwiJwQtVZi9AlzF37jnM 

And paste the following information:
Server: 151.106.124.151
Username: u891337127_hmadmin
Password: B2c>|y3&s


Or follow instructions from 
https://www.freakyjolly.com/xampp-how-to-connect-a-remote-database-in-phpmyadmin/

And use the following credentials:
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'u891337127_hmadmin';
$cfg['Servers'][$i]['password'] = 'B2c>|y3&s';
$cfg['Servers'][$i]['host'] = '151.106.124.151';

