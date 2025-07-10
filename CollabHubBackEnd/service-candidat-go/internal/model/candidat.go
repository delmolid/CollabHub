package model

import (
	"time"
)

// Language représente l'énumération des langues (équivalent de votre enum Java)
type Language string

const (
	LanguageFrench  Language = "FRENCH"
	LanguageEnglish Language = "ENGLISH"
	LanguageSpanish Language = "SPANISH"
	LanguageGerman  Language = "GERMAN"
)

// Candidat représente la structure d'un candidat (équivalent exact de votre entité Java)
type Candidat struct {
	ID            uint      `json:"id" gorm:"primaryKey;autoIncrement"`                               // @Id @GeneratedValue
	FirstName     string    `json:"firstName" gorm:"column:first_name;type:varchar(250);not null"`    // @NotBlank @Column(name = "first_name", length = 250)
	LastName      string    `json:"lastName" gorm:"column:last_name;type:varchar(250);not null"`      // @NotBlank @Column(name = "last_name", length = 250)
	Email         string    `json:"email" gorm:"column:email;type:varchar(250);uniqueIndex;not null"` // @NotBlank @Email @Column(unique = true, length = 250)
	Phone         string    `json:"phone" gorm:"column:phone;type:varchar(250);uniqueIndex;not null"` // @NotBlank @Column(unique = true, length = 250)
	Picture       *string   `json:"picture" gorm:"column:picture;type:varchar(1000)"`                 // @Column(length = 1000) - nullable
	DateBirth     time.Time `json:"dateBirth" gorm:"column:date_birth;not null"`                      // @Past @NotNull @Column(name = "date_birth")
	Address       *string   `json:"address" gorm:"column:adress"`                                     // @Column(name = "adress") - nullable (même faute que Java)
	LinkLinkedin  *string   `json:"linkLinkedin" gorm:"column:link_linkedin"`                         // @Column(name = "link_linkedin") - nullable
	Description   string    `json:"description" gorm:"column:description;type:text;not null"`         // @NotBlank @Column(name = "description")
	LinkGithub    *string   `json:"linkGithub" gorm:"column:link_github"`                             // @Column(name = "link_github") - nullable (convention PostgreSQL)
	LinkPortfolio *string   `json:"linkPortfolio" gorm:"column:link_portfolio"`                       // @Column(name = "link_portfolio") - nullable
	Language      Language  `json:"language" gorm:"column:language;type:varchar(255);not null"`       // @NotNull @Enumerated(EnumType.STRING)
	Interests     string    `json:"interests" gorm:"column:interests;type:text;not null"`             // @NotBlank @Column(name = "interests")
	CV            string    `json:"cv" gorm:"column:cv;type:varchar(500);not null"`                   // @NotBlank @Column(name = "cv")
	CreatedAt     time.Time `json:"createdAt" gorm:"column:created_at;autoCreateTime"`                // @Column(name = "created_at")
}

// TableName spécifie le nom de la table pour GORM (équivalent @Table(name = "candidat"))
func (Candidat) TableName() string {
	return "candidat"
}

// CandidatCreateRequest représente la structure pour créer un candidat
type CandidatCreateRequest struct {
	FirstName     string    `json:"firstName" binding:"required,min=1"`   // @NotBlank
	LastName      string    `json:"lastName" binding:"required,min=1"`    // @NotBlank
	Email         string    `json:"email" binding:"required,email"`       // @NotBlank @Email
	Phone         string    `json:"phone" binding:"required,min=1"`       // @NotBlank
	Picture       *string   `json:"picture"`                              // nullable
	DateBirth     time.Time `json:"dateBirth" binding:"required"`         // @Past @NotNull
	Address       *string   `json:"address"`                              // nullable
	LinkLinkedin  *string   `json:"linkLinkedin"`                         // nullable
	Description   string    `json:"description" binding:"required,min=1"` // @NotBlank
	LinkGithub    *string   `json:"linkGithub"`                           // nullable
	LinkPortfolio *string   `json:"linkPortfolio"`                        // nullable
	Language      Language  `json:"language" binding:"required"`          // @NotNull
	Interests     string    `json:"interests" binding:"required,min=1"`   // @NotBlank
	CV            string    `json:"cv" binding:"required,min=1"`          // @NotBlank
}

