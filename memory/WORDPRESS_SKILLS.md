# WordPress Skills & Templates

## Ключевые навыки для миграции
- PHP для WordPress:
  - шаблоны темы (`header.php`, `footer.php`, `front-page.php`, `page.php`),
  - работа с WP_Query,
  - корректное экранирование и безопасность.
- Theme Development:
  - enqueue assets,
  - регистрация меню/виджетов/навигации,
  - структура `template parts`.
- CSS/JS:
  - перенос текущих классов,
  - оптимизация загрузки,
  - адаптивность 360 / 768 / 1280.
- Контент-моделирование:
  - `page` + ACF поля,
  - минимально-инвазивный CPT при необходимости.
- SEO:
  - canonical / OG / meta / OpenGraph,
  - schema.org,
  - robots + sitemap + редиректы.
- QA и запуск:
  - локальный smoke-check,
  - чек-листы для аналитики и форм,
  - rollout и rollback.

## Рекомендуемый стек
- WordPress + классическая тема (без блокового конструктора).
- ACF (или Custom Fields),
- SEO плагин: Rank Math (или аналог),
- Form plugin (WPForms/Fluent Forms),
- Caching: WP Super Cache/LiteSpeed Cache (по окружению).

## Паттерны миграции из текущего кода
- `page.html` роутинг -> WP условия + выборка ACF-групп.
- `theme.js` -> инициализация после DOM, lazy init для слайдера.
- `integrations.js` -> отдельный модуль `assets/js/integrations.js` + безопасная инициализация через настройки.
- `header/footer` из Webasyst -> `get_template_part` и единый контекст `page` данных.

## Коммуникационные артефакты
- Каждый сабагент отдает:
  - `findings` (что найдено),
  - `migration map` (что куда переезжает),
  - `risks` (что может сломаться),
  - `acceptance criteria` (критерии готовности).

