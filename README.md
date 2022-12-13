# Redirect-Log-In-Application

This application allows users to log in to Website1 with Sever1, then get redirected to Website2 on Server2 and get automatically logged in (or registered).

# Instructions on how to setup and run this project:

Get the first application (the one with the authentication):
 
git clone -b master https://github.com/ch-daniel/Redirect-Log-In-Application.git
 

Rename the cloned folder. (You can name it as app1)


Get the second application:
 
git clone -b app1 https://github.com/ch-daniel/Redirect-Log-In-Application.git
 


Rename the cloned folder. (You can name it as app2)


Create two databases for localhost. I used XAMPP and PhpMyAdmin to do so.


Database names should be “app1” and “app2”


cd into the folders from two terminals

Run the following commands in directory “app1”

 
php artisan migrate:fresh
php artisan db:seed
php artisan serve
 

The seeder has created an admin user.
Email: 		admin@a.a
Password:  	admin

And a simple user:
Email: 		user@u.u
Password:  	password


In a separate terminal run the following commands in directory “app2”

 
php artisan migrate:fresh
php artisan serve --port=8080
 

It is important to run the server on port 8080 specifically.


Navigate to localhost:8000 to get started
