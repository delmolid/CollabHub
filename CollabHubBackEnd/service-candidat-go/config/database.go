package config

import (
	"os"
	"strconv"
	"time"
)

type Config struct {
	// Base de données
	Database DatabaseConfig `json:"database"`

	// Serveur
	Server ServerConfig `json:"server"`
}

type DatabaseConfig struct {
	Host     string `json:"host"`
	Port     int    `json:"port"`
	User     string `json:"user"`
	Password string `json:"password"`
	DBName   string `json:"db_name"`
	SSLMode  string `json:"ssl_mode"`
	URL      string `json:"url"`
}

type ServerConfig struct {
	Port         int           `json:"port"`
	ReadTimeout  time.Duration `json:"read_timeout"`
	WriteTimeout time.Duration `json:"write_timeout"`
	IdleTimeout  time.Duration `json:"idle_timeout"`
}

// Load charge la configuration depuis les variables d'environnement
func Load() (*Config, error) {
	config := &Config{
		Database: DatabaseConfig{
			Host:     getEnv("DB_HOST", "localhost"),
			Port:     getIntEnv("DB_PORT", 5432),
			User:     getEnv("DB_USERNAME", "postgres"),
			Password: getEnv("DB_PASSWORD", "password"),
			DBName:   getEnv("DB_NAME", "candidat"),
			SSLMode:  getEnv("DB_SSL_MODE", "disable"),
			URL:      getEnv("DATABASE_URL", ""),
		},
		Server: ServerConfig{
			Port:         getIntEnv("SERVER_PORT", 8080),
			ReadTimeout:  30 * time.Second,
			WriteTimeout: 30 * time.Second,
			IdleTimeout:  60 * time.Second,
		},
	}

	return config, nil
}

// getEnv récupère une variable d'environnement avec valeur par défaut
func getEnv(key, defaultValue string) string {
	if value := os.Getenv(key); value != "" {
		return value
	}
	return defaultValue
}

// getIntEnv récupère une variable d'environnement entière avec valeur par défaut
func getIntEnv(key string, defaultValue int) int {
	if value := os.Getenv(key); value != "" {
		if intValue, err := strconv.Atoi(value); err == nil {
			return intValue
		}
	}
	return defaultValue
}

// GetDatabaseURL construit l'URL complète de la base de données
func (c *Config) GetDatabaseURL() string {
	if c.Database.URL != "" {
		return c.Database.URL
	}

	// Construction de l'URL PostgreSQL
	return "postgres://" +
		c.Database.User + ":" +
		c.Database.Password + "@" +
		c.Database.Host + ":" +
		strconv.Itoa(c.Database.Port) + "/" +
		c.Database.DBName +
		"?sslmode=" + c.Database.SSLMode
}

// GetServerAddress retourne l'adresse complète du serveur
func (c *Config) GetServerAddress() string {
	return ":" + strconv.Itoa(c.Server.Port)
}
