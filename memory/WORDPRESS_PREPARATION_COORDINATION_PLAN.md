## 2026-07-20 — Active Orchestration Queue (immediate execution)

Goal: shift to active build mode and keep the hard gate as the single source of truth.

1) `agent-skill-scout` closes `ready_for_build`
- Validate all blockers from matrix `11a` are marked complete.
- Add gate decision in `memory/DECISIONS.md` with timestamp and owner.
- Flip `ready_for_build` in `memory/WORDPRESS_CAPABILITY_MATRIX.md`.
- Output: gate status ready + decision reference.

2) `agent-theme-builder` executes build slice
- Implement remaining files from `memory/BUILD_TEMPLATE_LIST.md`.
- Update `memory/BUILD_LOG.md` with completed files.
- Ensure all settings reads are through theme helper contract (no raw settings lookups in templates).
- Output: clean template partial set + updated log.

3) `agent-seo-qa` validates migration controls
- Run matrix and smoke checks from `memory/SEO_MIGRATION_MATRIX.md` and `memory/QA_SMOKE_CHECKS.md`.
- Validate canonical/redirect/404 and main SEO fields.
- Output: pass/fail updates and critical risks only.

4) `agent-launch-coordinator` prepares rollout slice
- Finalize `memory/ROLLING_PLAN.md` + `memory/RISK_LOG.md`.
- Define staging -> pilot criteria and rollback triggers.
- Output: rollout plan with hard stop criteria.

Hard rule: no production build handoff before gate closure, and all blockers must be logged in `memory/CRITICAL_REMEDIATION_ACTIONS.md` if still open.

# РљРѕРѕСЂРґРёРЅР°С†РёРѕРЅРЅС‹Р№ РїР»Р°РЅ РїРѕРґРіРѕС‚РѕРІРєРё Рє РјРёРіСЂР°С†РёРё Webasyst -> WordPress

## Р¦РµР»СЊ
РџРѕРґРіРѕС‚РѕРІРёС‚СЊ РїСЂРѕРµРєС‚ Рє СЃР±РѕСЂРєРµ С‚Р°Рє, С‡С‚РѕР±С‹ `ready_for_build` РјРѕР¶РЅРѕ Р±С‹Р»Рѕ РїРѕСЃС‚Р°РІРёС‚СЊ С‚РѕР»СЊРєРѕ РЅР° РѕСЃРЅРѕРІР°РЅРёРё С„Р°РєС‚РёС‡РµСЃРєРёС… Р°СЂС‚РµС„Р°РєС‚РѕРІ, Р° РЅРµ РїСЂРµРґРїРѕР»РѕР¶РµРЅРёР№.

## Р Р°СЃРїСЂРµРґРµР»РµРЅРёРµ РїРѕ СЃР°Р±Р°РіРµРЅС‚Р°Рј (РїРѕ РєР°Р¶РґРѕРјСѓ Р±Р»РѕРєСѓ)

