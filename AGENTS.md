# Local verification rule

The real local project URL is https://vetritual.lvh.me/ (or http://vetritual.lvh.me/ if local HTTPS is blocked). Check this URL first before trusting preview.html or files in the OneDrive source copy. The live Webasyst theme served by Apache is C:\xampp\webasyst-local\wa-data\public\site\themes\vetritual-modern; sync source changes there and clear C:\xampp\webasyst-local\wa-cache\101524\apps\site\templates\compiled when template changes do not appear.

Agents must develop and check all changes on the local Webasyst instance before adding them to the main/source theme.

- Primary local URL: `https://vetritual.lvh.me/`
- Fallback if local HTTPS is blocked: `http://vetritual.lvh.me/`

Do not treat `preview.html` or files in the OneDrive source copy as the final verification target. After local verification succeeds, copy/sync the approved changes back into the main project files.

When template changes do not appear locally, clear the compiled Webasyst cache before re-checking:

`C:\xampp\webasyst-local\wa-cache\101524\apps\site\templates\compiled`

## WordPress migration architecture

This repository includes the project-local skill `skills/wordpress-vetritual/SKILL.md` and Codex-discoverable WordPress skills in `.codex/skills/`. Read and follow the applicable skills before WordPress implementation; they supplement the native checklist below.

Before any WordPress migration or theme remediation work, agents must explicitly check for available WordPress-relevant skills/tools/plugins. If a dedicated WordPress skill/tool is available, load and follow it before touching files. If no dedicated WordPress skill/tool is available, state that clearly and proceed with the native WordPress checklist below instead of inventing ad hoc content architecture.

Mandatory WordPress project entrypoint before implementation:

1. Open `memory/WORDPRESS_SKILLS.md`.
2. Open `memory/WORDPRESS_MIGRATION_WORKFLOW.md` only when planning or orchestrating more than one slice.
3. Open `memory/subagents/WORDPRESS_ASSIGNMENTS.md` when using subagents.
4. From `wordpress-theme/vetritual-modern`, run `../../.codex/skills/wp-project-triage/scripts/detect_wp_project.mjs` with Node and select the relevant workflow through `.codex/skills/wordpress-router/`.
5. Use `.codex/skills/wp-wpcli-and-ops/` for WP-CLI or production operations, and `.codex/skills/wp-performance/` for any performance investigation.

When porting the Webasyst/Smarty theme to WordPress, treat Webasyst as the visual and DOM/CSS reference only. Do not copy Smarty logic directly and do not replace WordPress content management with theme settings.

The WordPress theme must use native WordPress architecture:

- page text belongs in WordPress Pages and is rendered with `the_title()`, `the_content()`, excerpts, featured images, blocks, or block patterns;
- navigation belongs in registered WordPress menus and is rendered with `wp_nav_menu()`;
- images that editors change belong in the Media Library, featured images, blocks, or native attachment fields;
- repeatable editorial entities such as services, prices, reviews, FAQ, and process steps should use core blocks, patterns, custom post types, or proper metabox/ACF-style fields, not JSON strings in Customizer;
- Customizer/theme options are allowed only for global theme-level settings: logo/site identity, phone, email, address, analytics IDs, verification tags, color tokens if needed, and limited global CTA defaults;
- template parts may provide fixed visual wrappers matching Webasyst, but the editable content inside them must come from native WordPress content sources.

If an existing pass introduced `*_json` Customizer fields or `vr_theme_setting_array()` as the source of page/section content, treat that as transitional debt. The correct fix is to migrate those fields back to Pages, menus, media, blocks, or CPT/metabox data while preserving the Webasyst visual contract.

## WordPress SEO workflow

For SEO work on the WordPress theme, read `skills/seo-vetritual/SKILL.md` and use the Codex-discoverable counterpart `.codex/skills/seo-vetritual/` together with only the needed specialist skills:

- `semantic-core` for intent, semantic clusters, and page architecture;
- `seo-optimizer` for page-level on-page and technical audits;
- `wp-performance` for performance work affecting Core Web Vitals;
- `serp-monitor` for the agreed Yandex ranking set;
- `yandex-metrika` for read-only outcome measurement;
- `demand-research` only when factual demand research is required.

