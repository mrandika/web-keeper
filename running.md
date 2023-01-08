# Running Keeper on Local Machine
## Prerequisite
- PHP, 8.0 or newer
- Composer Package Manager [Download](https://getcomposer.org/)
- MySQL database server, 5.3 or newer

To simplify this process, we recommend using either:
- MAMP (for Mac) [Download](https://www.mamp.info/en/windows/),
- LAMP (for Linux),
- or XAMPP (for Windows) [Download](https://www.apachefriends.org/download.html)

that already included the PHP and MySQL database server.

## Setting up The Server
1. Turn on the Apache, and MySQL Services
2. Open phpMyAdmin Panel
3. At the "Database Server", note the "Server" and "User". Save this key
4. Create a new database called "keeper"

## Cloning the Keeper App
1. Head over to Keeper [Repository](https://github.com/mrandika/web-keeper)
2. Download or clone the source code

## Running the Keeper App
1. Open your terminal or command prompt window in Keeper directory
2. Run the `composer install` command
3. Copy the `.env.example` file to `.env`
4. Run following command `php artisan key:generate` to generate an app key 

After this step, you're required to manually modify the env variable inside the `.env` file. You'll need to change these variables:

`GMAPS_API_KEY=` (leave blank if you dont have one)
`DB_HOST=` (default: localhost)
`DB_PORT=` (default: 3306)
`DB_DATABASE=keeper`
`DB_USERNAME=` (default: root)
`DB_PASSWORD=` (default: (empty) or root in MAMP)

5. After modifying the env variable, run the migrations using `php artisan migrate` command to create all the tables
6. Run the `php artisan db:seed` to populate the newly database using Keeper data samples
7. You can start the server using `php artisan serve`
8. By default, the application is now serving at http://127.0.0.1:8000
9. Verify that you can see the Keeper Login Screen.

You can use following credentials to login to the application:
|Role  | Credentials |
|--|--|
| Super-Admin | superadmin@keeper (Supersecret@123) |
| Admin | admin@keeper (Supersecret@123) |
| Employee | employee@keeper (Supersecret@123) |

## Running the Keeper Test Cases
In order to run the case, you'll need to purge all the table and populate it with Keeper data samples. To do this, simply run `php artisan migrate:fresh` and `php artisan db:seed` if you made changes to the Keeper data samples before.

To run the test cases, type `php artisan test`