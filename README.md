# projet AD

site internet de sculptures

## Environnement de développement

### Pré-requis

* PHP 7.4
* Composer
* Symfony CLI
* Docker
* Docker-compose
* Nodejs et npm

Vous pouvez vérifier les pré-requis (sauf Docker et Docker-compose) avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirements
```

### Lancer l'environnement de développement

```bash
composer install
npm install
npm run build
docker-compose up -d
symfony serve -d
```

## Lancer les tests

```bash
php bin/phpunit --testdox
```