# VELORA Accessories Shop — fresh install

## Setup with XAMPP
1. Stop Apache and MySQL before replacing files if needed.
2. Extract this ZIP. Copy the `accessories-shop` folder into `C:\xampp\htdocs\`.
3. Start Apache and MySQL in XAMPP.
4. In phpMyAdmin, create/import the database by importing `accessories-shop/database.sql`. This SQL creates the `accessories_shop` database, six tables, five categories, and 70 products.
5. The PDO connection is configured for MySQL at `127.0.0.1:3307`, username `root`, blank password. If your MySQL port differs, edit `config/database.php`.
6. Open `http://localhost/accessories-shop/`.

## Important
Import `database.sql` only into a fresh install. If `accessories_shop` already exists and contains data you need, export/back it up first. To start completely fresh, drop only the `accessories_shop` database in phpMyAdmin, then import `database.sql`. Do not delete other databases.
