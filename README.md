# Worn!
洋服の着用状況を簡単に記録・管理できるサービスです。  
どの服をいつ着たか、どれだけ活用しているかを可視化して、より効率的なワードローブ管理をサポートします。

<img width="375" src="/public/img/app-preview.png">

## URL
https://wear-logger.fly.dev/

## 使用技術
- PHP 8.2
- Laravel 11.31
- PostgreSQL 17
- JavaScript
- Tailwind CSS 3.1.0
- Vite 6.0
- Docker

## 仕様書
### プロトタイプ
<img width="720" src="https://github.com/user-attachments/assets/9cf16b7d-07c6-4c4a-af65-69007f652c96">

### ER図
<img width="720" src="https://github.com/user-attachments/assets/505aef27-1db8-4476-aff5-7193844f82d9">

## 機能一覧
- ユーザー登録、ログイン機能(Breeze)
- アイテム登録機能
    - アイテム登録、更新、削除
    - 複数アイテム一括削除
- アイテム絞り込み機能
- 着用記録登録機能
    - 当日の着用登録、解除
    - 複数アイテムの一括当日着用登録、解除
    - カレンダーによる複数日の一括着用登録、解除
- 統計情報表示機能
    - 未使用アイテムリスト
    - 着用回数ランキング
