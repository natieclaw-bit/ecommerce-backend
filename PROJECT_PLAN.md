# 電商後台專案計畫

## 專案名稱
StockFlow Commerce

## 目標
建立一套公司第一個電商系統，包含：
- 管理者後台：商品/庫存/訂單管理
- 客戶前台：瀏覽庫存、下單、查詢訂單進度

## 第一階段範圍（MVP）
1. 商品管理
2. 庫存管理
3. 客戶下單
4. 訂單查詢
5. 訂單狀態追蹤
6. 管理者登入

## 角色
- Admin：管理商品、庫存、訂單
- Customer：瀏覽商品、下單、查詢訂單

## MVP 功能清單
### 後台
- 登入/登出
- 商品 CRUD
- 庫存數量調整
- 訂單列表
- 訂單狀態更新（pending / paid / packing / shipped / completed / cancelled）

### 前台
- 商品列表
- 商品詳情
- 購物車
- 建立訂單
- 查看訂單進度

## 主要頁面
- `/admin/login`
- `/admin/products`
- `/admin/inventory`
- `/admin/orders`
- `/products`
- `/products/{id}`
- `/cart`
- `/checkout`
- `/orders/{order_no}`

## 技術方向
- Laravel 13
- MySQL
- Blade（MVP）
- Tailwind CSS（後續可補）

## 第二階段候選
- 金流串接
- 會員系統
- 出貨通知
- 權限分級
- 報表分析
