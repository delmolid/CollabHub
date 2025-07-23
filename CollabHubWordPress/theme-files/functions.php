<?php
/**
 * Functions.php pour le thème CollabHub
 * Gestion de l'intégration avec l'API Go backend
 */

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Configuration de l'API (connexion externe au backend)
define('COLLABHUB_API_BASE_URL', 'http://host.docker.internal:8080/api/v1');
define('COLLABHUB_RECRUTEUR_API_URL', 'http://host.docker.internal:8081/api/v1');

/**
 * Setup du thème
 */
function collabhub_theme_setup() {
    // Support des images à la une
    add_theme_support('post-thumbnails');
    
    // Support des menus
    add_theme_support('menus');
    
    // Enregistrer les menus
    register_nav_menus(array(
        'primary' => 'Menu Principal',
        'footer' => 'Menu Pied de page'
    ));
    
    // Support du titre dynamique
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'collabhub_theme_setup');

/**
 * Enqueue scripts et styles
 */
function collabhub_scripts() {
    // Style principal
    wp_enqueue_style('collabhub-style', get_stylesheet_uri());
    
    // jQuery (inclus dans WordPress)
    wp_enqueue_script('jquery');
    
    // Script principal pour les appels API
    wp_enqueue_script(
        'collabhub-api', 
        get_template_directory_uri() . '/js/collabhub-api.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Localiser les variables pour JavaScript
    wp_localize_script('collabhub-api', 'collabhub_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('collabhub_nonce'),
        'api_base_url' => COLLABHUB_API_BASE_URL
    ));
}
add_action('wp_enqueue_scripts', 'collabhub_scripts');

/**
 * Classe pour gérer les appels API vers le backend Go
 */
class CollabHub_API {
    
    private static $base_url = COLLABHUB_API_BASE_URL;
    
    /**
     * Récupérer tous les candidats
     */
    public static function get_candidats() {
        $response = wp_remote_get(self::$base_url . '/candidat', array(
            'timeout' => 30,
            'headers' => array(
                'Content-Type' => 'application/json'
            )
        ));
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        return $data;
    }
    
    /**
     * Récupérer un candidat par ID
     */
    public static function get_candidat($id) {
        $response = wp_remote_get(self::$base_url . '/candidat/' . $id, array(
            'timeout' => 30,
            'headers' => array(
                'Content-Type' => 'application/json'
            )
        ));
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        return $data;
    }
    
    /**
     * Créer un nouveau candidat
     */
    public static function create_candidat($data) {
        $response = wp_remote_post(self::$base_url . '/candidat', array(
            'timeout' => 30,
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($data)
        ));
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        return $data;
    }
    
    /**
     * Mettre à jour un candidat
     */
    public static function update_candidat($id, $data) {
        $response = wp_remote_request(self::$base_url . '/candidat/' . $id, array(
            'method' => 'PUT',
            'timeout' => 30,
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($data)
        ));
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        return $data;
    }
}

/**
 * AJAX Handler pour récupérer les candidats
 */
function collabhub_ajax_get_candidats() {
    check_ajax_referer('collabhub_nonce', 'nonce');
    
    $candidats = CollabHub_API::get_candidats();
    
    wp_send_json($candidats);
}
add_action('wp_ajax_get_candidats', 'collabhub_ajax_get_candidats');
add_action('wp_ajax_nopriv_get_candidats', 'collabhub_ajax_get_candidats');

/**
 * AJAX Handler pour sauvegarder un profil candidat
 */
function collabhub_ajax_save_candidat() {
    check_ajax_referer('collabhub_nonce', 'nonce');
    
    $candidat_data = array(
        'firstName' => sanitize_text_field($_POST['firstName']),
        'lastName' => sanitize_text_field($_POST['lastName']),
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone']),
        'dateBirth' => sanitize_text_field($_POST['dateBirth']),
        'address' => sanitize_textarea_field($_POST['address']),
        'description' => sanitize_textarea_field($_POST['description']),
        'linkLinkedin' => esc_url_raw($_POST['linkLinkedin']),
        'linkGithub' => esc_url_raw($_POST['linkGithub']),
        'linkPortfolio' => esc_url_raw($_POST['linkPortfolio']),
        'language' => sanitize_text_field($_POST['language']),
        'interests' => sanitize_textarea_field($_POST['interests']),
        'cv' => esc_url_raw($_POST['cv'])
    );
    
    if (isset($_POST['candidat_id']) && !empty($_POST['candidat_id'])) {
        // Mise à jour
        $result = CollabHub_API::update_candidat($_POST['candidat_id'], $candidat_data);
    } else {
        // Création
        $result = CollabHub_API::create_candidat($candidat_data);
    }
    
    wp_send_json($result);
}
add_action('wp_ajax_save_candidat', 'collabhub_ajax_save_candidat');
add_action('wp_ajax_nopriv_save_candidat', 'collabhub_ajax_save_candidat');

