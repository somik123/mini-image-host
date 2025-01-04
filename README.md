# mini-image-host
Just a quick image host in PHP


<img src="https://raw.githubusercontent.com/somik123/mini-image-host/main/html/i/screenshot.png" />


## Installation

### Method 1 (tradional method):
1. Install PHP 8.x as well as Apache/Nginx/Lighttpd and set php to work with it.
1. Copy the contents of the `html` folder to your webroot, default: `/var/www/html/`
1. Access it over http/https

### Method 2 (docker method):
1. Clone the repo into your prefered folder
1. Change to the directory containing `docker-compose.yml` file: `cd mini-image-host`
1. Start the docker container: `docker compose up -d`
1. Access the website by going to `yourServerIp:port` (default port `8080`)

> **Note:** You can edit `docker-compose.yml` file and replace `./html` with the full path to your html directory. You can also change the default port from `8080` to your prefered port.
