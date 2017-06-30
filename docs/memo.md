# Pickles 2 から baserCMS へコンテンツを盛り付けるメモ

やりながらbaserCMSに詳しくなってきたので、知ったことをメモします。

- `<baserRoot>/admin/` で管理画面にアクセスできる。
- データのインポート/エクスポート機能が存在する。
    - Home > システム設定 > ユーティリティ > データメンテナンス
    - 「データのバックアップ」、「データの復元」 から操作
    - データはZIPファイルで入出力。
    - ZIPを解凍すると、 `core` と `plugin` フォルダに分かれており、それぞれ `table_name.csv` と `table_name.php` のファイルがセットで、DBテーブルの数だけ置かれている？ような構造。
    - `table_name.php` は、 `CakeSchema` クラスのサブクラスになっているので、おそらくCakePHPの機能を使って入出力しているのではないか。
- `core/contents.csv`
    - Pickles 2 のサイトマップに相当するデータ。
    - ただし、フォルダという概念がある。物理階層を表している？
    - フォルダは、 `core/content_folders.csv` にリストされる。
    - `core/contents.csv` の type=ContentFolder のとき、 entity_id で紐付いている。
- `core/pages.csv`
    - Pickles 2 のコンテンツに相当するデータ。
    - `core/contents.csv` で、type=Page のとき、entity_id で紐付いている。
- `core/users.csv`
    - ユーザー情報がハッシュ化されたパスワード付きで出力されてしまうので要注意。
- `core/sites.csv`
    - スマホ用、ケータイ用、などの区別がある場合、ここに登録するらしい。
    - PC用ページは定義する必要がなく、 ID=0 とすると関連づく。
    - PC用ページしかない場合は、レコードを挿入しなくてよい。
