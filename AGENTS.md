# AGENTS.md

## Cursor Cloud specific instructions

### What this app is
Laravel 8 travel-agency / accounting ERP ("Tour Vision Travel"). Modules: Accounts, OTA/LMS, Agent, Umrah. Stack: PHP 8.4, Composer, MariaDB/MySQL, Livewire, Jetstream, Passport, Spatie Permission, Yajra DataTables. Frontend (AdminLTE) assets are committed under `public/`; there is no `package.json`, so no `npm`/Mix build is needed or possible.

### Services and how to run them
The VM startup (update) script only runs `composer install`. You must start the database and web server yourself each session; the DB data dir and `.env` persist in the VM snapshot.

- MariaDB (required): start with `sudo mariadbd --user=mysql` (run it in a tmux session; it logs to stdout). Root user has no password over TCP (`mysql -uroot -h127.0.0.1`). Databases: `laravel` (dev, migrated + seeded) and `laravel_test` (for the test suite).
- Web server (required): DO NOT use `php artisan serve` / `server.php`. The front controller is the repo-root `index.php` (cPanel-style layout, docroot = repo root), and views reference assets with a `public/` prefix (e.g. `asset('public/plugins/...')`), so `server.php` (which expects `public/index.php`) does not work. Instead run the built-in server with the repo root as docroot plus a small router that emulates the root `.htaccess`:
  ```bash
  cat > /tmp/router.php <<'PHP'
  <?php
  $root = '/workspace';
  $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  if ($uri !== '/' && file_exists($root . $uri) && !is_dir($root . $uri)) { return false; }
  require_once $root . '/index.php';
  PHP
  php -S 0.0.0.0:8000 -t /workspace /tmp/router.php
  ```
  Then the app is at http://127.0.0.1:8000 (`/` → `/home` → `/login`).

### Login
Seeded admin: `admin@gmail.com` / `123456` (full-access Admin role).

### First-time DB setup (only if the snapshot DB is empty / after a reset)
```bash
php artisan migrate:fresh --seed   # seeds admin, permissions, chart of accounts, geography, airlines
php artisan passport:install       # required: api guard driver is passport
php artisan storage:link           # public file uploads
```
`.env` is created from `.env.example` with `APP_KEY` generated; DB points at `laravel` on `127.0.0.1` as `root` (no password).

### Tests
Run against the separate test DB so dev data is not wiped by `RefreshDatabase`:
```bash
DB_DATABASE=laravel_test php artisan test
```
Only the default Jetstream scaffold tests exist under `tests/`. ~12 pass (including the core `AuthenticationTest`). ~13 fail as a PRE-EXISTING condition because this app replaced the default Jetstream UI with a custom AdminLTE UI, so scaffolded tests reference views that no longer exist (registration screen, profile/2FA/delete-account/update-password forms). These failures are unrelated to environment setup.

### Lint
There is no local linter. Style is enforced via StyleCI (SaaS) using `.styleci.yml` (Laravel preset). `php -l` can be used for syntax checks.

### Known app-level caveats (not environment problems)
- Case-sensitive view paths: some controllers request views with the wrong case (e.g. `view('Setup.airlines.index')` while the folder is `resources/views/setup/...`). These pages throw "View not found" on Linux (case-sensitive) even though they work on macOS/Windows. The Airlines page is one example.
- Copy-paste bugs in some modal forms: e.g. the Countries create modal (`resources/views/countries/index.blade.php`) posts to `continents.store` instead of `countries.store`, so creating a country via that form fails.
- A known-good simple create flow for smoke tests is HR → Department (`/Hr/department`, single "Department Name" field, posts to `department.store`).

### Migration notes
Two committed migrations had defects that prevent a fresh MySQL/MariaDB build and were corrected: `create_transaction_accounts_table` declared a second auto-increment column (`code`), and `create_agent_wallets_table` declared a duplicate `agentID` column. Deprecation notices from `laravel/framework` under PHP 8.4 are harmless.