/**
 * Créer les pages nécessaires lors de l'activation du thème
 */
function collabhub_create_pages() {
    // Page profil candidat
    $profil_page = get_page_by_path('profil-candidat');
    if (!$profil_page) {
        wp_insert_post(array(
            'post_title' => 'Profil Candidat',
            'post_name' => 'profil-candidat',
            'post_content' => '[collabhub_profil_candidat]',
            'post_status' => 'publish',
            'post_type' => 'page'
        ));
    }
    
    // Page liste candidats
    $liste_page = get_page_by_path('candidats');
    if (!$liste_page) {
        wp_insert_post(array(
            'post_title' => 'Liste des Candidats',
            'post_name' => 'candidats',
            'post_content' => '[collabhub_liste_candidats]',
            'post_status' => 'publish',
            'post_type' => 'page'
        ));
    }
}
add_action('after_switch_theme', 'collabhub_create_pages');

/**
 * Shortcode pour afficher le formulaire de profil candidat
 */
function collabhub_profil_candidat_shortcode($atts) {
    ob_start();
    
    // Récupérer l'ID du candidat si fourni
    $candidat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $candidat_data = null;
    
    if ($candidat_id > 0) {
        $candidat_response = CollabHub_API::get_candidat($candidat_id);
        if (!isset($candidat_response['error'])) {
            $candidat_data = $candidat_response['data'] ?? null;
        }
    }
    
    include get_template_directory() . '/templates/profil-candidat.php';
    
    return ob_get_clean();
}
add_shortcode('collabhub_profil_candidat', 'collabhub_profil_candidat_shortcode');

/**
 * Shortcode pour afficher la liste des candidats
 */
function collabhub_liste_candidats_shortcode($atts) {
    ob_start();
    
    $candidats_response = CollabHub_API::get_candidats();
    $candidats = array();
    
    if (!isset($candidats_response['error'])) {
        $candidats = $candidats_response['data'] ?? array();
    }
    
    include get_template_directory() . '/templates/liste-candidats.php';
    
    return ob_get_clean();
}
add_shortcode('collabhub_liste_candidats', 'collabhub_liste_candidats_shortcode');





/**
 * Fonctions utilitaires
 */

/**
 * Formater une date pour l'affichage
 */
function collabhub_format_date($date_string) {
    return date('d/m/Y', strtotime($date_string));
}

/**
 * Obtenir les langues disponibles
 */
function collabhub_get_languages() {
    return array(
        'FRENCH' => 'Français',
        'ENGLISH' => 'Anglais',
        'SPANISH' => 'Espagnol',
        'GERMAN' => 'Allemand'
    );
}

/**
 * Valider un email
 */
function collabhub_validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Sécuriser l'output HTML
 */
function collabhub_esc_html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * WIDGETS ELEMENTOR PERSONNALISÉS POUR COLLABHUB
 */

// Enregistrer les widgets Elementor personnalisés
function register_collabhub_elementor_widgets($widgets_manager) {
    require_once(__DIR__ . '/elementor-widgets/candidat-list-widget.php');
    require_once(__DIR__ . '/elementor-widgets/candidat-form-widget.php');
    
    $widgets_manager->register(new \CollabHub_Candidat_List_Widget());
    $widgets_manager->register(new \CollabHub_Candidat_Form_Widget());
}
add_action('elementor/widgets/register', 'register_collabhub_elementor_widgets');

// Créer une catégorie pour nos widgets
function add_collabhub_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'collabhub',
        [
            'title' => __('CollabHub', 'textdomain'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'add_collabhub_elementor_widget_categories');

// Enqueue scripts pour Elementor
function collabhub_elementor_scripts() {
    wp_enqueue_script('jquery');
    wp_localize_script('jquery', 'collabhub_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('collabhub_nonce'),
        'api_base_url' => 'http://host.docker.internal:8080/api/v1'
    ));
}
add_action('wp_enqueue_scripts', 'collabhub_elementor_scripts');

