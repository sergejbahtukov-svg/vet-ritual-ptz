# WordPress Migration Workflow — Vet Ritual Modern

## 0. Цель
- Перенести сайт с текущей Webasyst темы `vetritual-modern` на WordPress с сохранением:
  - URL-структуры,
  - SEO-настроек и мета-блоков,
  - блоков контента и маршрутов,
  - логики интеграций и cookie-согласий.
- Обеспечить тему, которую можно настраивать без изменений кода: текст, контакты, CTA, секции, SEO-поля, визуальные токены.

## 1. Исходная диагностика Webasyst
1. Собрать карту сайта:
   - `/`
   - `/o-nas/`
   - `/uslugi/`
   - `/usyplenie-zhivotnyh/`
   - `/usyplenie-koshek/`
   - `/usyplenie-sobak/`
   - `/krematsyja-zhivotnyh/`
   - `/obschaja-krematsyja/`
   - `/individualnaja-krematsyja/`
   - `/vyvoz-zhivotnyh/`
   - `/vyvoz-umershih-zhivotnyh/`
   - `/vyvoz-umershikh-zhivotnyh/`
   - `/vyvoz-tela-zhivotnogo/`
   - `/tseny/`
   - `/kontakty/`
   - `/about/` (резолв через `o-nas`)
   - `/404/`
2. Зафиксировать глобальные блоки:
   - `header.html`,
   - `footer.html`,
   - элементы меню, контакты, логотип/бренд-акценты.
3. Зафиксировать SEO и мета:
   - title/description/OG,
   - canonical,
   - verification meta,
   - schema JSON-LD (`LocalBusiness`, `WebPage`).
4. Зафиксировать JS/интеграции:
   - UI и поведенческие модули из `theme.js`,
   - `integrations.js` (режимы аналитики, событие `vr:cookie-accepted`).

## 2. Карта контента и маппинг страниц
1. `index.html` -> `index.php` + `front-page.php`/`page.php` оболочка.
2. `home.html` -> `front-page.php` + `template-parts/home/*`.
3. `about.html` -> reusable partial.
4. `page.html` -> `page.php` с роутингом и ACF.
5. `error.html` -> `404.php`.
6. `css/theme.css` -> `assets/css/theme.css`.
7. `js/theme.js` -> `assets/js/theme.js`.
8. `js/integrations.js` -> `assets/js/integrations.js` (либо `inc/integrations.php`).
9. Разбить секции на `template-parts` и связать с полями контента.

## 3. Архитектура темы WordPress
1. Базовая структура темы:
   - `style.css`
   - `functions.php`
   - `index.php`
   - `front-page.php`
   - `page.php`
   - `single.php`
   - `404.php`
   - `header.php`
   - `footer.php`
   - `template-parts/`
   - `inc/`
   - `assets/css`, `assets/js`, `assets/img`
   - `theme.json`
2. Обязательные возможности:
   - регистрация меню,
   - enqueue скриптов/стилей,
   - базовая безопасность экранирования (`esc_html`, `esc_url`, `wp_kses_post`),
   - совместимость с SEO плагином.
3. Контентная модель:
   - базовые страницы через `page`,
   - структурированные поля через ACF/мета-поля `page`,
   - минимально возможные CPT только при явной необходимости.

## 4. Theme Settings (главный слой пользовательской настройки без кода)
1. Реализовать единый слой настроек темы:
   - **Customizer**: визуальные базовые поля (цвета, типографика, кнопки, логотип, фавикон, отступы секций).
   - **Theme Options (Settings API / ACF Options Page)**: бизнес-данные и SEO.
   - **theme.json**: глобальные токены (`color`, `spacing`, `typography`) для editor-aware настроек.
2. Единый конфиг доступа в коде:
   - создать `inc/helpers/theme-options.php`
   - `vr_theme_setting($key, $default = '')` для всех шаблонов,
   - кеширование через транзиенты при сохранении опций.
3. Обязательные группы настроек:
   - **Бренд и контакты**: телефон, адрес, email, часы работы, соцссылки.
   - **Контент верхнего уровня**: блок `hero`, CTA, подвал, контакты, короткие блоки доверия.
   - **Отключаемые секции**: главная, услуги, цены, отзывы, контакты.
   - **SEO/технические поля**: заголовки, описания, OG fallback, `robots noindex`, canonical override.
   - **Аналитика и privacy**: режим аналитики, ID метрик, текст и текст кнопок cookie consent.
4. Правило интеграции:
   - пользовательские изменения должны применяться только через `theme_setting()` + `theme options`/Customizer.
   - прямое жёсткое редактирование шаблонов — только для разработческой доработки через отдельный changelog.
5. Проверка совместимости:
   - при смене темы через Customizer убедиться, что все блоки отображаются и сохраняются.

## 5. Интеграции и consent
1. Перенос cookie-соглашения:
   - persistent banner,
   - событие `vr:cookie-accepted`,
   - режимы: `always`, `on_consent`, `disabled`.
