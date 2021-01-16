# yii2 keendashboard demo1
1) create database "db_starter"
2) you may need to adjust the "app/config/db.php" for credentials
3) open cmd, goto "app" folder then run:

	composer install or composer update
	
	yii migrate
	
	yii seed

4) visit site @ http://localhost/yii2-keen-demo1/
5) goto http://localhost/yii2-keen-demo1/api/available-users for active users.

============================================================================
IMPORTANT NOTES:
when renaming the app, make sure to also change the "app\config\console.php"

	'urlManager' => [
        'baseUrl' => '/starter/web'
    ]
for the "yii seed/roles 10" to properly generate navigations

# features
1) Base on keenadmin dashboard demo1 v2
2) Provide token base image rendering
3) organize custom gii for template
4) dynamic roles implementation
5) search everything from dashboard
6) dynamic columns filtering
7) export capabilities (pdf, csv, xls, xlxs, browser print)
8) bulk action implementation
9) on click activation of records on gridview
10) backup and restore application
11) ip white list and black list support
12) User Blocking system
13) User Session with autologout
14) Logs support

# Modules
1) Dashboard
2) Backup
3) File
4) General Setting
5) Ip
6) Log
7) Role
8) Setting
9) User
10) User columns
11) Visit log
11) Session
