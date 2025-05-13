/**
 * Основной JavaScript файл для темы Otuken Festival
 */

jQuery(document).ready(function($) {
    'use strict';

    // Показываем страницу после загрузки
    $('body').addClass('loaded');

    // Переключение языка
    $('.lang-btn').on('click', function() {
        const lang = $(this).data('lang');
        switchLanguage(lang);
    });

    // Функция переключения языка
    function switchLanguage(lang) {
        // Активируем кнопку выбранного языка
        $('.lang-btn').removeClass('active');
        $(`.lang-btn[data-lang="${lang}"]`).addClass('active');

        // Переключаем тексты
        $('[data-lang]').each(function() {
            const key = $(this).data('lang');
            const langKey = key.endsWith(`-${lang}`) ? key : key.replace(/-[a-z]{2}$/, `-${lang}`);
            
            // Проверяем, есть ли перевод для этого элемента
            if (typeof otukenTranslations !== 'undefined' && otukenTranslations[lang] && otukenTranslations[lang][key]) {
                $(this).text(otukenTranslations[lang][key]);
            } else if ($(this).is('input, textarea')) {
                // Для полей ввода обновляем placeholder
                if (typeof otukenTranslations !== 'undefined' && otukenTranslations[lang] && otukenTranslations[lang][key]) {
                    $(this).attr('placeholder', otukenTranslations[lang][key]);
                }
            } else if (key.endsWith('-ru') || key.endsWith('-en') || key.endsWith('-tr') || key.endsWith('-mn')) {
                // Для элементов с языковыми суффиксами
                if (key.endsWith(`-${lang}`)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            }
        });

        // Сохраняем выбранный язык в куки
        saveLangPreference(lang);
    }

    // Сохранение выбранного языка
    function saveLangPreference(lang) {
        $.ajax({
            url: otukenData.ajaxurl,
            type: 'POST',
            data: {
                action: 'otuken_switch_language',
                lang: lang,
                nonce: otukenData.nonce
            },
            success: function(response) {
                console.log('Language switched to ' + lang);
            }
        });
    }

    // Модальное окно регистрации
    const modal = $('#registration-modal');
    const registerBtn = $('.register-btn');
    const closeModal = $('.close-modal');

    registerBtn.on('click', function(e) {
        e.preventDefault();
        modal.fadeIn();
        $('body').addClass('modal-open');
    });

    closeModal.on('click', function() {
        modal.fadeOut();
        $('body').removeClass('modal-open');
    });

    $(window).on('click', function(e) {
        if ($(e.target).is(modal)) {
            modal.fadeOut();
            $('body').removeClass('modal-open');
        }
    });

    // Мобильное меню
    const hamburger = $('.hamburger');
    const navLinks = $('.nav-links');

    hamburger.on('click', function() {
        navLinks.toggleClass('active');
        $(this).toggleClass('active');
    });

    // Анимация при прокрутке
    const header = $('.header');
    const scrollThreshold = 100;

    $(window).on('scroll', function() {
        if ($(this).scrollTop() > scrollThreshold) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
    });

    // Анимация появления элементов
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.program-card, .about-content, .contact-item, .news-card').forEach(element => {
        observer.observe(element);
    });

    // Плавная прокрутка к якорям
    $('a[href^="#"]').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 80
            }, 800);
        }
    });

    // Инициализация языка при загрузке страницы
    const currentLang = getCookie('otuken_language') || otukenData.currentLang || 'ru';
    switchLanguage(currentLang);

    // Функция для получения значения cookie
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
}); 