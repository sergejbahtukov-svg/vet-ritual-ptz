# Карта контента Webasyst → WordPress

## 1) Обязательная карта URL
1. `/` — Главная.
2. `/o-nas/` — О нас.
3. `/uslugi/` — Услуги (переключатель карточек/intro).
4. `/usyplenie-zhivotnyh/` — Усыпление животных.
5. `/usyplenie-koshek/` — Усыпление кошек.
6. `/usyplenie-sobak/` — Усыпление собак.
7. `/krematsyja-zhivotnyh/` — Кремация животных.
8. `/obschaja-krematsyja/` — Общая кремация.
9. `/individualnaja-krematsyja/` — Индивидуальная кремация.
10. `/vyvoz-zhivotnyh/` — Вывоз животных.
11. `/vyvoz-umershih-zhivotnyh/` — алиас (перенаправление на `/vyvoz-zhivotnyh/`).
12. `/vyvoz-umershikh-zhivotnyh/` — алиас (перенаправление на `/vyvoz-zhivotnyh/`).
13. `/vyvoz-tela-zhivotnogo/` — алиас (перенаправление на `/vyvoz-zhivotnyh/`).
14. `/tseny/` — Цены.
15. `/kontakty/` — Контакты.
16. `/about/` — алиас `o-nas`.
17. `404` — страница ошибки.

## 2) Источник контента по каждому URL
1. `/` — `home.html` + шаблонная shell-сетка из `index.html`.
2. `/o-nas/` — `about.html` + секция контактов из `page.html`.
3. `/uslugi/` — секции `page.html` с `vr_page_url == uslugi`.
4. `/usyplenie-zhivotnyh/` — `page.html`, branch с `vr_page_url == usyplenie-zhivotnyh`.
5. `/usyplenie-koshek/` — `page.html`, branch с `vr_page_url == usyplenie-koshek`.
6. `/usyplenie-sobak/` — `page.html`, branch с `vr_page_url == usyplenie-sobak`.
7. `/krematsyja-zhivotnyh/` — `page.html`, branch с `vr_page_url == krematsyja-zhivotnyh`.
8. `/obschaja-krematsyja/` — `page.html`, branch с `vr_page_url == obschaja-krematsyja`.
9. `/individualnaja-krematsyja/` — `page.html`, branch с `vr_page_url == individualnaja-krematsyja`.
10. `/vyvoz-zhivotnyh/` — `page.html`, branch с `vr_page_url == vyvoz-zhivotnyh` и его алиасы.
11. `/tseny/` — `page.html`, branch с `vr_page_url == ceny`.
12. `/kontakty/` — `page.html`, branch с `vr_page_url == kontakty`.
13. `/about/` — отдельный редирект на `/o-nas/`.

## 3) Ключевые компоненты интерфейса
1. Header: logo, мобильное меню, выпадающий список услуг, телефонный CTA.
2. Footer: брендинг, быстрые ссылки, телефон, адрес.
3. Hero: для главной и для страниц с `vr_page_hero_class`.
4. CTA: кнопка/контакт для всех страниц.
5. Reviews и блок “этапы” на главной из `home.html`.
6. Cookie баннер на уровне body в `index.html`.

## 4) Контентная структура страниц WordPress
1. Шаблон `front-page.php` для `/`.
2. Шаблон `page.php` для всех остальных внутренних URL.
3. Шаблон `404.php` для ошибочных URL.
4. `template-parts`:
   - `content-page.php`,
   - `content-hero.php`,
   - `content-services.php`,
   - `content-prices.php`,
   - `content-process.php`,
   - `content-contact.php`,
   - `content-about.php`,
   - `content-reviews.php`.

## 5) SEO и канонические URL
1. `title` и `description` формируются:
   - по URL-словарю как в текущей `index.html`;
   - с дефолтом на глобальные настройки.
2. canonical = `https://vet-ritual-ptz.ru` + текущий нормализованный path.
3. Для `404` — `noindex, follow`.

## 6) Принцип миграции контента
1. Сначала перенос структуры и роутов, затем наполнение контента через `wp-admin`/ACF.
2. `home.html` и блоки services/reviews/price/contact реализуются как `theme_part` с опциями через `theme settings`.
3. Для каждого маршрута должно быть валидное fallback-сообщение при пустом `page.content`.

