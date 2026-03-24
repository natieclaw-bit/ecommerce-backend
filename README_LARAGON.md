# Laragon 快速佈署指引

1. **複製環境檔**
   ```bash
   copy .env.laragon .env
   php artisan key:generate
   ```
2. **安裝套件**
   ```bash
   composer install
   npm install
   npm run build
   ```
3. **資料庫**
   - 在 Laragon 中建立 `stockflow` 資料庫（或修改 `.env` 中的 DB 名稱）。
   - 執行 Migration + Seeder：
     ```bash
     php artisan migrate --seed
     ```
4. **啟動**
   - 方式一：Laragon > Quick App > 指到此資料夾，即可使用 `http://stockflow.test`。
   - 方式二：
     ```bash
     php artisan serve --host=0.0.0.0 --port=8000
     ```
     然後在同網域裝置用 `http://<你的IP>:8000` 存取。
5. **其他**
   - 若要看執行心跳：`Get-Content logs\task-status.log -Wait`
   - 前端資源已經 `npm run build`，若要調整樣式再重新 build 一次即可。