Start with a measurable baseline, retain native WordPress content ownership, and separate facts from hypotheses. Do not create doorway pages, keyword-stuff copy, invented schema/reviews, or analytics/redirect/production writes without an explicit approved plan.

## Theme version discipline

Keep the Webasyst theme version and asset query version at `1.0` during normal development. Do not bump `theme.xml` version or `?v=` asset query strings after individual CSS/JS/template changes; use cache clearing, hard refresh, or local browser cache controls for verification. Bump versions only when the project owner explicitly asks to prepare a deploy/release.

## Deployment archive discipline

Write all deployment archives strictly into `deploy-vetritual-modern/`. Do not create or update deployment archives in the project root or scatter archive artifacts across the workspace. If an old archive already exists outside `deploy-vetritual-modern/`, leave it alone unless the project owner explicitly asks to move, replace, or delete it.

# Vet Ritual Modern РґР»СЏ Webasyst Site

Р“РѕС‚РѕРІР°СЏ С‚РµРјР° Р»РµР¶РёС‚ РІ `vetritual-modern/`.

## РЈСЃС‚Р°РЅРѕРІРєР°

1. РЎРєРѕРїРёСЂСѓР№С‚Рµ РїР°РїРєСѓ `vetritual-modern` РІ Webasyst:
   `wa-data/public/site/themes/vetritual-modern/`.
2. Р’ Р°РґРјРёРЅРєРµ Webasyst РѕС‚РєСЂРѕР№С‚Рµ РїСЂРёР»РѕР¶РµРЅРёРµ Site.
3. Р’ СЂР°Р·РґРµР»Рµ В«РЎС‚СЂСѓРєС‚СѓСЂР°В» РІС‹Р±РµСЂРёС‚Рµ С‚РµРјСѓ `Vet Ritual Modern` РґР»СЏ РЅСѓР¶РЅРѕРіРѕ РїРѕСЃРµР»РµРЅРёСЏ.
4. Р”Р»СЏ РіР»Р°РІРЅРѕР№ СЃС‚СЂР°РЅРёС†С‹ РѕСЃС‚Р°РІСЊС‚Рµ URL РїСѓСЃС‚С‹Рј РёР»Рё `/`. РЁР°Р±Р»РѕРЅ `page.html` РїРѕРґС…РІР°С‚РёС‚ `home.html` Рё РїРѕРєР°Р¶РµС‚ СЃРѕР±СЂР°РЅРЅСѓСЋ РіР»Р°РІРЅСѓСЋ СЃ СѓСЃР»СѓРіР°РјРё, С†РµРЅР°РјРё, РѕС‚Р·С‹РІР°РјРё Рё РєРѕРЅС‚Р°РєС‚Р°РјРё.

## РџСЂР°РІРёР»Р° РїСЂРѕРµРєС‚Р°

