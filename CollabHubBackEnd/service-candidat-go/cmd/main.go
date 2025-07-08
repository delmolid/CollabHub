package main

import (
	"log"
	"service-candidat-go/config"
	"service-candidat-go/internal/model"
	"service-candidat-go/routes"

	"github.com/gin-gonic/gin"
	"github.com/joho/godotenv"
)

func main() {
	// Charger le fichier .env
	if err := godotenv.Load(); err != nil {
		log.Println("⚠️ Fichier .env non trouvé")
	}

	// Charger la configuration
	cfg, err := config.Load()
	if err != nil {
		log.Fatal("❌ Erreur configuration:", err)
	}

	// Initialiser la base de données
	db, err := config.InitDatabase(cfg)
	if err != nil {
		log.Fatal("❌ Erreur DB:", err)
	}
	defer config.CloseDatabase()

	// Auto-migration (création automatique des tables)
	log.Println("🔄 Démarrage de l'auto-migration...")
	if err := db.AutoMigrate(&model.Candidat{}); err != nil {
		log.Fatal("❌ Erreur migration:", err)
	}
	log.Println("✅ Migration des tables réussie")

	// Configurer Gin
	gin.SetMode(gin.DebugMode)
	router := gin.Default()

	// Configurer les routes
	routes.SetupRoutes(router, db)

	// Démarrer le serveur
	address := cfg.GetServerAddress()
	log.Printf("🚀 Serveur démarré sur %s", address)
	log.Printf("📋 API: http://localhost%s/api/v1/candidat", address)
	log.Printf("🏥 Health: http://localhost%s/health", address)

	if err := router.Run(address); err != nil {
		log.Fatal("❌ Erreur serveur:", err)
	}
}
