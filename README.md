# yii2 keen admin dashboard
1) create database "db_starter"
2) you may need to adjust the "app/config/db.php" for credentials
3) open cmd, goto root folder then run:

	composer install or composer update
	
	yii migrate
	
	yii seed

	yii serve

4) goto [domain]/api/v1/user/available-users for active users.

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
