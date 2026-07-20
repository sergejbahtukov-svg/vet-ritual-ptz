# PROJECT

## Суть проекта
- Миграция сайта с Webasyst (текущая тема `vetritual-modern`) на WordPress.
- Требуется сохранить:
  - структуру URL,
  - SEO-настройки,
  - блоки контента главной страницы и служебных страниц,
  - поведение аналитических интеграций.

## Участники и артефакты
- Базовая площадка: Webasyst локально (`C:\xampp\webasyst-local\wa-data\public\site\themes\vetritual-modern\`).
- Исходный сайт: `https://vetritual.lvh.me/`.
- Директория сборки/архивов: `deploy-vetritual-modern/`.
- Базовая база знаний перехода: `memory/*`.
- Режим валидации: сначала локальный Webasyst (как источник истины), потом WP staging.

## Что входит в scope миграции
- Шаблоны Webasyst:
  - `index.html`
  - `header.html`
  - `footer.html`
  - `home.html`
  - `about.html`
  - `page.html`
  - `error.html`
  - JS: `js/theme.js`, `js/integrations.js`
- Бизнес-логика:
  - маршрутизация по slug из `page.html`,
  - блоки услуг и цены,
  - динамический header/footer,
  - cookie-consent + ленивый запуск аналитики,
  - OG/meta/Schema в `index.html`.

## Что не входит в scope
- Внедрение интернет-магазина.
- Полный e-mail / CRM интеграционный слой за пределами текущих интеграций.
- Новое UI/дизайн-редизайн, т.е. перенос по максимуму 1:1.

