# Uptime
Simple Uptime Monitor
* Version: 0.1
* Author: Stephen Phillips
* Author URI: https://www.stephenphillips.co.uk/
* Date Updated: 05/02/2024

Introduction
============
I wanted to make a quick script to monitor client websites, run via URL or crontab with the objectives to use a MySQL db, use PHP's own in built Curl functions, that checks for 500 HTTP error codes and will send an email if detected to admin account, and that also checks for content changes using returned content length, sending an email if it is different to the previous value also, with an antispam check so as not to spam emails too often or repeat send them.

Installation
============
1. Simply place the file 'uptime.php' into a folder where you want to run it from.
2. Upload and install the mysql DB file from ./db/uptime.sql.
3. Test with default data.
4. Example Crontab - */5	*	*	*	*	/usr/local/bin/php /home/public_html/uptime.php

Examples
============
URL example: https://yourwebsite.co.uk/uptime.php?recordId=1
Crontab: - */5	*	*	*	*	/usr/local/bin/php /home/public_html/uptime.php

Notes
=====
This script is my first effort at doing this, the current antispam checks out the box only allow an email to be sent once per a day to warn about errors and content change warnings, it could be easily adjusted to allow only once per an hour for example by changing the related database fields and checks in code to use a datetime format of Y-m-d h:i:s for example etc instead of just the date Y-m-d.

Version 0.1 - 05/02/2024
===========
Initial build of first version with basic features created and tested
