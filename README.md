# 🚀 CollabHub

Plateforme de collaboration entre candidats et recruteurs basée sur une architecture microservices.

## 📋 Table des matières

- [Architecture](#architecture)
- [Prérequis](#prérequis)
- [Configuration de la base de données](#configuration-de-la-base-de-données)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [API Documentation](#api-documentation)

## 🏗️ Architecture

CollabHub utilise une architecture microservices composée de :

- **service-candidat** : Gestion des profils candidats et candidatures
- **service-recruteur** : Gestion des offres d'emploi et recruteurs
- **frontend** : Interface utilisateur React

## 📋 Prérequis

- Java 17+
- PostgreSQL 12+
- Node.js 16+
- Maven 3.6+

## 🗄️ Configuration de la base de données

### Installation PostgreSQL

```bash
# macOS avec Homebrew
brew install postgresql
brew services start postgresql

# Ubuntu/Debian
sudo apt update
sudo apt install postgresql postgresql-contrib

# Windows
# Télécharger depuis https://www.postgresql.org/download/windows/
```

### Configuration du service candidat

1. **Créer la base de données** :
```bash
# Se connecter à PostgreSQL
psql -U postgres

# Créer la base de données (dans psql)
CREATE DATABASE candidatdb;
\q
```

2. **Créer les tables** :
```bash
# Naviguer vers le répertoire du projet
cd "chemin/vers/CollabHub"

# Naviguer vers le répertoire resources
cd CollabHubBackEnd/service-candidat/app/src/main/resources

# Exécuter le script SQL
psql -U postgres -d candidatdb -f candidatDB.sql
```

3. **Vérifier la création des tables** :
```bash
# Se connecter à la base candidat
psql -U postgres -d candidatdb

# Lister les tables créées
\dt

# Voir la structure d'une table
\d candidat;

# Quitter psql
\q
```

### Configuration du service recruteur

```bash
# Répéter les mêmes étapes pour le service recruteur
CREATE DATABASE recruteurdb;
# Puis exécuter le script SQL correspondant
```

### Variables d'environnement

Créer un fichier `.env` dans chaque service :

```env
# Service candidat
DB_HOST=localhost
DB_PORT=5432
DB_NAME=candidatdb
DB_USER=postgres
DB_PASSWORD=votre_mot_de_passe
```

## 🚀 Installation

### Backend (Microservices)

```bash
# Service candidat
cd CollabHubBackEnd/service-candidat
mvn clean install
mvn spring-boot:run

# Service recruteur
cd CollabHubBackEnd/service-recruteur
mvn clean install
mvn spring-boot:run
```

### Frontend

```bash
cd CollabHubFrontEnd
npm install
npm start
```

## 📱 Utilisation

1. Accéder à l'application : `http://localhost:3000`
2. Les services backend tournent sur :
   - Service candidat : `http://localhost:8081`
   - Service recruteur : `http://localhost:8082`

## 📚 API Documentation

### Service Candidat
- `GET /api/candidats` - Liste des candidats
- `POST /api/candidats` - Créer un candidat
- `PUT /api/candidats/{id}` - Modifier un candidat
- `DELETE /api/candidats/{id}` - Supprimer un candidat

### Service Recruteur
- `GET /api/jobs` - Liste des offres d'emploi
- `POST /api/jobs` - Créer une offre
- `PUT /api/jobs/{id}` - Modifier une offre
- `DELETE /api/jobs/{id}` - Supprimer une offre

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit les changements (`git commit -am 'Ajout nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Créer une Pull Request



---

**Développé par Molid NOUR AWALEH
