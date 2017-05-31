# LaravelAppLication
Appplications build with laravel framework


Setup:
create a mysql database with the following:

databaseName as TestApp
databaseUser as harisu
databasePassword as fe14a094

then run the php arisan make:migrate command to migrate the database tables
currently the database created will be empty so manually populate it to test 
Still writing the seedings .

1. Signup and log into the app.
2. visit the /profile route to upload the profile photo with the ability to crop the image before submitting.

When you visit the profile picture and successfully upload and crop a photo, The application create stores the image in public/image directory
and also create another copy of this same message with dimension 50x50 and stores it in public/images/avater

The app gets all request from /notification base directory and checks if there is a get parameter in te request it extracts the value of te get parameter and uses it to delete a notification with primary key which is the parameter value.

It not from the root directory because the root directory takes you to a log in page so to escape from loging we use the /notification as base directory for any other request.
this page will be updated.

