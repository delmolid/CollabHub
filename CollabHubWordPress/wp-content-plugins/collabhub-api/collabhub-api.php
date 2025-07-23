<?php
/**
 * Plugin Name: CollabHub API Integration
 * Description: Intègre l'API CollabHub avec des shortcodes pour afficher et gérer les candidats
 * Version: 1.0.0
 * Author: CollabHub Team
 */

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Classe principale du plugin CollabHub API
 */
class CollabHub_API_Plugin {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    public function init() {
        // Enregistrer les shortcodes
        add_shortcode('collabhub_liste_candidats', array($this, 'liste_candidats_shortcode'));
        add_shortcode('collabhub_profil_candidat', array($this, 'profil_candidat_shortcode'));
        
        // Enregistrer les handlers AJAX
        add_action('wp_ajax_get_candidats', array($this, 'ajax_get_candidats'));
        add_action('wp_ajax_nopriv_get_candidats', array($this, 'ajax_get_candidats'));
        add_action('wp_ajax_save_candidat', array($this, 'ajax_save_candidat'));
        add_action('wp_ajax_nopriv_save_candidat', array($this, 'ajax_save_candidat'));
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'collabhub_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('collabhub_nonce'),
            'api_base_url' => 'http://host.docker.internal:8080/api/v1'
        ));
    }
    
    /**
     * Shortcode pour la liste des candidats
     */
    public function liste_candidats_shortcode($atts) {
        ob_start();
        
        $candidats_response = $this->get_candidats();
        $candidats = array();
        
        if (!isset($candidats_response['error'])) {
            $candidats = $candidats_response['data'] ?? array();
        }
        
        $this->load_template('liste-candidats', compact('candidats'));
        
        return ob_get_clean();
    }
    
    /**
     * Shortcode pour le profil candidat
     */
    public function profil_candidat_shortcode($atts) {
        ob_start();
        
        // Récupérer l'ID du candidat si fourni
        $candidat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $candidat_data = null;
        
        if ($candidat_id > 0) {
            $candidat_response = $this->get_candidat($candidat_id);
            if (!isset($candidat_response['error'])) {
                $candidat_data = $candidat_response['data'] ?? null;
            }
        }
        
        $this->load_template('profil-candidat', compact('candidat_data'));
        
        return ob_get_clean();
    }
    
    /**
     * Récupérer tous les candidats
     */
    public function get_candidats() {
        $response = wp_remote_get('http://host.docker.internal:8080/api/v1/candidat', array(
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
    public function get_candidat($id) {
        $response = wp_remote_get('http://host.docker.internal:8080/api/v1/candidat/' . $id, array(
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
     * Créer un candidat
     */
    public function create_candidat($data) {
        $response = wp_remote_post('http://host.docker.internal:8080/api/v1/candidat', array(
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
     * AJAX Handler pour récupérer les candidats
     */
    public function ajax_get_candidats() {
        check_ajax_referer('collabhub_nonce', 'nonce');
        
        $candidats = $this->get_candidats();
        
        wp_send_json($candidats);
    }
    
    /**
     * AJAX Handler pour sauvegarder un profil candidat
     */
    public function ajax_save_candidat() {
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
        
        $result = $this->create_candidat($candidat_data);
        
        wp_send_json($result);
    }
    
    /**
     * Charger un template
     */
    private function load_template($template_name, $variables = array()) {
        // Extraire les variables pour les rendre disponibles dans le template
        extract($variables);
        
        $template_path = plugin_dir_path(__FILE__) . 'templates/' . $template_name . '.php';
        
        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo '<p>Template ' . esc_html($template_name) . ' non trouvé.</p>';
        }
    }
}

// Initialiser le plugin
new CollabHub_API_Plugin();

/**
 * Fonctions utilitaires
 */
function collabhub_format_date($date_string) {
    return date('d/m/Y', strtotime($date_string));
}

function collabhub_get_languages() {
    return array(
        'FRENCH' => 'Français',
        'ENGLISH' => 'Anglais',
        'SPANISH' => 'Espagnol',
        'GERMAN' => 'Allemand'
    );
} 