# 資料表草案

## users
- id
- name
- email
- password
- role (`admin`, `customer`)
- preferred_channel (LINE / FB / Email / Web)
- lifecycle_stage (`new`, `active`, `churn-risk`, ...)
- last_engagement_at
- cx_tags (JSON)
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

## categories
- id
- parent_id (nullable self reference)
- name
- slug (unique)
- description
- sort_order
- is_active
- created_at / updated_at

## category_product（Pivot）
- id
- category_id
- product_id
- created_at / updated_at

## product_variants
- id
- product_id
- sku (unique)
- attributes (JSON：尺寸/顏色/容量等)
- price (可覆寫 product price)
- cost_price
- stock
- is_default
- image_url
- created_at / updated_at

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

## tracking_sessions
- id
- session_key
- user_id
- device_fingerprint
- origin_channel
- started_at
- last_activity_at
- ended_at
- created_at / updated_at

## interaction_events
- id
- user_id
- tracking_session_id
- event_type (search / browse / cart ...)
- origin_channel
- payload JSON
- occurred_at
- created_at / updated_at

## search_logs
- id
- user_id
- tracking_session_id
- query_text
- filters JSON
- result_count
- clicked_sku
- latency_ms
- occurred_at
- created_at / updated_at

## recommendation_logs
- id
- user_id
- tracking_session_id
- algorithm_version
- context JSON
- served_skus JSON
- engagement JSON
- feedback_status (`pending`/`positive`/`negative`)
- served_at
- created_at / updated_at

## cart_snapshots
- id
- user_id
- tracking_session_id
- snapshot_hash
- items JSON
- subtotal
- captured_at
- created_at / updated_at

## 建議狀態流
pending -> paid -> packing -> shipped -> completed
pending -> cancelled
paid -> cancelled（人工審核）
