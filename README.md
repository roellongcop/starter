# yii2 keen admin dashboard
1) create database "db_starter"
2) you may need to adjust the "app/config/db.php" for credentials
3) open cmd, goto root folder then run:

	```composer install or composer update``` - (install dependency)
	
	```yii migrate``` (create database structure and create fixed set of data)
	
	```yii serve``` (start server)

4) goto development server created: ```[http://host]/api/v1/user/available-users``` for available user
5) Additional Command (you may configure console.php in config, eg: baseUrl)

'urlManager' => [
    'scriptUrl' => 'http://localhost:8080/',
    'baseUrl' => '/',
    'enablePrettyUrl' => true,
]
        
	```yii fixture *``` Create fixed set of data, Overwrite migration fixed data)

	```php vendor/bin/codecept run``` (Running tests)

	```yii seed/init``` (Generate random data on [roles, users, ips], Overwrite migration fixed data)

	```yii seed Role 10``` (Generate Additional 10 roles)

	```yii seed Users 10``` (Generate Additional 10 users)

	```yii seed Ip 10``` (Generate Additional 10 ips)

	```yii queue/run``` (Running queue jobs, must set to cron job on live-production)

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
* Queuing System
* Fixture Setup | for testing

# Modules
* Dashboard
* Users
	* List
	* User Meta
* Files
	* List
	* My Files
	* Model Files
* System
	* Roles
	* Backups
	* Sessions
	* Logs
	* Visit Logs
	* Queues
* Settings
	* List
	* My Settings
	* General Setting
	* Ip
	* Themes
	* Notifications
