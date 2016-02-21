EtuUTT Election module
======================

This is a small laravel project created for the student office of my university. Students can vote for a team during election on this application. They log in via our [student website API](https://github.com/ungdev/EtuUTT).

Althoug this project is licensed under the [MIT license](http://opensource.org/licenses/MIT), it has not a lot of chances to be used in another place than our university. That's why a part of the documentation is in French.

## Required

* MySQL
* PHP > 5.4.45
* PHP modules
 * pdo_mysql.so
 * mcrypt.so

## Configuration
This is an example of installation configuration for a single or multi vhost server on Debian 8.

Replace `domain.com` by your domain.
### PHP-fpm configuration (tested on Debian 8, PHP

* Install PHP and composer. Then create pool directory

```bash
apt-get install php5-fpm curl php5-cli php5-mcrypt php5-mysql
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
mkdir -p /var/www/domain.com
```

* Configure your php-fpm pool

Create `/etc/php5/fpm/pool.d/domain.com.conf` with the following content :

```
[domain.com]

user = www-data
group = www-data

listen = /var/run/php-$pool.sock
listen.owner = www-data
listen.group = www-data

pm = dynamic
pm.max_children = 10
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3

chdir = /var/www/$pool/

security.limit_extensions = .php

php_admin_flag[allow_url_include] =  off
php_admin_value[open_basedir] = /var/www/$pool/:/usr/bin:/tmp
php_admin_value[display_errors] = off
php_admin_value[disable_functions] = dl,exec,passthru,shell_exec,system,popen,curl_multi_exec,parse_ini_file,show_source
```

* Disable default pools that you don't need (only if you dont need it)

```bash
mv /etc/php5/fpm/pool.d/www.conf /etc/php5/fpm/pool.d/www.conf.disabled
```
* (Re)Start php-fpm and enable it

```bash
systemctl restart php5-fpm
systemctl enable php5-fpm
```


### Nginx configuration (tested on Debian 8, Nginx 1.6.2)

* Install nginx

```
apt-get install nginx
```

* Create this file

```
# /etc/nginx/sites-available/domain.com
server {
    listen 80;

    server_name  domain.com;

    root   /var/www/domain.com/public;
    index index.php;

    location / {
              try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        expires off;
        fastcgi_pass unix:/var/run/php-domain.com.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

* Enable the vhost and (re)start the nginx server.

```bash
ln -s /etc/nginx/sites-available/domain.com /etc/nginx/sites-enabled/
systemctl restart nginx
systemctl enable nginx
```

### Mysql installation and configuration

* Installez et sécurisez mysql
```bash
apt-get install mysql-server
mysql_secure_installation
```
* Lancez un shell mysql en tant que root
```bash
mysql --user=root -p
```
* Creation d'une base de donnée et d'un user associé
```sql
CREATE DATABASE election;
# Replace `password` in the following line
CREATE USER 'election'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON election.* To 'election'@'localhost';
FLUSH PRIVILEGES;
```

### Website installation

```bash
apt-get install git
git clone https://github.com/alabate/utt-bde-election /var/www/domain.com
cd /var/www/domain.com/
composer update
chown -R www-data:www-data /var/www/domain.com/
```


### Website configuration configuration (In french)
* Copiez le fichier `.env.example` en `.env`
* Réglez vos paramètres de connexion à la base de donnée dans `.env`
* Executez `php artisan migrate` afin de créer les tables dans la base de donnée
* Executez `php artisan key:generate` afin de générer la clé de chiffrement
* Modifiez la propriété `url` de `config/app.php`. Modifiez aussi les locales et timezone si nécéssaire.
* Copiez le fichier `config/election.example.php` en `config/election.php`
* Créez une application sur le [site etudiant de l'UTT](https://etu.utt.fr/api/panel)
 * Utilisez `http://xxxxxx/login/auth` comme URL de redirection
 * Cochez uniquement 'Données publiques'
* Réglez chaque parametre du fichier `config/election.php`
* Si vous êtes sur le même réseau local que le site etu, il se peut que vous ne puissiez pas vous y connecter. Testez en faisant `wget etu.utt.fr`, si la connexion est refusée, alors essayez `http://illidan.sia` (pas de https) comme `baseuri` de `config/election.php`
* Si votre serveur n'est pas en https, commentez la ligne `URL::forceSchema("https");` du fichier `app/Http/routes.php`
* Enfin réglez les droits du dossier : `chown -R www-data:www-data /var/www/domain.com/`
