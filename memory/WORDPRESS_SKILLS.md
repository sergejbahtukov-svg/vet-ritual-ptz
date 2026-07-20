# WordPress Skills & Templates

## Базовый стек
- PHP для WordPress темы:
  - `template files`
  - `WP_Query`
  - `template hierarchy`
  - `enqueue`, `nav menus`
- Theme API:
  - `Theme Customizer` (`WP_Customize_Manager`)
  - `Settings API` (`register_setting`, `add_settings_section`, `add_settings_field`)
  - `Options` + `theme_mod` / `ACF option pages`
  - `theme.json` и базовые tokens для редактора
- Frontend:
  - перенос CSS/JS блоков, производительность, accessibility
- SEO:
  - `title/description`, OG, Schema, canonical, robots, sitemap
- QA:
  - smoke check, rollout checklist, rollback checklist

## Ресурсы сайта
- Page Builder/вложенные модули по необходимости
- ACF (для полей страниц/групп)
- Rank Math (или эквивалент)
- WPForms / Fluent Forms (если нужны формы)
- Кеш и скорость: WP Super Cache / LiteSpeed Cache
- Подключение счетчиков/интеграций (Metrika, GA/GTM и др.) через theme settings

## Модель Theme Settings
- Все правки пользователя должны проходить через админку:
  - Contacts/brand
  - Hero + CTA
  - Включение/выключение секций
  - SEO fallback
  - Cookie consent + метрики
- Единый контракт чтения:
  - `vr_theme_setting($key, $default)`
- Нельзя читать опции напрямую в шаблонах через `get_option()` без helper-слоя.

## План миграции контента
- `page.html` / `home.html` -> `page.php`, `front-page.php`, `template-parts`
- `theme.js` + `integrations.js` -> `assets/js/*`
- Контентная информация:
  - глобальные данные в `theme options`
  - структурные поля в ACF
  - визуальный уровень в `theme.json`

## Поиск и интеграция скиллов (новый обязательный шаг)
- Перед стартом разработки запускается сборка:
  - `memory/WORDPRESS_CAPABILITY_MATRIX.md`
  - `agent-skill-scout` делает инвентаризацию по всем ролям
- Для каждого незакрытого навыка фиксируем вариант закрытия:
  - назначение владельца
  - внутренний спайк
  - внешний плагин/ресурс
  - обучение или расширение
- Без закрытых критичных пробелов старт разработки откладывается.

## Output шаблон для сабагентов
- Каждый сабагент отчитывается:
  - findings
  - mapping
  - risks
  - acceptance criteria
- Обязательно включить в итоговый отчёт ссылку на `Theme Settings Contract`.
## Критические требования по навыкам для готовности к сборке

- Поддержать `ready_for_build` только после подтвержденного skill-mapping и темный контракт настроек.
- Theme Settings реализуются через helper (`vr_theme_setting`) и безопасный вывод (`esc_*`).
- Обязателен план миграции URL и редиректов как часть content mapping.
- Нужны локальные проверки на `https://vetritual.lvh.me/` и сценарий rollback для rollout.
