# SEO Migration Matrix (Webasyst → WP)

## 1) Общие правила
1. База домена: `https://vet-ritual-ptz.ru`.
2. `canonical` формируется из normalized slug + domain.
3. OpenGraph и Twitter берут значения из:
   - page-level fallback,
   - theme-level defaults,
   - global defaults.
4. Для 404:
   1. `noindex, follow`,
   2. отдельный шаблон с `status_code 404`.

## 2) Маппинг ключевых SEO-полей
1. `meta title`:
   1. `page.meta_title` (если есть),
   2. route default map (legacy),
   3. `default_meta_title`.
2. `meta description`:
   1. `page.meta_description` (если есть),
   2. route default map,
   3. `default_meta_description`.
3. `canonical`:
   1. для страниц: домен + normalized_path,
   2. для 404: отсутствие canonical по правилу legacy.
4. `og:image`:
   1. page-level image,
   2. theme-level `og_image_id`,
   3. `/wa-data/public/site/vetritual-media/og-home.png`.
5. `twitter:image/type/title/desc`:
   1. mirroring OpenGraph.

## 3) Структурированные данные
1. `LocalBusiness`:
1. Заполняются фиксированные поля:
   - `name`,
   - `address`,
   - `telephone`,
   - `areaServed`,
   - `openingHours`.
2. `WebPage`:
   - `name` = title,
   - `description` = description,
   - `url` = canonical.
3. `BreadcrumbList`:
   - рендерится для внутренних страниц, не для главной.

## 4) Redirect/aliases и SEO безопасность
1. `about/`, `vyvoz-*` алиасы — 301 redirect на канонические роуты.
2. Для канонических URL не дублировать контент без canonical.
3. Проверять robots и robots.txt:
   - `404` не индексируется,
   - сайт в целом индексируется в индексировании.

