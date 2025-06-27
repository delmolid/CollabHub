package controller

import (
	"fmt"
	"net/http"
	"service-candidat-go/internal/service"
	"time"

	"github.com/gin-gonic/gin"
)

// CandidatController gère les requêtes HTTP pour les candidats
type CandidatController struct {
	candidatService service.CandidatService
}

// NewCandidatController crée une nouvelle instance du controller
func NewCandidatController(candidatService service.CandidatService) *CandidatController {
	return &CandidatController{
		candidatService: candidatService,
	}
}

// GetAllCandidats récupère tous les candidats
// @Summary Récupère tous les candidats
// @Description Retourne la liste de tous les candidats
// @Tags candidats
// @Accept json
// @Produce json
// @Success 200 {array} model.CandidatResponse
// @Failure 500 {object} ErrorResponse
// @Router /api/v1/candidat [get]
func (ctrl *CandidatController) GetAllCandidats(c *gin.Context) {
	candidats, err := ctrl.candidatService.FindAll()
	if err != nil {
		c.JSON(http.StatusInternalServerError, ErrorResponse{
			Error:   "Erreur lors de la récupération des candidats",
			Message: err.Error(),
			Code:    "INTERNAL_ERROR",
		})
		return
	}

	c.JSON(http.StatusOK, SuccessResponse{
		Data:    candidats,
		Message: "Candidats récupérés avec succès",
		Count:   len(candidats),
	})
}

// SuccessResponse représente une réponse de succès
type SuccessResponse struct {
	Data    interface{} `json:"data"`
	Message string      `json:"message"`
	Count   int         `json:"count,omitempty"`
}

// ErrorResponse représente une réponse d'erreur
type ErrorResponse struct {
	Error   string `json:"error"`
	Message string `json:"message"`
	Code    string `json:"code"`
}

// generateRequestID génère un ID unique pour la requête
func generateRequestID() string {
	// Implémentation simple avec timestamp
	return fmt.Sprintf("req-%d", time.Now().UnixNano())
}
