# User Manager (Front)
If you need to run this project, follow these steps:

```bash
git clone https://github.com/Abreny/user-manager-api.git
composer install
php bin/console doctrine:migrations:migrate
php bin/console server:start
```

Note:
* The app wil be started in http://localhost:8000
* Change you database config in **env** file after cloning the project