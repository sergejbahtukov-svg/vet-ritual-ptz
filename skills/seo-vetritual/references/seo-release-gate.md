# SEO release gate

Run the relevant checks for every SEO-affecting theme or content change.

## Before merge

- A single canonical page owns the intended search intent; no duplicate/doorway page was added.
- The editor can update visible SEO copy through native WordPress data.
- Title, meta description, one H1, heading hierarchy, canonical, robots, Open Graph and image alt text are correct for the page type.
- Structured data matches visible, supportable facts and validates as JSON.
- Internal links resolve and do not create loops or broken targets.
- No unapproved third-party tag, font, script, personal data, credential, or analytics write was introduced.

## Local verification

- Test the actual local WordPress page, including the target service page, 404, menu, and 360/768/1280 px layouts.
- Run syntax checks for changed PHP/JS and the repository test commands available for the slice.
- Record a reproducible speed baseline for performance-affecting work; compare the same URL, cache state, and environment.
- Confirm Russian text renders correctly and content remains editable in WordPress.

## After deployment

- Check the public canonical URL, redirect behavior where applicable, HTTP status, and visible metadata.
- Note deployment time, changed URLs, and expected leading indicators.
- Monitor only the agreed keyword set and confirmed Metrika goals; distinguish observation from causation.
