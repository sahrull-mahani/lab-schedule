# APLIKASI PANGKALAN LPG & INFLASI

## init DB
- Migrate database
```javascript
php spark migrate
```

- Refresh database
```javascript
php spark migrate:refresh
```

## seed DB
- Seeder database
```javascript
php spark db:seed BasicSeeder
```

## tidak update versi ci (tetap di versi 4.3.6)
```javascript
composer require codeigniter4/framework:4.1.5 -W
```