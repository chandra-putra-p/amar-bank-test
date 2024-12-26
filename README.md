# Amar Bank Test - Chandra Putra

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.


## Prerequisites

Here's what you need to run this project
- [PHP 8.4.2+](https://www.php.net/downloads.php)
- [Composer 2.8.4+](https://getcomposer.org/download/)

### Installing

- Install PHP:
    Follow the instructions from [link](https://www.php.net/manual/en/install.php)
- Install Composer:
    Follow the instructions from [link](https://getcomposer.org/doc/00-intro.md)

### Install project packages
- Go to this project's root folder
- In terminal, execute this command for installing the packages
```shell
composer install
```

## Running the Application

To get started quickly with running this project on your local machine, execute:
```shell
$ composer start
```

If you wanna see the test cases execution, execute:
```shell
$ composer test
```

## List API documentation

After you executed command:
```shell
$ composer start
```
You will be able to hit these APIs:
### Health Check
- curl
    ```curl
    curl --location 'http://localhost:8080/'
    ```
- Response
    ```plain
    Don't worry, I'm alive :)
    ```
### Loan Creation
- curl
    ```curl
    curl --location 'http://localhost:8080/loans' \
    --header 'Content-Type: application/json' \
    --data '{
        "name": "John Doe",
        "ktpNumber": "1122330112804455",
        "loanAmount": 1001,
        "loanPeriod": 1,
        "loanPurpose": "wedding party",
        "dob": "01-12-1980",
        "gender": "MALE"
    }'
    ```
- Response
    ```json
    {
        "status": true,
        "message": "Loan created successfully",
        "data": {
            "id": "663457b8-7624-48da-9062-06c42853e822",
            "timestamp": "2024-12-26 12:48:09",
            "name": "John Doe",
            "ktpNumber": "1122330112804455",
            "loanAmount": 1001,
            "loanPeriod": 1,
            "loanPurpose": "wedding party",
            "dob": "01-12-1980",
            "gender": "MALE"
        }
    }
    ```
The created loan data will be stored in json file at `/_database/loans.json`