# Webcup 2026

Application web développée dans le cadre de la Webcup 2026.

## Stack technique

- Symfony 7.4
- PHP 8.4+
- MySQL
- Doctrine ORM
- Twig
- Symfony Security
- HTML / CSS

# Installation

1.  Cloner le projet

git clone https://github.com/TACHIRIFA/webcup-2026.git

cd webcup-2026

2. Installer les dépendances

composer install

3. Configurer la base de données

Créer une base de données MySQL :

webcup_2026

Puis configurer la variable DATABASE_URL dans .env.local

Exemple :

DATABASE_URL="mysql://root:@127.0.0.1:3306/webcup_2026?serverVersion=8.0.31\&charset=utf8mb4"

4. Créer la base de données

php bin/console doctrine:database:create --if-not-exists

5. Exécuter les migrations

php bin/console doctrine:migrations:migrate

6. Créer un utilisateur

php bin/console app:create-user

La commande demandera :

l'adresse e-mail

le mot de passe

7. Lancer le serveur

php -S 127.0.0.1:8000 -t public

Puis ouvrir :

http://127.0.0.1:8000

Authentification

/ → page de connexion

/dashboard → dashboard protégé

/logout → déconnexion
