<?php
/**
 * Функции для новостного раздела сайта фестиваля Отюкен
 */

// Подключение стилей для страницы новости
function otuken_news_styles() {
    if (is_single() || is_page_template('news-template.php')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
        wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        wp_enqueue_style('otuken-news-style', get_template_directory_uri() . '/style-news.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'otuken_news_styles');

// Добавление поддержки миниатюр для постов
function otuken_news_setup() {
    add_theme_support('post-thumbnails');
    add_image_size('news-large', 1200, 600, true);
    add_image_size('news-medium', 600, 400, true);
    add_image_size('news-small', 300, 200, true);
}
add_action('after_setup_theme', 'otuken_news_setup');

// Добавление метабоксов для дополнительных полей новости
function otuken_news_meta_boxes() {
    add_meta_box(
        'otuken_news_meta',
        'Дополнительные поля новости',
        'otuken_news_meta_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'otuken_news_meta_boxes');

// Функция отображения метабоксов
function otuken_news_meta_callback($post) {
    // Добавляем nonce для безопасности
    wp_nonce_field('otuken_news_meta', 'otuken_news_meta_nonce');
    
    // Получаем значения полей, если они существуют
    $news_subtitle = get_post_meta($post->ID, '_news_subtitle', true);
    $news_important = get_post_meta($post->ID, '_news_important', true);
    
    // Поле для подзаголовка новости
    echo '<p><label for="news_subtitle">Подзаголовок новости:</label></p>';
    echo '<p><input type="text" id="news_subtitle" name="news_subtitle" value="' . esc_attr($news_subtitle) . '" style="width:100%;" /></p>';
    
    // Чекбокс для отметки важной новости
    echo '<p>';
    echo '<input type="checkbox" id="news_important" name="news_important" ' . checked($news_important, 'on', false) . ' />';
    echo '<label for="news_important">Отметить как важную новость</label>';
    echo '</p>';
}

// Сохранение данных метабоксов
function otuken_save_news_meta($post_id) {
    // Проверяем nonce
    if (!isset($_POST['otuken_news_meta_nonce']) || !wp_verify_nonce($_POST['otuken_news_meta_nonce'], 'otuken_news_meta')) {
        return;
    }
    
    // Проверяем автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Проверяем права пользователя
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Сохраняем данные
    if (isset($_POST['news_subtitle'])) {
        update_post_meta($post_id, '_news_subtitle', sanitize_text_field($_POST['news_subtitle']));
    }
    
    $news_important = isset($_POST['news_important']) ? 'on' : 'off';
    update_post_meta($post_id, '_news_important', $news_important);
}
add_action('save_post', 'otuken_save_news_meta');

// Функция для вывода последних новостей
function otuken_latest_news($count = 3, $category = '') {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // Если указана категория, добавляем её в запрос
    if (!empty($category)) {
        $args['category_name'] = $category;
    }
    
    $latest_news = new WP_Query($args);
    
    if ($latest_news->have_posts()) {
        echo '<div class="news-grid">';
        while ($latest_news->have_posts()) {
            $latest_news->the_post();
            ?>
            <div class="news-card">
                <div class="news-image">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('news-medium'); ?>" alt="<?php the_title_attribute(); ?>" class="news-img">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="news-img">
                    <?php endif; ?>
                </div>
                <div class="news-content">
                    <h3 class="news-card-title"><?php the_title(); ?></h3>
                    <p class="news-date"><?php echo get_the_date(); ?></p>
                    <p class="news-text"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                    <a href="<?php the_permalink(); ?>" class="news-link">Подробнее</a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>Новостей пока нет.</p>';
    }
}

// Шорткод для вывода новостей
function otuken_news_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'count' => 3,
            'category' => '',
        ),
        $atts,
        'otuken_news'
    );
    
    ob_start();
    otuken_latest_news($atts['count'], $atts['category']);
    return ob_get_clean();
}
add_shortcode('otuken_news', 'otuken_news_shortcode');

// Добавляем переводы для новостного раздела
function otuken_news_translations($translations) {
    // Русский
    $translations['ru']['news-title'] = 'Новости';
    $translations['ru']['news-more'] = 'Подробнее';
    $translations['ru']['news-back'] = 'Вернуться к списку новостей';
    $translations['ru']['news-related'] = 'Похожие новости';
    $translations['ru']['news-share'] = 'Поделиться';
    $translations['ru']['news-tweet'] = 'Твитнуть';
    $translations['ru']['news-telegram'] = 'Отправить';
    
    // Английский
    $translations['en']['news-title'] = 'News';
    $translations['en']['news-more'] = 'Read more';
    $translations['en']['news-back'] = 'Back to news list';
    $translations['en']['news-related'] = 'Related news';
    $translations['en']['news-share'] = 'Share';
    $translations['en']['news-tweet'] = 'Tweet';
    $translations['en']['news-telegram'] = 'Send';
    
    // Монгольский
    $translations['mn']['news-title'] = 'Мэдээ';
    $translations['mn']['news-more'] = 'Дэлгэрэнгүй';
    $translations['mn']['news-back'] = 'Мэдээний жагсаалт руу буцах';
    $translations['mn']['news-related'] = 'Холбоотой мэдээ';
    $translations['mn']['news-share'] = 'Хуваалцах';
    $translations['mn']['news-tweet'] = 'Жиргэх';
    $translations['mn']['news-telegram'] = 'Илгээх';
    
    // Турецкий
    $translations['tr']['news-title'] = 'Haberler';
    $translations['tr']['news-more'] = 'Daha fazla';
    $translations['tr']['news-back'] = 'Haber listesine dön';
    $translations['tr']['news-related'] = 'İlgili haberler';
    $translations['tr']['news-share'] = 'Paylaş';
    $translations['tr']['news-tweet'] = 'Tweet';
    $translations['tr']['news-telegram'] = 'Gönder';
    
    return $translations;
}
add_filter('otuken_translations', 'otuken_news_translations'); 