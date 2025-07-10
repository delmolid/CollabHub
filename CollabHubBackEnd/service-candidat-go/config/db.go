package config

import (
	"fmt"
	"log"
	"time"

	"gorm.io/driver/postgres"
	"gorm.io/gorm"
	"gorm.io/gorm/logger"
)

var DB *gorm.DB

// InitDatabase initialise la connexion à la base de données
func InitDatabase(config *Config) (*gorm.DB, error) {
	// Configuration du logger GORM
	gormConfig := &gorm.Config{
		Logger: logger.Default.LogMode(logger.Info),
		NowFunc: func() time.Time {
			return time.Now().UTC()
		},
	}

	// Connexion à PostgreSQL
	dsn := config.GetDatabaseURL()
	db, err := gorm.Open(postgres.Open(dsn), gormConfig)
	if err != nil {
		return nil, fmt.Errorf("erreur de connexion à la base de données: %w", err)
	}

	// Configuration du pool de connexions
	sqlDB, err := db.DB()
	if err != nil {
		return nil, fmt.Errorf("erreur lors de la récupération de la DB SQL: %w", err)
	}

	// Configuration des connexions
	sqlDB.SetMaxIdleConns(10)           // Connexions inactives max
	sqlDB.SetMaxOpenConns(100)          // Connexions ouvertes max
	sqlDB.SetConnMaxLifetime(time.Hour) // Durée de vie max d'une connexion

	// Test de la connexion
	if err := sqlDB.Ping(); err != nil {
		return nil, fmt.Errorf("impossible de ping la base de données: %w", err)
	}

	log.Println("✅ Connexion à la base de données PostgreSQL établie")
	log.Printf("📋 Base de données: %s:%d/%s", config.Database.Host, config.Database.Port, config.Database.DBName)

	DB = db
	return db, nil
}

// CloseDatabase ferme la connexion à la base de données
func CloseDatabase() error {
	if DB != nil {
		sqlDB, err := DB.DB()
		if err != nil {
			return err
		}
		return sqlDB.Close()
	}
	return nil
}

// GetDB retourne l'instance de la base de données
func GetDB() *gorm.DB {
	return DB
}

// HealthCheck vérifie l'état de la base de données
func HealthCheck() error {
	if DB == nil {
		return fmt.Errorf("base de données non initialisée")
	}

	sqlDB, err := DB.DB()
	if err != nil {
		return fmt.Errorf("erreur lors de la récupération de la DB SQL: %w", err)
	}

	if err := sqlDB.Ping(); err != nil {
		return fmt.Errorf("ping de la base de données échoué: %w", err)
	}

	return nil
}
