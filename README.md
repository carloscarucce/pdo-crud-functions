# pdo-crud-functions
Provides functions for common tasks using PDO

---

## Requirements

- PHP 7.1+
- PDO Extension installed and active

## Installation

With composer:

````
composer require carloscarucce/pdo-crud-functions
````

Manual:

- Download code from the repository
- Move files into your project folder
- Include the desired function in your script whenever you want to use it (*include 'path/to/project/pdo_insert_row.php'*, for example)

## Examples

First you have to connect to your database using PDO.

````php
<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=my_database', $username, $password);
````

I will leave some links for further details:

- (Official docs) https://www.php.net/manual/en/class.pdo.php
- (Practical usage tutorials) https://www.w3schools.com/php/php_mysql_connect.asp
- (Video tutorial) https://youtu.be/yWJFbPT3TC0

### Inserting data
```php
<?php

$table = 'users';
$data = [
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'active' => 1
];

//INSERT INTO users (name, email, active) VALUES ('John Doe', 'johndoe@example.com', '1')
$userId = pdo_insert($pdo, $table, $data);

if (!is_null($userId)) {
    //row inserted
} else {
    //error on inserting row
}
```

### Updating data
```php
<?php

$id = 123;
$table = 'users';
$data = [
    'name' => 'John D.',
    'active' => 1
];

//UPDATE users SET name='John D.', active='1' WHERE id='123'
$updated = pdo_update_row($pdo, $table, $data, $id);

if ($updated) {
    //row updated
} else {
    //row not updated
}
```

### Deleting a row
```php
<?php

$id = 123;
$table = 'users';

//DELETE FROM users WHERE id='123'
$deleted = pdo_delete_row($pdo, $table, $id);

if ($deleted) {
    //row deleted
} else {
    //row not deleted
}
```

### Selecting data

Conventional way:
```php
<?php

$query = 'SELECT * FROM users WHERE active=:active'
$params = [':active' => 1];

$result = pdo_select_query($pdo, $query, $params);

echo '<ul>';
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo '<li>', $row['name'], ' - ', $row['active'], '</li>';
}
echo '</ul>';
echo 'Results count: ', $result->rowCount();
```

Using a callback:
```php
<?php

$query = 'SELECT * FROM users WHERE active=:active'
$params = [':active' => 1];
$renderLineFn = function($row) {
    echo '<li>', $row['name'], ' - ', $row['active'], '</li>';
};

$result = 

echo '<ul>';
pdo_select_query($pdo, $query, $params, $renderLineFn);
echo '</ul>';
echo 'Results count: ', $result->rowCount();
```
Both methods would result in the same output:
````html
<ul>
    <li>John D. - 1</li>
    <li>Mr. Brown - 1</li>
    <li>Mrs. America - 0</li>
</ul>
````