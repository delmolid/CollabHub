#!/bin/bash

# Script de démarrage pour CollabHub
# Usage: ./start.sh [build|up|down|logs|clean]

set -e

echo "🚀 CollabHub - Script de démarrage Docker"
echo "=========================================="

# Couleurs pour les logs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Fonction d'aide
show_help() {
    echo -e "${BLUE}Usage: $0 [OPTION]${NC}"
    echo ""
    echo "Options:"
    echo -e "  ${GREEN}build${NC}     Construire les images Docker"
    echo -e "  ${GREEN}up${NC}        Démarrer tous les services"
    echo -e "  ${GREEN}down${NC}      Arrêter tous les services"
    echo -e "  ${GREEN}logs${NC}      Afficher les logs de tous les services"
    echo -e "  ${GREEN}clean${NC}     Nettoyer les images et volumes Docker"
    echo -e "  ${GREEN}health${NC}    Vérifier l'état des services"
    echo -e "  ${GREEN}help${NC}      Afficher cette aide"
    echo ""
}

# Fonction pour vérifier que Docker est démarré
check_docker() {
    if ! docker info > /dev/null 2>&1; then
        echo -e "${RED}❌ Docker n'est pas démarré${NC}"
        exit 1
    fi
}

# Fonction de build
build_services() {
    echo -e "${YELLOW}🔨 Construction des images Docker...${NC}"
    docker-compose build --no-cache
    echo -e "${GREEN}✅ Images construites avec succès${NC}"
}

# Fonction de démarrage
start_services() {
    echo -e "${YELLOW}🚀 Démarrage des services...${NC}"
    docker-compose up -d
    echo ""
    echo -e "${GREEN}✅ Services démarrés avec succès !${NC}"
    echo ""
    echo -e "${BLUE}📋 URLs d'accès :${NC}"
    echo -e "  • Service Candidat (Go):   ${GREEN}http://localhost:8080${NC}"
    echo -e "  • Service Recruteur (Java): ${GREEN}http://localhost:8081${NC}"
    echo -e "  • PostgreSQL:               ${GREEN}localhost:5432${NC}"
    echo ""
    echo -e "${BLUE}🏥 Health checks :${NC}"
    echo -e "  • Candidat Health:   ${GREEN}http://localhost:8080/health${NC}"
    echo -e "  • Candidat API:      ${GREEN}http://localhost:8080/api/v1/candidat${NC}"
    echo ""
}

# Fonction d'arrêt
stop_services() {
    echo -e "${YELLOW}⏹️  Arrêt des services...${NC}"
    docker-compose down
    echo -e "${GREEN}✅ Services arrêtés${NC}"
}

# Fonction de logs
show_logs() {
    echo -e "${YELLOW}📋 Affichage des logs...${NC}"
    docker-compose logs -f
}

# Fonction de nettoyage
clean_docker() {
    echo -e "${YELLOW}🧹 Nettoyage Docker...${NC}"
    docker-compose down -v --rmi all --remove-orphans
    docker system prune -f
    echo -e "${GREEN}✅ Nettoyage terminé${NC}"
}

# Fonction de health check
health_check() {
    echo -e "${YELLOW}🏥 Vérification de l'état des services...${NC}"
    echo ""
    
    # Postgres
    if docker-compose ps postgres | grep -q "Up"; then
        echo -e "PostgreSQL:        ${GREEN}✅ En cours d'exécution${NC}"
    else
        echo -e "PostgreSQL:        ${RED}❌ Arrêté${NC}"
    fi
    
    # Service Candidat
    if docker-compose ps service-candidat | grep -q "Up"; then
        echo -e "Service Candidat:  ${GREEN}✅ En cours d'exécution${NC}"
        # Test API
        if curl -s http://localhost:8080/health > /dev/null; then
            echo -e "API Candidat:      ${GREEN}✅ Accessible${NC}"
        else
            echo -e "API Candidat:      ${YELLOW}⚠️  En cours de démarrage...${NC}"
        fi
    else
        echo -e "Service Candidat:  ${RED}❌ Arrêté${NC}"
    fi
    
    # Service Recruteur
    if docker-compose ps service-recruteur | grep -q "Up"; then
        echo -e "Service Recruteur: ${GREEN}✅ En cours d'exécution${NC}"
    else
        echo -e "Service Recruteur: ${RED}❌ Arrêté${NC}"
    fi
}

# Vérifier Docker
check_docker

# Traitement des arguments
case "$1" in
    build)
        build_services
        ;;
    up)
        start_services
        ;;
    down)
        stop_services
        ;;
    logs)
        show_logs
        ;;
    clean)
        clean_docker
        ;;
    health)
        health_check
        ;;
    help|--help|-h)
        show_help
        ;;
    "")
        echo -e "${YELLOW}🔨 Construction et démarrage complet...${NC}"
        build_services
        start_services
        ;;
    *)
        echo -e "${RED}❌ Option inconnue: $1${NC}"
        show_help
        exit 1
        ;;
esac 