# Palworld Admin Tool

## Description
An Admin tool receives information via rcon and displays them.

## Overview
1. [Installation Variations](#install-possibilities)
2. [Installation via Release (1 click install)](#installation-via-release)
3. [Full Installation](#full-installation)
   1. [Prerequisites full Installation](#prerequisites-developerfull-installation)
   2. [Install Steps](#installation-steps)
3. [Updating](#updating)

## Installation Variations
You can install this tool in the following ways
- Install via docker-compose
  - Head over to https://github.com/Insax/palworld-admin-tool-docker and read the installation instructions
- Install using the latest [release](https://github.com/Insax/palworld-admin-tool/releases/latest) for Windows Users.
  - Go to [Installation via Release](#installation-via-release) and follow the steps (1 click install)
- Install cloning the repository (Advanced/Developer Installation)
  - Go to [Developer Setup](#developer-installation)
  
    
## Installation via Release
> :warning: **This way of installing does not support updating your installation and has limitations.** 

#### This way of installing provides a fully working instance for testing purposes, its not meant to be used in real production. 

#### If you like it go for the docker version or the full install.

Steps
1. Download the release as zip and extract it somewhere
2. Run the script install-start.ps1 using powershell.
3. Visit http://localhost

> :warning: **Once again, this is more of a Test installation than anything else.**

## Full Installation
This will provide you with everything to update or develop the app yourself.

### Prerequisites Developer/Full Installation
This application has some requirements that must be fullfilled in order to for everything to work properly.

1. PHP 8.1 with the following extensions enabled:**
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
   - sqlite
1. composer (https://getcomposer.org/)
2. npm (20 or higher) https://nodejs.org/en/download
3. Supervisord or an equivalent http://supervisord.org/
4. Nginx or an equivalent https://nginx.org/en/download.html
5. [Optional] Any Mysql or Postgres Database, alternatively sqlite can be used.

### Installation Steps

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
    
   1. If you would like to use SQLITE set `DB_CONNECTION` to `sqlite` and delete the `DB_DATABASE` line.

    ```bash
    cp .env.example .env
    ```
   
5. Create the database tables in your already created database.

    ```bash
    php artisan migrate --force
    ```
    
6. Generate an application key

   ```bash
   php artisan key:generate
   ```
    
7. Create a job in supervisor or an equivalent tool that auto restarts and runs

   ```bash
   php artisan short-schedule:run
   ```
8. Configure your webserver, the content root is in `public`


## Updating
Rerun steps 2 - 5

## Running Tests

We don't do that here.