1. РќРµР»СЊР·СЏ Р»РѕРјР°С‚СЊ РєРѕРґРёСЂРѕРІРєСѓ С„Р°Р№Р»РѕРІ СЃРєСЂРёРїС‚Р°РјРё. Р”Р»СЏ СЂСѓС‡РЅС‹С… РїСЂР°РІРѕРє РёСЃРїРѕР»СЊР·РѕРІР°С‚СЊ `apply_patch`; РґР»СЏ РјРµС…Р°РЅРёС‡РµСЃРєРёС… РїСЂР°РІРѕРє Р·Р°СЂР°РЅРµРµ РїСЂРѕРІРµСЂСЏС‚СЊ, С‡С‚Рѕ С„Р°Р№Р» РѕСЃС‚Р°РЅРµС‚СЃСЏ РІ UTF-8 Р±РµР· mojibake. РџРѕСЃР»Рµ РёР·РјРµРЅРµРЅРёСЏ С€Р°Р±Р»РѕРЅРѕРІ РѕР±СЏР·Р°С‚РµР»СЊРЅРѕ РїСЂРѕСЃРјРѕС‚СЂРµС‚СЊ СЂСѓСЃСЃРєРёР№ С‚РµРєСЃС‚ РІ Р±СЂР°СѓР·РµСЂРµ РёР»Рё С‡РµСЂРµР· `curl`.
2. РќРµР»СЊР·СЏ РѕР±РЅРѕРІР»СЏС‚СЊ Р°СЂС…РёРІС‹ РґРµРїР»РѕСЏ (`vetritual-modern.zip`, `vetritual-modern.tar.gz`) Р±РµР· РїСЂСЏРјРѕР№ РєРѕРјР°РЅРґС‹ РІР»Р°РґРµР»СЊС†Р° РїСЂРѕРµРєС‚Р°.
3. РќРµР»СЊР·СЏ РѕСЃС‚Р°РІР»СЏС‚СЊ СЃСЃС‹Р»РєРё РЅР° РЅРµСЃСѓС‰РµСЃС‚РІСѓСЋС‰РёРµ Р»РѕРєР°Р»СЊРЅС‹Рµ СЃС‚СЂР°РЅРёС†С‹. РџРѕСЃР»Рµ РёР·РјРµРЅРµРЅРёСЏ РЅР°РІРёРіР°С†РёРё РёР»Рё С„СѓС‚РµСЂР° РїСЂРѕРІРµСЂСЏС‚СЊ РІСЃРµ РІРЅСѓС‚СЂРµРЅРЅРёРµ СЃСЃС‹Р»РєРё РЅР° РєРѕРґ `200`.
4. РќРµР»СЊР·СЏ РїСЂР°РІРёС‚СЊ СЃРєРѕРјРїРёР»РёСЂРѕРІР°РЅРЅС‹Р№ РєСЌС€ Webasyst РєР°Рє РёСЃС‚РѕС‡РЅРёРє РёСЃС‚РёРЅС‹. РСЃС…РѕРґРЅРёРєРё С‚РµРјС‹ Р»РµР¶Р°С‚ РІ `vetritual-modern/`; РєСЌС€ РјРѕР¶РЅРѕ С‚РѕР»СЊРєРѕ РѕС‡РёС‰Р°С‚СЊ, РµСЃР»Рё Webasyst РїСЂРѕРґРѕР»Р¶Р°РµС‚ РѕС‚РґР°РІР°С‚СЊ СЃС‚Р°СЂСѓСЋ РІРµСЂСЃРёСЋ.
5. РџСЂРё РёР·РјРµРЅРµРЅРёРё CSS/JS РЅРµ РїРѕРґРЅРёРјР°С‚СЊ query version РІ `index.html` РґРѕ РґРµРїР»РѕСЏ; РґР»СЏ Р»РѕРєР°Р»СЊРЅРѕР№ РїСЂРѕРІРµСЂРєРё РѕС‡РёС‰Р°С‚СЊ РєСЌС€ Webasyst/Р±СЂР°СѓР·РµСЂР° РёР»Рё РґРµР»Р°С‚СЊ hard refresh.
6. РџРѕСЃР»Рµ СЃРёРЅС…СЂРѕРЅРёР·Р°С†РёРё РІ Р»РѕРєР°Р»СЊРЅС‹Р№ Webasyst РїСЂРѕРІРµСЂСЏС‚СЊ СЂРµР°Р»СЊРЅС‹Р№ URL `http://vetritual.lvh.me/`, Р° РЅРµ С‚РѕР»СЊРєРѕ `preview.html`.
7. Р—Р°РїСЂРµС‰С‘РЅ Tilda-РєРѕРґ РІ РїСЂРѕРµРєС‚Рµ. РџСЂРё РѕР±РЅР°СЂСѓР¶РµРЅРёРё РєР»Р°СЃСЃРѕРІ, СЃРєСЂРёРїС‚РѕРІ, inline-СЂР°Р·РјРµС‚РєРё РёР»Рё Р·Р°РІРёСЃРёРјРѕСЃС‚РµР№ Tilda (`t-rec`, `t396`, `tilda-blocks`, `tilda-scripts`, `tn-atom` Рё РїРѕРґРѕР±РЅС‹Рµ) РёС… РЅСѓР¶РЅРѕ РЅРµРјРµРґР»РµРЅРЅРѕ РїРµСЂРµРїРёСЃР°С‚СЊ РїРѕРґ РЅР°С‚РёРІРЅС‹Рµ С€Р°Р±Р»РѕРЅС‹, CSS Рё JS Webasyst, Р±РµР· СЃРѕС…СЂР°РЅРµРЅРёСЏ Tilda-Р·Р°РІРёСЃРёРјРѕСЃС‚РµР№.

