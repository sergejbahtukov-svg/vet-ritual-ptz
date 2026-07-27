---
name: seo-vetritual
description: Coordinate SEO for the Vet Ritual WordPress theme. Use when planning keyword-led page architecture, improving template-level technical SEO or performance, preparing schema and metadata, auditing indexability, or evaluating rankings and Yandex Metrika after a change.
---

# Vet Ritual SEO

## Overview

Treat custom-theme development and SEO as one delivery stream: content ownership, indexability, metadata, speed, and measurement must support the same landing-page plan. Preserve native WordPress editing; do not make SEO copy or page entities into Customizer JSON.

## Entry checks

1. Read `AGENTS.md` and `skills/wordpress-vetritual/SKILL.md` before touching the theme.
2. For any WordPress change, start with `wordpress-router` and `wp-project-triage`; use the repository’s existing tooling rather than guessing.
3. Establish a baseline before optimising: target URL, page intent, current title/H1/canonical/indexability, Core Web Vitals or a reproducible performance measure, and the business conversion being measured.
4. Test the custom theme locally before deployment. Never infer SEO correctness from static exports or preview HTML.

## Select the smallest appropriate skill

| Need | Use |
|---|---|
| Map search intent to pages, services, FAQ, and editorial content | `semantic-core`; use `demand-research` when actual demand research is needed |
| Audit an existing page’s on-page and technical signals | `seo-optimizer` |
| Diagnose TTFB, slow templates, cron, database or caching | `wp-performance` |
| Safely inspect or operate WordPress via CLI | `wp-wpcli-and-ops` |
| Measure rankings and changes in Yandex SERP | `serp-monitor` |
| Measure visits and confirmed goals, with read-only access by default | `yandex-metrika` |

Do not install a page builder, ACF, or SEO plugin solely to avoid theme work. Choose a plugin only after confirming the native implementation cannot meet a defined requirement and the project owner approves the added dependency.

## Delivery sequence

1. **Structure first.** Build a semantic map: cluster → intent → one canonical landing page → editor-owned content source → internal links. Avoid creating multiple near-duplicate pages for the same query.
2. **Implement in the theme.** Keep each page’s visible text in Pages/CPTs/blocks, global contacts in options, and navigation in menus. Implement a single H1, logical headings, canonical URL, useful title/description, Open Graph, robots directives, and meaningful image alt text.
3. **Add structured data only when factual.** Prefer `Organization`/`LocalBusiness`, `WebSite`, `WebPage`, `BreadcrumbList`, `Service`, and `FAQPage` where the corresponding visible content exists. Never fabricate ratings, reviews, prices, availability, medical credentials, or business claims.
4. **Measure performance before and after.** Use `wp-performance` for repeatable backend measurements; do not trade a fast page for keyword-stuffed markup or excessive third-party scripts.
5. **Release and observe.** Run the gate in `references/seo-release-gate.md`, deploy, then record the change and compare rankings/analytics only after enough data has accumulated.

## Safety and reporting

- Separate facts, hypotheses, and recommended actions in every SEO report.
- Do not claim a lead, sale, conversion, or ranking lift without a confirmed goal, source, period, and enough data.
- Analytics writes, goal changes, tag changes, URL migrations, redirects, database operations, and production cache flushes require an explicit plan and project-owner approval.
- Do not expose tokens, counter identifiers, credentials, or personal data in commits, screenshots, or reports.
- Keep Russian copy helpful and accurate for Petrozavodsk/Karelia; no keyword stuffing, doorway pages, copied competitor text, or unsupported promises.

## Expected deliverables

For a planned slice, provide: intent and target page, content owner in WordPress, metadata/schema/internal-link changes, performance impact, verification result, and the metric/check that will decide whether the change worked.
