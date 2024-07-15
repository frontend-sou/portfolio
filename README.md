# Tsumami-sou / お酒のおつまみレシピ共有サービス

![service-image](https://raw.githubusercontent.com/frontend-sou/portfolio/public/images/readme.png)
<img src="https://img.shields.io/badge/-PHP-777BB4.svg?logo=php&style=plastic">
<img src="https://img.shields.io/badge/-Laravel-E74430.svg?logo=laravel&style=plastic">
<img src="https://img.shields.io/badge/-Vue.js-4FC08D.svg?logo=vue.js&style=plastic">
<img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=plastic">
<img src="https://img.shields.io/badge/-Amazon%20AWS-232F3E.svg?logo=amazon-aws&style=plastic">
[![Thanks](https://img.shields.io/badge/Thank%20you-for%20visiting-00aab9)](https://www.hayabusatrip.com)

## サービス概要

ツマミソウは、「お酒に合うおつまみを探して晩酌を楽しみたい！」という想いから作られた、無料のおつまみレシピ共有サービスです。

・お酒のつまみはコンビニで済ませているが、段々飽きてきた
・お酒をより美味しく感じるためにおつまみのレパートリーを増やしたい

というような要望に応えるべく、レシピ投稿から検索まで簡単ステップでサービスをお使いいただけます。

### ▼ サービスURL



レスポンシブ対応済のため、PCでもスマートフォンでもご利用いただけます。

## メイン機能の使い方

<table>
  <tr>
     <th style="text-align: center">おつまみレシピ作成</th>
    <th style="text-align: center">タグ、タイトル、本文、写真のアップロード</th>
    <th style="text-align: center">おつまみレシピ公開</th>
  </tr>
<!--   <tr>
    <td><img src="https://raw.githubusercontent.com/frontend-sou/portfolio/public/images/readme.png" alt="旅行プラン作成" />まずは、旅行プラン作成ボタンを押して、各旅行情報を記入後に作成ボタンを押す。</td>
    <td><img src="https://raw.githubusercontent.com/keynyaan/hayabusatrip-frontend/main/public/images/demo/add-spot.gif" alt="旅行スポット追加" />次に、スポット追加ボタンを押して、各スポット情報を記入後に追加ボタンを押す。</td>
    <td><img src="https://raw.githubusercontent.com/keynyaan/hayabusatrip-frontend/main/public/images/demo/publish-settings.gif" alt="旅行プラン公開" />最後に、三点リーダーから公開状態の変更ボタンを押して、公開に変更したら完了！</td>
  </tr> -->
</table>

## 使用技術一覧

**バックエンド:** PHP 8.2 / Laravel 11.0

- コード解析 / フォーマッター: Rubocop
- テストフレームワーク: RSpec

**フロントエンド:** Vue.js

- コード解析: ESLint
- フォーマッター: Prettier
- テストフレームワーク: Jest / React Testing Library
- CSSフレームワーク: Tailwind CSS
- 主要パッケージ: Axios / Font Awesome / React Paginate / React Responsive Modal / React Toastify

**インフラ:** AWS(Route53 / Certificate Manager / ALB / VPC / ECR / ECS Fargate / RDS MySQL / S3) / Nginx / Vercel

**CI / CD:** GitHub Actions

**環境構築:** Docker / Docker Compose

**認証:** Laravel

## 主要対応一覧

### ユーザー向け

#### 機能

- メールアドレスとパスワードを利用したユーザー登録 / ログイン機能
- ユーザー情報変更機能
- パスワード再設定機能
- 退会機能
- おつまみレシピ投稿の取得 / 作成 / 更新 / 削除機能
- 投稿のタグ付け機能
- 投稿のいいね/一覧取得機能
- 自分の投稿一覧取得機能
- レシピ投稿ワード検索機能(Vue3のref関数を用いたリアクティブな検索)
- レシピ投稿タグ検索機能(Vue3のref関数を用いたリアクティブな検索)
- ページネーション機能
- 画像の取得 / アップロード機能
- ページのSPA機能

#### 画面

- トップページ
- ログイン画面
- 投稿一覧画面
- マイ投稿一覧画面
- いいね画面
- レスポンシブデザイン

### 非ユーザー向け

#### システム / インフラ

- inertiaツール活用によるSPA構築
- Dockerによる開発環境のコンテナ化
- Route53による独自ドメイン + SSL化
- GitHub ActionsによるCI / CDパイプラインの構築
  - バックエンド
    - CI: Rubocop / RSpec
    - CD: AWS ECS
  - フロントエンド
    - CI: ESLint / Prettier / Jest / Codecov
    - CD: Vercel

#### テスト / セキュリティ

- クロスブラウザテスト

  - PC
    - Windows10 / 11: Google Chrome / Firefox / Microsoft Edge
    - Mac: Google Chrome / Firefox / Safari
  - スマートフォン
    - Android: Google Chrome
    - iOS: Safari

## インフラ構成図

![er-diagram](https://raw.githubusercontent.com/keynyaan/hayabusatrip-frontend/main/public/images/diagrams/er-diagram.png)

## ER図

![infrastructure-diagram](https://raw.githubusercontent.com/frontend-sou/portfolio/draw.io)


## 画面遷移図

[Figma\_画面遷移図](https://www.figma.com/file/1OgxVeGaDw9riHGzxyGoLG/%E7%94%BB%E9%9D%A2%E9%81%B7%E7%A7%BB%E5%9B%B3_HayabusaTrip?type=design&node-id=0-1&mode=design)
