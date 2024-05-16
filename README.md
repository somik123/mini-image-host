# mini-image-host
Just a quick image host in PHP


<img src="https://raw.githubusercontent.com/somik123/mini-image-host/main/i/screenshot.png" />


## Installation

### Method 1 (tradional method):
1. Install PHP 8.x as well as Apache/Nginx/Lighttpd and set php to work with it.
1. Copy the contents of the `html` folder to your webroot, default: `/var/www/html/`
1. Access it over http/https

### Method 2 (docker method):
1. Clone the repo into your prefered folder
1. Change to the html directory: `cd mini-image-host/html`
1. Get the full path to the html directory: `pwd`
1. Change back to the repo's home directory: `cd ..`
1. Edit the `docker-compose.yml` file and replace `/home/somik/mini-image-host/html` with the full path to your html directory you got in step 3: `nano docker-compose.yml` 
1. You can also change the default port from `8080` to your prefered port.
1. Save and exit: `Ctrl + x`
1. Start the docker container: `docker compose up -d`
1. Access the website by going to `yourServerIp:port` (default port `8080`)

