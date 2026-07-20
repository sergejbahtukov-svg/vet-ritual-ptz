# Memory cleanup protocol

## Цель
Ограничить шум в LLM-wiki, чтобы субагенты и люди работали только с текущими и связанными артефактами.

## Что считается активным
- Обязательные файлы (блокируются от удаления автоматически):
  - `AGENTS.md`
  - `memory/README.md`
  - `memory/00-HOME.md`
  - `memory/01-NOW.md`
  - `memory/PROJECT.md`
  - `memory/DECISIONS.md`
  - `memory/WORKLOG.md`
  - `memory/EVIDENCE.md`
- Все доменные карты в работе (`OFFER`, `AUDIENCES`, `FUNNEL`, `SITE`, `ADS`, `ANALYTICS`).
- Все файлы, на которые есть прямые ссылки в других памяти-файлах.

## Еженедельная проверка
1. Запустить отчет:
   - `powershell -NoProfile -File memory\\scripts\\memory-gc.ps1`
2. Проверить `memory-cleanup-report-YYYY-MM-DD_HH-mm.md`:
   - **Orphans** — кандидаты на очистку (неиспользуемые, не привязанные).
   - **Stale orphans** — неактивные более чем `-StaleDays` (по умолчанию 45).
3. В `DECISIONS.md` зафиксировать `ready_for_clean`, если нужны удаление/архивация.

## Правила удаления
- По умолчанию скрипт **не удаляет** ничего (dry-run).
- Удаление выполняется только вручную через `-DeleteOrphans` с отдельным подтверждением.
- Удаление неиспользуемых архивов/копий вне `memory/*` не входит в этот протокол.

