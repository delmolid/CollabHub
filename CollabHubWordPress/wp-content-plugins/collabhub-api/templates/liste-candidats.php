<?php
/**
 * Template pour afficher la liste des candidats
 * Utilisé par le shortcode [collabhub_liste_candidats]
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="collabhub-candidats-list">
    <div class="candidats-header">
        <h2>🎯 Liste des Candidats</h2>
        <p class="candidats-count">
            <?php if (!empty($candidats)): ?>
                <strong><?php echo count($candidats); ?></strong> candidat(s) trouvé(s)
            <?php else: ?>
                Aucun candidat trouvé
            <?php endif; ?>
        </p>
    </div>

    <?php if (!empty($candidats)): ?>
        <div class="candidats-grid">
            <?php foreach ($candidats as $candidat): ?>
                <div class="candidat-card">
                    <!-- Photo -->
                    <div class="candidat-photo">
                        <?php if (!empty($candidat['picture'])): ?>
                            <img src="<?php echo esc_url($candidat['picture']); ?>" alt="Photo de <?php echo esc_html($candidat['firstName'] . ' ' . $candidat['lastName']); ?>">
                        <?php else: ?>
                            <div class="photo-placeholder">
                                <span class="initials"><?php echo substr($candidat['firstName'], 0, 1) . substr($candidat['lastName'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Infos principales -->
                    <div class="candidat-info">
                        <h3 class="candidat-name">
                            <?php echo esc_html($candidat['firstName'] . ' ' . $candidat['lastName']); ?>
                        </h3>
                        
                        <p class="candidat-email">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo esc_attr($candidat['email']); ?>"><?php echo esc_html($candidat['email']); ?></a>
                        </p>
                        
                        <p class="candidat-phone">
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?php echo esc_attr($candidat['phone']); ?>"><?php echo esc_html($candidat['phone']); ?></a>
                        </p>

                        <p class="candidat-language">
                            <i class="fas fa-globe"></i>
                            <?php
                            $languages = array(
                                'FRENCH' => 'Français',
                                'ENGLISH' => 'Anglais', 
                                'SPANISH' => 'Espagnol',
                                'GERMAN' => 'Allemand'
                            );
                            echo $languages[$candidat['language']] ?? $candidat['language'];
                            ?>
                        </p>
                    </div>

                    <!-- Description courte -->
                    <div class="candidat-description">
                        <p><?php echo wp_trim_words(esc_html($candidat['description']), 15, '...'); ?></p>
                    </div>

                    <!-- Liens sociaux -->
                    <div class="candidat-links">
                        <?php if (!empty($candidat['linkLinkedin'])): ?>
                            <a href="<?php echo esc_url($candidat['linkLinkedin']); ?>" target="_blank" title="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($candidat['linkGithub'])): ?>
                            <a href="<?php echo esc_url($candidat['linkGithub']); ?>" target="_blank" title="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($candidat['linkPortfolio'])): ?>
                            <a href="<?php echo esc_url($candidat['linkPortfolio']); ?>" target="_blank" title="Portfolio">
                                <i class="fas fa-globe-americas"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($candidat['cv'])): ?>
                            <a href="<?php echo esc_url($candidat['cv']); ?>" target="_blank" title="Télécharger CV">
                                <i class="fas fa-download"></i> CV
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="candidat-actions">
                        <a href="/profil-candidat?id=<?php echo $candidat['id']; ?>" class="btn-view">
                            <i class="fas fa-eye"></i> Voir le profil
                        </a>
                    </div>

                    <!-- Date de création -->
                    <div class="candidat-date">
                        <small><i class="fas fa-calendar"></i> Inscrit le <?php echo date('d/m/Y', strtotime($candidat['createdAt'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-candidats">
            <div class="empty-state">
                <i class="fas fa-users fa-3x"></i>
                <h3>Aucun candidat trouvé</h3>
                <p>Il semble qu'il n'y ait aucun candidat enregistré pour le moment.</p>
                <p><strong>Vérifiez :</strong></p>
                <ul>
                    <li>✅ Votre API backend est démarrée</li>
                    <li>✅ La base de données contient des candidats</li>
                    <li>✅ La connectivité réseau</li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.collabhub-candidats-list {
    padding: 20px 0;
}

.candidats-header {
    text-align: center;
    margin-bottom: 30px;
}

.candidats-header h2 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 2.2em;
}

.candidats-count {
    color: #7f8c8d;
    font-size: 1.1em;
}

.candidats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.candidat-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #ecf0f1;
}

.candidat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.candidat-photo {
    text-align: center;
    margin-bottom: 20px;
}

.candidat-photo img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #3498db;
}

.photo-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3498db, #2980b9);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 3px solid #3498db;
}

.initials {
    color: white;
    font-size: 24px;
    font-weight: bold;
}

.candidat-name {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 1.3em;
    text-align: center;
}

.candidat-info p {
    margin-bottom: 8px;
    color: #555;
}

.candidat-info i {
    width: 16px;
    color: #3498db;
    margin-right: 8px;
}

.candidat-description {
    margin: 15px 0;
    color: #666;
    font-style: italic;
}

.candidat-links {
    text-align: center;
    margin: 15px 0;
}

.candidat-links a {
    display: inline-block;
    margin: 0 8px;
    color: #3498db;
    font-size: 1.2em;
    transition: color 0.3s ease;
}

.candidat-links a:hover {
    color: #2980b9;
}

.candidat-actions {
    text-align: center;
    margin-top: 20px;
}

.btn-view {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-view:hover {
    background: linear-gradient(135deg, #2980b9, #1f5582);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.candidat-date {
    text-align: center;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #ecf0f1;
}

.candidat-date small {
    color: #95a5a6;
}

.no-candidats {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    color: #bdc3c7;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #7f8c8d;
    margin-bottom: 15px;
}

.empty-state ul {
    display: inline-block;
    text-align: left;
    color: #95a5a6;
    margin-top: 15px;
}

@media (max-width: 768px) {
    .candidats-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .candidat-card {
        padding: 20px;
    }
}
</style> 