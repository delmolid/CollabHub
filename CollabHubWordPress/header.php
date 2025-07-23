<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <header class="site-header">
        <div class="header-content">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                Logo CollabHub
            </a>
            
            <nav class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'main-menu',
                    'fallback_cb' => function() {
                        echo '<ul class="main-menu">
                                <li><a href="' . home_url() . '">Accueil</a></li>
                                <li><a href="/candidats">Candidats</a></li>
                                <li><a href="/profil-candidat">Mon Profil</a></li>
                              </ul>';
                    }
                ));
                ?>
            </nav>
            
            <button class="menu-toggle" aria-label="Menu">
                Menu
            </button>
        </div>
    </header> 