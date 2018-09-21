
------To download most recent dump and import:
To use this sql dump, load xampp or whatever mariadb/sql environment you are running. 
Either copy all text from cs455.sql and paste it into the terminal where you are launching sql commands,
or if you are using xammp, simply navigate to http://localhost/phpmyadmin/ and find the "import" button 
where you can browse for cs455.sql and it will then run the commands in the file.

------To export your own database for changes:
If you make any changes to the database, use the export function on XAMPP to export a new cs455.sql file.
While exporting, go under "Export Method: " and choose the "Custom - display all possible options" radio button. 
Then, scroll down until you reach the "Object creation options" header. Here, click the check box 
"Add CREATE DATABASE / USE statement" on. Then scroll all the way down and click "Go". phpMyAdmin will 
automatically download the file. Create a new branch and upload it.

Godspeed.
