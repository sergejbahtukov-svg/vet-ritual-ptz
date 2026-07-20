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

- `WORDPRESS_PREPARATION_COORDINATION_PLAN.md` — единый координационный трек для сабагентов.
- `WORDPRESS_THEME_OPTIONS_SPEC.md` — контракт по theme settings для user-friendly настройки.
- `BUILD_TEMPLATE_LIST.md` — список целевых шаблонов и partials для сверки сборки.
- `WORDPRESS_CAPABILITY_MATRIX.md` (обновлён) — readiness-gate перед build.
- `WORDPRESS_PREPARATION_COORDINATION_PLAN.md` — текущая карта координации.
- `CRITICAL_REMEDIATION_ACTIONS.md` — чеклист обязательных блокеров и порядок закрытия до build.
- `WORDPRESS_MIGRATION_WORKFLOW.md` — расширен блоком hard-gate и критических требований AGENTS.
