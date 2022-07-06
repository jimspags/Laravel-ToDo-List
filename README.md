### PREREQUISITE
- XAMPP version 8.1.6
  https://www.apachefriends.org/blog/new_xampp_20220516.html
- Composer
  https://getcomposer.org/
- Git
  https://git-scm.com/downloads

### Installation
- Clone the Repository from GitHub to your local machine. Open Git Bash
```
    cd C:/xampp/htdocs/
    git clone https://github.com/jimspags/Laravel-ToDo-List.git
    cd laravel-todo-list
    git pull
    composer install
```

- Create Database using XAMPP. Open XAMPP control panel
```
    Start Apache and Mysql
    Click Admin of Apache
    Navigate to PhpMyAdmin
    Click new and type any database name and create
```

- Configure database information. Open project folder using your any code editor
```
    Open .env file
    Set value DB_DATABASE = <database_name> and save
    Set username DB_USERNAME = root //for default
    Set password DB_PASSwORD = //Leave it blank for default
```

- Run the project. Open terminal inside the project folder and run this commands
```
    php artisan serve
    php artisan migrate
```

- Open project on web browser. Enter this laravel development server on the url tab
```
  http://127.0.0.1:8000
```

## ToDo List
Built Using Laravel 9, Ajax, Jquery and Bootstrap

## Screenshots

![image](https://user-images.githubusercontent.com/73511781/175801941-1b779fbd-e076-4467-951b-13b85d8a1e27.png)

![image](https://user-images.githubusercontent.com/73511781/175801949-bd0c9874-a5a8-4f8d-ac1c-94ce73700472.png)


