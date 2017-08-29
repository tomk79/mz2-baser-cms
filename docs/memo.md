# Pickles 2 から baserCMS へコンテンツを盛り付けるメモ

## わかったこと

やりながらbaserCMSに詳しくなってきたので、知ったことをメモします。

### 全般

- `http://<baserRoot>/admin/` で管理画面にアクセスできる。
- データのインポート/エクスポート機能が存在する。
    - Home > システム設定 > ユーティリティ > データメンテナンス
    - 「データのバックアップ」、「データの復元」 から操作
    - データはZIPファイルで入出力。
    - ZIPを解凍すると、 `core` と `plugin` フォルダに分かれており、それぞれ `table_name.csv` と `table_name.php` のファイルがセットで、DBテーブルの数だけ置かれている？ような構造。
    - `table_name.php` は、 `CakeSchema` クラスのサブクラスになっているので、おそらくCakePHPの機能を使って入出力しているのではないか。
- `core/contents.csv`
    - Pickles 2 のサイトマップに相当するデータ。
    - ただし、フォルダという概念がある。(後述)
    - レイアウトテンプレート は `layout_template` のこと。テーマフォルダの `<theme>/Layouts/{$layout_template}.php` に関連付けられる。
    - `lft` と `rght` の両フィールドは、パンくずのツリー構造の表現に関係している。 [入れ子集合モデル](http://www.geocities.jp/mickindex/database/db_tree_ns.html) の左端と右端の値を格納する。
- `core/pages.csv`
    - Pickles 2 のコンテンツに相当するデータ。
    - `core/contents.csv` で、type=Page のとき、 `entity_id` で紐付いている。
- `core/users.csv`
    - ユーザー情報がハッシュ化されたパスワード付きで出力されてしまうので要注意。
- `core/sites.csv`
    - スマホ用、ケータイ用、などの区別がある場合、ここに登録するらしい。
    - PC用ページは定義する必要がなく、 ID=0 とすると関連づく。
    - PC用ページしかない場合は、レコードを挿入しなくてよい。
    - サブサイト は、デバイス別のビューのことを指している。
- 固定ページのURLに `.html` を付けることは可能。しかし、 `/` などは付けられない。あくまで単体のファイル名として有効な名前にしなければならない。

#### フォルダ

- フォルダは、 `core/content_folders.csv` にリストされる。
- `core/contents.csv` の type=ContentFolder のとき、 `entity_id` で紐付いている。
- フォルダは物理的な階層構造を表現している。
- フォルダは、親ページになる場合に必要。
- フォルダの直下に置かれている、 `name=index` のページをコンテンツとして表示する。
- `name=index` のページが存在しない場合は、下層ページのリストが表示される。

### テーマ

- テーマには、[初期データ読込機能](https://github.com/baserproject/basercms-docs/blob/dev-4/%E6%A9%9F%E8%83%BD%E4%BB%95%E6%A7%98/090.%E3%83%86%E3%83%BC%E3%83%9E/%E5%88%9D%E6%9C%9F%E3%83%87%E3%83%BC%E3%82%BF%E8%AA%AD%E8%BE%BC%E6%A9%9F%E8%83%BD.md)がついている。コンテンツやページの一覧を含めることもできるらしい。
- テーマは `<baserRoot>/theme/{$theme_name}/` にインストールする。 [baserMarket](https://market.basercms.net/) で購入しダウンロードしたテーマは、ここに置いたら認識された。
    - `<baserRoot>/app/webroot/theme/{$theme_name}/` においてもOK？ 置き場所のルールは [ここ](https://github.com/baserproject/basercms-docs/blob/dev-4/%E6%A9%9F%E8%83%BD%E4%BB%95%E6%A7%98/090.%E3%83%86%E3%83%BC%E3%83%9E/%E7%AE%A1%E7%90%86%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0%E3%83%86%E3%83%BC%E3%83%9E.md) に書かれていた。

## わからないこと

- コンテンツ一覧上にある フォルダ は、どういう概念か？
- コンテンツ一覧の並び順はどうやって制御しているか？
- 物理階層と論理階層を分けて管理できるか？
- レイアウトテンプレートと、固定ページテンプレートと、フォルダテンプレートは別？
