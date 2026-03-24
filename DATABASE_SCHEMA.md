# 資料表草案

## users
- id
- name
- email
- password
- role (`admin`, `customer`)
- created_at
- updated_at

## products
- id
- sku
- name
- slug
- description
- image_url
- cost_price (decimal, default 0, 反映採購/製造成本)
- price
- status
- created_at
- updated_at

## inventories
- id
- product_id
- quantity
- reserved_quantity
- updated_at

## orders
- id
- order_no
- user_id
- status
- total_amount
- contact_name
- contact_phone
- shipping_address
- created_at
- updated_at

## order_items
- id
- order_id
- product_id
- product_name
- unit_price
- quantity
- subtotal

## order_status_logs
- id
- order_id
- status
- note
- created_at

## 建議狀態流
pending -> paid -> packing -> shipped -> completed
pending -> cancelled
paid -> cancelled（人工審核）