## Р‘РµР·РѕРїР°СЃРЅР°СЏ РІРµР±-СЂР°Р·СЂР°Р±РѕС‚РєР°

1. Р­РєСЂР°РЅРёСЂРѕРІР°С‚СЊ РґРёРЅР°РјРёС‡РµСЃРєРёРµ РґР°РЅРЅС‹Рµ РІ С€Р°Р±Р»РѕРЅР°С… Webasyst: Р·Р°РіРѕР»РѕРІРєРё, meta-РѕРїРёСЃР°РЅРёСЏ, РёРјРµРЅР° СЃС‚СЂР°РЅРёС† Рё СЃРѕРѕР±С‰РµРЅРёСЏ РѕС€РёР±РѕРє РІС‹РІРѕРґРёС‚СЊ С‡РµСЂРµР· `|escape`, РµСЃР»Рё СЌС‚Рѕ РЅРµ РѕСЃРѕР·РЅР°РЅРЅРѕ РґРѕРІРµСЂРµРЅРЅС‹Р№ HTML.
2. РќРµ РІСЃС‚Р°РІР»СЏС‚СЊ РїРѕР»СЊР·РѕРІР°С‚РµР»СЊСЃРєРёР№ HTML/JS Р±РµР· СЃР°РЅРёС‚РёР·Р°С†РёРё. РљРѕРЅС‚РµРЅС‚ РёР· Р°РґРјРёРЅРєРё РґРѕР»Р¶РµРЅ РїРѕРїР°РґР°С‚СЊ С‚РѕР»СЊРєРѕ РІ РїСЂРµРґРЅР°Р·РЅР°С‡РµРЅРЅСѓСЋ РѕР±Р»Р°СЃС‚СЊ СЃС‚СЂР°РЅРёС†С‹.
3. РќРµ С…СЂР°РЅРёС‚СЊ СЃРµРєСЂРµС‚С‹, С‚РѕРєРµРЅС‹, РїР°СЂРѕР»Рё Рё РїСЂРёРІР°С‚РЅС‹Рµ РєР»СЋС‡Рё РІ С‚РµРјРµ, Р°СЂС…РёРІР°С… РґРµРїР»РѕСЏ РёР»Рё РїСѓР±Р»РёС‡РЅС‹С… Р°СЃСЃРµС‚Р°С….
4. РќРµ РїРѕРґРєР»СЋС‡Р°С‚СЊ РІРЅРµС€РЅРёРµ СЃРєСЂРёРїС‚С‹ Рё С€СЂРёС„С‚С‹ Р±РµР· РЅРµРѕР±С…РѕРґРёРјРѕСЃС‚Рё. Р•СЃР»Рё РІРЅРµС€РЅРёР№ СЂРµСЃСѓСЂСЃ РЅСѓР¶РµРЅ, РёСЃРїРѕР»СЊР·РѕРІР°С‚СЊ HTTPS Рё РїРѕРЅРёРјР°С‚СЊ, С‡С‚Рѕ РѕРЅ РІР»РёСЏРµС‚ РЅР° РїСЂРёРІР°С‚РЅРѕСЃС‚СЊ, СЃРєРѕСЂРѕСЃС‚СЊ Рё СѓСЃС‚РѕР№С‡РёРІРѕСЃС‚СЊ СЃР°Р№С‚Р°.
5. РџСЂРѕРІРµСЂСЏС‚СЊ Р°РґР°РїС‚РёРІРЅРѕСЃС‚СЊ РјРёРЅРёРјСѓРј РЅР° 360, 768 Рё 1280 px: С€Р°РїРєР°, РјРµРЅСЋ, РєРЅРѕРїРєРё, РєР°СЂС‚РѕС‡РєРё, С‚Р°Р±Р»РёС†С‹ С†РµРЅ, С„РѕСЂРјС‹ Рё С„СѓС‚РµСЂ РЅРµ РґРѕР»Р¶РЅС‹ Р»РѕРјР°С‚СЊСЃСЏ РёР»Рё РїРµСЂРµРєСЂС‹РІР°С‚СЊ С‚РµРєСЃС‚.
6. РџСЂРѕРІРµСЂСЏС‚СЊ РґРѕСЃС‚СѓРїРЅРѕСЃС‚СЊ Р±Р°Р·РѕРІРѕ: РґРѕСЃС‚Р°С‚РѕС‡РЅС‹Р№ РєРѕРЅС‚СЂР°СЃС‚, РїРѕРЅСЏС‚РЅС‹Рµ `alt` Сѓ СЃРјС‹СЃР»РѕРІС‹С… РёР·РѕР±СЂР°Р¶РµРЅРёР№, РІРёРґРёРјС‹Р№ С„РѕРєСѓСЃ, РєРѕСЂСЂРµРєС‚РЅС‹Рµ `aria-label` Сѓ РєРЅРѕРїРѕРє РјРµРЅСЋ.
7. РќРµ РґРµР»Р°С‚СЊ destructive-РѕРїРµСЂР°С†РёРё СЃ С„Р°Р№Р»Р°РјРё Р±РµР· РїСЂРѕРІРµСЂРєРё Р°Р±СЃРѕР»СЋС‚РЅРѕРіРѕ РїСѓС‚Рё. РћСЃРѕР±РµРЅРЅРѕ Р°РєРєСѓСЂР°С‚РЅРѕ СЂР°Р±РѕС‚Р°С‚СЊ СЃ `wa-cache`, Р°СЂС…РёРІР°РјРё Рё РїР°РїРєРѕР№ `C:\xampp\webasyst-local`.
8. РџРѕСЃР»Рµ РїСЂР°РІРѕРє РїСЂРѕРіРѕРЅСЏС‚СЊ smoke-check: РіР»Р°РІРЅР°СЏ, `usyplenie-zhivotnyh`, `krematsyja-zhyvotnyh`, `vyvoz-zhivotnyh`, 404-СЃС‚СЂР°РЅРёС†Р°, РјРѕР±РёР»СЊРЅРѕРµ РјРµРЅСЋ.