2. Перенос аналитики:
   - Yandex Metrika,
   - Google Analytics 4,
   - Google Tag Manager,
   - Meta Pixel,
   - VK Pixel,
   - TopMailRu,
   - TikTok.
3. Контактные блоки и формы:
   - единая точка хранения номеров/адресов/достоверности данных в theme settings.

## 6. SEO и редиректы
1. Мигрировать canonical/title/description в 1:1 матрицу.
2. Настроить legacy и альтернативные URL из `page.html`.
3. Настроить robots/sitemap после наполнения WP.
4. Проверки:
   - 404/duplicate,
   - мета для всех обязательных страниц,
   - схема/валидность OpenGraph.

## 7. QA и rollout
1. Стейдж-план:
   - WP staging,
   - URL smoke-check,
   - SEO/мета/схема,
   - интеграции и формы,
   - производительность и кэш.
2. Smoke-URL:
   - `/`
   - `/usyplenie-zhivotnyh/`
   - `/krematsyja-zhivotnyh/`
   - `/vyvoz-zhivotnyh/`
   - `/kontakty/`
   - `/404/`
3. Результаты писать в `EVIDENCE.md` и `WORKLOG.md`.

## 8. Launch
1. Rollout: staging -> pilot -> production.
2. Перед launch:
   - HTTPS, редирект-цепочки, работа форм, события аналитики, cookie-поток.
3. Откат:
   - сохранить резервный способ возврата на текущий Webasyst сайт до полного закрытия приемки.

## 9. Роли сабагентов
1. `agent-skill-scout` — инвентаризация и покрытие скиллов (перед стартом разработки).
2. `agent-audit-webasyst` — аудит шаблонов/интеграций и рисков.
3. `agent-content-mapper` — URL/content mapping + АCF/структура блоков.
4. `agent-wp-architecture` — структура темы + hooks + theme settings API контракт.
5. `agent-theme-builder` — перенос `partial`-структуры и UI, поддержка настроек.
6. `agent-seo-qa` — SEO-матрица и чек-листы.
7. `agent-launch-coordinator` — rollout и rollback.

## 10. Обязательные артефакты
- `memory/00-HOME.md`
- `memory/01-NOW.md`
- `memory/EVIDENCE.md`
- `memory/WORDPRESS_SKILLS.md`
- `memory/WORDPRESS_THEME_OPTIONS_SPEC.md`
 - `memory/subagents/WORDPRESS_ASSIGNMENTS.md`
 - `memory/WORDPRESS_CAPABILITY_MATRIX.md`

## 11. Поиск и интеграция скиллов (новый gate)
1. До старта технической миграции запустить `agent-skill-scout`:
   - актуализировать все требуемые навыки по проекту;
   - сверить их с реальными возможностями команды;
   - закрыть пробелы или спланировать закрытие.
2. Для каждой критичной задачи, которая не покрыта:
   - назначить владельца;
   - дать срок закрытия;
   - зафиксировать fallback-план.
3. Только после статуса `ready_for_build` переходить в `agent-wp-architecture`.
4. Любое обновление воркфлоу должно обновлять:
   - `WORDPRESS_CAPABILITY_MATRIX.md`;
   - роли/зоны ответственности сабагентов;
   - список обязательных артефактов.

## 11a. Mandatory blocker list before BUILD stage (critical fixes)

1. `ready_for_build` is valid only when all required artifacts exist and are completed:
- `memory/INVENTORY_WEBASYST.md`
- `memory/WEBASYST_RISK_LIST.md`
- `memory/CONTENT_MAP.md`
- `memory/PAGE_FIELD_PLAN.md`
- `memory/ARCHITECTURE_CHECKLIST.md`
- `memory/THEME_SETTINGS_CONTRACT.md`
- `memory/WORDPRESS_THEME_OPTIONS_SPEC.md`
- `memory/BUILD_TEMPLATE_LIST.md`
- `memory/BUILD_LOG.md`
- `memory/SEO_MIGRATION_MATRIX.md`
- `memory/QA_SMOKE_CHECKS.md`
- `memory/ROLLING_PLAN.md`
- `memory/RISK_LOG.md`

2. Ни одна сборочная задача не стартует, пока `agent-skill-scout` не отметит в `memory/WORDPRESS_CAPABILITY_MATRIX.md` статус всех направлений как `Готов` и не зафиксирует это в `memory/DECISIONS.md`.

3. Перед любыми локальными проверками по шаблонам и темплейтам:
- Проверка только через `https://vetritual.lvh.me/` (`http://vetritual.lvh.me/` как fallback).
- Синхронизация изменений через проектную директорию Webasyst из `AGENTS.md`.
- Очистка `C:\xampp\webasyst-local\wa-cache\101524\apps\site\templates\compiled` при отсутствии эффектов после правок шаблонов.
- Версии `theme.xml` и `?v=` строго `1.0` до официального релиза.

4. Для релиза/миграции обязательны:
- `ROLLING_PLAN.md` с сценариями staging -> pilot -> production.
- `RISK_LOG.md` с четким rollback trigger.
- Минимальный data fallback для theme settings и безопасные дефолты на уровне helper.
