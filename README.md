# Secure Application Development Project
___
This is a project to develop a login system for the Secure Applications Development module in the 4th year Software Development course at ITCarlow

## Project Structure
* All pages are stored at the root 🌳
* The root PHP logic for each page is stored in the *_page* folder
* Helper functions are stored in the *helpers* folder
* Files stored within the *static* folder each contains the following
    * components - reusable elements with pages
    * css - css associate with each page
        * main.css is used commonly across each page
        * every additional css file is unique to a page
    * img - images used within the project
    * js - Javascript functions used within pages

## Requirements
* XAMPP or equivalent PHP and SQL environment

## Usage
* Once the folder structure is successfully setup, visiting the login.php page first is essential as it will create the database required. \
* Additionally if the database is using none-xampp default database credentials, the database file in helpers/db.php must be updated. \
* A default username of "Admin" with the password "Password1!" is created within the system. \
* All test cases require the `requests` library from [PyPi](https://pypi.org/project/requests/) \
This can be installed by running \
`pip install requests` \
or by using the included requirements file \
`pip install -r requirements.txt`

## Authors

Liliana O'Sullivan - *Developer*
Richard Butler - *Lecturer*
