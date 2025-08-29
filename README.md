
# 🚀 CollabHub

**Plateforme de collaboration entre candidats et recruteurs**  
*Architecture moderne avec API Go et Frontend WordPress*

## 🏗️ **Architecture du Projet**

```
📁 CollabHub/
├── 🐹 CollabHubBackEnd/       # API REST (Go + Java) + PostgreSQL
├── 🌐 CollabHubWordPress/     # Frontend WordPress + MySQL  
└── 🚀 start-collabhub.sh      # Script de démarrage complet
```

### **🎯 Architecture Finalisée**
- ✅ **WordPress** comme frontend unique et professionnel
- ✅ **Séparation claire** : Backend API ↔ Frontend WordPress  
- ✅ **Votre maquette** parfaitement intégrée
- ✅ **Architecture simplifiée** : focus sur l'efficacité

---

## 🚀 **Démarrage rapide**

### **Option 1 : Démarrage complet automatique**
```bash
# Lancer tout l'environnement en une commande
./start-collabhub.sh
```

### **Option 2 : Démarrage manuel étape par étape**
```bash
# 1. Backend API (Go + PostgreSQL)
cd CollabHubBackEnd
./start.sh

# 2. Frontend WordPress (MySQL + WordPress)  
cd ../CollabHubWordPress
./start-wordpress.sh
```

### **🌐 Services disponibles après démarrage :**
- **Frontend WordPress** : http://localhost
- **Backend API Go** : http://localhost:8080
- **PostgreSQL** : localhost:5432
- **MySQL WordPress** : localhost:3306

---

## 📋 **Architecture détaillée**

### **🐹 Backend (CollabHubBackEnd/)**
```
🗄️ PostgreSQL (Port 5432)
    ↑
🐹 service-candidat-go (Port 8080) - API principale en Go
🔶 service-recruteur (Port 8081) - API Java Spring Boot  
```

**Technologies :**
- **Go 1.21+** avec Gin Framework
- **Java 17** avec Spring Boot
- **PostgreSQL** avec GORM
- **Docker & Docker Compose**

### **🌐 Frontend (CollabHubWordPress/)**
```
🗄️ MySQL (Port 3306)
    ↑
🌐 WordPress (Port 80/443) 
    ↓ API Calls
🔗 Backend API (localhost:8080)
```

**Technologies :**
- **WordPress** dernière version
- **PHP** avec thème custom
- **MySQL** pour WordPress
- **AJAX** pour communication API

---

## 🎯 **Fonctionnalités implémentées**

### ✅ **Backend API Go**
- **CRUD Candidats** complet
- **Auto-migration** GORM
- **Validation** des données
- **CORS** configuré
- **Health checks**

### ✅ **Frontend WordPress**
- **Page profil candidat** (votre maquette)
- **Liste des candidats**
- **Communication API** temps réel
- **Interface responsive**
- **Administration WordPress**

### ✅ **Fonctionnalités principales**
- ✅ Création/modification profils candidats
- ✅ Gestion des informations personnelles
- ✅ Liens professionnels (LinkedIn, GitHub, Portfolio)
- ✅ Sauvegarde automatique
- ✅ Messages de feedback utilisateur

---

## 📚 **Documentation**

### **📖 Guides détaillés :**
- **Backend** : [`./CollabHubBackEnd/README.md`](./CollabHubBackEnd/README.md)
- **WordPress** : [`./CollabHubWordPress/README.md`](./CollabHubWordPress/README.md)
- **API Endpoints** : http://localhost:8080/health

### **🔧 Pages importantes :**
- **📝 Profil candidat** : http://localhost/profil-candidat
- **👥 Liste candidats** : http://localhost/candidats  
- **⚙️ WordPress Admin** : http://localhost/wp-admin
- **🔍 API Health** : http://localhost:8080/health

---

## 🛠️ **Développement**

### **🔄 Workflow recommandé :**

1. **Modifier l'API** (nouveau champ, endpoint)
```bash
   cd CollabHubBackEnd/service-candidat-go
   # Modifier model, service, controller
   docker-compose restart service-candidat
   ```

2. **Modifier le frontend** (design, fonctionnalité)
```bash
   cd CollabHubWordPress
   # Modifier style.css, templates/, functions.php
   # Les changements sont immédiats
   ```

3. **Tester l'intégration**
```bash
   curl http://localhost:8080/api/v1/candidat
   # Visiter http://localhost/profil-candidat
```

### **🐛 Debug et logs :**
```bash
# Logs backend
cd CollabHubBackEnd && docker-compose logs service-candidat

# Logs WordPress  
cd CollabHubWordPress && docker-compose logs wordpress

# Statut des services
docker-compose ps
```

---

## 🎨 **Personnalisation**

### **Frontend WordPress :**
- **Design** : Modifier `CollabHubWordPress/style.css`
- **Templates** : Modifier `CollabHubWordPress/templates/`
- **API Logic** : Modifier `CollabHubWordPress/functions.php`

### **Backend API :**
- **Modèles** : `CollabHubBackEnd/service-candidat-go/internal/model/`
- **Endpoints** : `CollabHubBackEnd/service-candidat-go/internal/controller/`
- **Business Logic** : `CollabHubBackEnd/service-candidat-go/internal/service/`

---

## 🔧 **Gestion des services**

### **Commandes utiles :**
```bash
# Démarrer tout
./start-collabhub.sh

# Arrêter tout  
cd CollabHubWordPress && docker-compose down
cd CollabHubBackEnd && docker-compose down

# Redémarrer un service
cd CollabHubBackEnd && docker-compose restart service-candidat

# Logs en temps réel
cd CollabHubWordPress && docker-compose logs -f wordpress
```

### **Ports utilisés :**
- **80** : WordPress Frontend
- **3306** : MySQL (WordPress)
- **5432** : PostgreSQL (Backend)
- **8080** : API Go (service-candidat)
- **8081** : API Java (service-recruteur)

---

## 🚀 **Prochaines étapes**

### **Phase 1 : Complétude**
- [ ] Upload de photos de profil
- [ ] Gestion formations/expériences  
- [ ] API recruteur opérationnelle
- [ ] Authentification utilisateurs

### **Phase 2 : Fonctionnalités avancées**
- [ ] Dashboard recruteur WordPress
- [ ] Système de matching
- [ ] Notifications email
- [ ] Recherche avancée

### **Phase 3 : Production**
- [ ] Déploiement cloud
- [ ] CDN pour les assets
- [ ] Monitoring & logs
- [ ] Tests automatisés

---

## 🤝 **Contribution**

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit les changements (`git commit -m 'Ajouter nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Créer une Pull Request

---

## 📝 **Notes importantes**

### **⚠️ Pré-requis :**
- **Docker Desktop** installé et lancé
- **Ports 80, 3306, 5432, 8080, 8081** disponibles
- **macOS, Linux ou Windows** avec Bash

### **🔧 Dépannage courant :**
- **Port 80 occupé** : Arrêter Apache/Nginx local
- **API indisponible** : Vérifier que le backend est démarré en premier
- **WordPress pages 404** : Aller dans WP-Admin > Réglages > Permaliens > Enregistrer

**🎯 Votre maquette de profil candidat est maintenant 100% fonctionnelle !**

---

*Dernière mise à jour : Juillet 2024*
