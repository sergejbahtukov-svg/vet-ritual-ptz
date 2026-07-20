# WordPress Migration — Assignment Board

## Что нужно сделать
- Сделать так, чтобы у каждого сабагента был конкретный артефакт на handoff.

## Board
1. `agent-audit-webasyst` — `READY`  
   Задача:
   1. Закрыть аудит всех шаблонов и JS.
   2. Выдать "Route Inventory", "Integration Inventory", "Risk List".
   3. Сдать ссылку на итоговый документ.

2. `agent-content-mapper` — `READY`  
   Задача:
   1. Подготовить `URL Mapping` Webasyst -> WP.
   2. Подготовить `Section Mapping` для home/about/service/prices.
   3. Выдать рекомендуемую схему ACF.

3. `agent-wp-architecture` — `READY`  
   Задача:
   1. Спроектировать структуру темы и порядок файлов.
   2. Дать список обязательных плагинов и точек расширения.
   3. Подготовить шаблон `functions.php`-контракта.

4. `agent-theme-builder` — `READY`  
   Задача:
   1. Подготовить структуру partials и миграционный план UI.
   2. Зафиксировать, какие блоки переносить как частичные шаблоны, а какие как ACF-блоки.

5. `agent-seo-qa` — `READY`  
   Задача:
   1. Подготовить миграцию SEO полей и canonical map.
   2. Список редиректов и 404-gap.
   3. Чек-лист smoke-проверок.

6. `agent-launch-coordinator` — `READY`  
   Задача:
   1. Составить план staging → pilot → production.
   2. Сроки и критерии Go/No-Go.
   3. Rollback script + fallback-контакт.

## Нормы handoff
- Формат сдачи: Markdown со ссылками на файлы памяти и короткой таблицей `файл | риск | решение`.
- Срок первого статуса: до конца дня.
- Каждая недоделка переводит задачу в `BLOCKED`, если не подтверждена.

