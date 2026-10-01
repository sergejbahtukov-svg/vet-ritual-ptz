# Проект Vet Ritual

Действующий сайт работает на WordPress: https://vet-ritual-ptz.ru/.

## Код и данные

- Тема: `wordpress-theme/vetritual-modern/`.
- Локальная установка: `C:\xampp\htdocs\vetritual-wp`.
- Контент хранится в WordPress Pages, Menus, Media Library и типах записей `vr_*`.
- Глобальные контакты, реквизиты и интеграции хранятся в настройках темы.
- Начальные данные для новой установки описаны в `tools/seed-wordpress-content.php`. Для действующего сайта использовать точечные операции.

## Публикация

- Код темы выпускает `.github/workflows/deploy-wordpress.yml` через `scripts/deploy-wordpress.sh`.
- Перед заменой темы сценарий сохраняет резервную копию базы.
- После выпуска проверяются главная, цены, основные услуги, контакты и 404.
