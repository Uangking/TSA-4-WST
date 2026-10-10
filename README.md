# IT0049 TFA4 — Sessions and Authentication

**Developer:** King Gee

This beginner-friendly project extends the TFA3 point-of-sale accounts application with session-based login and logout. Customers and user accounts are available only after login. Passwords are stored as secure hashes, not plain text.

## Requirements

- PHP 8.2 or newer with `mysqli`, `intl`, `mbstring`, and `fileinfo`
- MySQL
- Composer
- PHP GD extension for avatar image processing

## Setup

1. Start MySQL and create an empty database named `pos_db_tfa4`.
2. Install project dependencies:

   ```bash
   composer install
   ```

3. Import the completed TFA4 export into the empty database:

   ```bash
   mysql -u your_local_mysql_user -p < database/pos_db_tfa4.sql
   ```

   The export creates/uses `pos_db_tfa4` and includes the original five customers and five users, the password column, and migration history. Sample password values are `NULL` so you can initialize local demo passwords in the next step. Import it only into a new empty database; it does not drop or reset existing tables.

4. Copy `env` to `.env` and set your local values:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   database.default.hostname = 127.0.0.1
   database.default.database = pos_db_tfa4
   database.default.username = your_local_mysql_user
   database.default.password = your_local_mysql_password
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

   Keep `.env` private and never commit it.

5. The export already includes the additive password-column migration. Initialize temporary passwords for the five sample accounts:

   ```bash
   php spark users:initialize-demo-passwords
   ```

   The command writes the generated credentials to `writable/demo-passwords.txt` on this computer and stores only password hashes in MySQL. Keep that file private. It is ignored by Git. The command will refuse to replace an existing file or overwrite existing sample-user password hashes.

6. Start the application:

   ```bash
   php spark serve
   ```

   Visit `http://localhost:8080` and sign in using a sample username and its generated password.

## Routes

- `GET /` — Home
- `GET /about` — About
- `GET /login` and `POST /login` — Login
- `POST /logout` — Logout
- `GET /customers` — Customer Accounts (login required)
- `GET|POST /customers/new` — Add a customer (login required)
- `GET|POST /customers/edit/{id}` — Edit a customer (login required)
- `GET /users` — User Accounts (login required)
- `GET|POST /users/new` — Add a user (login required)
- `GET|POST /users/edit/{id}` — Edit a user and optionally upload an avatar (login required)

The forms use CSRF protection. Customer and user forms validate required fields and preserve safe form values after validation errors. New users set a password, which is stored as a hash. Usernames must be unique. Login failures use the same message for unknown users and incorrect passwords.

## Avatar uploads

Avatars are optional and can be uploaded while editing a user. Genuine JPG/JPEG and PNG images up to 2 MB are resized proportionally to fit within 300 by 300 pixels. Images are stored in `public/uploads/avatars/`. The user list displays an uploaded avatar when its file exists and a local placeholder otherwise.

## Database notes

The migration adds a nullable password column to `users` without replacing existing tables or records. Run this project against its separate `pos_db_tfa4` database, not the TFA3/live database.

## Source repository

The original TFA3 project is at [https://github.com/Uangking/TSA-3-WST](https://github.com/Uangking/TSA-3-WST). This TFA4 copy has no configured GitHub remote.
