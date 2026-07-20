## 2026-07-20 — Live delegation (execution mode)

### `agent-skill-scout`
- Owner: hard gate and readiness control.
- Task: sign readiness, update matrix + decisions.
- Exit condition: `ready_for_build` is explicitly `true` in matrix and decision log has blocker closure.

### `agent-theme-builder`
- Owner: implementation queue.
- Task: finish all template files from `memory/BUILD_TEMPLATE_LIST.md` and keep settings through helper.
- Exit condition: `memory/BUILD_LOG.md` updated; required templates/partials done.

### `agent-seo-qa`
- Owner: SEO and smoke verification.
- Task: validate SEO matrix + smoke checklist.
- Exit condition: redirects/canonical/404 checks recorded and open risks listed.

### `agent-launch-coordinator`
- Owner: rollout and rollback.
- Task: finalize rollout steps and risk triggers for pilot.
- Exit condition: `ROLLING_PLAN.md` + `RISK_LOG.md` contain staging/pilot/rollback criteria.

Daily handoff format: each owner updates its artifact status in `memory/WORDPRESS_CAPABILITY_MATRIX.md` (Готов/В ожидании/Не готов) and adds one line to `memory/WORKLOG.md` when state changes.

# WordPress Theme Migration вЂ” Assignments Board

## Р‘Р°Р·РѕРІС‹Рµ РїСЂР°РІРёР»Р° РїСЂРѕРµРєС‚Р°
Р¦РµР»СЊ: РїРµСЂРµРЅРѕСЃ С‚РµРјС‹ `vetritual-modern` РёР· Webasyst РІ WordPress СЃ СѓРїСЂР°РІР»РµРЅРёРµРј РєРѕРЅС‚РµРЅС‚РѕРј Рё РЅР°СЃС‚СЂРѕР№РєР°РјРё С‡РµСЂРµР· Р°РґРјРёРЅРєСѓ (Customizer / theme options / theme.json).

### РџСЂРёРЅС†РёРї РёСЃРїРѕР»РЅРµРЅРёСЏ
- Р’СЃРµ РєР»РёРµРЅС‚СЃРєРёРµ РїСЂР°РІРєРё (РєРѕРЅС‚РµРЅС‚, С‚РµРєСЃС‚С‹, CTA, SEO/РјРµС‚Р°, СЃРµРєС†РёРё) РїСЂРѕС…РѕРґСЏС‚ С‡РµСЂРµР· Theme Settings.
- РљРѕРґРѕРІС‹Рµ С€Р°Р±Р»РѕРЅС‹ РёСЃРїРѕР»СЊР·СѓСЋС‚ РµРґРёРЅС‹Р№ helper.
- Р—Р°РґР°С‡Рё, РєРѕС‚РѕСЂС‹Рµ С‚СЂРµР±СѓСЋС‚ С‡Р°СЃС‚РѕР№ СЂСѓС‡РЅРѕР№ РїРѕРґСЃС‚СЂРѕР№РєРё, РЅРµ СЂРµР°Р»РёР·СѓСЋС‚СЃСЏ С‡РµСЂРµР· РїСЂР°РІРєСѓ С€Р°Р±Р»РѕРЅРѕРІ.

---

## 0) `agent-skill-scout`
### Р¦РµР»СЊ
РџРѕРґРіРѕС‚РѕРІРёС‚СЊ РєР°СЂС‚Сѓ РєРѕРјРїРµС‚РµРЅС†РёР№ Рё Р·Р°РєСЂС‹С‚СЊ СЂР°Р·СЂС‹РІС‹ РїРµСЂРµРґ Р·Р°РїСѓСЃРєРѕРј СЂР°Р·СЂР°Р±РѕС‚РєРё.

### Output
- `WORDPRESS_CAPABILITY_MATRIX.md`:
  - Р·Р°РґР°С‡Рё Рё С‚СЂРµР±РѕРІР°РЅРёСЏ,
  - owner РЅР°РІС‹РєР°,
  - СЃС‚Р°С‚СѓСЃ (РµСЃС‚СЊ/С‡Р°СЃС‚РёС‡РЅРѕ/РЅРµС‚),
  - РїР»Р°РЅ Р·Р°РєСЂС‹С‚РёСЏ.

