# LaravelAppLication
Appplications build with laravel framework

The app gets all request from /notification base directory and checks if there is a get parameter in te request it extracts the value of te get parameter and uses it to delete a notification with primary key which is the parameter value.

It not from the root directory because the root directory takes you to a log in page so to escape from loging we use the /notification as base directory for any other request.
this page will be updated.

Setup:
create a mysql database with the following:

databaseName as TestApp
databaseUser as harisu
databasePassword as fe14a094

then run the php arisan make:migrate command to migrate the database tables
currently the database created will be empty so manually populate it to test 
Still writing the seedings 
