# web-news-rest-api-demo

## PROJECT DESCRIPTION

This is demo rest-api for some online news website or application. It consist some basics
operation, and because it's only demonstrative project it have some missing parts.

Just for purpose of testing, creating user is not authorized!

This project have 3 kind of users:
* visitor
* author
* admin

Visitor can manipulate with comments and haven't got any other permissions.
Admin can manipulate with users(get all users list, specific user, delete user), also can do some operations with posts(publish, recommend, unrecommend, suggest changes...).
Author can only make posts and provide requested changes.

About this project structure as you can see I have divided every entity in separate folders.
Base directory consists controller, repository, service and middleware class which will be extended so I use them as a "template" for other classes.
All entities are divided in different service providers. All depedency injections are resolved inside service providiers.


#### For this project you must have mail.trap account.

### To run this project you need to run following commands:

1. Manualy create a database scheme inside you mysql server.

2. rename .env-example into .env and insert your credentials

3. composer install -> install vendor and all depedencies for this project
4. php artisan vendor:publish -> select Tymon\LaravelServiceProvider
5. php artisan jwt:secret -> generate secret key

### Then run migrations with this order:

1. php artisan migrate --path=app/User/Migration/ -> create user table
2. php artisan migrate --path=app/PostCategory/Migration/ -> create categories table
3. php artisan migrate --path=app/Post/Migration/ -> create posts table
4. php artisan migrate --path=app/Comment/Migration/ -> create comments table
5. php artisan migrate -> create notifications table

### Optional, in case that you want to seed a database run this commands:

1. php artisan db:seed --class=UserSeeder -> seed users table
2. php artisan db:seed --class=PostCategorySeeder -> seed categories table
3. php artisan db:seed --class=PostSeeder -> seed post table
4. php artisan db:seed --class=CommentSeeder -> seed comment table

postman collection you can download [here](https://drive.google.com/file/d/1lonVRJY6aslIP4OZCOnnaEk7aJAPcl_O/view?usp=sharing), postman environment you can download [here](https://drive.google.com/file/d/1ImnhZ91y0XJYjSUBhJpsOKBJ_C31ElDf/view?usp=sharing)
