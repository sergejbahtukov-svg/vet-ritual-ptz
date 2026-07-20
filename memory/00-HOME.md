# Проектный дом: входная карта

## Что это
- Проект: `Vet Ritual Modern`, сейчас на Webasyst, планируется переход на WordPress.
- Основная цель: спланировать миграцию без потери контента, структуры URL и SEO.
- Текущее исходное место: `vetritual-modern/` (Webasyst тема).

## Текущий статус
- Кодовая база расположена в `C:\Users\sbaht\OneDrive\Документы\вет ритуал птз\`.
- Живой сайт и проверочный URL:
  - `https://vetritual.lvh.me/`
  - (если HTTPS недоступен) `http://vetritual.lvh.me/`
- Исходники Webasyst темы для правок: `C:\xampp\webasyst-local\wa-data\public\site\themes\vetritual-modern\`
- Правило верификации: проверка только через реальный Webasyst URL, `preview.html` — только как черновой просмотр.

## Что уже зафиксировано
- В проекте создана структура памяти:
  - `memory/WORDPRESS_MIGRATION_WORKFLOW.md`
  - `memory/WORDPRESS_SKILLS.md`
  - `memory/subagents/00-SUBAGENTS.md`
  - `memory/subagents/WORDPRESS_ASSIGNMENTS.md`
- Документы частично нуждаются в нормализации и уточнении под исполняемый план.

## Базовые правила разработки
- Версия темы и query string у ассетов держать на `1.0` до релиза.
- Не править `wa-cache` руками без необходимости; использовать чистку только целевого каталога шаблонов.
- Не плодить архивы миграции вне `deploy-vetritual-modern/`.
- Обязательно собирать все артефакты миграции в памяти:
  - `memory/WORKLOG.md`
  - `memory/DECISIONS.md`
  - `memory/EVIDENCE.md`

## Как стартовать работу
1. Прочитать `AGENTS.md`.
2. Обновить `memory/00-HOME.md` и `memory/01-NOW.md`.
3. Выдать команде сабагентов точные входные данные из этого проекта:
   - список страниц и шаблонов,
   - интеграции и SEO-правила,
   - требования по аналитике и согласиям на cookie.
4. Запустить поэтапный `memory/WORDPRESS_MIGRATION_WORKFLOW.md`.

