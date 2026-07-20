# Evidence

## Исходный контур
- Локальная проверка Webasyst: `https://vetritual.lvh.me/`.
- Исходные шаблоны в `vetritual-modern/`.
- Ключевые интеграционные скрипты:
  - `js/theme.js`
  - `js/integrations.js`

## Что подтверждено по теме
- `index.html` содержит:
  - SEO-блоки (title/description/OG),
  - `LocalBusiness` и `WebPage` JSON-LD,
  - canonical / URL-логику для 404 и SEO-заголовков,
  - подключение меток аналитики.
- `page.html` содержит роутинг по URL (в т.ч. алиасы для вывоза).
- `header.html` и `footer.html` содержат глобальный каркас, контактные блоки и меню.
- `home.html` содержит все ключевые секции главной страницы.
- `theme.js` управляет слайдерами, меню, плавным скроллом и наблюдением видимости.
- `integrations.js` управляет:
  - Yandex Metrika / Google Analytics / GTM / Meta Pixel / VK / Mail.ru / TikTok,
  - режимами аналитики (always/on_consent/disabled),
  - связью с cookie-согласием.

## Артефакты памяти
- `memory/WORDPRESS_MIGRATION_WORKFLOW.md`
- `memory/WORDPRESS_SKILLS.md`
- `memory/subagents/00-SUBAGENTS.md`
- `memory/subagents/WORDPRESS_ASSIGNMENTS.md`

## Примечание
- Все URL и SEO-данные в workflow привязаны к текущей структуре Webasyst и требуют проверки по живой валидации перед переносом.

