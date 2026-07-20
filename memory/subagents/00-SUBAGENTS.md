# Subagent Matrix для WordPress

## `agent-skill-scout`
- Задача: построить карту компетенций перед этапом разработки.
- Что делает:
  - проверяет, какие навыки из `WORDPRESS_SKILLS.md` действительно доступны;
  - формирует `memory/WORDPRESS_CAPABILITY_MATRIX.md`;
  - закрывает пробелы по компетенциям:
    - назначение владельца,
    - внутренний spike,
    - внешний консультант/плагин.
- Результат: только после закрытия критичных пробелов даёт разрешение `ready_for_build`.

## `agent-audit-webasyst`
- Задача: аудит Webasyst-кода, шаблонов и интеграций.
- Вывод:
  - список страниц/route/content-секций;
  - риск-лист по SEO и интеграциям.
- Theme settings блок: указывает, что уже можно вынести в Theme Settings.

## `agent-content-mapper`
- Задача: сопоставить URL/контент Webasyst с WP-структурой.
- Вывод:
  - `CONTENT_MAP.md`
  - `PAGE_FIELD_PLAN.md`
- Theme settings блок: пометка глобальных полей для ACF/Options/Customizer.

## `agent-wp-architecture`
- Задача: архитектура WP темы.
- Вывод:
  - `ARCHITECTURE_CHECKLIST.md`
  - `THEME_SETTINGS_CONTRACT.md`
- В контракте должно быть:
  - `inc/helpers/theme-options.php`,
  - helper `vr_theme_setting($key, $default = '')`,
  - источник значений: options/customizer/acf/ defaults;
  - `theme.json` токены.
- Запрет: шаблоны не читают настройки напрямую из `get_option()`, только через helper.

## `agent-theme-builder`
- Задача: перенос шаблонов и UI-построение.
- Вывод:
  - `BUILD_LOG.md`
  - подготовленные `template-parts`
- Theme settings блок: все клиентские тексты и секции только через `vr_theme_setting()` и ACF helper.

## `agent-seo-qa`
- Задача: SEO и валидация качества миграции.
- Вывод:
  - `SEO_MIGRATION_MATRIX.md`
  - `QA_SMOKE_CHECKS.md`
- Theme settings блок: проверка управляемых SEO-параметров (название, title/description/OG, robots flags).

## `agent-launch-coordinator`
- Задача: rollout и rollback.
- Вывод:
  - `ROLLING_PLAN.md`
  - `RISK_LOG.md`
- Theme settings блок: пилотно проверить пользовательские смены без деплоя кода.

## Правило по управляемости
- Любая настраиваемая для клиента логика не должна жить в шаблонах.
- Если параметр должен меняться чаще 1 раза в месяц, он идет в Theme Settings.
## Critical blockers for prep stage (shared)

- `agent-audit-webasyst` must deliver full inventory before build.
- `agent-content-mapper` must deliver URL/field mapping before theme-builder starts.
- `agent-wp-architecture` must deliver `WORDPRESS_THEME_OPTIONS_SPEC.md` + `THEME_SETTINGS_CONTRACT.md` and approved fallback strategy before build.
- `agent-seo-qa` must deliver `SEO_MIGRATION_MATRIX.md` + smoke URLs.
- `agent-launch-coordinator` must deliver rollback-ready `ROLLING_PLAN.md` + `RISK_LOG.md`.
- `agent-skill-scout` is the only owner that can set `ready_for_build`.

Critical blockers close only after these items are in `memory/WORDPRESS_CAPABILITY_MATRIX.md` as `Готов` and recorded in `memory/DECISIONS.md`.
