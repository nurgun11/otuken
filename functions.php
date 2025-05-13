<?php
/**
 * Otuken Festival Theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Подключение стилей и скриптов
function otuken_enqueue_scripts() {
    // Основной стиль темы
    wp_enqueue_style('otuken-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Стили для новостного раздела
    wp_enqueue_style('otuken-news-style', get_template_directory_uri() . '/style-news.css', array(), '1.0.0');
    
    // Шрифты Google
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap', array(), null);
    
    // Основной скрипт
    wp_enqueue_script('otuken-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Файл переводов
    wp_enqueue_script('otuken-translations', get_template_directory_uri() . '/js/translations.js', array(), '1.0.0', true);
    
    // Локализация скриптов
    wp_localize_script('otuken-main', 'otukenData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('otuken-nonce'),
        'currentLang' => apply_filters('wpml_current_language', 'ru')
    ));
}
add_action('wp_enqueue_scripts', 'otuken_enqueue_scripts');

// Получение текущего языка
function otuken_get_current_language() {
    // Если установлен WPML, используем его
    if (function_exists('icl_object_id')) {
        return apply_filters('wpml_current_language', NULL);
    }
    
    // Если установлен Polylang, используем его
    if (function_exists('pll_current_language')) {
        return pll_current_language();
    }
    
    // Иначе используем куки или возвращаем дефолтный язык
    if (isset($_COOKIE['otuken_language'])) {
        return sanitize_text_field($_COOKIE['otuken_language']);
    }
    
    return 'ru'; // Язык по умолчанию
}

// Обработчик AJAX для переключения языка
function otuken_switch_language() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'otuken-nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    $lang = isset($_POST['lang']) ? sanitize_text_field($_POST['lang']) : 'ru';
    
    // Устанавливаем куки на 30 дней
    setcookie('otuken_language', $lang, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
    
    wp_send_json_success();
}
add_action('wp_ajax_otuken_switch_language', 'otuken_switch_language');
add_action('wp_ajax_nopriv_otuken_switch_language', 'otuken_switch_language');

// Регистрация меню
function otuken_register_menus() {
    register_nav_menus(array(
        'primary' => __('Главное меню', 'otuken'),
        'footer' => __('Меню в подвале', 'otuken'),
    ));
}
add_action('init', 'otuken_register_menus');

// Поддержка темы
function otuken_theme_support() {
    // Поддержка миниатюр
    add_theme_support('post-thumbnails');
    
    // Поддержка HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Поддержка заголовка
    add_theme_support('title-tag');
    
    // Поддержка логотипа
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Поддержка форматов записей
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'audio',
        'gallery',
    ));
}
add_action('after_setup_theme', 'otuken_theme_support');

// Регистрация сайдбара
function otuken_widgets_init() {
    register_sidebar(array(
        'name'          => __('Сайдбар', 'otuken'),
        'id'            => 'sidebar-1',
        'description'   => __('Добавьте виджеты сюда', 'otuken'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'otuken_widgets_init');

// Подключение функций для новостного раздела
require get_template_directory() . '/functions-news.php';

// Обработка формы регистрации
function otuken_handle_registration() {
    if (!isset($_POST['otuken_nonce']) || !wp_verify_nonce($_POST['otuken_nonce'], 'otuken_registration')) {
        wp_send_json_error('Ошибка безопасности');
        exit;
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $events = isset($_POST['events']) ? $_POST['events'] : array();

    // Валидация
    if (empty($name) || empty($email) || empty($phone)) {
        wp_send_json_error('Пожалуйста, заполните все обязательные поля');
        exit;
    }

    // Отправка уведомления администратору
    $admin_email = get_option('admin_email');
    $subject = 'Новая регистрация на фестиваль Отюкен';
    
    $message = "Имя: $name\n";
    $message .= "Email: $email\n";
    $message .= "Телефон: $phone\n";
    $message .= "Выбранные мероприятия: " . implode(', ', $events) . "\n";
    
    wp_mail($admin_email, $subject, $message);
    
    // Сохранение в базе данных
    $participant_data = array(
        'post_title'    => $name,
        'post_status'   => 'private',
        'post_type'     => 'participant',
    );
    
    $participant_id = wp_insert_post($participant_data);
    
    if ($participant_id) {
        update_post_meta($participant_id, 'email', $email);
        update_post_meta($participant_id, 'phone', $phone);
        update_post_meta($participant_id, 'events', $events);
        
        wp_send_json_success('Спасибо за регистрацию! Мы свяжемся с вами в ближайшее время.');
    } else {
        wp_send_json_error('Произошла ошибка при регистрации. Пожалуйста, попробуйте позже.');
    }
    
    exit;
}
add_action('wp_ajax_otuken_registration', 'otuken_handle_registration');
add_action('wp_ajax_nopriv_otuken_registration', 'otuken_handle_registration');

// Регистрация типа записи "Участник"
function otuken_register_participant_post_type() {
    $labels = array(
        'name'                  => _x('Участники', 'Post Type General Name', 'otuken'),
        'singular_name'         => _x('Участник', 'Post Type Singular Name', 'otuken'),
        'menu_name'             => __('Участники', 'otuken'),
        'all_items'             => __('Все участники', 'otuken'),
        'add_new_item'          => __('Добавить нового участника', 'otuken'),
        'add_new'               => __('Добавить нового', 'otuken'),
        'edit_item'             => __('Редактировать участника', 'otuken'),
        'view_item'             => __('Просмотреть участника', 'otuken'),
        'search_items'          => __('Поиск участников', 'otuken'),
    );
    
    $args = array(
        'label'                 => __('Участник', 'otuken'),
        'description'           => __('Участники фестиваля', 'otuken'),
        'labels'                => $labels,
        'supports'              => array('title', 'custom-fields'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    );
    
    register_post_type('participant', $args);
}
add_action('init', 'otuken_register_participant_post_type'); 