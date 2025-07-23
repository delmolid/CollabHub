<?php
/**
 * Template pour le profil candidat
 * Utilisé par le shortcode [collabhub_profil_candidat]
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="profil-candidat">
    <form id="profil-candidat-form" method="post">
        <?php wp_nonce_field('collabhub_nonce', 'collabhub_nonce'); ?>
        
        <!-- En-tête avec photo de profil -->
        <div class="profil-header">
            <div class="photo-profil">
                <?php if (isset($candidat_data['picture']) && !empty($candidat_data['picture'])): ?>
                    <img src="<?php echo esc_url($candidat_data['picture']); ?>" alt="Photo de profil">
                <?php else: ?>
                    <i class="user-icon">👤</i>
                <?php endif; ?>
            </div>
            <div class="photo-actions">
                <button type="button" class="btn btn-primary" id="add-photo">Ajouter une photo de profil</button>
                <button type="button" class="btn" id="modify-photo">Modifier votre photo de profil</button>
            </div>
        </div>

        <!-- Section Informations personnelles -->
        <div class="profil-section">
            <h2 class="section-title">
                <i>👤</i>
                Informations personnelles
            </h2>

            <div class="form-group">
                <label for="firstName">Prénom</label>
                <input type="text" 
                       id="firstName" 
                       name="firstName" 
                       class="form-control" 
                       placeholder="Saisissez votre prénom"
                       value="<?php echo isset($candidat_data['firstName']) ? esc_html($candidat_data['firstName']) : ''; ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="lastName">Nom</label>
                <input type="text" 
                       id="lastName" 
                       name="lastName" 
                       class="form-control" 
                       placeholder="Saisissez votre nom"
                       value="<?php echo isset($candidat_data['lastName']) ? esc_html($candidat_data['lastName']) : ''; ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="nom@email.com"
                       value="<?php echo isset($candidat_data['email']) ? esc_html($candidat_data['email']) : ''; ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       class="form-control" 
                       placeholder="Saisissez votre numéro de téléphone"
                       value="<?php echo isset($candidat_data['phone']) ? esc_html($candidat_data['phone']) : ''; ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="dateBirth">Date de naissance</label>
                <input type="date" 
                       id="dateBirth" 
                       name="dateBirth" 
                       class="form-control"
                       value="<?php echo isset($candidat_data['dateBirth']) ? date('Y-m-d', strtotime($candidat_data['dateBirth'])) : ''; ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" 
                       id="address" 
                       name="address" 
                       class="form-control" 
                       placeholder="Saisissez votre adresse"
                       value="<?php echo isset($candidat_data['address']) ? collabhub_esc_html($candidat_data['address']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="description">Formation</label>
                <input type="text" 
                       id="formation" 
                       name="formation" 
                       class="form-control" 
                       placeholder="Saisissez votre formation"
                       value="">
            </div>
        </div>

        <!-- Section Liens professionnels -->
        <div class="profil-section">
            <h2 class="section-title">Liens professionnels</h2>

            <div class="form-group">
                <label for="linkLinkedin">LinkedIn</label>
                <input type="url" 
                       id="linkLinkedin" 
                       name="linkLinkedin" 
                       class="form-control" 
                       placeholder="Lien URL LinkedIn"
                       value="<?php echo isset($candidat_data['linkLinkedin']) ? esc_url($candidat_data['linkLinkedin']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="linkGithub">GitHub</label>
                <input type="url" 
                       id="linkGithub" 
                       name="linkGithub" 
                       class="form-control" 
                       placeholder="Lien URL GitHub"
                       value="<?php echo isset($candidat_data['linkGithub']) ? esc_url($candidat_data['linkGithub']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="linkPortfolio">Portfolio</label>
                <input type="url" 
                       id="linkPortfolio" 
                       name="linkPortfolio" 
                       class="form-control" 
                       placeholder="Lien URL portfolio"
                       value="<?php echo isset($candidat_data['linkPortfolio']) ? esc_url($candidat_data['linkPortfolio']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="interests">Objectifs professionnels</label>
                <textarea id="interests" 
                          name="interests" 
                          class="form-control" 
                          rows="3"
                          placeholder="Vos objets"><?php echo isset($candidat_data['interests']) ? esc_html($candidat_data['interests']) : ''; ?></textarea>
            </div>
        </div>

        <!-- Section Études et formations passées -->
        <div class="profil-section">
            <div class="section-box">
                <h3>Études et formations passées</h3>
                <div class="add-item-container">
                    <a href="#" class="add-item">+ Ajouter une formation</a>
                </div>
                <div id="formations-list">
                    <!-- Les formations seront ajoutées dynamiquement ici -->
                </div>
            </div>
        </div>

        <!-- Section Expériences professionnelles -->
        <div class="profil-section">
            <div class="section-box">
                <h3>Expériences professionnelles</h3>
                <div class="add-item-container">
                    <a href="#" class="add-item">+ Ajouter une expérience</a>
                </div>
                <div id="experiences-list">
                    <!-- Les expériences seront ajoutées dynamiquement ici -->
                </div>
            </div>
        </div>

        <!-- Section Langues et centres d'intérêt -->
        <div class="profil-section">
            <div class="section-box">
                <h3>Langues et centres d'intérêt</h3>
                
                <div class="form-group">
                    <a href="#" class="add-item">+ Ajouter une langue</a>
                    <div class="language-selection">
                        <label for="language">Langue principale</label>
                        <select id="language" name="language" class="form-control" required>
                            <option value="">Sélectionnez une langue</option>
                            <?php 
                            $languages = collabhub_get_languages();
                            $selected_language = isset($candidat_data['language']) ? $candidat_data['language'] : '';
                            foreach ($languages as $code => $name): 
                            ?>
                                <option value="<?php echo $code; ?>" <?php selected($selected_language, $code); ?>>
                                    <?php echo $name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="centers-interest">Centres d'intérêt :</label>
                    <input type="text" 
                           id="centers-interest" 
                           name="centers-interest" 
                           class="form-control" 
                           placeholder="Précisez vos centres d'intérêt"
                           value="">
                </div>
            </div>
        </div>

        <!-- Champs cachés pour données complètes -->
        <input type="hidden" name="description" id="description" value="<?php echo isset($candidat_data['description']) ? esc_html($candidat_data['description']) : ''; ?>">
        <input type="hidden" name="cv" id="cv" value="<?php echo isset($candidat_data['cv']) ? esc_url($candidat_data['cv']) : ''; ?>">
        <input type="hidden" name="picture" id="picture" value="<?php echo isset($candidat_data['picture']) ? esc_url($candidat_data['picture']) : ''; ?>">
        
        <?php if (isset($candidat_data['id'])): ?>
            <input type="hidden" name="candidat_id" value="<?php echo intval($candidat_data['id']); ?>">
        <?php endif; ?>

        <!-- Actions -->
        <div class="profil-actions">
            <button type="submit" class="btn-save" id="save-profil">
                <span class="save-text">Enregistrer</span>
                <span class="loading" style="display: none;"></span>
            </button>
        </div>
    </form>

    <!-- Messages de retour -->
    <div id="message-container"></div>
</div>

<script>
jQuery(document).ready(function($) {
    // Gestion de la soumission du formulaire
    $('#profil-candidat-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $saveBtn = $('#save-profil');
        var $saveText = $('.save-text');
        var $loading = $('.loading');
        
        // Afficher le loading
        $saveBtn.prop('disabled', true);
        $saveText.hide();
        $loading.show();
        
        // Préparer les données
        var formData = {
            action: 'save_candidat',
            nonce: collabhub_ajax.nonce,
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            dateBirth: $('#dateBirth').val(),
            address: $('#address').val(),
            description: $('#interests').val(), // Utiliser interests comme description
            linkLinkedin: $('#linkLinkedin').val(),
            linkGithub: $('#linkGithub').val(),
            linkPortfolio: $('#linkPortfolio').val(),
            language: $('#language').val(),
            interests: $('#interests').val(),
            cv: $('#cv').val(),
            picture: $('#picture').val()
        };
        
        // Ajouter l'ID si c'est une mise à jour
        var candidatId = $('input[name="candidat_id"]').val();
        if (candidatId) {
            formData.candidat_id = candidatId;
        }
        
        // Envoyer la requête AJAX
        $.post(collabhub_ajax.ajax_url, formData)
            .done(function(response) {
                if (response.error) {
                    showMessage('Erreur: ' + response.error, 'error');
                } else {
                    showMessage('Profil sauvegardé avec succès !', 'success');
                    
                    // Si c'est une création, rediriger vers l'édition
                    if (!candidatId && response.data && response.data.id) {
                        setTimeout(function() {
                            window.location.href = '?id=' + response.data.id;
                        }, 1500);
                    }
                }
            })
            .fail(function() {
                showMessage('Erreur de connexion. Veuillez réessayer.', 'error');
            })
            .always(function() {
                // Masquer le loading
                $saveBtn.prop('disabled', false);
                $saveText.show();
                $loading.hide();
            });
    });
    
    // Fonction pour afficher les messages
    function showMessage(message, type) {
        var $container = $('#message-container');
        var $message = $('<div class="message ' + type + '">' + message + '</div>');
        
        $container.empty().append($message);
        
        // Faire défiler vers le message
        $('html, body').animate({
            scrollTop: $container.offset().top - 100
        }, 500);
        
        // Masquer après 5 secondes pour les messages de succès
        if (type === 'success') {
            setTimeout(function() {
                $message.fadeOut();
            }, 5000);
        }
    }
    
    // Gestion de l'upload de photo (placeholder)
    $('#add-photo, #modify-photo').on('click', function(e) {
        e.preventDefault();
        showMessage('Fonctionnalité d\'upload de photo à implémenter', 'info');
    });
    
    // Gestion des formations et expériences (placeholder)
    $('.add-item').on('click', function(e) {
        e.preventDefault();
        showMessage('Fonctionnalité d\'ajout à implémenter', 'info');
    });
});
</script> 