#!/bin/bash

# 🌐 Script de démarrage CollabHub WordPress Frontend
echo "🌐 Démarrage de CollabHub WordPress Frontend..."
echo "=============================================="

# Vérifier que Docker est lancé
if ! docker info > /dev/null 2>&1; then
    echo "❌ Erreur: Docker n'est pas lancé"
    echo "   Veuillez démarrer Docker Desktop et réessayer"
    exit 1
fi

# Vérifier que nous sommes dans le bon répertoire
if [ ! -f "docker-compose.yml" ]; then
    echo "❌ Erreur: docker-compose.yml non trouvé"
    echo "   Assurez-vous d'être dans le dossier CollabHubWordPress"
    exit 1
fi

# Vérifier que l'API backend est accessible
echo "🔍 Vérification de l'API backend..."
if ! curl -s http://localhost:8080/health > /dev/null 2>&1; then
    echo "⚠️  L'API backend n'est pas accessible sur localhost:8080"
    echo "   Assurez-vous de démarrer le backend d'abord :"
    echo "   cd ../CollabHubBackEnd && ./start.sh"
    echo ""
    read -p "Continuer quand même ? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

echo "🐳 Construction et démarrage de WordPress..."
docker-compose up -d --build

echo ""
echo "⏳ Attente que les services soient prêts..."

# Attendre que MySQL soit prêt
echo "   - MySQL..."
until docker-compose exec -T mysql mysqladmin ping -h localhost --silent > /dev/null 2>&1; do
    sleep 2
done
echo "   ✅ MySQL prêt"

# Attendre que WordPress soit prêt
echo "   - WordPress..."
until curl -s http://localhost > /dev/null 2>&1; do
    sleep 2
done
echo "   ✅ WordPress prêt"

echo ""
echo "🎉 WordPress CollabHub lancé avec succès !"
echo "=========================================="
echo ""
echo "🌐 Frontend WordPress : http://localhost"
echo "📝 Profil candidat   : http://localhost/profil-candidat"
echo "👥 Liste candidats   : http://localhost/candidats"
echo "⚙️  WordPress Admin   : http://localhost/wp-admin"
echo ""
echo "🔧 Commandes utiles :"
echo "   docker-compose ps              # État des services"
echo "   docker-compose logs            # Voir tous les logs"
echo "   docker-compose logs wordpress  # Logs WordPress"
echo "   docker-compose down            # Arrêter WordPress"
echo ""
echo "📋 Prérequis :"
echo "   🐹 Backend API doit être lancé sur localhost:8080"
echo "   📊 PostgreSQL doit être accessible sur localhost:5432"
echo ""
echo "🚀 Prêt à utiliser ! Ouvrez http://localhost dans votre navigateur" 