### Theme Settings Р±Р»РѕРє
- Р—Р°С„РёРєСЃРёСЂРѕРІР°С‚СЊ, РєР°РєРёРµ СЂР°Р·РґРµР»С‹ С‚РµРјС‹ РґРѕР»Р¶РЅС‹ Р±С‹С‚СЊ РґРѕСЃС‚СѓРїРЅС‹ С‡РµСЂРµР· Р°РґРјРёРЅРєСѓ СЃ РїРµСЂРІРѕРіРѕ СЂРµР»РёР·Р°:
  - Р±СЂРµРЅРґРёРЅРі/РєРѕРЅС‚Р°РєС‚С‹;
  - hero Рё CTA;
  - РїРµСЂРµРєР»СЋС‡Р°С‚РµР»Рё СЃРµРєС†РёР№;
  - Р±Р°Р·РѕРІС‹Р№ SEO;
  - privacy/consent Рё РјРµС‚СЂРёРєРё.

---

## 1) `agent-audit-webasyst`
### Р¦РµР»СЊ
РЎРѕР±СЂР°С‚СЊ baseline РєРѕРЅС‚РµРЅС‚Р° Рё СЂРёСЃРєРѕРІ РёР· С‚РµРєСѓС‰РµРіРѕ Webasyst.

### Output
- `INVENTORY_WEBASYST.md`
- `WEBASYST_RISK_LIST.md`

### Theme Settings Р±Р»РѕРє
- РЎРµРєС†РёРё Рё РїРѕР»СЏ, РєРѕС‚РѕСЂС‹Рµ РјРѕР¶РЅРѕ РїРѕР»РЅРѕСЃС‚СЊСЋ РІС‹РІРµСЃС‚Рё РІ Theme Settings, РЅРµ Р·Р°С‚СЂР°РіРёРІР°СЏ С€Р°Р±Р»РѕРЅС‹.

---

## 2) `agent-content-mapper`
### Р¦РµР»СЊ
РЎРѕРїРѕСЃС‚Р°РІРёС‚СЊ РјР°СЂС€СЂСѓС‚С‹ Рё РєРѕРЅС‚РµРЅС‚РЅСѓСЋ РјРѕРґРµР»СЊ Webasyst -> WP.

### Output
- `CONTENT_MAP.md`
- `PAGE_FIELD_PLAN.md`

### Theme Settings Р±Р»РѕРє
- РћС‚РјРµС‚РёС‚СЊ РіР»РѕР±Р°Р»СЊРЅС‹Рµ РїРѕР»СЏ, РєРѕС‚РѕСЂС‹Рµ РЅР°РґРѕ С…СЂР°РЅРёС‚СЊ РІ options/theme settings.

---

## 3) `agent-wp-architecture`
### Р¦РµР»СЊ
РЎС„РѕСЂРјРёСЂРѕРІР°С‚СЊ Р°СЂС…РёС‚РµРєС‚СѓСЂСѓ WP С‚РµРјС‹ СЃ РєРѕРЅС‚СЂР°РєС‚РѕРј РЅР°СЃС‚СЂРѕРµРє.

### Output
- `ARCHITECTURE_CHECKLIST.md`
- `THEME_SETTINGS_CONTRACT.md`

### Theme Settings Р±Р»РѕРє (РєСЂРёС‚РёС‡РЅРѕ)
- РћР±СЏР·Р°С‚РµР»СЊРЅС‹Р№ helper:
  - `inc/helpers/theme-options.php`
  - `vr_theme_setting($key, $default = '')`
- РџСЂРёРѕСЂРёС‚РµС‚ РёСЃС‚РѕС‡РЅРёРєРѕРІ РЅР°СЃС‚СЂРѕРµРє РІ РєРѕРЅС‚СЂР°РєС‚Рµ:
  - ACF -> Theme Mods -> Options -> defaults.