| РџСѓРЅРєС‚ | Р§С‚Рѕ Р·Р°РєСЂС‹РІР°РµРј | РЎР°Р±Р°РіРµРЅС‚ | РђСЂС‚РµС„Р°РєС‚ | РљСЂРёС‚РµСЂРёР№ Р·Р°РІРµСЂС€РµРЅРёСЏ |
|---|---|---|---|---|
| 1 | РРЅРІРµРЅС‚Р°СЂРёР·Р°С†РёСЏ Webasyst (template, route, SEO-С‚РµРіРё, РёРЅС‚РµРіСЂР°С†РёРё) | `agent-audit-webasyst` | `memory/INVENTORY_WEBASYST.md`, `memory/WEBASYST_RISK_LIST.md` | РџРѕР»РЅС‹Р№ СЃРїРёСЃРѕРє СЃС‚СЂР°РЅРёС†/slug/blocks + СЂРёСЃРєРё РїРµСЂРµРЅРѕСЃР°. |
| 2 | РљР°СЂС‚Р° СЃС‚СЂР°РЅРёС† Рё РїРѕР»РµР№ Webasyst | `agent-content-mapper` | `memory/CONTENT_MAP.md`, `memory/PAGE_FIELD_PLAN.md` | Р’ РєР°Р¶РґРѕР№ Webasyst-СЃС‚СЂР°РЅРёС†Рµ РµСЃС‚СЊ СЃРѕРѕС‚РІРµС‚СЃС‚РІРёРµ WordPress-СЃС‚СЂСѓРєС‚СѓСЂРµ Рё РїР»Р°РЅ РїРѕР»РµР№. |
| 3 | Theme settings РєРѕРЅС‚СЂР°РєС‚ | `agent-skill-scout`, `agent-content-mapper` | `memory/WORDPRESS_THEME_OPTIONS_SPEC.md` | РЈС‚РІРµСЂР¶РґРµРЅРЅС‹Р№ РїРµСЂРµС‡РµРЅСЊ РІСЃРµС… РЅР°СЃС‚СЂР°РёРІР°РµРјС‹С… РїРѕР»РµР№, С‚РёРїРѕРІ Рё С„РѕР»Р±СЌРєРѕРІ. |
| 4 | РўРµС…РЅРёС‡РµСЃРєР°СЏ Р°СЂС…РёС‚РµРєС‚СѓСЂР° WP С‚РµРјС‹ | `agent-wp-architecture` | `memory/ARCHITECTURE_CHECKLIST.md`, `memory/THEME_SETTINGS_CONTRACT.md`, `memory/WORDPRESS_THEME_OPTIONS_SPEC.md` | РЈРєР°Р·Р°РЅ РјРµС…Р°РЅРёР·Рј С…СЂР°РЅРµРЅРёСЏ РґР°РЅРЅС‹С… (theme mod/settings API/ACF), СЃС‚СЂСѓРєС‚СѓСЂР° helper Рё fallback. |
| 5 | РЁР°Р±Р»РѕРЅС‹ Рё partials | `agent-theme-builder` | `memory/BUILD_TEMPLATE_LIST.md`, `memory/BUILD_LOG.md` | Р—Р°С„РёРєСЃРёСЂРѕРІР°РЅ РїРѕР»РЅС‹Р№ СЃРїРёСЃРѕРє С„Р°Р№Р»РѕРІ С‚РµРјС‹ Рё РєР°СЂС‚Р° РјРёРіСЂР°С†РёРё Webasyst->WP. |
| 6 | SEO/QA Рё URL-СЃРѕРїРѕСЃС‚Р°РІР»РµРЅРёРµ | `agent-seo-qa` | `memory/SEO_MIGRATION_MATRIX.md`, `memory/QA_SMOKE_CHECKS.md` | Р”Р»СЏ РІСЃРµС… РєР»СЋС‡РµРІС‹С… URL РµСЃС‚СЊ check-РїРѕРёРЅС‚, canonical/OG/schema/robots РїСЂРѕРІРµСЂРµРЅС‹. |
| 7 | Rollout Рё РѕС‚РєР°С‚ | `agent-launch-coordinator` | `memory/ROLLING_PLAN.md`, `memory/RISK_LOG.md` | Р•СЃС‚СЊ СЃС†РµРЅР°СЂРёР№ staging -> pilot -> production Рё РїРѕС€Р°РіРѕРІС‹Р№ rollback. |
| 8 | РљРѕРѕСЂРґРёРЅР°С†РёСЏ Рё Р·Р°РєСЂС‹С‚РёРµ gate | `agent-skill-scout` | `memory/WORDPRESS_CAPABILITY_MATRIX.md`, `memory/DECISIONS.md` | `ready_for_build` СЃС‚Р°РІРёС‚СЃСЏ С‚РѕР»СЊРєРѕ РїСЂРё РіРѕС‚РѕРІРЅРѕСЃС‚Рё 1..7. |

