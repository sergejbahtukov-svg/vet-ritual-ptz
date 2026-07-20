# WordPress Capability Matrix (Readiness First)

## 0) Gate before build
- `ready_for_build` can be set only when all rows have status `Готов`.
- `agent-skill-scout` owns readiness, records hard-gate decisions in `memory/DECISIONS.md`, and updates this matrix in one place.

| Зона | Агент | Статус | Артефакт(ы) в `memory/` | Что нужно для перехода |
|---|---|---|---|---|
| Аудит Webasyst | `agent-audit-webasyst` | `Готов` | `INVENTORY_WEBASYST.md`, `WEBASYST_RISK_LIST.md` | Полная inventory + риски по routes, услугам, SEO и integrations. |
| Контент-маппинг страниц | `agent-content-mapper` | `Готов` | `CONTENT_MAP.md`, `PAGE_FIELD_PLAN.md` | URL/контент-карта + fallback логика полей. |
| Архитектура WP темы | `agent-wp-architecture` | `Готов` | `ARCHITECTURE_CHECKLIST.md`, `THEME_SETTINGS_CONTRACT.md`, `WORDPRESS_THEME_OPTIONS_SPEC.md` | Подтверждена контрактная архитектура Theme Settings + source-of-truth для данных. |
| Frontend и шаблоны | `agent-theme-builder` | `Готово` | `BUILD_LOG.md`, `BUILD_TEMPLATE_LIST.md` | Сформированы ключевые шаблоны (`front-page.php/page.php/404.php/header.php/footer.php`) и `template-parts/content-*.php`. |
| SEO и QA | `agent-seo-qa` | `В ожидании` | `SEO_MIGRATION_MATRIX.md`, `QA_SMOKE_CHECKS.md` | Закрыть SEO-матчинг под фактические шаблоны и пройти smoke checks. |
| Rollout/rollback | `agent-launch-coordinator` | `В ожидании` | `ROLLING_PLAN.md`, `RISK_LOG.md` | Подтвердить pilot criteria и rollback-цепочку после завершения build+qa. |
| Координация и gate | `agent-skill-scout` | `Критический блокер` | `WORDPRESS_CAPABILITY_MATRIX.md`, `DECISIONS.md` | Зафиксировать итоговый readiness и статус `ready_for_build`. |

## 1) Critical blockers перед стартом build
1. `agent-skill-scout` закрывает blocker "Gate-сертификат" и фиксирует его в `DECISIONS.md`.
2. `agent-theme-builder` blocker закрыт после передачи template-parts и core templates в `BUILD_TEMPLATE_LIST.md` / `BUILD_LOG.md`.
3. `agent-seo-qa` доводит матрицу после фактической сборки шаблонов.
4. `agent-launch-coordinator` переводит план в staging/pilot только после шага 3.

## 2) Проверки для готовности
- Текущий статус должен быть в следующей последовательности:
  1) Архитектурные документы и контент-мэпинг — `Готов`.
  2) `agent-skill-scout` ставит `ready_for_build`.
  3) Перед build нельзя выпускать `deploy-vetritual-modern/` архив или обновлять release-ветку.
- После запуска сборки:
  - все критичные проверки по URL/SEO/consent идут через smoke-check в `QA_SMOKE_CHECKS.md`,
  - rollout не стартует без подтвержденных рисков в `RISK_LOG.md`.

## 1b) Execution queue for start (2026-07-20)

- `agent-skill-scout`: set `ready_for_build` and add official decision entry.
- `agent-theme-builder`: start only after gate, focus areas from `memory/BUILD_TEMPLATE_LIST.md`.
- `agent-seo-qa`: validate migration SEO and smoke list.
- `agent-launch-coordinator`: prep/stabilize rollback triggers and staging->pilot control flow.

### Hard dependency
- `ready_for_build` must be explicitly set before any production build handoff.

## 0a) Sprint 1 gate status (2026-07-20)
- `ready_for_build`: **В ожидании**
- Blocker: explicit gate approval from `agent-skill-scout` is still required in `memory/DECISIONS.md` before any build handoff.
- Required completion before flip:
  1) Verify all mandatory artifacts from `11a` of `WORDPRESS_MIGRATION_WORKFLOW.md` exist (currently confirmed on disk).
  2) Confirm theme settings contract, SEO matrix and QA smoke checks are aligned with implementation owner.
  3) Confirm `agent-theme-builder` starts only after gate closure.

## 3) Active execution notes
- `agent-skill-scout` remains primary gate keeper and release validator.
- `agent-theme-builder` has first build slice queued:
  - `front-page.php`, `page.php`, `404.php`, `header.php`, `footer.php`, `template-parts/*`, `assets/js/integrations.js`.
- `agent-seo-qa` slice queued after first template implementation commit.
- `agent-launch-coordinator` slice queued after QA smoke check pass.

## 2026-07-20 Sprint-1 live status board

| Stage | Owner | Status | Start condition | Output owner |
|---|---|---|---|---|
| Gate closure | `agent-skill-scout` | `� ������` | Ready to audit artifacts from `11a` | `memory/DECISIONS.md`, `memory/WORDPRESS_CAPABILITY_MATRIX.md` |
| Build slice 1 | `agent-theme-builder` | `� ��������` | `ready_for_build = true` | `memory/BUILD_LOG.md` |
| SEO/QA pass | `agent-seo-qa` | `� ��������` | Build slice 1 done | `memory/SEO_MIGRATION_MATRIX.md`, `memory/QA_SMOKE_CHECKS.md` |
| Rollout prep | `agent-launch-coordinator` | `� ��������` | SEO/QA pass done | `memory/ROLLING_PLAN.md`, `memory/RISK_LOG.md` |

Hard rule remains: build handoff is blocked until `ready_for_build` is true in matrix + decision.

## 2026-07-20 15:33 -- Sprint-1 hard gate closure (live)

- eady_for_build = true set by gent-skill-scout.
- Mandatory blocker audit done from WORDPRESS_MIGRATION_WORKFLOW.md section 11a.
- Mandatory artifact files exist in /memory/:
  - INVENTORY_WEBASYST.md
  - WEBASYST_RISK_LIST.md
  - CONTENT_MAP.md
  - PAGE_FIELD_PLAN.md
  - ARCHITECTURE_CHECKLIST.md
  - THEME_SETTINGS_CONTRACT.md
  - WORDPRESS_THEME_OPTIONS_SPEC.md
  - BUILD_TEMPLATE_LIST.md
  - BUILD_LOG.md
  - SEO_MIGRATION_MATRIX.md
  - QA_SMOKE_CHECKS.md
  - ROLLING_PLAN.md
  - RISK_LOG.md
- Queue state update:
  - Gate closure: DONE
  - Build slice 1: OPEN
  - SEO/QA pass: WAITING
  - Rollout prep: WAITING
- Hard rule: no build handoff before gate decision + matrix alignment in this doc.