# Legal documents publication

## Owner correction: HTML-only publication

- Owner requested removal of the standalone `в ИП МЯСНИКОВ КИРИЛЛ ЛЬВОВИЧ` line and downloadable files if not legally required.
- Reviewed 152-FZ article 18.1(2): public access to the policy is required, with no mandated PDF/DOCX format. Source: https://www.consultant.ru/document/cons_doc_LAW_61801/eeeebe22bf738fd65bb66b95cc278911ae2525ee/ . Article 9 does not mandate downloadable consent templates: https://www.consultant.ru/document/cons_doc_LAW_61801/6c94959bc017ac80140621762d2ac59f6006b08c/ .
- HTML-only migration removes the exact introductory paragraph, download controls on both pages, and the four matching public attachments after validating paths, SHA-256, and retained originals in the release package. Other page text and editor changes are preserved.
- Local verification passed: page text comparison, absent download controls, old document URLs unavailable, 14 internal links and 404. Policy inspected at 360/768/1280 px with no overflow.
- Original files remain in the repository and the owner's Downloads. Fresh imports now create HTML pages without public document attachments.

- Request: publish the four owner-supplied PDF/DOCX files on vet-ritual-ptz.ru.
- Baseline: production WordPress release d6c1180; local Webasyst and WordPress returned 200 after starting existing XAMPP services.
- Native WordPress pages: `/privacy-policy/` and `/personal-data-consent/`; original files imported into the Media Library. Policy also assigned to the core privacy-page setting.
- Navigation: registered `footer_legal` WordPress menu, displayed in footer and existing cookie notice if enabled. Analytics configuration is unchanged.
- DOCX text and tables retained in document order; automatic list numbering verified against supplied PDF. Original PDF/DOCX SHA-256 checksums recorded in `legal-documents/manifest.json`.
- Source policy contains blank approval date/order fields and existing numbering/date inconsistencies. Originals and wording are preserved; this publication is not a legal revision.
- Local verification: original file checksums match HTTP downloads; page text comparison passed allowing WordPress typographic dash substitution; 14 internal links returned 200; missing route returned 404; mobile menu opens/closes.
- Browser checks: 360, 768, 1280 px, no page overflow; wide legal tables scroll inside their wrappers. Legal page text bypasses theme reveal animation so long content remains visible.
- Deployment runs the idempotent importer after theme activation and existing database backup. Subsequent releases preserve editor changes and do not reimport files. Core/config are not modified.
- Working branch: `codex/legal-documents`, based on current production rather than the older dirty primary checkout.
- Production outcome: release `27243723966c05df1d0b1b518d3527d3221c1d96`, Actions run `35356225262`, success. Both pages returned 200; full text checks and SHA-256 of all four downloads passed; all 14 internal links returned 200 and missing route 404. Both public pages were inspected at 360 px with visible content and no horizontal overflow.
