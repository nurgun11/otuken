<?php
/**
 * Главная страница сайта
 */
get_header();
?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title" data-lang="hero-title"><?php echo __('Международный этнокультурный фестиваль Отюкен', 'otuken'); ?></h1>
            <p class="hero-subtitle" data-lang="hero-subtitle"><?php echo __('Объединяем культуры, сохраняем традиции', 'otuken'); ?></p>
            <a href="#" class="hero-cta register-btn" data-lang="hero-cta"><?php echo __('Зарегистрироваться', 'otuken'); ?></a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <h2 class="section-title" data-lang="about-title"><?php echo __('О фестивале', 'otuken'); ?></h2>
            <div class="about-content">
                <p class="about-text" data-lang="about-text">
                    <?php echo __('Фестиваль Отюкен — это масштабное событие, объединяющее тюркские и монгольские народы. В программе: обряды очищения и поклонения, массовые танцы, концерты с национальными инструментами и горловым пением, конные парады и спортивные состязания, мастер-классы по ремёслам и национальной кухне, дегустации, исторические реконструкции, показ костюмов и исполнение эпосов. Это уникальная площадка для живого культурного обмена, сохранения и развития традиций, искусства и ремёсел.', 'otuken'); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="news" class="news">
        <div class="container">
            <h2 class="section-title" data-lang="news-title"><?php echo __('Новости', 'otuken'); ?></h2>
            <?php otuken_latest_news(3); ?>
        </div>
    </section>

    <!-- Program Section -->
    <section id="program" class="program">
        <div class="container">
            <h2 class="section-title" data-lang="program-title"><?php echo __('Программа фестиваля', 'otuken'); ?></h2>
            <div class="program-grid">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="program-content">
                        <h3 class="program-title" data-lang="program-ceremonies-ru"><?php echo __('Обряды и ритуалы', 'otuken'); ?></h3>
                        <h3 data-lang="program-ceremonies-en" style="display: none;"><?php echo __('Ceremonies and Rituals', 'otuken'); ?></h3>
                        <h3 data-lang="program-ceremonies-mn" style="display: none;"><?php echo __('Зан үйл ба ёслол', 'otuken'); ?></h3>
                        <h3 data-lang="program-ceremonies-tr" style="display: none;"><?php echo __('Törenler ve Ritüeller', 'otuken'); ?></h3>
                        <p data-lang="program-ceremonies-desc-ru"><?php echo __('Древние обряды очищения и поклонения духам природы, проводимые шаманами и жрецами.', 'otuken'); ?></p>
                        <p data-lang="program-ceremonies-desc-en" style="display: none;"><?php echo __('Ancient purification ceremonies and worship of nature spirits, conducted by shamans and priests.', 'otuken'); ?></p>
                        <p data-lang="program-ceremonies-desc-mn" style="display: none;"><?php echo __('Бөө нар, ламууд хийдэг байгалийн сүнснүүдэд мөргөх, ариусгах эртний зан үйлүүд.', 'otuken'); ?></p>
                        <p data-lang="program-ceremonies-desc-tr" style="display: none;"><?php echo __('Şamanlar ve rahipler tarafından yürütülen doğa ruhlarına adanmış antik arınma törenleri ve ibadetler.', 'otuken'); ?></p>
                    </div>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <div class="program-content">
                        <h3 class="program-title" data-lang="program-concerts-ru"><?php echo __('Концерты', 'otuken'); ?></h3>
                        <h3 data-lang="program-concerts-en" style="display: none;"><?php echo __('Concerts', 'otuken'); ?></h3>
                        <h3 data-lang="program-concerts-mn" style="display: none;"><?php echo __('Концертууд', 'otuken'); ?></h3>
                        <h3 data-lang="program-concerts-tr" style="display: none;"><?php echo __('Konserler', 'otuken'); ?></h3>
                        <p data-lang="program-concerts-desc-ru"><?php echo __('Выступления с национальными инструментами и горловым пением, традиционные песни и танцы.', 'otuken'); ?></p>
                        <p data-lang="program-concerts-desc-en" style="display: none;"><?php echo __('Performances with national instruments and throat singing, traditional songs and dances.', 'otuken'); ?></p>
                        <p data-lang="program-concerts-desc-mn" style="display: none;"><?php echo __('Үндэсний хөгжмийн зэмсэг болон хөөмийтэй тоглолт, уламжлалт дуу хөгжим, бүжиг.', 'otuken'); ?></p>
                        <p data-lang="program-concerts-desc-tr" style="display: none;"><?php echo __('Ulusal enstrümanlar ve gırtlak şarkısı, geleneksel şarkılar ve danslar ile performanslar.', 'otuken'); ?></p>
                    </div>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-horse"></i>
                    </div>
                    <div class="program-content">
                        <h3 class="program-title" data-lang="program-sports-ru"><?php echo __('Спортивные состязания', 'otuken'); ?></h3>
                        <h3 data-lang="program-sports-en" style="display: none;"><?php echo __('Sports Competitions', 'otuken'); ?></h3>
                        <h3 data-lang="program-sports-mn" style="display: none;"><?php echo __('Спортын тэмцээнүүд', 'otuken'); ?></h3>
                        <h3 data-lang="program-sports-tr" style="display: none;"><?php echo __('Spor Müsabakaları', 'otuken'); ?></h3>
                        <p data-lang="program-sports-desc-ru"><?php echo __('Конные парады, стрельба из лука, национальные виды борьбы и другие традиционные состязания.', 'otuken'); ?></p>
                        <p data-lang="program-sports-desc-en" style="display: none;"><?php echo __('Horse parades, archery, national wrestling styles and other traditional competitions.', 'otuken'); ?></p>
                        <p data-lang="program-sports-desc-mn" style="display: none;"><?php echo __('Морин жагсаал, нум сум харвах, үндэсний барилдаан болон бусад уламжлалт тэмцээнүүд.', 'otuken'); ?></p>
                        <p data-lang="program-sports-desc-tr" style="display: none;"><?php echo __('At geçitleri, okçuluk, ulusal güreş stilleri ve diğer geleneksel yarışmalar.', 'otuken'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title" data-lang="contact-title"><?php echo __('Контакты', 'otuken'); ?></h2>
            <div class="contact-grid">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 data-lang="contact-address-title"><?php echo __('Адрес', 'otuken'); ?></h3>
                    <p data-lang="contact-address"><?php echo __('Монголия, аймак Туве, сомон Сэргэлэн', 'otuken'); ?></p>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3 data-lang="contact-phone-title"><?php echo __('Телефон', 'otuken'); ?></h3>
                    <p data-lang="contact-phone"><?php echo __('+7 (999) 123-45-67', 'otuken'); ?></p>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 data-lang="contact-email-title"><?php echo __('Email', 'otuken'); ?></h3>
                    <p data-lang="contact-email"><?php echo __('info@otuken-fest.ru', 'otuken'); ?></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?> 