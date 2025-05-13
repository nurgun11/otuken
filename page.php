<?php
/**
 * Шаблон для отображения статических страниц
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
</div>

<div class="container">
    <div class="page-content">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</div>

<style>
    .page-header {
        background: var(--primary-color);
        color: var(--white);
        padding: 80px 0;
        margin-bottom: 40px;
        text-align: center;
    }
    
    .page-title {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .page-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 0;
    }
    
    .page-content p {
        margin-bottom: 1.5rem;
    }
    
    .page-content h2, .page-content h3, .page-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }
    
    .page-content ul, .page-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    
    .page-content li {
        margin-bottom: 0.5rem;
    }
    
    .page-content img {
        max-width: 100%;
        height: auto;
        margin: 1.5rem 0;
    }
    
    .page-content blockquote {
        border-left: 4px solid var(--secondary-color);
        padding-left: 1rem;
        margin-left: 0;
        margin-right: 0;
        font-style: italic;
        color: #555;
    }
    
    @media (max-width: 768px) {
        .page-header {
            padding: 60px 0;
        }
        
        .page-title {
            font-size: 2rem;
        }
    }
</style>

<?php get_footer(); ?> 