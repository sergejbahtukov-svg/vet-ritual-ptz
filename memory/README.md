# Личное wiki проекта (LLM/WordPress workflow)

## Что это за набор
- Набор документов для управляемой миграции Webasyst темы `vetritual-modern` в WordPress.
- Все материалы сфокусированы на воспроизводимости: каждое решение и шаги миграции зафиксированы.

## Главные файлы
- `00-HOME.md` — текущее состояние и рамки проекта.
- `01-NOW.md` — что делаем в этом спринте.
- `PROJECT.md` — границы проекта и источники правды.
- `OFFER.md` — текущее предложение и ограничения.
- `AUDIENCES.md` — сегменты аудитории.
- `FUNNEL.md` — логика воронки/цепочки пользовательских сценариев.
- `SITE.md` — структура сайта, технические параметры и инфраструктура.
- `ADS.md` — рекламные каналы и перетоки.
- `ANALYTICS.md` — метрики, источники данных и интеграции аналитики.
- `DECISIONS.md` — принятые решения и рисковые точки.
- `WORKLOG.md` — журнал выполнения.
- `EVIDENCE.md` — фиксация подтверждений из исходника.
- `WORDPRESS_MIGRATION_WORKFLOW.md` — готовый технический план миграции.
- `WORDPRESS_SKILLS.md` — набор технологий и навыков для команды/сабагентов.
- `subagents/00-SUBAGENTS.md` — матрица ролей.
- `subagents/WORDPRESS_ASSIGNMENTS.md` — текущая доска задач.
- `memory-cleanup-protocol.md` — самопроверка/самоочистка памяти.
- `scripts/memory-gc.ps1` — неразрушающий аудит «сиротних» wiki-файлов.

## Правило работы
1. Вход всегда через `AGENTS.md`.
2. Ключевая проверка идёт на `https://vetritual.lvh.me/`.
3. Доменные входы: `OFFER.md`, `AUDIENCES.md`, `FUNNEL.md`, `SITE.md`, `ADS.md`, `ANALYTICS.md`.
4. Все финальные решения и результаты записывать в `DECISIONS.md`, `WORKLOG.md`, `EVIDENCE.md`.
5. Проверка целостности памяти выполняется по `memory-cleanup-protocol.md`.

## Как начать
- Сначала открыть `AGENTS.md`.
- Затем пройти базовый маршрут: `memory/README.md` → `00-HOME.md` → `01-NOW.md`.
- Дальше: открыть доменную карту из `OFFER.md`/`AUDIENCES.md`/`FUNNEL.md`/`SITE.md`/`ADS.md`/`ANALYTICS.md`.
- После этого запускать `memory/WORDPRESS_MIGRATION_WORKFLOW.md`.

## Еженедельная дисциплина памяти
- Один раз в неделю выполнять:
  - `powershell -NoProfile -File memory\\scripts\\memory-gc.ps1`
  - Проверять отчёт `memory\\memory-cleanup-report-<дата>.md`
  - Удаление и архивирование неиспользуемых файлов — только после ручного подтверждения в `DECISIONS.md` и в рамках `ready_for_clean`.
