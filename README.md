# Redirect-Log-In-Application

This application allows users to log in to Website1 with Sever1, then get redirected to Website2 on Server2 and get automatically logged in (or registered).

It also includes such features as:
- non-admin users can log in or register in App1. They get redirected to App2. They have a coin balance on App2.
- admin dashboard (on App1) that allows you to change the coin amounts for all users that appear in the User table of App2.
- non-admin users can view the history of transactions on their profile page on App2.
- communication between servers is done with PHP requests signed by a secret API key.
- Daily bonus. Every day at midnight it is reset. Every time a user logs in or visits a page of the website2, it considers him for the daily bonus, based on when the last bonus was received.


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
