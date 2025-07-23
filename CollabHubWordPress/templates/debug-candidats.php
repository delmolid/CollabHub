<?php
/**
 * Template de DEBUG pour les candidats
 */

if (!defined('ABSPATH')) {
    exit;
}

echo "<h2>🔍 DEBUG - Liste des candidats</h2>";

// Test PHP
echo "<p><strong>✅ PHP fonctionne !</strong></p>";

// Vérifier la variable candidats
if (isset($candidats)) {
    echo "<p><strong>✅ Variable \$candidats existe</strong></p>";
    echo "<p>Nombre de candidats : <strong>" . count($candidats) . "</strong></p>";
    
    if (!empty($candidats)) {
        echo "<h3>📋 Données candidats :</h3>";
        echo "<div style='background:#f0f0f0; padding:10px; margin:10px 0;'>";
        
        foreach ($candidats as $index => $candidat) {
            echo "<div style='border:1px solid #ccc; margin:5px; padding:10px;'>";
            echo "<h4>Candidat " . ($index + 1) . ":</h4>";
            echo "<p><strong>Nom:</strong> " . esc_html($candidat['firstName'] ?? 'N/A') . " " . esc_html($candidat['lastName'] ?? 'N/A') . "</p>";
            echo "<p><strong>Email:</strong> " . esc_html($candidat['email'] ?? 'N/A') . "</p>";
            echo "<p><strong>Téléphone:</strong> " . esc_html($candidat['phone'] ?? 'N/A') . "</p>";
            echo "<p><strong>Langue:</strong> " . esc_html($candidat['language'] ?? 'N/A') . "</p>";
            echo "</div>";
        }
        
        echo "</div>";
    } else {
        echo "<p><strong>❌ Le tableau \$candidats est vide</strong></p>";
    }
} else {
    echo "<p><strong>❌ Variable \$candidats n'existe pas</strong></p>";
}

// Test API direct
echo "<h3>🔗 Test API direct :</h3>";
$api_url = 'http://host.docker.internal:8080/api/v1/candidat';
$response = wp_remote_get($api_url, array('timeout' => 30));

if (is_wp_error($response)) {
    echo "<p><strong>❌ Erreur API:</strong> " . $response->get_error_message() . "</p>";
} else {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if ($data && isset($data['data'])) {
        echo "<p><strong>✅ API accessible</strong> - " . count($data['data']) . " candidat(s) trouvé(s)</p>";
    } else {
        echo "<p><strong>❌ Erreur parsing JSON</strong></p>";
        echo "<pre>" . esc_html($body) . "</pre>";
    }
}
?>

<style>
h2, h3 { color: #2c3e50; }
p { margin: 5px 0; }
.debug-section { margin: 20px 0; padding: 15px; background: #ecf0f1; border-radius: 5px; }
</style> 