    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>CollabHub</h3>
                <p>Plateforme de gestion des candidats et recruteurs</p>
            </div>
            
            <div class="footer-section">
                <h4>Liens rapides</h4>
                <ul>
                    <li><a href="<?php echo home_url(); ?>">Accueil</a></li>
                    <li><a href="/candidats">Candidats</a></li>
                    <li><a href="/profil-candidat">Créer un profil</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>API Status</h4>
                <div id="api-status">
                    <span class="status-indicator">Vérification...</span>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> CollabHub. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
    jQuery(document).ready(function($) {
        // Vérifier le statut de l'API
        $.get(collabhub_ajax.api_base_url.replace('/api/v1', '') + '/health')
            .done(function(response) {
                $('#api-status').html('<span class="status-indicator success">✅ API Opérationnelle</span>');
            })
            .fail(function() {
                $('#api-status').html('<span class="status-indicator error">❌ API Indisponible</span>');
            });
    });
    </script>

    <?php wp_footer(); ?>
</body>
</html> 