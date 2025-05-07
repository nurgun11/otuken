document.addEventListener('DOMContentLoaded', () => {
    // Инициализация текущего языка
    let currentLang = 'ru';
    
    // Модальное окно
    const modal = document.getElementById('registration-modal');
    const registerButtons = document.querySelectorAll('[data-action="register"]');
    const closeModal = document.querySelector('.close-modal');
    
    // Открытие модального окна
    registerButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Закрытие модального окна
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    });
    
    // Закрытие модального окна при клике вне его
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    
    // Функция для переключения языка
    function switchLanguage(lang) {
        currentLang = lang;
        
        // Обновляем активную кнопку языка
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-lang') === lang) {
                btn.classList.add('active');
            }
        });
        
        // Обновляем все элементы с атрибутом data-lang
        document.querySelectorAll('[data-lang]').forEach(element => {
            const key = element.getAttribute('data-lang');
            if (translations[lang] && translations[lang][key]) {
                element.textContent = translations[lang][key];
            }
        });
        
        // Обновляем атрибут lang у html
        document.documentElement.lang = lang;
    }
    
    // Обработчики для кнопок переключения языка
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const lang = btn.getAttribute('data-lang');
            switchLanguage(lang);
        });
    });
    
    // Обработка формы регистрации
    const registrationForm = document.getElementById('extended-registration-form');
    if (registrationForm) {
        registrationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Собираем данные формы
            const formData = new FormData(registrationForm);
            const data = {};
            formData.forEach((value, key) => {
                if (key === 'events') {
                    if (!data[key]) {
                        data[key] = [];
                    }
                    data[key].push(value);
                } else {
                    data[key] = value;
                }
            });

            // Здесь можно добавить отправку данных на сервер
            console.log('Form data:', data);

            // Показываем сообщение об успешной регистрации
            alert(translations[currentLang]['registration-success'] || 'Регистрация успешно завершена!');
            
            // Закрываем модальное окно
            modal.style.display = 'none';
            document.body.style.overflow = '';
            
            // Очищаем форму
            registrationForm.reset();
        });
    }
    
    // Плавная прокрутка для навигационных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Анимация появления элементов при прокрутке
    const observerOptions = {
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.program-card, .about-content, .contact-item').forEach(element => {
        observer.observe(element);
    });
    
    // Добавляем стили для анимации
    const style = document.createElement('style');
    style.textContent = `
        .program-card, .about-content, .contact-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        
        .program-card.visible, .about-content.visible, .contact-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
    `;
    document.head.appendChild(style);
}); 