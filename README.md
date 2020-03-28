Проект "Расписание"
===================

Существующий интерфейс расписания в Московском политехе - устарел, как функционально, так и внешне.
Новое расписание будет использовать существующие методы и интерфейсы для сбора данных, но обрабатывать их, тем самым предоставляя пользователям новые возможности при использовании расписания.

Цели
----

- взаимодействия со сторонними приложениями, по средствам API;
- отслеживание изменений в расписании.

О Backend
---------

**Backend** представляет собой сборщик данных из существующей системы и API для получения обработанных данных. 

За основу был взят [PHP фреймворк Laravel 7.x](https://laravel.com/) .
Сборщик данных основан на связке [Job + Queue](https://laravel.com/docs/7.x/queues) + [HTTP Client](https://laravel.com/docs/7.x/http-client) .
API предоставляется стандартными, для Laravel, подходами.

При разработке использовано
---------------------------
- [PHPStorm](https://www.jetbrains.com/phpstorm/) (Education license)
  - [Laravel Idea](https://plugins.jetbrains.com/plugin/13441-laravel-idea) (Education license)
  - [Markdown Navigator Enhanced](https://plugins.jetbrains.com/plugin/7896-markdown-navigator-enhanced) (Personal license)
  - [Material UI Theme](https://plugins.jetbrains.com/plugin/8006-material-theme-ui)
- [Laravel](https://laravel.com/)
  - [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- [GitHub Student Developer Pack](https://education.github.com/pack) 

**THANKS for opportunity to use free professional tools!**
