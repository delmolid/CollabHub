package routes

import (
	"service-candidat-go/internal/controller"
	"service-candidat-go/internal/repository"
	"service-candidat-go/internal/service"

	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

// SetupRoutes configure toutes les routes de l'application
func SetupRoutes(router *gin.Engine, db *gorm.DB) {
	// Initialiser les couches (Repository -> Service -> Controller)
	candidatRepo := repository.NewCandidatRepository(db)
	candidatService := service.NewCandidatService(candidatRepo)
	candidatController := controller.NewCandidatController(candidatService)

	// Routes de santé et test
	router.GET("/health", HealthCheck)
	router.GET("/ping", Ping)

	// Groupe API v1
	v1 := router.Group("/api/v1")
	{
		// Routes pour les candidats
		candidats := v1.Group("/candidat")
		{
			candidats.GET("", candidatController.GetAllCandidats) // GET /api/v1/candidat
			// candidats.GET("/:id", candidatController.GetCandidatByID)   // GET /api/v1/candidat/:id
			// candidats.POST("", candidatController.CreateCandidat)       // POST /api/v1/candidat
			// candidats.PUT("/:id", candidatController.UpdateCandidat)    // PUT /api/v1/candidat/:id
			// candidats.DELETE("/:id", candidatController.DeleteCandidat) // DELETE /api/v1/candidat/:id
		}
	}

	// Routes futures (à décommenter quand nécessaire)
	// v2 := router.Group("/api/v2")
	// {
	//     // Nouvelles versions des APIs
	// }
}

// HealthCheck vérifie l'état de santé de l'application
func HealthCheck(c *gin.Context) {
	c.JSON(200, gin.H{
		"status":  "healthy",
		"service": "service-candidat-go",
		"version": "1.0.0",
		"timestamp": gin.H{
			"unix": gin.H{},
		},
	})
}

// Ping endpoint de test simple
func Ping(c *gin.Context) {
	c.JSON(200, gin.H{
		"message": "pong",
		"service": "service-candidat-go",
	})
}
