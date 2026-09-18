# Mobile audit of the two legal pages

Scope: production `/privacy-policy/` and `/personal-data-consent/`, with the same WordPress templates checked locally before publishing the fix.

## Results

- Browser viewport checks: 320, 360, 390, 430, 768 px for both pages; policy also checked at 844 px. No horizontal page overflow, clipped paragraphs, headings or footer legal links.
- Body text: 17 px, line height 29.24 px, text/background contrast approximately 5.27:1. Meta viewport permits user scaling.
- Policy tables retain semantic table markup, labelled focusable scrolling regions and horizontal scrolling. Keyboard horizontal scrolling was verified. Wide tables require sideways scrolling on phones; no whole-page overflow.
- Mobile menu links are 44 px high, footer legal links approximately 54 px at 360 px. Menu opens and closes.
- Found and fixed: at 844×390 the menu bottom was at 451.6 px, with the phone action below the visible screen. A legal-page-only inline media rule limits menu height using `dvh` with a `vh` fallback and enables vertical scrolling. After the fix menu bottom is 374.4 px; phone action can be scrolled into view (bottom 366 px). Portrait behavior remains intact.
- The small inline rule uses the existing WordPress style handle: no new network request and no stale asset-cache problem. No theme/asset version bump.
- Production HTTP baseline, three serial GETs per page, compressed HTML only: policy TTFB 0.823/0.555/0.719 s, 19,610 bytes; consent 0.615/0.417/0.765 s, 9,909 bytes. Gzip enabled. These are local-network observations, not full mobile render time or Core Web Vitals.
- No large content images or external webfonts on the legal pages; theme logos are SVG. Existing Yandex Metrika remains enabled and unchanged.
- Local PHP lint, exact legal text check, absence of removed downloads, 14 internal links and missing-page 404 were checked.

## Limits

Viewport emulation in the available Chromium browser; no physical iPhone/Android or Safari/WebKit run. No throttled 4G/CPU Lighthouse run, LCP/INP/CLS field assessment, load testing or production server configuration changes.
