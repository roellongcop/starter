# yii2 keen admin dashboard
1) create database "db_starter"
2) you may need to adjust the "app/config/db.php" for credentials
3) open cmd, goto root folder:
	- To install dependency:
		
            composer install    
		
    - To create database structure and create fixed set of data:
	           
            yii migrate
	
    - To start server:
	        
            yii serve


4) goto development server created for available user: 
        
        [http://host]/api/v1/user/available-users
5) Additional Command
    - To create fixed set of data, Overwrite migration fixed data:
	        
	        yii fixture *
    - To run tests:
    
            php vendor/bin/codecept run
    - To generate random data on [roles, users, ips], Overwrite migration fixed data and fixture:
    
    	    yii seed/init
    - To generate Additional 10 roles:
	
	        yii seed Role 10
    - To generate Additional 10 users:
    
            yii seed Users 10
    - To generate Additional 10 ips:
            
            yii seed Ip 10
    - To run queue jobs, must set to cron job on live-production:
        
            yii queue/run

============================================================================

# Accounts
* Developer
	- developer@developer.com
	- developer@developer.com
* Superadmin
	- superadmin@superadmin.com
	- superadmin@superadmin.com
* Admin
	- admin@admin.com
	- admin@admin.com

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
* Image Gallery
* Photo Uploader (dropzone with Cropper)
* Queuing System
* Fixture Setup | for testing
* Database Seeding
* Notification
* Visitors | Cookie & Session

# Modules
* Dashboard
* Users
	* List
	* User Meta
* Files
	* List
	* My Files
* System
	* Roles
	* Backups
	* Sessions
	* Logs
	* Visit Logs
	* Queues
* Settings
	* List
	* General Setting
	* Ip
	* Themes
* Notifications
* Visitors