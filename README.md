# yii2 keen admin dashboard
1) create database "db_starter"
2) you may need to adjust the "app/config/db.php" for credentials
3) open cmd, goto root folder then run:

	```composer install or composer update``` - (install dependency)
	
	```yii migrate``` (create database structure)

	```yii fixture *``` (create fixed set of data)
	
	```yii serve```

4) Additional Command

	```php vendor/bin/codecept run``` (Running tests: [must run fixture first])

	```yii seed``` (generate random data on [roles, users, ips])

	```yii seed Role 10``` (generate 10 roles)

	```yii seed Users 10``` (generate 10 users)
	
	```yii seed Ip 10``` (generate 10 ips)

============================================================================


# Features
* Base on keenadmin dashboard
* Provide token base image rendering
* Organize custom gii for template
* Dynamic roles implementation
* Search everything from dashboard
* Dynamic columns filtering
* Export capabilities (pdf, csv, xls, xlxs, browser print)
* Bulk action implementation
* On click activation of records on gridview
* Backup and restore application
* Ip white list and black list support
* User Blocking system
* User Session with autologout
* Logs support (database interaction, login logout)
* Dynamic Themes
* Rest API setup
* General Settings
* Photo Uploader (dropzone)
* Fixture Setup | for testing

# Modules
* Dashboard
* Backup
* File
* Ip
* Log
* Role
* Setting
* User
* User Meta (holding user additional attributes (eg: settings))
* Model File (holding uploaded files; connected with File module)
* Visit log
* Session
* Theme
