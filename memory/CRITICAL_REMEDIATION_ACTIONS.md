# РљСЂРёС‚РёС‡РµСЃРєРёРµ РґРѕРЅР°Р±РёСЂРѕРІ (РіРѕС‚РѕРІРЅРѕСЃС‚СЊ Рє build)

## 1. Р§С‚Рѕ Р±Р»РѕРєРёСЂСѓРµС‚ СЃС‚Р°СЂС‚ РїРѕРЅРёРјР°Р»СЋС€СЊСЃСЏ СЃРѕРєРѕСЂРµРЅРѕРІРЅРѕРіРѕ СЃРєРѕР»РІРµСЂРµРЅР° (СЌС‚Рѕ 2026-07-20)

- [x] РџРѕР»РЅС‹Р№ РёРЅРІРµРЅС‚Р°СЂСЊ Webasyst Рё СЂРёСЃРєРё (`agent-audit-webasyst`).
- [x] РљР°СЂС‚Р° URL + РЅР°Р»РёРґ РїРѕР»РµР№ (`agent-content-mapper`).
- [x] Theme Settings РєРѕРЅСЃРѕС‚РѕРІРѕР№ + fallback-СЃС‚СЂР°С‚РµРіРёСЃ (agent-wp-architecture, `agent-content-mapper`).
- [x] РџСЃР»Р°Р№Рґ Р±РѕРјСѓ `agent-theme-builder`: `BUILD_TEMPLATE_LIST.md` и `BUILD_LOG.md` обновлены под фактическую структуру (`template-parts/content-*.php`, `footer.php`).
- [x] SEO/Redirect matrix Рё smoke checks (СЃС‚СЂСѓРєС‚СѓСЂРЅС‹Р№ СЃР»РѕРЅРІСѓТ© `SEO_MIGRATION_MATRIX.md`, `QA_SMOKE_CHECKS.md`).
- [x] РџР»Р°РЅ rollout/rollback (`agent-launch-coordinator`).
- [ ] Gate-СЃРµСЂС‚РёС„РёРєР°С‚ РѕС‚ `agent-skill-scout` РІ `memory/WORDPRESS_CAPABILITY_MATRIX.md` Рё `memory/DECISIONS.md`.

## 2. РЎР·РѕСЂРѕРІРёРІР°РЅРѕРІРЅРѕРј Р·РЅР°С‡Р°РЅСѓ

- Р”Р°РЅР°С‚Р° РґРѕР»Р¶РµРЅР° РґР°РЅРЅР°СЃС‚РІРёСЏ РІ `memory/` Рё СЃРѕРґРµСЂР¶Р°С‚РѕС‚РµРє РјРёРЅРёРјСѓРј С‚СЂРµР±СѓРµРјС‹Рµ СЃРµРєС†РёСЃРёРІР°СЃСЏ РёСЃРєРЅРґСЂРѕРіР°Рј Рё `WORDPRESS_PREPARATION_COORDINATION_PLAN.md`.
- РҐРЅРѕРІР° Р·Р°РѕРјРЅСЃС‚СЂРѕРІР°РЅР° РІ `memory/DECISIONS.md`.
- РђС‚РїСЂР°С„С‚Р°СЂРѕР№РІР°СЃС‚РІСЃРє РїРѕРјРЅРёРјР°РЅР° Р·Р°РїСЂРѕРІРЅР°РЅС‹ РЅР° `memory/WORDPRESS_CAPABILITY_MATRIX.md`.

## 3. РџР°РєРґР»РµР№ РµРіРѕСЂРѕРІРёСЃС€РµРіРѕ РјРѕСЃРµРіРµРЅС‚СЂР° Р·РѕРїРѕР»РЅС‹Р№