## Р§С‚Рѕ РїРµСЂРµРЅРµСЃРµРЅРѕ

- РћСЃРЅРѕРІРЅРѕРµ РїРѕР·РёС†РёРѕРЅРёСЂРѕРІР°РЅРёРµ: СѓСЃС‹РїР»РµРЅРёРµ, РєСЂРµРјР°С†РёСЏ, РІС‹РІРѕР· Р¶РёРІРѕС‚РЅС‹С… РІ РџРµС‚СЂРѕР·Р°РІРѕРґСЃРєРµ Рё РљР°СЂРµР»РёРё.
- РўРµР»РµС„РѕРЅ, Р°РґСЂРµСЃ, СЂРµР¶РёРј 24/7 Рё Р±Р»РѕРє СЃ РєР»СЋС‡РµРІС‹РјРё СѓСЃР»РѕРІРёСЏРјРё.
- РЈСЃР»СѓРіРё, С†РµРЅС‹ РїРѕ РІРµСЃРѕРІС‹Рј РєР°С‚РµРіРѕСЂРёСЏРј, РїРѕСЂСЏРґРѕРє РѕР±СЂР°С‰РµРЅРёСЏ, РѕС‚Р·С‹РІС‹ Рё РєРѕРЅС‚Р°РєС‚РЅС‹Р№ Р±Р»РѕРє.
- Р’РЅСѓС‚СЂРµРЅРЅРёРµ СЃС‚СЂР°РЅРёС†С‹ Webasyst РІС‹РІРѕРґСЏС‚ СЃРІРѕР№ РєРѕРЅС‚РµРЅС‚ С‡РµСЂРµР· `{$page.content}`, РЅРѕ РїРѕР»СѓС‡Р°СЋС‚ РѕР±С‰СѓСЋ С‚РёРїРѕРіСЂР°С„РёРєСѓ, С€Р°РїРєСѓ, РїРѕРґРІР°Р» Рё РІРёР·СѓР°Р»СЊРЅС‹Р№ СЃС‚РёР»СЊ С‚РµРјС‹.
