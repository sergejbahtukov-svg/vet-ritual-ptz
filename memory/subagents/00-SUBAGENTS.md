# Subagent Matrix для перехода на WordPress

## `agent-audit-webasyst`
- Задача: сделать исчерпывающий аудит Webasyst исходников.
- Выход:
  - список файлов шаблонов и функций,
  - список URL и их назначение,
  - список интеграций и параметров конфигурации,
  - список рисков при парсинге Smarty-логики.

## `agent-content-mapper`
- Задача: связать Webasyst-контент с будущими WP структурами.
- Выход:
  - карта маршрутов (`Webasyst slug` -> `WP route/page`),
  - структура ACF/поля для услуг и страниц,
  - перенос блоков главной и внутренних страниц,
  - правило SEO-цепочки для каждого URL.

## `agent-wp-architecture`
- Задача: спроектировать WP-тему и техархитектуру.
- Выход:
  - структура файлов и зависимостей темы,
  - `functions.php` контракт (`enqueue`, меню, post data),
  - список необходимых плагинов,
  - стратегия redirects и canonical.

## `agent-theme-builder`
- Задача: перенести UI/markup/behavior в WordPress partials.
- Выход:
  - partial plan (`template-parts`),
  - план миграции JS и CSS,
  - список адаптивных компонентов и их тестов,
  - оценка сложности визуальных блоков.

## `agent-seo-qa`
- Задача: SEO и контроль качества.
- Выход:
  - список обязательных SEO полей,
  - матрица canonical и redirect,
  - список 404, дублей и пропущенных страниц,
  - smoke-check checklist по desktop/mobile.

## `agent-launch-coordinator`
- Задача: координация rollout.
- Выход:
  - staging plan и график,
  - план pilot,
  - rollback plan с критериями отката,
  - финальный checklist перед релизом.

## Cross-agent правила
- Все выводы каждого сабагента должны ссылаться на источники из `memory/EVIDENCE.md`.
- Любой спорный пункт помечать как `Assumption` до валидации в коде.
- Если обнаружена логическая дыра — сразу обновлять `DECISIONS.md`.

