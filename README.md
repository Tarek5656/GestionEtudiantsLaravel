# GestionEtudiantLaravel

Application Laravel de gestion des étudiants, des matières, des examens, des notes et des bulletins.

## Fonctionnalités

- Authentification avec rôles (`admin` et `user`)
- Tableau de bord administrateur
- Gestion des étudiants (CRUD)
- Gestion des matières (CRUD)
- Gestion des examens (CRUD)
- Saisie et consultation des notes
- Génération et consultation des bulletins (actuels et anciens)
- Espace étudiant (profil, examens, matières, bulletins)

## Stack technique

- PHP 8.2+
- Laravel 12
- Blade
- Vite + Tailwind CSS
- Base de données SQL (configuration via `.env`)

## Installation

1. Cloner le dépôt puis aller dans le dossier du projet.
2. Installer les dépendances PHP :
   ```bash
   composer install
   ```
3. Installer les dépendances front :
   ```bash
   npm install
   ```
4. Copier le fichier d’environnement :
   ```bash
   cp .env.example .env
   ```
5. Générer la clé d’application :
   ```bash
   php artisan key:generate
   ```
6. Configurer la base de données dans `.env`.
7. Lancer les migrations et les seeders :
   ```bash
   php artisan migrate --seed
   ```

## Lancer le projet

### En mode développement (recommandé)

```bash
composer run dev
```

### Ou manuellement

Terminal 1 :
```bash
php artisan serve
```

Terminal 2 :
```bash
npm run dev
```

## Comptes de test

Après `php artisan migrate --seed`, un compte administrateur est créé :

- **Email** : `admin@example.com`
- **Mot de passe** : `admin123`

Des comptes étudiants sont aussi générés automatiquement avec des emails du type :
`prenom.nom@edu.isga.ma`.

## Tests

```bash
composer test
```

## Structure utile

- `/app/Http/Controllers/Admin` : logique côté administrateur
- `/app/Http/Controllers/User` : logique côté étudiant
- `/resources/views/admin` : vues admin
- `/resources/views/user` : vues étudiant
- `/database/migrations` : structure de base de données
- `/database/seeders` : jeux de données initiaux

## Licence

Ce projet est distribué sous licence MIT.
