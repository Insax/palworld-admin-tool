# Palworld Admin Toll

## Description

An Admin tool receives information via rcon and displays them.

## Prerequisites

The following packages need to be installed:

1. php (8.1 or higher) with the following extensions
   - ctype
   - curl
   - dom
   - fileinfo
   - filter
   - hash
   - mbstring
   - openssl
   - pcre
   - pdo
   - session
   - tokenizer
   - xml
15. composer (https://getcomposer.org/)
16. npm (20 or higher) https://nodejs.org/en/download
17. Supervisord or an equivalent or http://supervisord.org/
18. Nginx or an equivalent https://nginx.org/en/download.html
19. Any Mysql or Postgres Database that supports column type `enum`

## Installation

1. Clone the repository

    ```bash
    git clone https://github.com/Insax/palworld-admin-tool.git
    cd palworld-admin-tool
    ```

2. Install necessary packages using composer and npm

    ```bash
    composer install --no-dev
    npm install
    ```

3. Compile assets

    ```bash
    npm run build
    ```
4. Copy .env.example to .env and adjust the DB_HOST, DB_PORT, DB_USER, DB_DATABASE, DB_PASSWORD so it matches your setup

    ```bash
    cp .env.example .env
    ```
4. Generate an application key

   ```bash
   php artisan key:generate
   ```
4. Create a job in supervisor or an equivalent tool that auto restarts and runs

   ```bash
   php artisan short-schedule:run --lifetime=60
   ```   
5. Adjust the connections in config/rcon.php so they match you servers. Do not edit the default entry, it will not show up the application.

6. Configure your webserver, the content root is in `public`
7. Visit the website, the installer should pop up.

## Running Tests

We don't do that here.
