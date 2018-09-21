# SchedulingApp
UNA SE scheduling application
                                                                  
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

6.	App should now be accessible at: http://localhost/SchedulingApp/

-------------------------------------------------------------------------------
NOTE: login will not work without LDAP file. 

To test without the LDAP 
	  1. Open authenticate.php
    2. Go to line 58 - you may set a hardcoded user here
