<?php get_header(); ?>

<main class="main-content">
    <div class="container">
        <h1>Bienvenue sur CollabHub</h1>
        <p>Plateforme de gestion des candidats et recruteurs</p>
        
        <div class="quick-actions">
            <a href="/profil-candidat" class="btn btn-primary">Créer un profil candidat</a>
            <a href="/candidats" class="btn">Voir tous les candidats</a>
        </div>
        
        <!-- Affichage des derniers candidats -->
        <section class="recent-candidats">
            <h2>Derniers candidats inscrits</h2>
            <div id="recent-candidats-list">
                <div class="loading">Chargement...</div>
            </div>
        </section>
    </div>
</main>

<script>
jQuery(document).ready(function($) {
    // Charger les derniers candidats
    $.get(collabhub_ajax.ajax_url, {
        action: 'get_candidats',
        nonce: collabhub_ajax.nonce
    }).done(function(response) {
        var $container = $('#recent-candidats-list');
        
        if (response.error) {
            $container.html('<div class="message error">Erreur: ' + response.error + '</div>');
            return;
        }
        
        var candidats = response.data || [];
        
        if (candidats.length === 0) {
            $container.html('<p>Aucun candidat inscrit pour le moment.</p>');
            return;
        }
        
        var html = '<div class="candidats-grid">';
        candidats.slice(0, 6).forEach(function(candidat) {
            html += '<div class="candidat-card">';
            html += '<h3>' + candidat.firstName + ' ' + candidat.lastName + '</h3>';
            html += '<p>' + candidat.email + '</p>';
            if (candidat.description) {
                html += '<p class="description">' + candidat.description.substring(0, 100) + '...</p>';
            }
            html += '<a href="/profil-candidat?id=' + candidat.id + '" class="btn">Voir le profil</a>';
            html += '</div>';
        });
        html += '</div>';
        
        $container.html(html);
    }).fail(function() {
        $('#recent-candidats-list').html('<div class="message error">Erreur de connexion</div>');
    });
});
</script>

<?php get_footer(); ?> 