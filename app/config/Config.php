<?php

 //database params
 define('DB_HOST', 'localhost');
 define('DB_USER', 'root');
 define('DB_PASS', '');
 define('DBUSERS', 'MYSITE_USERS');

 //approot
 define('APPROOT', dirname(dirname(__FILE__)));
 define('UPLOADROOT', dirname(dirname(dirname(__FILE__))));
 define('OUTSIDEPROJ', dirname(dirname(dirname(dirname(__FILE__)))));

 define("ADMINAPPROOT", dirname(dirname(dirname(__FILE__))));
 //urlroot
 //dynamic links
 define('URLROOT', 'http://localhost/Projects/MySite');
 define('URLROOTADMINSIDE', 'http://localhost/Projects/MySiteAdminSide');

 //what to upload
 define('PROFILEPIC', 'PROFILE PIC');
 define('PROFILECOVER', 'PROFILE COVER');

 
 $_SESSION['PREVIOUSPAGE'] = '';

 //sitename
 define('SITENAME', 'MySite');

 