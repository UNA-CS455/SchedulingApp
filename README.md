# SchedulingApp
UNA SE scheduling application

   _____  _____       _  _   _____ _____             _____ ______ 
  / ____|/ ____|     | || | | ____| ____|           / ____|  ____|
 | |    | (___ ______| || |_| |__ | |__    ______  | (___ | |__   
 | |     \___ \______|__   _|___ \|___ \  |______|  \___ \|  __|  
 | |____ ____) |        | |  ___) |___) |           ____) | |____ 
  \_____|_____/         |_| |____/|____/           |_____/|______|
                                                                  
-------------------------------------------------------------------------------
Testing Setup

1.	Download schedulingApp.ZIP and extract

2.	Place in C:\xampp\htdocs

3.	Run xampp-control.exe

4.	Start MySQL and Apache in XAMPP

5.	Open SchedulingApp\scripts\DDL_DUMPS
      -Copy contents of file: cs455.sql
      -Open browser
        -Go to: https:/127.0.0.1/PHPmyadmin
        -Paste SQL from cs455.sql and run

6.	Repeat step 5 for cs55(blacklisting).sql

7.	App should now be accessible at: http://localhost/SchedulingApp/

-------------------------------------------------------------------------------
NOTE: login will not work without LDAP file. 

To test without the LDAP 
	  1. Open authenticate.php
    2. Go to line 58 - you may set a hardcoded user here