- Р”РѕР±Р°РІРёС‚СЊ РІ `theme.json` Р±Р°Р·РѕРІС‹Рµ С‚РѕРєРµРЅС‹ (С†РІРµС‚Р°, С‚РёРїРѕРіСЂР°С„РёРєР°, spacing).

---

## 4) `agent-theme-builder`
### Р¦РµР»СЊ
РЎРѕР±СЂР°С‚СЊ С€Р°Р±Р»РѕРЅС‹ Рё UI РЅР° WP СЃ РїСЂРёРјРµРЅРµРЅРёРµРј РЅР°СЃС‚СЂРѕРµРє.

### Output
- `BUILD_LOG.md`
- РіРѕС‚РѕРІС‹Рµ template-С„Р°Р№Р»С‹/partial-Рё (`front-page.php`, `page.php`, `404.php`, `header.php`, `footer.php`, `template-parts/*`)

### Theme Settings Р±Р»РѕРє
- Р’СЃРµ СѓРїСЂР°РІР»СЏРµРјС‹Рµ СЌР»РµРјРµРЅС‚С‹ СЂРµРЅРґРµСЂСЏС‚СЃСЏ С‡РµСЂРµР· helper-РїРѕРґС…РѕРґ:
  - `esc_html(vr_theme_setting(...))`,
  - РјР°СЃСЃРёРІРЅС‹Рµ РїРѕР»СЏ С‡РµСЂРµР· РІР°Р»РёРґРёСЂРѕРІР°РЅРЅС‹Р№ helper JSON decode.

---

## 5) `agent-seo-qa`
### Р¦РµР»СЊ
РџСЂРѕРІРµСЂРёС‚СЊ SEO Рё С‚РµС…РЅРёС‡РµСЃРєРѕРµ РєР°С‡РµСЃС‚РІРѕ.

### Output
- `SEO_MIGRATION_MATRIX.md`
- `QA_SMOKE_CHECKS.md`

### Theme Settings Р±Р»РѕРє
- РџСЂРѕРІРµСЂРёС‚СЊ, С‡С‚Рѕ С‡Р°СЃС‚Рѕ РјРµРЅСЏРµРјС‹Рµ SEO-РїР°СЂР°РјРµС‚СЂС‹ СѓРїСЂР°РІР»СЏРµРјС‹ РёР· Theme Settings.

---

## 6) `agent-launch-coordinator`
### Р¦РµР»СЊ
РџРѕСЃС‚СЂРѕРёС‚СЊ Р·Р°РїСѓСЃРє Рё РѕС‚РєР°С‚ Р±РµР· РїРѕС‚РµСЂСЊ.

### Output
- `ROLLING_PLAN.md`
- `RISK_LOG.md`

### Theme Settings Р±Р»РѕРє
- РџРёР»РѕС‚: СЃРјРµРЅР° CTA/РєРѕРЅС‚Р°РєС‚РѕРІ/РІРєР»СЋС‡РµРЅРёСЏ СЃРµРєС†РёРё Р±РµР· РґРµРїР»РѕСЏ.

---

## Р§С‚Рѕ СЃС‡РёС‚Р°РµРј done (global)
- РљСЂРёС‚РёС‡РЅС‹Рµ РїРѕР»СЊР·РѕРІР°С‚РµР»СЊСЃРєРёРµ РїР°СЂР°РјРµС‚СЂС‹ РјРµРЅСЏСЋС‚СЃСЏ РІ Р°РґРјРёРЅРєРµ Р·Р° 1-2 РєР»РёРєР°.
- Р’СЃРµ Р·РЅР°С‡РµРЅРёСЏ РїСЂРѕС…РѕРґСЏС‚ `esc_*`/СЃР°РЅРёС‚РёР·Р°С†РёСЋ РЅР° СѓСЂРѕРІРЅРµ helper/presentation.
- Р”РѕРєСѓРјРµРЅС‚РёСЂРѕРІР°РЅРѕ, РєС‚Рѕ Рё РіРґРµ РїРѕРґРґРµСЂР¶РёРІР°РµС‚ РєР°Р¶РґСѓСЋ РіСЂСѓРїРїСѓ РЅР°СЃС‚СЂРѕРµРє.
## Р”РѕРї. Р±Р»РѕРєРµСЂС‹ РґР»СЏ Р·Р°РїСѓСЃРєР° СЃР±РѕСЂРєРё