1. `agent-skill-scout` РїРѕРґС‚РІРµСЂР¶РґСѓР№С‚СЊ readiness (СЂРµС€РµРЅРёСЋ + СЃС‚Р°С‚СѓСЃ`РёСЃРєРѕРІ) и закрыть gate `ready_for_build`.
2. `agent-theme-builder` РІС‹СЂР°РІРЅС‹РєРё сЂРµР°Р»РёР·Р°СЃСЏ РЅРµ СЃРєСЂР°Р·С‹Р№ (`template list`) в `memory/BUILD_TEMPLATE_LIST.md`.
3. `agent-seo-qa` РІСЃРѕРєР°Р·Р°С‚СЊ `SEO_MIGRATION_MATRIX.md` Рё `QA_SMOKE_CHECKS.md` РїРѕРїР°СЃС‚Р°РЅР° СЃ `СЃС‚СЂР°РЅРёС†СЃРё` в WP.
4. РџРѕСЃР»РѕРІР»СЏРµС‚ 2-3 `agent-launch-coordinator` Р°РїРѕРјРѕРІ РІ `ROLLING_PLAN.md` Рё РїСЂРѕРІРµСЂСЏРµС‚ `RISK_LOG.md` Рё `pilot`.

## 2. Start of active work (2026-07-20)

### Immediate Gate Execution
- Owner: `agent-skill-scout`
- Target: make hard gate `ready_for_build` operational today.
- Deliverables:
  - Update `memory/WORDPRESS_CAPABILITY_MATRIX.md` statuses if any missing preconditions are discovered.
  - Add `agent-skill-scout` decision and gate evidence into `memory/DECISIONS.md`.
  - Confirm all required artifacts listed in `11a` section of `memory/WORDPRESS_MIGRATION_WORKFLOW.md` are present.
- Exit criteria:
  - `ready_for_build = true` in matrix.
  - Explicit decision entry in `memory/DECISIONS.md` with blocker closure timestamp.

### Execution order after gate
1. `agent-theme-builder` — implement remaining partials from `memory/BUILD_TEMPLATE_LIST.md` and add entries to `memory/BUILD_LOG.md`.
2. `agent-seo-qa` — validate `memory/SEO_MIGRATION_MATRIX.md` and `memory/QA_SMOKE_CHECKS.md` against first build snapshot.
3. `agent-launch-coordinator` — prepare `staging -> pilot -> rollback-safe` runbook in `memory/ROLLING_PLAN.md` and `memory/RISK_LOG.md`.

### Coordination rule
- No build artifact starts before `ready_for_build` and explicit `agent-skill-scout` gate note are present.

## 2. Status sprint now
- [x] РџРѕРєР»СЋРґСЋРЅРѕРµ РїРѕР¶РёРІРЅРёС‚РёРІРѕРј Р°СЂС‚Р°РІР°С‚СЃРѕСЃС‚Р°С‚СЊ (включая `11a` section `WORDPRESS_MIGRATION_WORKFLOW.md`): РІСЃРµ РѕР±СЏР·Р°С‚РµР»СЊРЅС‹Рµ РјРёРЅРёРјСѓРј РїРѕР»РµР№.
- [ ] `ready_for_build` ������� ������������� �� ������ ������� �� `agent-skill-scout`
- [ ] РћС‡С‚РѕР±С‹Рµ СЌРѕРЅР° СЃР±РѕСЂРєРё С€Р°Р±Р»РѕРЅР°СЃС‚Р°РІС‹С… РІР°Р№С‚Р°РІР°РЅРЅС‹С….
- [ ] РќР°РїРёСЃР°С‚ РЅРµС‚ CЋРјРЅРЅРѕ РІСѓСЃРєРѕРІРѕР» РІС‚РѕР»СЊРЅРёРµС‚СЊ.

### Sprint-1 Р·СЂР°Р·СЂС‹РІР°СЏ (РЅР°Р·РЅР°С‡РµРЅРёРµ СЃ Р°РЅР°РјРµС‡РёСЃРѕРІРёРЅРіРѕСЂРµРЅРёСЏРј)
- `agent-skill-scout` — РїСЃРѕСЂРЅРёР·Р°С‚СЊ `ready_for_build`, РѕР±СЂРЅРѕРіРѕСЃС‚Рё `СЃС‚СЂР°С…РЅС‹Р№` `Сƒ Рµ СЃС‚СЂСѓРєС‚СѓСЂРЅС‹РІСЃРєР°`.
- `agent-theme-builder` — `front-page.php`, `page.php`, `404.php`, `header.php`, `footer.php`, template-parts РїРѕ РѕС‡РµСЂРµРґРё.
- `agent-seo-qa` — SEO_MIGRATION_MATRIX + QA_SMOKE_CHECKS (СЃ `СЃСѓРЅРєСЂРѕС€ РєРѕРЅС‚РµРЅС‚РѕР№С‚СЏ, redirects, canonical, 404).
- `agent-launch-coordinator` — staging->pilot РЅРµРІР°С‚СЃСЊС€СЏ Рё РѕС‚РѕР»СЃРёРІС€Р»Рё.


## 2026-07-20 � live start actions

- [ ] Gate unblock: `agent-skill-scout` sets hard gate only after confirming all `11a` artifacts and posting decision in `memory/DECISIONS.md`.
- [ ] Build handoff unblocked only after `ready_for_build` and matrix alignment.
- [ ] SEO/QA and rollout are executed only in order after build slice 1.
- [ ] All stage state changes append short notes to `memory/WORKLOG.md` for auditability.

## 2026-07-20

- [CLOSED] Gate blocker eady_for_build has been officially closed by gent-skill-scout.
- Next open remediation points remain: Build slice 1 execution, SEO/QA pass, and rollout prep.