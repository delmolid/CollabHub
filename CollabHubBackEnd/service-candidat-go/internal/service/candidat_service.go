package service

import (
	"fmt"
	"service-candidat-go/internal/model"
	"service-candidat-go/internal/repository"
)

// CandidatService interface définit les méthodes du service (équivalent de votre service Java)
type CandidatService interface {
	// Méthode principale pour commencer
	FindAll() ([]*model.CandidatResponse, error)
}

// candidatService implémente CandidatService
type candidatService struct {
	candidatRepo repository.CandidatRepository
}

// NewCandidatService crée une nouvelle instance du service
func NewCandidatService(candidatRepo repository.CandidatRepository) CandidatService {
	return &candidatService{
		candidatRepo: candidatRepo,
	}
}

// FindAll retourne tous les candidats (équivalent de votre méthode Java)
func (s *candidatService) FindAll() ([]*model.CandidatResponse, error) {
	// Récupérer tous les candidats depuis le repository
	candidats, err := s.candidatRepo.FindAll()
	if err != nil {
		return nil, fmt.Errorf("erreur lors de la récupération des candidats: %w", err)
	}

	// Convertir les entités en réponses DTO
	responses := make([]*model.CandidatResponse, len(candidats))
	for i, candidat := range candidats {
		responses[i] = candidat.ToResponse()
	}

	return responses, nil
}
