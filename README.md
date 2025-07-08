
# 🚀 CollabHub

Plateforme de collaboration entre candidats et recruteurs basée sur une architecture microservices moderne.

## 📋 Table des matières

- [Architecture](#architecture)
- [Technologies](#technologies)
- [Prérequis](#prérequis)
- [Configuration de la base de données](#configuration-de-la-base-de-données)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [API Documentation](#api-documentation)
- [Structure du projet](#structure-du-projet)
- [Développement](#développement)
- [Contribution](#contribution)

## 🏗️ Architecture

CollabHub utilise une architecture microservices polyglotte composée de :

### Backend Microservices
- **service-candidat (Java)** : Gestion des profils candidats (Spring Boot) (Migration en en cours vers Golang) 
- **service-candidat-go (Go)** : Version Go du service candidat (Gin)
- **service-recruteur (Java)** : Gestion des offres d'emploi et recruteurs (Spring Boot) (en cours de developpement)

### Frontend
- **CollabHubFrontEnd (Angular)** : Interface utilisateur moderne

### Base de données
- **PostgreSQL** : Base de données relationnelle pour tous les services

## 🛠️ Technologies

### Backend
- **Java 17** avec Spring Boot 3.2
- **Go 1.21+** avec Gin Framework
- **PostgreSQL 12+**
- **GORM** (Go ORM)
- **JPA/Hibernate** (Java ORM)

### Frontend
- **Angular 17+**
- **TypeScript**
- **HTML5/CSS3**


## 📋 Prérequis

- **Java 17+**
- **Go 1.21+**
- **Node.js 18+**
- **PostgreSQL 12+**
- **Angular CLI**
- **Docker** (optionnel)

## 🗄️ Configuration de la base de données

### Installation PostgreSQL

```bash
# macOS avec Homebrew
brew install postgresql
brew services start postgresql

# Ubuntu/Debian
sudo apt update
sudo apt install postgresql postgresql-contrib
sudo systemctl start postgresql

# Windows
# Télécharger depuis https://www.postgresql.org/download/windows/
```

### Configuration des bases de données

1. **Créer les bases de données** :
```bash
# Se connecter à PostgreSQL
psql -U postgres

# Créer les bases de données
CREATE DATABASE candidatdb;
CREATE DATABASE recruteurdb;

# Vérifier la création
\l

# Quitter psql
\q
```

2. **Initialiser les tables pour le service candidat** :
```bash
# Naviguer vers le répertoire du projet
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

# Voir la structure de la table candidat
\d candidat;

# Quitter psql
\q
```

## 🚀 Installation

### 1. Backend - Service Candidat Java

```bash
# Naviguer vers le service Java
cd CollabHubBackEnd/service-candidat

# Créer le fichier .env
cat > .env << EOF
DB_HOST=localhost
DB_PORT=5432
DB_NAME=candidatdb
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
JAVA_SERVICE_PORT=8081
EOF

# Compiler et lancer
./gradlew build
./gradlew bootRun
```

### 2. Backend - Service Candidat Go

```bash
# Naviguer vers le service Go
cd CollabHubBackEnd/service-candidat-go

# Créer le fichier .env
cat > .env << EOF
DB_HOST=localhost
DB_PORT=5432
DB_NAME=candidatdb
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
SERVER_PORT=8082
EOF

# Installer les dépendances
go mod tidy

# Lancer le service
go run main.go
```

### 3. Backend - Service Recruteur

```bash
# Naviguer vers le service recruteur
cd CollabHubBackEnd/service-recruteur

# Créer le fichier .env
cat > .env << EOF
DB_HOST=localhost
DB_PORT=5432
DB_NAME=recruteurdb
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
RECRUTEUR_SERVICE_PORT=8083
EOF

# Compiler et lancer
./gradlew build
./gradlew bootRun
```

### 4. Frontend Angular

```bash
# Naviguer vers le frontend
cd CollabHubFrontEnd

# Installer les dépendances
npm install

# Lancer en mode développement
ng serve

# Ou avec npm
npm start
```

## 📱 Utilisation

### Accès aux applications

- **Frontend** : `http://localhost:4200`
- **Service Candidat Java** : `http://localhost:8081`
- **Service Candidat Go** : `http://localhost:8082`
- **Service Recruteur** : `http://localhost:8083`

### Health Checks

```bash
# Vérifier l'état des services
curl http://localhost:8081/actuator/health  # Java
curl http://localhost:8082/health           # Go
curl http://localhost:8083/actuator/health  # Recruteur
```

### Tests API

```bash
# Service Candidat Java
curl http://localhost:8081/api/v1/candidat

# Service Candidat Go
curl http://localhost:8082/api/v1/candidat

# Service Recruteur
curl http://localhost:8083/api/v1/recruteur
```

## 📚 API Documentation

### Service Candidat (Java & Go)

| Méthode | Endpoint | Description | Status |
|---------|----------|-------------|--------|
| `GET` | `/api/v1/candidat` | Liste des candidats | ✅ Implémenté |
| `GET` | `/api/v1/candidat/{id}` | Candidat par ID | 🔄 En cours |
| `POST` | `/api/v1/candidat` | Créer un candidat | 🔄 En cours |
| `PUT` | `/api/v1/candidat/{id}` | Modifier un candidat | 🔄 En cours |
| `DELETE` | `/api/v1/candidat/{id}` | Supprimer un candidat | 🔄 En cours |

### Service Recruteur

| Méthode | Endpoint | Description | Status |
|---------|----------|-------------|--------|
| `GET` | `/api/v1/recruteur` | Liste des recruteurs | 📋 Planifié |
| `GET` | `/api/v1/jobs` | Liste des offres | 📋 Planifié |
| `POST` | `/api/v1/jobs` | Créer une offre | 📋 Planifié |

### Modèle de données Candidat

```json
{
  "id": 1,
  "firstName": "John",
  "lastName": "Doe",
  "email": "john.doe@example.com",
  "phone": "+33123456789",
  "picture": "https://example.com/photo.jpg",
  "dateBirth": "1990-05-15T00:00:00Z",
  "address": "123 Rue de la Paix, Paris",
  "linkLinkedin": "https://linkedin.com/in/johndoe",
  "description": "Développeur Full Stack passionné",
  "linkGithub": "https://github.com/johndoe",
  "linkPortfolio": "https://johndoe.dev",
  "language": "FRENCH",
  "interests": "Programmation, Technologies, Innovation",
  "cv": "cv-john-doe.pdf",
  "createdAt": "2024-01-15T10:30:00Z"
}
```

## 🔧 Développement

### Commandes utiles

```bash
# Backend Java
./gradlew clean build
./gradlew test
./gradlew bootRun

# Backend Go
go mod tidy
go test ./...
go run main.go
go build -o service-candidat-go

# Frontend Angular
ng build
ng test
ng serve
ng generate component nom-composant
```

### Variables d'environnement

Chaque service utilise un fichier `.env` pour la configuration :

```env
# Exemple pour service-candidat-go
DB_HOST=localhost
DB_PORT=5432
DB_NAME=candidatdb
DB_USERNAME=postgres
DB_PASSWORD=your_password
SERVER_PORT=8082
APP_ENV=development
```

### Docker (Optionnel)

```bash
# Construire et lancer tous les services
docker-compose up -d

# Lancer seulement la base de données
docker-compose up -d postgres

# Voir les logs
docker-compose logs -f service-candidat-go
```

## 🧪 Tests

```bash
# Tests backend Java
cd CollabHubBackEnd/service-candidat
./gradlew test

# Tests backend Go
cd CollabHubBackEnd/service-candidat-go
go test ./...

# Tests frontend
cd CollabHubFrontEnd
npm test
```

## 🚀 Déploiement

### Production

1. **Configurer les variables d'environnement de production**
2. **Construire les images Docker**
3. **Déployer avec Kubernetes ou Docker Compose**

```bash
# Build production
go build -o service-candidat-go main.go
./gradlew bootJar
ng build --prod
```

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit les changements (`git commit -am 'Ajout nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Créer une Pull Request

### Standards de code

- **Java** : Suivre les conventions Spring Boot
- **Go** : Utiliser `gofmt` et `golint`
- **Angular** : Suivre le style guide Angular

## 📊 Statut du projet

| Composant | Status | Version |
|-----------|--------|---------|
| service-candidat (Java) | ✅ Opérationnel | 1.0.0 |
| service-candidat-go | ✅ Opérationnel | 1.0.0 |
| service-recruteur | 🔄 En développement | 0.1.0 |
| Frontend Angular | 🔄 En développement | 0.1.0 |

## 📞 Support

Pour toute question ou problème :
- Créer une issue GitHub
- Contacter l'équipe de développement

---

**Développé par Molid NOUR AWALEH**  
*Architecture microservices polyglotte avec Java, Go et Angular*
