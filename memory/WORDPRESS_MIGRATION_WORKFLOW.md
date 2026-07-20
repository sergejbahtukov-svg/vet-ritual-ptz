# WordPress Migration Workflow — Vet Ritual Modern

## 0. Цель
- Перенести сайт с текущей Webasyst темы `vetritual-modern` на WordPress с сохранением:
  - URL-структуры,
  - SEO-сигналов и мета-тегов,
  - карточек контента и блоков секций,
  - поведения интеграций/аналитики и cookie-согласий,
  - форм и контактной логики.

## 1. Исходная диагностика (Webasyst)
1. Собрать карту сайта из `index.html` и `page.html`.
2. Зафиксировать все страницы и маршруты:
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
   - `/about/` (по факту через `o-nas`)
   - `/404/`
3. Зафиксировать глобальные элементы из `header.html` и `footer.html`.
4. Зафиксировать SEO и мета-логику из `index.html`:
   - title/description/OG,
   - canonical,
   - verification meta,
   - schema JSON-LD (`LocalBusiness`, `WebPage`).
5. Зафиксировать JS-логику:
   - UI из `theme.js`,
   - интеграции из `integrations.js` и режимы `analyticsMode`,
   - события согласия `vr:cookie-accepted` и ленивый запуск пикселей.

## 2. Блоки миграции контента
1. Карта шаблонов:
   - `index.html` -> `page.php` + общая обёртка `header.php/footer.php`.
   - `home.html` -> `front-page.php` + partial `template-parts/home/*`.
   - `about.html` -> частичный блок в `template-parts/sections/about.php`.
   - `page.html` -> `page.php` с условной маршрутизацией + ACF поля.
   - `error.html` -> `404.php`.
2. Ресурсы и ассеты:
   - `css/theme.css` -> `assets/css/theme.css`.
   - `js/theme.js` -> `assets/js/theme.js`.
   - `js/integrations.js` -> `assets/js/integrations.js` или `inc/integrations.php`.
3. Карта содержимого:
   - Услуги: hero, краткое описание, список услуг, ценовые карточки, этапы, CTA, блоки доверия.
   - Контент страниц (контакты/цены/о компании) переносить в `page meta` или ACF-группы.

## 3. Техархитектура WordPress
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
2. Конфигурация функций:
   - регистрация меню и widget area,
   - подключение CSS/JS через `wp_enqueue_*`,
   - безопасность escaping (`esc_html`, `esc_url`, `wp_kses_post`),
   - фильтры для SEO полей (`yoast`/`rankmath` совместимость).
3. Контентная модель:
   - базовые страницы: `page` + ACF для структурированных блоков,
   - приоритет простого и стабильного варианта без лишнего CPT,
   - CPT только при необходимости для повторяемых блоков блога/отзывов.

## 4. Критичные интеграции
1. Перенести систему cookie-consent:
   - banner + persist-состояние,
   - запуск аналитик только после согласия (или always/disabled из настройки).
2. Перенести загрузку метрик:
   - Yandex Metrika,
   - Google Analytics 4,
   - Google Tag Manager,
   - Meta Pixel,
   - VK Pixel,
   - TopMailRu,
   - TikTok (по возможности через существующую конфигурацию).
3. Контакты и кнопки:
   - телефон, адрес, соцссылки и почтовые контакты из Webasyst.

## 5. SEO и маршруты
1. Редиректы:
   - Промежуточные / legacy-алиасы из Webasyst в WP.
   - Базовые алиасы из `page.html` для вывоза должны идти 1:1.
2. Мета-данные:
   - title/description per-page,
   - canonical 1:1 по URL,
   - OG/Twitter из существующих значений.
3. Карта сайта/Robots:
   - настроить после миграции контента.
4. Проверки SEO:
   - отсутствующие/дублирующиеся title,
   - canonical на 404 и служебных страницах,
   - корректная разметка локального бизнеса.

## 6. QA и переход
1. Stage-контроль:
   - Stage 1: локальный WP staging, smoke-check URL,
   - Stage 2: контент и SEO-валидатор,
   - Stage 3: интеграции и формы,
   - Stage 4: производительность и кэши,
   - Stage 5: pilot.
2. Смоук-страницы (мини-черновой чек):
   - `/`
   - `/usyplenie-zhivotnyh/`
   - `/krematsyja-zhivotnyh/`
   - `/vyvoz-zhivotnyh/`
   - `/kontakty/`
   - `/404/`
3. Результаты каждого шага документировать в `EVIDENCE.md` и `WORKLOG.md`.

## 7. Launch
1. Окончательное переключение через короткий maintenance-режим.
2. Проверка:
   - HTTPS,
   - redirect chain,
   - формы обратной связи,
   - analytics events.
3. Резервный план:
   - хранить возможность быстрого отката на Webasyst до подтверждения полной проверки.
4. После go-live:
   - обновить архивы в `deploy-vetritual-modern/`,
   - закрыть задачу в рабочем журнале.

## 8. Ролевая модель сабагентов
1. `agent-audit-webasyst` — делает полный инвентаризационный отчёт из шаблонов и компонентов.
2. `agent-content-mapper` — описывает соответствие URL/контента и рекомендует контент-модель WP.
3. `agent-wp-architecture` — проектирует тему и зависимости WP.
4. `agent-theme-builder` — переносит разметку/стили/скрипты в partial-based структуру.
5. `agent-seo-qa` — фиксирует SEO/редиректы/чек-листы тестов.
6. `agent-launch-coordinator` — ведёт staging → production и rollback.

## 9. Входные артефакты для старта команды
- `memory/00-HOME.md`
- `memory/01-NOW.md`
- `memory/EVIDENCE.md`
- `memory/WORDPRESS_SKILLS.md`
- `memory/subagents/WORDPRESS_ASSIGNMENTS.md`

