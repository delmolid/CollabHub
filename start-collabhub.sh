#!/bin/bash

# 🚀 Script de démarrage complet CollabHub
echo "🚀 Démarrage complet de l'environnement CollabHub"
echo "================================================="
echo ""
echo "Architecture :"
echo "   🐹 Backend API (Go + PostgreSQL)"
echo "   🌐 Frontend WordPress + MySQL"
echo "   📡 Communication via API REST"
echo ""

# Vérifier que Docker est lancé
if ! docker info > /dev/null 2>&1; then
    echo "❌ Erreur: Docker n'est pas lancé"
    echo "   Veuillez démarrer Docker Desktop et réessayer"
    exit 1
fi

# Fonction pour attendre qu'un service soit prêt
wait_for_service() {
    local service_name=$1
    local url=$2
    local max_attempts=30
    local attempt=1
    
    echo "   Attente de $service_name..."
    while [ $attempt -le $max_attempts ]; do
        if curl -s "$url" > /dev/null 2>&1; then
            echo "   ✅ $service_name prêt"
            return 0
        fi
        sleep 2
        attempt=$((attempt + 1))
    done
    
    echo "   ⚠️  $service_name non accessible après ${max_attempts} tentatives"
    return 1
}

# Étape 1 : Démarrer le Backend (API + PostgreSQL)
echo "📊 Étape 1/2 : Démarrage du Backend (API Go + PostgreSQL)"
echo "-------------------------------------------------------"
cd CollabHubBackEnd
./start.sh

if [ $? -ne 0 ]; then
    echo "❌ Erreur lors du démarrage du backend"
    exit 1
fi

cd ..

# Attendre que l'API soit complètement prête
wait_for_service "API Go" "http://localhost:8080/health"

# Étape 2 : Démarrer le Frontend WordPress
echo ""
echo "🌐 Étape 2/2 : Démarrage du Frontend WordPress"
echo "---------------------------------------------"
cd CollabHubWordPress
./start-wordpress.sh

if [ $? -ne 0 ]; then
    echo "❌ Erreur lors du démarrage de WordPress"
    exit 1
fi

cd ..

echo ""
echo "🎉 Environnement CollabHub complètement opérationnel !"
echo "====================================================="
echo ""
echo "🌐 Services disponibles :"
echo "   Frontend WordPress : http://localhost"
echo "   Backend API Go     : http://localhost:8080"
echo "   PostgreSQL         : localhost:5432"
echo "   MySQL WordPress    : localhost:3306"
echo ""
echo "🎯 Pages d'accès direct :"
echo "   📝 Profil candidat    : http://localhost/profil-candidat"
echo "   👥 Liste candidats    : http://localhost/candidats"
echo "   ⚙️  WordPress Admin    : http://localhost/wp-admin"
echo "   🔍 API Health Check   : http://localhost:8080/health"
echo ""
echo "🛠️  Gestion séparée :"
echo "   Backend  : cd CollabHubBackEnd && docker-compose [commande]"
echo "   Frontend : cd CollabHubWordPress && docker-compose [commande]"
echo ""
echo "🔧 Arrêter tout :"
echo "   cd CollabHubWordPress && docker-compose down"
echo "   cd CollabHubBackEnd && docker-compose down"
echo ""
echo "📚 Documentation :"
echo "   Backend  : ./CollabHubBackEnd/README.md"
echo "   Frontend : ./CollabHubWordPress/README.md"
echo ""
echo "🚀 Prêt ! Ouvrez http://localhost pour commencer" 