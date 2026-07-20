# Rolling Plan: staging → pilot → production

## 1) Stage 1 — Staging
1. Собираем WP тему по чеклисту `ARCHITECTURE_CHECKLIST.md`.
2. Подтверждаем все критические артефакты из `WORDPRESS_CAPABILITY_MATRIX.md`:
   1. INVENTORY_WEBASYST,
   2. CONTENT_MAP,
   3. PAGE_FIELD_PLAN,
   4. THEME_SETTINGS_CONTRACT,
   5. SEO_MIGRATION_MATRIX,
   6. QA_SMOKE_CHECKS.
3. Прогон smoke по локальной инсталляции.
4. Проверить redirect-алиасы и SEO-фолбеки.

## 2) Stage 2 — Pilot
1. Развернуть только на staging-клоне с ограниченной аудиторией.
2. Проверить формы/CTA/телефон/контакты.
3. Проверить analytics/cookie режим на 3 браузерах.
4. Зафиксировать поведение 404.

## 3) Stage 3 — Production Release
1. Freeze темы:
   1. `theme.xml` и asset query остаются `1.0` до релиза.
2. Переключить DNS/host без параллельного изменения редиректов.
3. Проверить первые 100 страниц/ссылок из `AGENTS.md` smoke-set.
4. Зафиксировать в `DECISIONS.md` и архивировать в `deploy-vetritual-modern/`.

## 4) Rollback Triggers
1. SEO regression (canonical/404/robots).
2. Неизменный белый экран или критические JS ошибки.
3. Потеря форм/контактов на `/kontakty/`, `/uslugi/`, `/`.
4. Ошибки перенаправлений с alias URLs.

## 5) Rollback Steps
1. Откатить на последнюю рабочую версию Webasyst.
2. Отключить интеграции в WP (если вызвали конфликт).
3. Вернуть настройки DNS/URL до состояния pre-cutover.