// CandidatResponse représente la réponse API pour un candidat
type CandidatResponse struct {
	ID            uint      `json:"id"`
	FirstName     string    `json:"firstName"`
	LastName      string    `json:"lastName"`
	Email         string    `json:"email"`
	Phone         string    `json:"phone"`
	Picture       *string   `json:"picture"`
	DateBirth     time.Time `json:"dateBirth"`
	Address       *string   `json:"address"`
	LinkLinkedin  *string   `json:"linkLinkedin"`
	Description   string    `json:"description"`
	LinkGithub    *string   `json:"linkGithub"`
	LinkPortfolio *string   `json:"linkPortfolio"`
	Language      Language  `json:"language"`
	Interests     string    `json:"interests"`
	CV            string    `json:"cv"`
	CreatedAt     time.Time `json:"createdAt"`
}

// ToResponse convertit un Candidat en CandidatResponse
func (c *Candidat) ToResponse() *CandidatResponse {
	return &CandidatResponse{
		ID:            c.ID,
		FirstName:     c.FirstName,
		LastName:      c.LastName,
		Email:         c.Email,
		Phone:         c.Phone,
		Picture:       c.Picture,
		DateBirth:     c.DateBirth,
		Address:       c.Address,
		LinkLinkedin:  c.LinkLinkedin,
		Description:   c.Description,
		LinkGithub:    c.LinkGithub,
		LinkPortfolio: c.LinkPortfolio,
		Language:      c.Language,
		Interests:     c.Interests,
		CV:            c.CV,
		CreatedAt:     c.CreatedAt,
	}
}

// FromCreateRequest crée un Candidat à partir d'une CandidatCreateRequest
func (c *Candidat) FromCreateRequest(req *CandidatCreateRequest) {
	c.FirstName = req.FirstName
	c.LastName = req.LastName
	c.Email = req.Email
	c.Phone = req.Phone
	c.Picture = req.Picture
	c.DateBirth = req.DateBirth
	c.Address = req.Address
	c.LinkLinkedin = req.LinkLinkedin
	c.Description = req.Description
	c.LinkGithub = req.LinkGithub
	c.LinkPortfolio = req.LinkPortfolio
	c.Language = req.Language
	c.Interests = req.Interests
	c.CV = req.CV
}

// Méthodes utilitaires (équivalent des getters/setters Java)

// GetID retourne l'ID du candidat
func (c *Candidat) GetID() uint {
	return c.ID
}

// GetFullName retourne le nom complet du candidat
func (c *Candidat) GetFullName() string {
	return c.FirstName + " " + c.LastName
}

// HasPicture vérifie si le candidat a une photo
func (c *Candidat) HasPicture() bool {
	return c.Picture != nil && *c.Picture != ""
}

// HasAddress vérifie si le candidat a une adresse
func (c *Candidat) HasAddress() bool {
	return c.Address != nil && *c.Address != ""
}

// HasLinkedIn vérifie si le candidat a un profil LinkedIn
func (c *Candidat) HasLinkedIn() bool {
	return c.LinkLinkedin != nil && *c.LinkLinkedin != ""
}

// HasGitHub vérifie si le candidat a un profil GitHub
func (c *Candidat) HasGitHub() bool {
	return c.LinkGithub != nil && *c.LinkGithub != ""
}

// HasPortfolio vérifie si le candidat a un portfolio
func (c *Candidat) HasPortfolio() bool {
	return c.LinkPortfolio != nil && *c.LinkPortfolio != ""
}

// IsValidLanguage vérifie si la langue est valide
func IsValidLanguage(lang string) bool {
	switch Language(lang) {
	case LanguageFrench, LanguageEnglish, LanguageSpanish, LanguageGerman:
		return true
	default:
		return false
	}
}