## РўРµРєСѓС‰РёР№ РїРѕСЂСЏРґРѕРє Р·Р°РїСѓСЃРєР°
1. `agent-skill-scout` С„РёРєСЃРёСЂСѓРµС‚ РїР»Р°РЅ Рё РґРµРґР»Р°Р№РЅС‹ РїРѕ РєР°Р¶РґРѕРјСѓ Р±Р»РѕРєСѓ.
2. РџР°СЂР°Р»Р»РµР»СЊРЅРѕ Р·Р°РїСѓСЃРєР°СЋС‚СЃСЏ: `agent-audit-webasyst`, `agent-content-mapper`, `agent-wp-architecture`.
3. РџРѕСЃР»Рµ Р·Р°РєСЂС‹С‚РёСЏ РїСѓРЅРєС‚РѕРІ 1вЂ“3 Р·Р°РїСѓСЃРєР°СЋС‚СЃСЏ СЌС‚Р°РїС‹ СЃР±РѕСЂРєРё С€Р°Р±Р»РѕРЅРѕРІ Рё SEO-РїСЂРѕРІРµСЂРєРё.
4. `agent-wp-architecture` РґР°С‘С‚ С‚РµС…РЅРёС‡РµСЃРєРёР№ СЂРµРІСЊСЋ `ready_for_build`.
5. РџРѕСЃР»Рµ РїРѕР»РЅРѕРіРѕ Р·Р°РїРѕР»РЅРµРЅРёСЏ РјР°С‚СЂРёС†С‹ вЂ” С‚РѕР»СЊРєРѕ РїРѕСЃР»Рµ СЌС‚РѕРіРѕ СЂР°Р·СЂРµС€Р°РµС‚СЃСЏ С„Р°Р·Р° РєРѕРґР°.

## РљСЂРёС‚РёС‡РµСЃРєРёРµ Р±Р»РѕРєРµСЂС‹ Р·Р°РїСѓСЃРєР°
- РќРµС‚ `memory/WORDPRESS_THEME_OPTIONS_SPEC.md` в†’ Р±Р»РѕРєРµСЂ.
- РќРµС‚ РїРѕР»РЅРѕР№ РєР°СЂС‚С‹ URL/СЃС‚СЂР°РЅРёС† Рё fallback-Р»РѕРіРёРєРё РґР»СЏ Theme Settings в†’ Р±Р»РѕРєРµСЂ.
- РќРµС‚ `ROLLING_PLAN.md` + `RISK_LOG.md` в†’ Р±Р»РѕРєРµСЂ.

## Р РµР¶РёРј СЂР°Р±РѕС‚С‹ СЃР°Р±Р°РіРµРЅС‚РѕРІ
- РљР°Р¶РґС‹Р№ СЃР°Р±Р°РіРµРЅС‚ РїРёС€РµС‚ С‚РѕР»СЊРєРѕ СЃРІРѕР№ Р°СЂС‚РµС„Р°РєС‚ Рё РєРѕРјРјРµРЅС‚Р°СЂРёРё РІ РѕС‚РґРµР»СЊРЅС‹Р№ С„Р°Р№Р» РёР· СЃРїРёСЃРєР°.
- РћР±РЅРѕРІР»РµРЅРёСЏ СЃРѕСЃС‚РѕСЏРЅРёСЏ (Р’ СЂР°Р±РѕС‚Рµ/РћР¶РёРґР°РµС‚/Р“РѕС‚РѕРІРѕ) РІРµРґСѓС‚СЃСЏ РІ СЃРѕРѕС‚РІРµС‚СЃС‚РІСѓСЋС‰РµРј Р±Р»РѕРєРµ `memory/WORDPRESS_CAPABILITY_MATRIX.md`.
- Р›СЋР±РѕР№ РєРѕРЅС„Р»РёРєС‚ РјРµР¶РґСѓ РїР»Р°РЅР°РјРё РїРµСЂРµРґР°С‘С‚СЃСЏ С‡РµСЂРµР· `memory/DECISIONS.md`.

