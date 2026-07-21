# Workflow редактирования Vet Ritual в WordPress

## Базовый принцип

Верстка живет в теме, контент живет в штатной админке WordPress. Webasyst/Smarty используется только как визуальный источник: структура блоков, классы, отступы, медиа и порядок секций. Smarty-синтаксис и JSON-настройки не переносятся в WordPress как источник контента.

## Где редактировать

### Страницы

Открыть: `wp-admin/edit.php?post_type=page`

Через страницы редактируются:
- главная страница: заголовок, excerpt, featured image для hero;
- `/uslugi/`, `/o-nas/`, `/kontakty/`, `/tseny/` и alias `/tsyeny/`;
- сервисные страницы: `/usyplenie-zhivotnyh/`, `/krematsyja-zhyvotnyh/`, `/vyvoz-zhivotnyh/` и вложенные услуги.

Страницы остаются источником основного текста, SEO-заголовков, hero и длинного контента. Карточки, цены, этапы, отзывы и повторяемые блоки редактируются через отдельные типы записей ниже.

### Services

Открыть: `wp-admin/edit.php?post_type=vr_service`

Одна запись равна одной карточке услуги. Используются:
- заголовок записи;
- excerpt или контент для описания;
- featured image для изображения карточки;
- поле `Ссылка услуги` для URL;
- поле `CSS-класс медиа` для визуального состояния карточки;
- поле `Fallback media slug` для резервной картинки из темы;
- `menu_order` для порядка.

### Price Groups

Открыть: `wp-admin/edit.php?post_type=vr_price_group`

Одна запись равна одной группе цен. Используются:
- заголовок записи как название группы;
- excerpt как примечание;
- метабокс `Строки цен` для пар `Название` + `Цена`;
- `menu_order` для порядка.

`post_content` у групп цен не является источником строк прайса. Это сделано, чтобы не парсить текст и не хранить таблицу цен в неявном формате.

### Feature Cards

Открыть: `wp-admin/edit.php?post_type=vr_feature`

Одна запись равна одной информационной карточке. Используются:
- заголовок записи;
- контент записи как основной текст;
- поле `Контекст блока`: `about` или `contact`;
- поле `Пункты списка` для строк списка;
- `menu_order` для порядка.

### Process Steps

Открыть: `wp-admin/edit.php?post_type=vr_process_step`

Одна запись равна одному шагу процесса. Заголовок и контент выводятся в карточке шага. Порядок задается через `menu_order`.

### Reviews

Открыть: `wp-admin/edit.php?post_type=vr_review`

Заголовок - имя, excerpt - подпись, контент - текст отзыва. Порядок задается через `menu_order`.

### Настройки темы

Открыть: `wp-admin/themes.php?page=vr-theme-options`

Здесь остаются только глобальные параметры:
- название/город/контакты;
- социальные ссылки;
- CTA hero;
- SEO fallback и verification meta;
- аналитика, cookie, служебный HTML;
- базовый путь к media fallback.

Контентные JSON-поля считаются устаревшим долгом и не должны использоваться для новых правок.

## Проверка после правок

Проверить:
- `http://localhost/vetritual-wp/`
- `http://localhost/vetritual-wp/uslugi/`
- `http://localhost/vetritual-wp/o-nas/`
- `http://localhost/vetritual-wp/tseny/`
- `http://localhost/vetritual-wp/tsyeny/`
- `http://localhost/vetritual-wp/kontakty/`
- `http://localhost/vetritual-wp/usyplenie-zhivotnyh/`
- `http://localhost/vetritual-wp/krematsyja-zhyvotnyh/`
- `http://localhost/vetritual-wp/vyvoz-zhivotnyh/`
- `http://localhost/vetritual-wp/404`

Минимум responsive-проверки: 360, 768, 1280 px.
