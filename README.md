
## Установка

1. composer update
2. php artisan key:generate
3. php artisan migrate
4. php artisan db:seed
5. npm install

## Создание билда и разработка 
1. npm run prod - создание билда для продакшна
2. npm run watch-poll - режим разработчика

## Структура файловой системы
- /resources/views/spa.blade.php - файл в котором харнится шаблон для SPA.
- /resources/js/app.js - входная точка в проект.
- /resources/js/App.vue - входная точка в проект, отрисовка всех шаблонов. Корневой компонент!
- /resources/js/bootstrap.js - загрузка и инициализация параметров.
- /resources/js/components - папка где хранятся страницы сайта, модальные окна и.т.д. в виде компонентов.
- /resources/js/components/common - папка где хранятся общедоступные компоненты. Это может быть какие то модальные окна общего назначения или что то другое.
- /resources/js/components/pages - папка где хранятся страницы сайта в виде компонентов.
- /resources/js/components/[назване папки]/modals - папка где хранятся модальные окна.
- /resources/js/router/index.js - РОУТЕРЫ VUE ! Маршрутизация!
- /resources/js/Layout/Components - составные компоненты которые образуют всю страницу такие как футер, хидер, сайтбар итд!
- /resources/js/Layout/Components/Sidebar.vue - САЙДБАР, а если по русски то это левое меню в шаблоне!
- /resources/js/Layout/Wrappers - шаблоны для VUE


## Используем 
1. Шаблон - https://demo.dashboardpack.com/architectui-html-pro/

## Соглашение по схеме работы с ветками
Есть 2 ветки: master и dev
Правило: когда начинаем работу над какой либо фичей мы всегда ветвимся из ветки дев!!! А не от мастера!!!

Схема работы такая,
 
1) Получаем последние обновы из репы
git pull origin dev

2) Создаём новую ветку из ветки дев (авто переключается на созданную ветку)
git checkout -b NOVAYA_VETKA dev

3) Поработав на своей ветке и завершив работу  делаем коммит 
git commit -a -m "New feature finished"

4) Делаем слияние нашей ветки с веткой дев!
git checkout dev
git merge --no-ff NOVAYA_VETKA

5) Берем последние обновы из репы и если есть конфликты то решаем их
git pull origin dev

6) Отправляем наши обновы на репу в ветку дев 
git push origin dev

Слияние ветки dev с веткой master делает только тот человек который занимается сервером! 
При этом он, слияние делает не на сервере а у себя на компе!!! Это очень важно ибо если при слиянии будут конфликты то легче их решить на своем компе нежели на сервере куда люди заходят и могут увидеть ошибки вызванные в результате слияния.
А потом уже пушить результат слияния на репу, а на сервере обновление происходит уже из репы!!!




## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**

### Community Sponsors

<a href="https://op.gg"><img src="http://opgg-static.akamaized.net/icon/t.rectangle.png" width="150"></a>

- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [云软科技](http://www.yunruan.ltd/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
