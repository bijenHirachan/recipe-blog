Recipe Management System

-By Bijen Hirachan


Follow these steps to use this app.

1. Download the zip file.
2. Extract it.
3. Open it with editor of your choice.
4. Run the command below to install the dependencies. You must have composer installed in your system to run this command.<br>
    	<strong>composer install</strong>
5. Copy all the contents of <tab>".env.example"</tab> file to a new <tab>".env"</tab> file.
6. Set up your database in the .env file as shown below with valid credentials.<br>
		DB_CONNECTION=mysql<br>
		DB_HOST=127.0.0.1<br>
		DB_PORT=3306<br>
		DB_DATABASE=recipe-blog<br>
		DB_USERNAME=root<br>
		DB_PASSWORD=<br>
7. Run this command to generate unique key for your app.<br>
    	php artisan key:generate
8. Now you can run the migrations to create the required tables in your database.<br>
   		php artisan migrate
9. Run this command to link your public folder to the storage folder to access the requires files.<br>
    	php artisan storage:link

You are all set to go.

Run this command to fire your laravel Recipe Management App and enjoy.<br>
    	php artisan run


I hope the UI is quite user friendly and intuitive. I tried my best to make it as responsive as possible.

Thank you and have fun.
