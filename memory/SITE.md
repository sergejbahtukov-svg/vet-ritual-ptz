# SITE — сайт и инфраструктура

## Живые проверки (источник правды)
- Проверочный URL:
  - `https://vetritual.lvh.me/`
  - fallback: `http://vetritual.lvh.me/` если HTTPS блокируется
- Source of truth для текущего этапа:
  - `C:\xampp\webasyst-local\wa-data\public\site\themes\vetritual-modern\`

## Разделы проекта
- Исходники WordPress-ветки: `wordpress-theme/` (подготовительный артефакт).
- Source в локально обслуживаемом Webasyst: `vetritual-modern/` (рабочая зона).
- Архивы релиза только в `deploy-vetritual-modern/`.

## Риск-важности для миграции
- Наиболее важны URL стабильность, корректность `page.html` роутинга, и поведение SEO-блоков.
- Изменения проверяются только через локальную Webasyst точку, а не через `preview.html`.

## Не определено
- Рекомендуемая архитектура кеширования/CI/CD для финального деплоя — `не определено`.
- План staged rollout в проде — `не определено`.

## Текущий статус
- Обновление структуры сайта под WordPress идёт по рабочему workflow и не меняет production‑продукт без gate.

