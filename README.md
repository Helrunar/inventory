<p align="center"><img src="https://symfony.com/images/logos/header-logo.svg"></p>

# **Symfony 5 IMS with Gentella Free Bootstrap 4 Admin Dashboard Template**

Inventory Management System on the foundation of the Symfony 5 framework, Twitter Bootstrap and Gentelella template .

# **Features**
- Administration Dashboard with Gentelella Admin Theme
- Responsive Layout
- Bootstrap 4
- USER/ROLES CRUD with ajax and symfony form system 
- Password reset and send email, with link to reset the password
- Authentication system
- Translation functionality (Easy to set up whatever language you need/use)

# **Requirements**
- PHP >= 7.4
- Symfony >5.*
- MySQL

# **Credits**
[Gentelella](https://github.com/ColorlibHQ/gentelella) - Admin template project is developed and maintained by [Colorlib](https://colorlib.com/ "Colorlib - Make Your First Blog") and Aigars Silkalns
Mamour Wane (Mamless) co-founder of [ONETECHSN](https://onetechsn.com)

IMS is originally based on [Gentelella Admin Symfony](https://github.com/mamless/Gentella-admin-Symfony-5) by [mamless](https://github.com/mamless)

## License information
Gentelella is licensed under The MIT License (MIT). Which means that you can use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software. But you always need to state that Colorlib is the original author of this template.

# **SETUP**
1 - Install all dependencies :

~~~
    composer install
~~~


2 - Create database using the next command:
~~~
    php bin/console doctrine:schema:create
~~~

3 - Create scheme using migration command:
~~~
    php bin/console doctrine:migrations:migrate
~~~

4 - You will need to populate your database using fixtures for login.

Run:

~~~
    php bin/console doctrine:fixtures:load
~~~

And use the next credentials to login.

- Username : "admin"
- Password : "admin"

**ENJOY**
