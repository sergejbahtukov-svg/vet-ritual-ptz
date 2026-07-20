# Risk Log (migration)

## 1) Open Items
1. Alias integrity — сохранение `/about/` и legacy `/vyvoz-*` в SEO-нейтральном режиме.
2. Контентный drift в `page.content` между Webasyst и WP при переходе из редактора.
3. `integrations.js` может загрузиться без согласия из-за кэша скриптов.
4. Неполное покрытие menu schema в header/footer на алиасах.
5. Несвоевременные изменения `?v=` версии файлов ломают кэширование.

## 2) Mitigation Owners
1. `agent-content-mapper` — alias map + canonical strategy.
2. `agent-theme-builder` + `agent-wp-architecture` — content renderer + helper fallback.
3. `agent-theme-builder` — режимы consent и блоки.
4. `agent-theme-builder` — header/footer route consistency.
5. `agent-skill-scout` — контроль версии и hard-gate.

## 3) Escalation policy
1. Если на smoke обнаружен 404/редирект цикл, стоп и вернуть в `theme_builder`/`warchitecture` слой.
2. Если интеграции нарушают согласие пользователей — временно поставить `disabled` и задокументировать.
3. Если alias-каноника ломается — не открывать для pilot до исправления.
4. Каждая критичная блокировка фиксируется в `WORKLOG.md` и `DECISIONS.md`.

