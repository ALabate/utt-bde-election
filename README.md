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
