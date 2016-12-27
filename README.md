# Task Tracker
### Introduction

I have programmed TaskTracker during a challenging time while I was at school. I was assigned to lead a project team of 7 people. I found that it took too long to evaluate progress at the end of the day and keep up with what needs to be done. To make my life simple, I asked everyone to start submitting an entry per week with a description on what they have accomplished daily.

Entries were created on Mondays and updated during the working week. I found that this was a great way to save time, and was an easier method to review progress during the evenings.

I have shared this on GitHub, because I would like others who may face similar challenges to use my solution. If you also wish to build up on this project, feel free to do so. 

### Requirements
  - Web server
  - MySQL Database

### Features
  - Users login system (no admin)
  - System labels every entry to the week it is created (week 1 to 52)
  - Entries are categorized under weeks (View all entires page)

### How to set up TaskTracker
Assuming you have met the requirments above, let begin.

### Step 1
  - Download the entire repository.
  - Upload everything to your web server except `structure.sql` & `README.md`
  - Open `structure.sql`, copy the SQL and [query it](https://www.youtube.com/watch?v=4c50g_RXPZo) to create two tables, entries and users. (usually using phpMyAdmin or MySQL work bench)

### Step 2
Once the following tables are created `entries` and `users`, you need to update `config.php`

  - Go to the config.php file located in `/resources/config.php` (open it)
  - Update the database credentials with your new login data.

### Step 3
Create your first user

  - Go back to your database client and find the users table. Add a new user, give it any name and username, but leave the password field blank.
  - Once you have done that, go to Task Tracker using your browser and sign in using your username. Do not write a password, click login to continue.
  - You will be asked to create a new password, after you do not need to do it again. 

Repeat **step 3** for every new user.

*Your done! Congratulations*

### Support
If you think I have missed out something while writing this readme file, or you have suggestions to add. I can be contacted via samih@nivano.nl. If you also find bugs, let me know!

### Author
Made by Samih Soylu.

### License
Open source