# 🚀 Guide CollabHub : WordPress + API Go

## 📋 **Architecture de la solution**

```
🌐 WordPress Frontend (localhost:80)
    ↓ API REST Calls
🐹 Service Go API (localhost:8080)
    ↓ Database Connection  
🗄️ PostgreSQL (localhost:5432)
    +
🗄️ MySQL WordPress (localhost:3306)
```

### **Avantages de cette architecture :**
- ✅ **Frontend professionnel** avec WordPress (CMS, thèmes, plugins)
- ✅ **Backend puissant** avec votre API Go personnalisée
- ✅ **Séparation des préoccupations** : logique métier ≠ présentation
- ✅ **Évolutivité** : chaque service peut évoluer indépendamment
- ✅ **Réutilisabilité** : l'API peut servir d'autres frontends (mobile, etc.)

---

## 🏁 **Démarrage rapide**

### **1. Lancer l'environnement complet**

```bash
cd CollabHub/CollabHubBackEnd
docker-compose up -d
```

**Services disponibles :**
- 🌐 **WordPress** : http://localhost
- 🐹 **API Go** : http://localhost:8080
- 📊 **PostgreSQL** : localhost:5432
- 🗄️ **MySQL** : localhost:3306

### **2. Configuration initiale WordPress**

1. **Accéder à WordPress** : http://localhost
2. **Suivre l'installation** (langue, admin, etc.)
3. **Activer le thème CollabHub** :
   - Aller dans `Apparence > Thèmes`
   - Activer le thème "CollabHub"

### **3. Pages automatiquement créées**

Le thème crée automatiquement :
- `/profil-candidat` - Formulaire de profil (votre maquette)
- `/candidats` - Liste des candidats

---

## 🔧 **Structure du thème WordPress**

```
wordpress-custom/
├── style.css              # Styles CSS (basés sur votre maquette)
├── functions.php           # Logique PHP + connexion API
├── index.php              # Page d'accueil
├── header.php             # En-tête du site
├── footer.php             # Pied de page
└── templates/
    └── profil-candidat.php # Template de votre maquette
```

### **Fonctionnalités implémentées :**

#### **📝 Formulaire de profil candidat**
- ✅ **Tous les champs** de votre maquette
- ✅ **Validation** côté client et serveur
- ✅ **Sauvegarde** via API Go (AJAX)
- ✅ **Messages** de succès/erreur
- ✅ **Responsive** pour mobile

#### **🔗 Connexion API Go**
- ✅ **GET /candidat** - Liste des candidats
- ✅ **POST /candidat** - Créer un candidat
- ✅ **PUT /candidat/:id** - Modifier un candidat
- ✅ **Gestion d'erreurs** et timeouts

#### **🎨 Interface utilisateur**
- ✅ **Design fidèle** à votre maquette
- ✅ **Loading spinners** et feedback utilisateur
- ✅ **Navigation** intuitive

---

## 📡 **Communication WordPress ↔ Go API**

### **Flux de données :**

```
1. Utilisateur remplit formulaire WordPress
2. JavaScript envoie données via AJAX à WordPress
3. WordPress fait appel à l'API Go
4. Go sauvegarde en PostgreSQL
5. Go retourne la réponse à WordPress
6. WordPress affiche le résultat à l'utilisateur
```

### **Sécurité :**
- ✅ **Nonces WordPress** pour les formulaires
- ✅ **Sanitisation** des données d'entrée
- ✅ **Validation** côté serveur Go
- ✅ **Échappement** des données d'affichage

---

## 🛠️ **Personnalisation et développement**

### **Modifier le design :**
```css
/* Dans wordpress-custom/style.css */
.profil-candidat {
    /* Vos modifications CSS */
}
```

### **Ajouter des champs :**

1. **Modifier le modèle Go** (`candidat.go`)
2. **Mettre à jour l'API** (repository, service, controller)
3. **Ajouter le champ WordPress** (`profil-candidat.php`)
4. **Redémarrer** : `docker-compose restart service-candidat`

### **Ajouter de nouvelles pages :**

```php
// Dans functions.php
function nouveau_shortcode() {
    // Votre logique
}
add_shortcode('ma_nouvelle_page', 'nouveau_shortcode');
```

---

## 🚀 **Étapes suivantes recommandées**

### **Phase 1 : Fonctionnalités de base**
1. ✅ **Profil candidat** (fait)
2. 🔄 **Upload de photos** de profil
3. 🔄 **Gestion des formations/expériences**
4. 🔄 **Recherche et filtres** candidats

### **Phase 2 : Fonctionnalités avancées**
1. 🔄 **Authentification** utilisateurs
2. 🔄 **Dashboard recruteur**
3. 🔄 **Système de matching**
4. 🔄 **Notifications**

### **Phase 3 : Optimisations**
1. 🔄 **Cache Redis**
2. 🔄 **CDN** pour les images
3. 🔄 **Monitoring** et logs
4. 🔄 **Tests automatisés**

---

## 🔍 **Debugging et troubleshooting**

### **Vérifier l'état des services :**
```bash
docker-compose ps
docker-compose logs service-candidat
docker-compose logs wordpress
```

### **Tester l'API directement :**
```bash
# Santé de l'API
curl http://localhost:8080/health

# Liste des candidats
curl http://localhost:8080/api/v1/candidat
```

### **Logs WordPress :**
- Activer `WP_DEBUG` dans wp-config.php
- Vérifier `/wp-content/debug.log`

### **Problèmes courants :**

**❌ "API Indisponible"**
```bash
# Vérifier les conteneurs
docker-compose ps
# Reconstruire si nécessaire
docker-compose build --no-cache service-candidat
```

**❌ "Page non trouvée"**
- Aller dans WordPress Admin > Réglages > Permaliens
- Cliquer "Enregistrer" pour régénérer les URLs

---

## 📚 **Ressources supplémentaires**

### **Documentation technique :**
- [API Go Backend](./service-candidat-go/README.md)
- [WordPress Codex](https://codex.wordpress.org/)
- [Docker Compose](https://docs.docker.com/compose/)

### **Outils de développement :**
- **Postman** pour tester l'API
- **WordPress Admin** pour gérer le contenu
- **Docker Desktop** pour monitoring

---

## 🎯 **Votre maquette intégrée**

Votre maquette de profil candidat est maintenant **100% fonctionnelle** :

- ✅ **Photo de profil** avec actions
- ✅ **Informations personnelles** complètes
- ✅ **Liens professionnels** (LinkedIn, GitHub, Portfolio)
- ✅ **Sections dynamiques** (formations, expériences)
- ✅ **Sauvegarde** en temps réel
- ✅ **Design responsive**

**URL d'accès :** http://localhost/profil-candidat

**Prêt à utiliser ! 🚀** 