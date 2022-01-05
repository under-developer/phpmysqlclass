# Php MySQL Class
A class that automatically performs simple sql queries (PHP 7.X)

# MySQL Connection
Access to mysql is provided by the baglan(); function
The settings are as follows
```
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
#Simple MySQL query
sorgu(); function is used to run a query you want in MySQL,
Note : mysqli_query(); gives the same output as the function
```
$query = $sql->sorgu('SELECT * FROM `users` WHERE `id` = 1');
var_dump($query);
```
#The suzgec(); function
mysql_real_escape_string(); is the same as the function
```
$data = " Düştü m’ola sevdiğimin yurduna ";
$data = $sql->suzgec($data);
var_dump($data);
```

#assoc() function
mysql_fetch_assoc(); is the same as the function
```
$query = "SELECT * FROM `users` WHERE id = 1";
$data = $sql->assoc($query);
var_dump($data);
``

#while_assoc function()
Collects multiple data under a single array
```
$query = "SELECT * FROM `blogs`";
$data = $sql->while_assoc($query);
#var_dump($data);

for($i = 0;$i < count($data); $i++){
   echo $data[$i]["blog_id"];
   echo $data[$i]["blog_title"];
}

```
