<?php
/**
 * Подвал сайта
 */
?>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" class="footer-logo-img">
                <?php endif; ?>
                <span class="footer-logo-text" data-lang="footer-logo"><?php bloginfo('name'); ?></span>
            </div>
            <div class="footer-contact">
                <p class="contact-address" data-lang="contact-address">Адрес: г. Москва, ул. Примерная, 123</p>
                <p class="contact-phone" data-lang="contact-phone">+7 (999) 123-45-67</p>
                <p class="contact-email" data-lang="contact-email">info@otyuken-fest.ru</p>
            </div>
            <?php if (is_active_sidebar('footer-1')): ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="footer-bottom">
            <p class="footer-copyright" data-lang="footer-copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo __('Все права защищены.', 'otuken'); ?></p>
        </div>
    </div>
</footer>

<!-- Модальное окно для регистрации -->
<div id="registration-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div class="modal-header">
            <h2 data-lang="modal-title"><?php echo __('Регистрация на фестиваль', 'otuken'); ?></h2>
            <p data-lang="modal-welcome"><?php echo __('Уважаемые участники Международного этнофестиваля "Отюкен"!', 'otuken'); ?></p>
            <p data-lang="modal-description"><?php echo __('Мы рады приветствовать вас на сайте I Международного этнофестиваля «Отюкен», который пройдет 7 августа 2025 года в Монголии в сомоне Сэргэлэн аймака Туве.', 'otuken'); ?></p>
            <p data-lang="modal-instruction"><?php echo __('Заполните, пожалуйста, регистрационную форму. После заполнения данных формы необходимо нажать зарегистрироваться', 'otuken'); ?></p>
        </div>
        <form id="extended-registration-form" class="extended-registration-form modal-checkboxes" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="otuken_registration">
            <?php wp_nonce_field('otuken_registration', 'otuken_registration_nonce'); ?>
            
            <div class="form-group">
                <input type="text" id="fullname" name="fullname" required placeholder="<?php echo esc_attr__('Ф.И.О. *', 'otuken'); ?>" data-lang="form-fullname-placeholder">
            </div>
            <div class="form-group">
                <input type="text" id="organization" name="organization" placeholder="<?php echo esc_attr__('Организация или название ансамбля', 'otuken'); ?>" data-lang="form-organization-placeholder">
            </div>
            <div class="form-group">
                <select id="country" name="country" required>
                    <option value="" disabled selected hidden data-lang="form-country-placeholder"><?php echo esc_attr__('Страна *', 'otuken'); ?></option>
                    <option value="RU">Россия</option>
                    <option value="MN">Монголия</option>
                    <option value="TR">Турция</option>
                    <option value="KZ">Казахстан</option>
                    <option value="KG">Кыргызстан</option>
                    <option value="UZ">Узбекистан</option>
                    <option value="TJ">Таджикистан</option>
                    <option value="TM">Туркменистан</option>
                    <option value="AZ">Азербайджан</option>
                    <option value="AM">Армения</option>
                    <option value="GE">Грузия</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" id="city" name="city" placeholder="<?php echo esc_attr__('Город, посёлок, село', 'otuken'); ?>" data-lang="form-city-placeholder">
            </div>
            <div class="form-group">
                <div class="events-label" data-lang="form-events"><?php echo esc_html__('Выберите одно или несколько мероприятий для участия', 'otuken'); ?></div>
                <div class="events-grid">
                    <div class="event-option">
                        <input type="checkbox" id="event1" name="events[]" value="event1">
                        <label for="event1" data-lang="form-event1-label"><?php echo esc_html__('Народные песни и танцы', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event2" name="events[]" value="event2">
                        <label for="event2" data-lang="form-event2-label"><?php echo esc_html__('Национальные костюмы', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event3" name="events[]" value="event3">
                        <label for="event3" data-lang="form-event3-label"><?php echo esc_html__('Настольные игры', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event4" name="events[]" value="event4">
                        <label for="event4" data-lang="form-event4-label"><?php echo esc_html__('Национальные блюда', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event5" name="events[]" value="event5">
                        <label for="event5" data-lang="form-event5-label"><?php echo esc_html__('Конная стрельба из лука', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event6" name="events[]" value="event6">
                        <label for="event6" data-lang="form-event6-label"><?php echo esc_html__('Исторический конный парад', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event7" name="events[]" value="event7">
                        <label for="event7" data-lang="form-event7-label"><?php echo esc_html__('Монгольская борьба', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event8" name="events[]" value="event8">
                        <label for="event8" data-lang="form-event8-label"><?php echo esc_html__('Борьба на поясах «Куреш»', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event9" name="events[]" value="event9">
                        <label for="event9" data-lang="form-event9-label"><?php echo esc_html__('Якутская борьба «Хапсаҕай»', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event10" name="events[]" value="event10">
                        <label for="event10" data-lang="form-event10-label"><?php echo esc_html__('Мас-рестлинг', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event11" name="events[]" value="event11">
                        <label for="event11" data-lang="form-event11-label"><?php echo esc_html__('Урианхайская стрельба', 'otuken'); ?></label>
                    </div>
                    <div class="event-option">
                        <input type="checkbox" id="event12" name="events[]" value="event12">
                        <label for="event12" data-lang="form-event12-label"><?php echo esc_html__('Перенос 130 кг камня', 'otuken'); ?></label>
                    </div>
                </div>
            </div>  
            <div class="form-group">
                <div class="event-option">
                    <input type="checkbox" id="spectator" name="spectator" value="true">
                    <label for="spectator" data-lang="form-spectator-label"><?php echo esc_html__('Буду участвовать в фестивале как зритель', 'otuken'); ?></label>
                </div>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder="<?php echo esc_attr__('Email *', 'otuken'); ?>" data-lang="form-email-placeholder">
            </div>
            <button type="submit" class="btn btn-primary" data-lang="register"><?php echo esc_html__('Зарегистрироваться', 'otuken'); ?></button>
        </form>
    </div>
</div>

<?php wp_footer(); ?> 