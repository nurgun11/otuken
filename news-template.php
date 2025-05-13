<?php
/**
 * Template Name: Шаблон новости
 * Template Post Type: post
 */
get_header();
?>

<div class="news-header">
    <div class="container">
        <h1 class="news-title"><?php the_title(); ?></h1>
        <div class="news-meta">
            <div class="news-meta-item">
                <i class="fas fa-calendar"></i>
                <span><?php echo get_the_date(); ?></span>
            </div>
            <div class="news-meta-item">
                <i class="fas fa-user"></i>
                <span><?php the_author(); ?></span>
            </div>
            <div class="news-meta-item">
                <i class="fas fa-folder"></i>
                <span><?php the_category(', '); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <a href="<?php echo get_post_type_archive_link('post'); ?>" class="back-button">
        <i class="fas fa-arrow-left"></i> Вернуться к списку новостей
    </a>
    
    <div class="news-content">
        <?php if(has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>" class="news-image">
        <?php endif; ?>
        
        <div class="news-text">
            <?php the_content(); ?>
        </div>
        
        <div class="news-tags">
            <?php
            $tags = get_the_tags();
            if($tags) {
                foreach($tags as $tag) {
                    echo '<a href="' . get_tag_link($tag->term_id) . '" class="news-tag">' . $tag->name . '</a>';
                }
            }
            ?>
        </div>
        
        <div class="news-share">
            <button class="share-button" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>', '_blank')">
                <i class="fab fa-facebook-f"></i> Поделиться
            </button>
            <button class="share-button" onclick="window.open('https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>', '_blank')">
                <i class="fab fa-twitter"></i> Твитнуть
            </button>
            <button class="share-button" onclick="window.open('https://t.me/share/url?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>', '_blank')">
                <i class="fab fa-telegram"></i> Отправить
            </button>
        </div>
    </div>
</div>

<div class="news-related">
    <div class="container">
        <h2 class="related-title">Похожие новости</h2>
        <div class="related-grid">
            <?php
            $related = new WP_Query(
                array(
                    'category__in'   => wp_get_post_categories(get_the_ID()),
                    'posts_per_page' => 3,
                    'post__not_in'   => array(get_the_ID())
                )
            );
            
            if($related->have_posts()) {
                while($related->have_posts()) {
                    $related->the_post();
            ?>
            <div class="related-card">
                <div class="related-image">
                    <?php if(has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="related-img">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="related-img">
                    <?php endif; ?>
                </div>
                <div class="related-content">
                    <h3 class="related-card-title"><?php the_title(); ?></h3>
                    <p class="related-date"><?php echo get_the_date(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="related-link">Подробнее</a>
                </div>
            </div>
            <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?> 