1) Р‘РµР· `INVENTORY_WEBASYST.md` Рё `WEBASYST_RISK_LIST.md` РЅРµ СЃС‚Р°СЂС‚СѓРµС‚ `agent-theme-builder`.
2) Р‘РµР· `CONTENT_MAP.md` Рё `PAGE_FIELD_PLAN.md` РЅРµ СЃС‚Р°СЂС‚СѓРµС‚ `agent-theme-builder` Рё `agent-seo-qa`.
3) Р‘РµР· `WORDPRESS_THEME_OPTIONS_SPEC.md`, `THEME_SETTINGS_CONTRACT.md` Рё `memory/WORDPRESS_SKILLS.md` РїРѕРґС‚РІРµСЂР¶РґРµРЅРёСЏ РЅРµ СЃС‚Р°СЂС‚СѓРµС‚ `agent-wp-architecture` РЅР° build lock.
4) Р‘РµР· `SEO_MIGRATION_MATRIX.md`, `QA_SMOKE_CHECKS.md` РЅРµ СЃС‚Р°СЂС‚СѓРµС‚ QA acceptance.
5) Р‘РµР· `ROLLING_PLAN.md` + `RISK_LOG.md` РЅРµР»СЊР·СЏ Р·Р°РїСѓСЃРєР°С‚СЊ Rollout.
6) `agent-skill-scout` РїСЂРѕРІРµСЂСЏРµС‚ СЃС‚Р°С‚СѓСЃ РІ matrix Рё РґРµР»Р°РµС‚ С„РёРЅР°Р»СЊРЅС‹Р№ gate `ready_for_build`.

Р­С‚Р°РїС‹ Р·Р°РїСѓСЃРєР° РґРѕР»Р¶РЅС‹ РІС‹РїРѕР»РЅСЏС‚СЊСЃСЏ РїРѕ РѕС‡РµСЂРµРґРё:
- СЃРЅР°С‡Р°Р»Р° audit/mapper/architecture (РІ С‚.С‡. settings spec),
- Р·Р°С‚РµРј С‚РѕР»СЊРєРѕ Р±РёР»Рґ/SEO/QA,
- РїРѕС‚РѕРј rollout.


## 2026-07-20 — Live sprint orchestration (start)

### 0) `agent-skill-scout`
- Task 1: close readiness gate and make explicit decision in `memory/DECISIONS.md`.
- Output: one decision record with timestamp, owner, and explicit `ready_for_build = true`.
- Exit condition: matrix and decisions include same gate state.

### 1) `agent-theme-builder`
- Condition to start: receive clear handoff that gate is closed.
- Scope: first-wave files from `memory/BUILD_TEMPLATE_LIST.md` and corresponding partials.
- Output: file-level completion lines in `memory/BUILD_LOG.md`.
- Exit condition: slice1 files committed (conceptually), no raw setting access.

### 2) `agent-seo-qa`
- Scope: `memory/SEO_MIGRATION_MATRIX.md` + `memory/QA_SMOKE_CHECKS.md`.
- Output: filled/updated checks for canonical, redirects, robots/404 and content parity.
- Exit condition: no critical SEO/URL issues before rollout.

### 3) `agent-launch-coordinator`
- Scope: stage-pilot runbook and rollback matrix.
- Output: `memory/ROLLING_PLAN.md`, `memory/RISK_LOG.md`.
- Exit condition: launch gates/rollback triggers approved.

### Handoff contract
- Каждый сабагент пишет один коммент в `memory/WORKLOG.md` после завершения этапа.
- `agent-skill-scout` контролирует статус строк в `memory/WORDPRESS_CAPABILITY_MATRIX.md`.
