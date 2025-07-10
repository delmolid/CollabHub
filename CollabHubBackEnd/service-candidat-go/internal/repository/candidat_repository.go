package repository

import (
	"service-candidat-go/internal/model"

	"gorm.io/gorm"
)

// CandidatRepository interface simplifiée pour commencer
type CandidatRepository interface {
	FindAll() ([]*model.Candidat, error)
	// TODO: Ajouter les autres méthodes progressivement
	FindByID(id uint) (*model.Candidat, error)
	Create(candidat *model.Candidat) error
	Update(candidat *model.Candidat) error
	Delete(id uint) error
	FindByEmail(email string) (*model.Candidat, error)
	FindByPhone(phone string) (*model.Candidat, error)
	ExistsByEmail(email string) (bool, error)
	ExistsByPhone(phone string) (bool, error)
	ExistsByLinkLinkedin(linkLinkedin string) (bool, error)
	ExistsByLinkGithub(linkGithub string) (bool, error)
}

// candidatRepository implémente CandidatRepository
type candidatRepository struct {
	db *gorm.DB
}

// NewCandidatRepository crée une nouvelle instance du repository
func NewCandidatRepository(db *gorm.DB) CandidatRepository {
	return &candidatRepository{
		db: db,
	}
}

// FindAll retourne tous les candidats
func (r *candidatRepository) FindAll() ([]*model.Candidat, error) {
	var candidats []*model.Candidat
	err := r.db.Order("created_at DESC").Find(&candidats).Error
	return candidats, err
}

// Méthodes temporaires (à implémenter progressivement)
func (r *candidatRepository) FindByID(id uint) (*model.Candidat, error) {
	// TODO: Implémenter
	return nil, nil
}

func (r *candidatRepository) Create(candidat *model.Candidat) error {
	// TODO: Implémenter
	return nil
}

func (r *candidatRepository) Update(candidat *model.Candidat) error {
	// TODO: Implémenter
	return nil
}

func (r *candidatRepository) Delete(id uint) error {
	// TODO: Implémenter
	return nil
}

func (r *candidatRepository) FindByEmail(email string) (*model.Candidat, error) {
	// TODO: Implémenter
	return nil, nil
}

func (r *candidatRepository) FindByPhone(phone string) (*model.Candidat, error) {
	// TODO: Implémenter
	return nil, nil
}

func (r *candidatRepository) ExistsByEmail(email string) (bool, error) {
	// TODO: Implémenter
	return false, nil
}

func (r *candidatRepository) ExistsByPhone(phone string) (bool, error) {
	// TODO: Implémenter
	return false, nil
}

func (r *candidatRepository) ExistsByLinkLinkedin(linkLinkedin string) (bool, error) {
	// TODO: Implémenter
	return false, nil
}

func (r *candidatRepository) ExistsByLinkGithub(linkGithub string) (bool, error) {
	// TODO: Implémenter
	return false, nil
}
