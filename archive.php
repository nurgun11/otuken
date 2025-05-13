<?php
/**
 * Шаблон для отображения архивных страниц
 */
get_header();
?>

<div class="news-archive-header">
    <div class="container">
        <h1 class="archive-title">
            <?php
            if (is_category()) {
                echo single_cat_title('', false);
            } elseif (is_tag()) {
                echo single_tag_title('', false);
            } elseif (is_author()) {
                the_post();
                echo get_the_author();
                rewind_posts();
            } elseif (is_post_type_archive()) {
                echo post_type_archive_title('', false);
            } elseif (is_tax()) {
                echo single_term_title('', false);
            } else {
                echo __('Новости', 'otuken');
            }
            ?>
        </h1>
        <?php
        if (is_category() || is_tag() || is_tax()) {
            echo '<div class="archive-description">' . term_description() . '</div>';
        }
        ?>
    </div>
</div>

<div class="container">
    <div class="archive-layout">
        <div class="news-filters">
            <div class="category-filter">
                <h3><?php echo __('Категории', 'otuken'); ?></h3>
                <ul>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order'   => 'ASC'
                    ));
                    
                    foreach ($categories as $category) {
                        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . ' (' . $category->count . ')</a></li>';
                    }
                    ?>
                </ul>
            </div>
            
            <div class="date-filter">
                <h3><?php echo __('Архив', 'otuken'); ?></h3>
                <ul>
                    <?php
                    wp_get_archives(array(
                        'type'            => 'monthly',
                        'limit'           => 12,
                        'show_post_count' => true
                    ));
                    ?>
                </ul>
            </div>
        </div>
        
        <div class="news-archive-content">
            <?php if (have_posts()) : ?>
                <div class="news-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="news-card">
                            <div class="news-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('news-medium'); ?>" alt="<?php the_title_attribute(); ?>" class="news-img">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="news-img">
                                <?php endif; ?>
                            </div>
                            <div class="news-content">
                                <h3 class="news-card-title"><?php the_title(); ?></h3>
                                <p class="news-date"><?php echo get_the_date(); ?></p>
                                <p class="news-text"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="news-link"><?php echo __('Подробнее', 'otuken'); ?></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <div class="pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Предыдущая', 'otuken'),
                        'next_text' => __('Следующая', 'otuken') . ' <i class="fas fa-chevron-right"></i>',
                    ));
                    ?>
                </div>
            <?php else : ?>
                <div class="no-news">
                    <p><?php echo __('Новости не найдены.', 'otuken'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .archive-layout {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        margin: 3rem 0;
    }
    
    .news-filters {
        flex: 1;
        min-width: 250px;
        max-width: 300px;
    }
    
    .news-archive-content {
        flex: 3;
        min-width: 300px;
    }
    
    .category-filter, .date-filter {
        margin-bottom: 2rem;
    }
    
    .category-filter h3, .date-filter h3 {
        margin-bottom: 1rem;
        color: var(--primary-color);
        font-size: 1.3rem;
    }
    
    .category-filter ul, .date-filter ul {
        list-style: none;
        padding: 0;
    }
    
    .category-filter li, .date-filter li {
        margin-bottom: 0.5rem;
    }
    
    .category-filter a, .date-filter a {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .category-filter a:hover, .date-filter a:hover {
        color: var(--secondary-color);
    }
    
    .pagination {
        margin-top: 2rem;
        text-align: center;
    }
    
    .pagination .page-numbers {
        display: inline-block;
        padding: 0.5rem 1rem;
        margin: 0 0.2rem;
        border: 1px solid var(--light-bg);
        color: var(--primary-color);
        text-decoration: none;
        border-radius: 3px;
        transition: all 0.3s ease;
    }
    
    .pagination .page-numbers.current {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }
    
    .pagination .page-numbers:hover {
        background: var(--light-bg);
    }
    
    .no-news {
        text-align: center;
        padding: 3rem 0;
        color: #777;
    }
    
    @media (max-width: 768px) {
        .archive-layout {
            flex-direction: column;
        }
        
        .news-filters {
            max-width: none;
        }
    }
</style>

<?php get_footer(); ?> 