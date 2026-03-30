# Lost-and-found
Lost & Found Management System
📌 Introduction

The Lost & Found Management System is a web-based application designed to help users report lost items, post found items, and recover belongings efficiently. The system provides secure authentication with OTP-based password reset via email, ensuring user account security.

This project is built using PHP, MySQL, HTML, CSS, and PHPMailer.

🎯 Objectives
Provide a platform to report lost items
Allow users to post found items
Enable secure user authentication
Implement OTP-based password recovery
Improve item recovery efficiency
⚙️ Technologies Used
Frontend: HTML, CSS
Backend: PHP
Database: MySQL
Email Service: PHPMailer (Gmail SMTP)
Server: XAMPP (Apache + MySQL)
🔐 Authentication Features
User Registration
User Login
Password Hashing (Secure login)
Forgot Password
Email OTP Verification
Reset Password
Auto Redirect after Reset
✨ Features
👤 User Features
Register new account
Login securely
Report lost items
Report found items
Reset password using OTP
Dashboard for user activities
🔒 Security Features
Password hashing using password_hash()
Password verification using password_verify()
OTP-based password reset
OTP expiry (5 minutes)
Email validation
Session management
🔄 How It Works
User Registration
User creates account
Details stored in database
Password stored securely (hashed)
User Login
User enters email and password
System verifies credentials
Redirect to dashboard
Forgot Password Flow
User clicks Forgot Password
User enters registered email
System sends OTP to email
User enters OTP
Installation / Setup
Step 1

Install XAMPP

Step 2

Move project folder to:

xampp/htdocs/
Step 3

Start XAMPP

Apache
MySQL
Step 4

Create Database

Create database in phpMyAdmin

Example:

lost_found

Import SQL file if available.

Step 5

Configure Database

Edit:

config/db.php

Add your database credentials.

Step 6

Run Project

Open browser:

http://localhost/lost_found
📧 Email OTP Setup

This project uses Gmail SMTP via PHPMailer.

Steps:

Enable Google 2-Step Verification
Generate App Password
Add credentials in send_otp.php
📌 Future Improvements
OTP verified
User resets password
Redirect to login page
