Recipe Management System

-By Bijen Hirachan


Follow these steps to use this app.

1. Download the zip file.
2. Extract it.
3. Open it with editor of your choice.
4. Run the command below to install the dependencies. You must have composer installed in your system to run this command.
    composer install
5. Copy all the contents of ".env.example" file to a new ".env" file.
6. Set up your database in the .env file as shown below with valid credentials.
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=recipe-blog
    DB_USERNAME=root
    DB_PASSWORD=
7. Run this command to generate unique key for your app.
    php artisan key:generate
8. Now you can run the migrations to create the required tables in your database.
    php artisan migrate
9. Run this command to link your public folder to the storage folder to access the requires files.
    php artisan storage:link

You are all set to go.

Run this command to fire your laravel Recipe Management App and enjoy.
    php artisan run


I hope the UI is quite user friendly and intuitive. I tried my best to make it as responsive as possible.

Thank you and have fun.