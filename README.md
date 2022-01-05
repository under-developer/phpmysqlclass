# Php MySQL Class
A class that automatically performs simple sql queries (PHP 7.X)

# MySQL Connection
Access to mysql is provided by the baglan(); function
The settings are as follows
```php
$sql = new sql;
$sql->baglan(
  'localhost', // Server Name
  'user' , // MySQL Username,
  'password' , // MySQL User password
  'db_name' , // Database name,
  '3306' , // MySQL Port address,
  'UTF-8' , // Charset
);
```
# Simple MySQL query
sorgu(); function is used to run a query you want in MySQL,
Note : mysqli_query(); gives the same output as the function
```php
$query = $sql->sorgu('SELECT * FROM `users` WHERE `id` = 1');
var_dump($query);
```
# The suzgec() function
mysql_real_escape_string(); is the same as the function
```php
$data = " Düştü m’ola sevdiğimin yurduna ";
$data = $sql->suzgec($data);
var_dump($data);
```

# assoc() function
mysql_fetch_assoc(); is the same as the function
```php
$query = "SELECT * FROM `users` WHERE id = 1";
$data = $sql->assoc($query);
var_dump($data);
```
# while_assoc() function
Collects multiple data under a single array
```php
$query = "SELECT * FROM `blogs`";
$data = $sql->while_assoc($query);
 
for($i = 0;$i < count($data); $i++){
   echo $data[$i]["blog_id"];
   echo $data[$i]["blog_title"];
}
```
# ekle() function
Add new data to MySQL table
Suppose there is a table named 'users' in mysql database and it receives name,email and password
```sql
CREATE TABLE users(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255),
   email VARCHAR(255),
   passwod VARCHAR(255),
   PRIMARY KEY(id)
);
```
You know what this sql query is for, it will create a ball named users, then it will create columns that ask for id, name, email and password.
When we want to add data into them, the ekle() function is used.
We have to create a set of keys equivalent to the created sql columns, and we enter the value we want to add to the values
```php
$add_array = [
  "name" => "User name",
  "email" => "user@email.com",
  "password" => "user_password"
];
$add = $sql->ekle($add_array);
var_dump($add); // Output : (boolen)true or false
```
