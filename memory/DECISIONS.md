# Decisions Log

## 2026-07-20

- Решение: перейти от чернового описания к рабочему migration-workflow, пригодному для запуска сабагентов.
  - Причина: пользователь запросил "готовый workflow для перехода на WordPress".
  - Обоснование: в проекте уже есть исходная структура из Webasyst, требуется унифицированный план и разметка ролей.
- Решение: закрепить единый метод работы по этапам через `memory/WORDPRESS_MIGRATION_WORKFLOW.md`.
  - Причина: предотвратить разъезжание команды и потерю артефактов.
  - Обоснование: в AGENTS.md заданы строгие правила верификации и структуры артефактов.
- Решение: сохранить версии ассетов и `theme.xml` на `1.0` до релизной сборки.
  - Причина: избегать ненужного инвалидационного шума и ложных проверок.
  - Обоснование: локальная проверка через очистку компиляции шаблонов.
- Решение: не использовать zip/tar на стадии проекта.
  - Причина: сейчас требуется только план и подготовка структуры, не сборка релиза.
  - Обоснование: в правилах AGENTS указано хранить релизные артефакты в `deploy-vetritual-modern/`.

## Следующие контрольные решения (ожидаются)
- Выбор CMS-фреймворка для контента (ACF vs кастомные блоки) после аудита SEO/контента.
- Финализация матрицы редиректов 1:1 для всех URL.
- Выбор плагинов: SEO/форма/кэш с учётом минимального риска.

## 2026-07-20 (координация WP-миграции)

- Решение: формализовать распределение всех подготовительных блоков по сабагентам в новом документе `memory/WORDPRESS_PREPARATION_COORDINATION_PLAN.md` и закрывать `ready_for_build` только через `memory/WORDPRESS_CAPABILITY_MATRIX.md`.
- Решение: создать обязательные документы перед сборкой: `memory/WORDPRESS_THEME_OPTIONS_SPEC.md` и `memory/BUILD_TEMPLATE_LIST.md`.
- Решение: все блокеры (отсутствующие артефакты, неполные карты URL/настроек, отсутствующий rollout-план) считаются запрещающими для запуска build-фазы.
- Решение: закрыть критические недостатки подготовительного этапа внедрения теми документами и блоками, которые не позволяют перейти к сборке без фактов:
  - добавлен обязательный блок в `WORDPRESS_MIGRATION_WORKFLOW.md` (pre-build blockers);
  - обновлены матричные и сабагентные карты с привязкой blocker -> artifact -> owner;
  - создан `CRITICAL_REMEDIATION_ACTIONS.md` как единый чеклист закрытия блокеров.

- РÐ¿Ñ€ÐµÐ´ÐµÐ»ÐµÐ½Ð½Ð¾: Ð·Ð°Ð¿Ð¾Ð»Ð½ÐµÐ½Ñ‹ ÐºÑ€Ð¸Ñ‚Ð¸Ñ‡ÐµÑ?ÐºÐ¸Ðµ Ð°ÐºÑ‚Ð¸Ð²Ð½Ð¾Ð¹ Ð¼Ð¸Ð³Ñ€Ð°Ñ†Ð¸Ð¸ Ð·Ð°Ð´Ð°Ð½Ð½Ð¾Ð¹ Ð´Ð»Ñ? Ð¼Ð¸Ð³Ñ€Ð°Ñ†Ð¸Ð¸ Webasyst → WP.
  - ÐšÐ¾Ð´Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ð¾ Ð´Ð¾Ð´Ð°Ð½Ñ‹ Ð°Ñ€Ñ‚ÐµÐ°ÐºÑ‚Ñ‹ INVENTORY_WEBASYST.md, WEBASYST_RISK_LIST.md, CONTENT_MAP.md, PAGE_FIELD_PLAN.md.
  - Ð—Ð°ÐºÐ»ÐµÐ¹ÐµÐ½Ð¾ Ð¾Ð±Ð½Ð¾Ð²Ð»ÐµÐ½Ð¸Ðµ ARCHITECTURE_CHECKLIST.md, THEME_SETTINGS_CONTRACT.md, SEO_MIGRATION_MATRIX.md, QA_SMOKE_CHECKS.md, ROLLING_PLAN.md, RISK_LOG.md, BUILD_LOG.md в memory/.


## 2026-07-20 (Execution start - WordPress migration)

- Решение: стартовать критическое окно по устранению blockers только после того, как `agent-skill-scout` подтвердит `ready_for_build` в `memory/WORDPRESS_CAPABILITY_MATRIX.md` и запишет итог в этом журнале.
- Причина: hard-gate защищает от запуска build без закрытия архитектурной и SEO/QA готовности.
- Ожидается: `agent-theme-builder`, `agent-seo-qa`, `agent-launch-coordinator` получают разрешение только после подтверждения gate.

## 2026-07-20 (Sprint-1 start and gate coordination)

- Решение: валидационный цикл запущен как Sprint-1.
- Текущее состояние gate: `ready_for_build` находится в статусе `В ожидании` до официального подтверждения `agent-skill-scout`.
- Проверка: все обязательные документы из `11a` раздела workflow подтверждены на диске; далее разрешён только запуск `agent-theme-builder` после смены статуса gate.
- Ожидаемый следующий шаг: запись explicit решения о закрытии gate после входящего отчёта `agent-theme-builder`, `agent-seo-qa` и `agent-launch-coordinator`.

## 2026-07-20 — Hard gate closed for sprint-1

- Decision: gate eady_for_build is now set to TRUE by the orchestrator for sprint-1.
- Evidence: mandatory blocker list from WORDPRESS_MIGRATION_WORKFLOW.md section 11a is present in /memory/.
- Condition: gent-theme-builder can start after this entry and updated matrix state.