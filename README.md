<p align="center"><a href="https://transaction-api.fly.dev/api/documentation" target="_blank"><img src="./resources/images/github-header-logo.png" width="400"></a></p>


## About the Project

The app consists in an API for storing and retrieving financial transaction data.

This project was developed according to a code challenge found on internet, with further improvements. The challenge requirements could be seen at [challenge page](https://transaction-api.fly.dev/challenge).

The **API documentation** is available at [API Documentation](https://transaction-api.fly.dev/api/documentation).


## Installation and Local Environment Setup

Follow below the steps to setup and run the application at a local environment.

Clone the github repository to your local machine with the command:

    $ git clone https://github.com/Jadersonrilidio/transaction-api

Create and edit the .env file Database variables (It is recommended to configure a mysql database with the following setups):

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_USERNAME=root
    DB_PASSWORD=
    
For a sqlite3 database, create a file at the root folder of the project with the command:

    $ touch ./database/database.sqlite

After configured the database and the db variables, run the migrations with the command:

    $ php artisan migrate

Finally, use the command below to run the application:

    $ php artisan serve

You also have the option to run the database seed command to populate the database:

    $ php artisan db:seed

Also you can run the unit tests with the command:

    $ php artisan test


## Contributing

Thank you for considering contributing to the Transaction API Project! For contributing, please send an e-mail to Jaderson Rodrigues [jaderson.rodrigues@yahoo.com](jaderson.rodrigues@yahoo.com).


## Security Vulnerabilities

If you discover any security vulnerability within the project, please send an e-mail to please send an e-mail to Jaderson Rodrigues [jaderson.rodrigues@yahoo.com](jaderson.rodrigues@yahoo.com).
