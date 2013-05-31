## appfog 向け laravel 4.0.x

appfog ですぐに使えるように設定ファイル等を考慮した laravelです

弄ったファイルは下記の通り

- .htaccess
  - appfog はドキュメントルートの指定が出来ないのでここでリクエストを public/ に飛ばす rewrite ルールを書いています
- bootstrap/start.php
  - environment は無指定（デフォルト）だと production になるので、他環境(local含む)はホスト名を設定します
  - ここを書き換えないと環境が切り替わりませんので、忘れずに変更しておきましょう
- app/config/local/*.php
  - local 設定
- app/config/*.php
  - app.php に logentries の設定が追加してあります
  - 使う場合は appfog の web console で addon を有効にしておきます
- app/start/production.php
  - アプリ開始時、production 環境でのみ実行される処理を書きます
  - laravel の log イベントにフックして logentries のロガーが設定してあります
  - logentries を使わない場合、LeLogger は呼ばれても何もしません

以下、オリジナルの readme

## Laravel PHP Framework

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laravel aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the entire framework can be found on the [Laravel website](http://laravel.com/docs).

### Contributing To Laravel

**All issues and pull requests should be filed on the [laravel/framework](http://github.com/laravel/framework) repository.**

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
