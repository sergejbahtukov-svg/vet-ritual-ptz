# Mobile typography and spacing

Owner requested consistent mobile font sizes and alignment, using `/tseny/` as the reference problem.

- At widths up to 640 px, shared scale: hero 30 px, section headings 26 px, card headings 20 px, body 16 px, prices 15 px, notes 14 px. Body line height 1.5–1.55.
- Shared 20 px page gutters. Price cards form a full-width vertical list; labels stay left and amounts align right. All eight approved individual cremation prices retained.
- Price-page introduction becomes plain readable text on the page background; the extra panel, shadow and oversized spacing are removed on mobile.
- Mobile reveal transitions no longer move or fade content. Buttons are at least 48 px high. Price hero has compact spacing.
- New small `assets/css/mobile.css` layer is included through `wp_add_inline_style` to avoid stale cached assets without changing theme/asset versions. Existing styles above 640 px remain unaffected.
- Implemented first in local WordPress and then copied into source. Webasyst reference HTTP endpoint checked first; native WordPress owns all text and prices.
- Local browser checks: price page at 320/360/390/500/640/768/1280 px; no horizontal page overflow or price-label intersections. Screenshots reviewed at 360 and 390 px. Main, euthanasia, cremation, transport, privacy and 404 pages checked at 360 px without text clipping. Menu opens/closes.
- Local smoke: main, prices, euthanasia, cremation, transport return 200; missing page returns 404. Changed PHP files pass lint; diff whitespace check passes.
