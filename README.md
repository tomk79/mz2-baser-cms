# mz2-baser-cms

[Pickles 2](http://pickles2.pxt.jp/) から [baserCMS](https://basercms.net/) へデータをエクスポートします。

## インストール - Install

coming soon.

## 使い方 - Usage

```php
<?php
$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main( '/path/to/your/.px_execute.php' );
$result = $mz2basercms->export( './path/to/your/export.zip' );
$errors = $mz2basercms->get_errors();

var_dump($result); // <- Result (true, or false)
var_dump($errors); // <- Error Messages
```

### オプション - Options

```php
<?php
$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main(
    '/path/to/your/.px_execute.php',
    // CMS Settings
    array(
        'local_resource_mode'=>'embed' ,
            // 画像などのコンテンツ個別リソースをどう出力するか？
            // embed = dataスキーマに変換して埋め込む (デフォルト)
            // theme_files = テーマディレクトリの files フォルダに出力する (ただし、出力後手動でファイル格納フォルダに設置しなおす必要あり)
    ),
    // Other options
    array(
        'commands'=> array(
            'php'=>'/path/to/php',
        ),
        'php_ini'=>'/path/to/php.ini',
        'php_extension_dir'=>'/path/to/php_extension_dir/'
    )
);
$result = $mz2basercms->export( './path/to/your/export.zip' );
$errors = $mz2basercms->get_errors();

var_dump($result); // <- Result (true, or false)
var_dump($errors); // <- Error Messages
```

## ライセンス - License

Copyright (c)2001-2017 Tomoya Koyanagi, and Pickles 2 Project<br />
MIT License https://opensource.org/licenses/mit-license.php


## 作者 - Author

- Tomoya Koyanagi <tomk79@gmail.com>
- website: <http://www.pxt.jp/>
- Twitter: @tomk79 <http://twitter.com/tomk79/>