## Р§С‚Рѕ СЃС‡РёС‚Р°С‚СЊ РіРѕС‚РѕРІС‹Рј Рє РєРѕРґ-prepare
- Р’СЃРµ 8 РїСѓРЅРєС‚РѕРІ РІ СЃС‚Р°С‚СѓСЃРµ `Р“РѕС‚РѕРІ`.
- `agent-skill-scout` РѕР±РЅРѕРІРёР» `ready_for_build` РІ `memory/WORDPRESS_CAPABILITY_MATRIX.md`.
- РќР°С‡РёРЅР°РµС‚СЃСЏ С„Р°Р·Р° `agent-theme-builder` СЃ С„РёРєСЃРёСЂРѕРІР°РЅРЅРѕР№ РєР°СЂС‚РѕР№ С€Р°Р±Р»РѕРЅРѕРІ Рё РєРѕРЅС‚СЂР°РєС‚Р°РјРё РЅР°СЃС‚СЂРѕРµРє.


## Актуальное состояние blocker
- Документы WORDPRESS_THEME_OPTIONS_SPEC.md, THEME_SETTINGS_CONTRACT.md, ARCHITECTURE_CHECKLIST.md, ROLLING_PLAN.md, RISK_LOG.md и WORDPRESS_CAPABILITY_MATRIX.md уже подготовлены.
- На текущий момент критический блокер только по gate eady_for_build в gent-skill-scout до официального подтверждения DECISIONS.md.


## 12. Critical gate start queue (2026-07-20)

### 0) Gate first
- `agent-skill-scout` signs and records `ready_for_build` in:
  - `memory/WORDPRESS_CAPABILITY_MATRIX.md`
  - `memory/DECISIONS.md`
- Condition: all artifacts from workflow mandatory list are physically present (not just planned).

### 1) Build queue only after gate
- `agent-theme-builder`: execute template/build tasks from `memory/BUILD_TEMPLATE_LIST.md`, keep all settings usage behind `vr_theme_setting(...)` helper.
- `agent-seo-qa`: run page-by-page smoke checks defined in `memory/QA_SMOKE_CHECKS.md` and confirm redirect + canonical behavior in SEO matrix.
- `agent-launch-coordinator`: activate rollout steps from `memory/ROLLING_PLAN.md`, update `memory/RISK_LOG.md` with live gate/rollback triggers.

### Weekly handoff
- At handoff, each agent posts status in the corresponding artifact row of `memory/WORDPRESS_CAPABILITY_MATRIX.md` with status: `Готов / В ожидании / Не готов`.


## 2026-07-20 — Live sprint-1 kickoff (approved)

### Starting now
- `agent-skill-scout` is responsible for hard-gate activation.
- `agent-theme-builder` starts only after explicit `ready_for_build = true`.
- `agent-seo-qa` и `agent-launch-coordinator` получают задачу только после завершения предыдущего этапа.

### Live execution queue (strict order)
1. **Gate closure** (`agent-skill-scout`)
   - Verify all artifacts from `memory/WORDPRESS_MIGRATION_WORKFLOW.md` section `11a` exist and are updated.
   - Confirm rows in `memory/WORDPRESS_CAPABILITY_MATRIX.md` reflect real blocker state.
   - Add one decision entry in `memory/DECISIONS.md` with timestamp and blocker clearance.
   - Set `ready_for_build = true`.
2. **Build slice 1** (`agent-theme-builder`)
   - Implement mandatory first batch from `memory/BUILD_TEMPLATE_LIST.md`.
   - Update `memory/BUILD_LOG.md` for each completed file.
   - Keep all settings reads through `vr_theme_setting(...)` only.
3. **SEO/QA pass** (`agent-seo-qa`)
   - Run `memory/SEO_MIGRATION_MATRIX.md` checks.
   - Run `memory/QA_SMOKE_CHECKS.md` for required URLs.
4. **Rollout prep** (`agent-launch-coordinator`)
   - Finalize `memory/ROLLING_PLAN.md`.
   - Finalize `memory/RISK_LOG.md` rollback triggers and staging/pilot readiness criteria.

### Coordination rule for handoff
- At each handoff, add one short line to `memory/WORKLOG.md` and update matrix row status to `В работе / Готов / Не готов`.

### Commit rule (local execution discipline)
- For every completed stage, run `memory/scripts/wp-migration-commit.ps1 -Stage <gate|build|seo|rollout|handoff|misc> -Message "..."`.
- Do not continue to next stage before commit for current stage is created and `memory/WORKLOG.md` has one handoff line.
