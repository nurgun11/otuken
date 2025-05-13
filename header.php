<?php
/**
 * Шапка сайта
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        body { visibility: hidden; }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <nav class="nav-container">
        <div class="logo">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" class="logo-img">
                </a>
            <?php endif; ?>
        </div>
        <button class="hamburger" aria-label="Меню">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="nav-links">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'menu-items',
                'fallback_cb' => false,
                'items_wrap' => '%3$s',
                'walker' => new Otuken_Walker_Nav_Menu()
            ));
            ?>
            <div class="language-selector">
                <button class="lang-btn <?php echo (otuken_get_current_language() === 'en') ? 'active' : ''; ?>" data-lang="en">EN</button>
                <button class="lang-btn <?php echo (otuken_get_current_language() === 'tr') ? 'active' : ''; ?>" data-lang="tr">TR</button>
                <button class="lang-btn <?php echo (otuken_get_current_language() === 'mn') ? 'active' : ''; ?>" data-lang="mn">MN</button>
                <button class="lang-btn <?php echo (otuken_get_current_language() === 'ru') ? 'active' : ''; ?>" data-lang="ru">RU</button>
            </div>
        </div>
    </nav>
</header>

<?php
// Класс для кастомного меню
if (!class_exists('Otuken_Walker_Nav_Menu')):
    class Otuken_Walker_Nav_Menu extends Walker_Nav_Menu {
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            $output .= '<a href="' . esc_url($item->url) . '" class="nav-link" data-lang="nav-' . sanitize_title($item->title) . '">' . esc_html($item->title) . '</a>';
        }
    }
endif;
?> 