# Zoo Web Application

## Description
Ce projet est une application web fullstack pour la gestion d'un zoo. Elle permet de gérer les animaux, leurs habitats, les services du zoo, les avis des visiteurs, ainsi que d'autres fonctionnalités administratives. Le projet utilise Symfony pour le backend et Docker pour la containerisation, garantissant ainsi une configuration et un déploiement facile.

---

## Fonctionnalités
- **Gestion des animaux** : Ajout, modification, suppression et consultation des animaux.
- **Gestion des habitats** : Création et modification des habitats avec des descriptions et des images.
- **Gestion des services** : Planification et gestion des horaires des services offerts au zoo.
- **Interface visiteur** : Les visiteurs peuvent consulter les animaux, les habitats et laisser des avis.
- **Interface administrateur** : CRUD complet pour les entités, gestion des employés et des vétérinaires.
- **Avis des visiteurs** : Gestion des avis avec Firebase pour le stockage.
- **Sécurité** : Authentification avec rôles (visiteur, employé, administrateur).

---

## Technologies utilisées
- **Backend** : Symfony 6
- **Frontend** : Twig avec CSS personnalisé (ou React/Vue.js si nécessaire)
- **Base de données** : PostgreSQL
- **Containerisation** : Docker & Docker Compose
- **Gestion des avis** : Firebase (NoSQL)
- **Serveur web** : Nginx
- **Tests** : PHPUnit

---

## Prérequis
Avant de commencer, assurez-vous d'avoir les outils suivants installés :
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Composer](https://getcomposer.org/)
- [Node.js et npm](https://nodejs.org/)

---

## Installation

### 1. Clonez le dépôt
```bash
git clone https://github.com/votre-utilisateur/zoo-web-app.git
cd zoo-web-app
```

### 2. Configurez les variables d'environnement
Copiez le fichier d'exemple `.env.example` en `.env` et modifiez-le selon vos besoins :
```bash
cp .env.example .env
```
Assurez-vous de configurer correctement la connexion à PostgreSQL, Firebase et autres services.

### 3. Construisez et démarrez les conteneurs Docker
```bash
docker-compose up -d --build
```

### 4. Installez les dépendances Symfony
```bash
docker exec -it php-container composer install
```

### 5. Créez la base de données et exécutez les migrations
```bash
docker exec -it php-container php bin/console doctrine:database:create
docker exec -it php-container php bin/console doctrine:migrations:migrate
```

### 6. Installez les dépendances front-end (si applicable)
```bash
docker exec -it php-container npm install
docker exec -it php-container npm run build
```

### 7. Importez les données initiales (fixtures, si disponibles)
```bash
docker exec -it php-container php bin/console doctrine:fixtures:load
```

---

## Accès au site

- **Frontend (visiteurs/utilisateurs)** : [http://localhost:8000](http://localhost:8000)
- **Backend (administration)** : [http://localhost:8000/admin](http://localhost:8000/admin)

---

## Structure des conteneurs
- **php-container** : Serveur PHP avec Symfony
- **db-container** : Serveur PostgreSQL pour la base de données
- **nginx-container** : Serveur Nginx pour servir l'application

---

## Commandes utiles

### Accéder au conteneur PHP
```bash
docker exec -it php-container bash
```

### Exécuter les tests Symfony
```bash
docker exec -it php-container php bin/phpunit
```

### Arrêter les conteneurs
```bash
docker-compose down
```

### Supprimer les conteneurs et les volumes
```bash
docker-compose down -v
```

---

## Fonctionnalités futures
- Intégration d'une API externe pour enrichir les données des animaux (ex. : espèce, alimentation).
- Ajout d'un tableau de bord statistique pour les administrateurs (nombre de visiteurs, consultations, etc.).
- Optimisation de l'interface utilisateur avec un framework front-end moderne (React/Vue.js).
- Notifications en temps réel pour les employés et les administrateurs via WebSocket.

---

## Contribution
Les contributions sont les bienvenues ! Si vous souhaitez ajouter des fonctionnalités ou corriger des bugs, veuillez :
1. Forker le dépôt
2. Créer une branche avec une description claire : `feature/ajout-fonctionnalite`
3. Soumettre une pull request

---
