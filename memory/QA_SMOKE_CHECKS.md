# WordPress smoke checks

## Local URL

`http://localhost/vetritual-wp/`

## Pages

Check `/`, `/uslugi/`, `/usyplenie-zhivotnyh/`, `/krematsyja-zhyvotnyh/`, `/vyvoz-zhivotnyh/`, `/tseny/`, `/kontakty/` and a missing URL that must return 404.

## Content

- Price rows on the home page and `/tseny/` match the edited `vr_price_group` record.
- Footer shows the legal name, INN and OGRNIP on all pages.
- Russian text is readable and internal links resolve.
- The mobile menu opens and closes.

## Layout

Check the affected pages at 360, 768 and 1280 px for horizontal overflow and overlapping prices or footer text.

## Production

After a release, repeat the content checks on `https://vet-ritual-ptz.ru/` and `/tseny/`. Confirm that the deployment created a database backup.
