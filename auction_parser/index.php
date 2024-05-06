<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">        
    <link href="./css/normalize.css" rel="stylesheet"/>
    <link href="./css/index.css" rel="stylesheet"/>
    <title>Поиск лота</title>
  </head>
  <body>
    <div class="page">      
      <div class="main">
        <div class="area">
          <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>

        <form class="bidding__inputs" action="process.php" method="post" name="">
          <label for="trade_number">Номер торгов:</label>          
            <input type="text" id="trade_number" name="trade_number" value="42242-ОТПП" required>
          <label for="lot_number">Номер лота:</label>            
            <input type="number" id="lot_number" name="lot_number" min="1" max="9999" value="1" required>
          
          <button type="submit">Найти</button>
        </form>
      </div>
    </div>        
  </body>
</html>

<?php
  define('INCLUDE_CONFIG', true);
  require_once 'config.php';

  // Подключение к базе данных
  $db = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['name']);

  // Проверка подключения
  if ($db->connect_error) {
      die("Ошибка подключения: ". $db->connect_error);
  }

  // Выполнение запроса для получения всех лотов
  $result = $db->query("SELECT * FROM auctions");

  // Вывод таблицы с лотами
  echo "<table>";
  // Для удобства ещё вывел номер торгов и номер лота
  echo "<tr><th>Номер торгов</th><th>Номер лота</th><th>URL адрес</th><th>Cведения об имуществе (предприятии) должника, выставляемом на торги, его составе...</th><th>Начальная цена</th><th>E-mail</th><th>Телефон</th><th>ИНН</th><th>Номер дела о банкротстве</th><th>Дата торгов</th></tr>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>". $row['trade_number']. "</td>";
    echo "<td>". $row['lot_number']. "</td>";
    echo "<td><a href='". $row['url']. "'>". $row['url']. "</a></td>";
    echo "<td>". $row['description']. "</td>";
    echo "<td>". $row['initial_lot_price']. "</td>";
    echo "<td>". $row['contact_email']. "</td>";
    echo "<td>". $row['contact_phone']. "</td>";
    echo "<td>". $row['debtor_inn']. "</td>";
    echo "<td>". $row['bankruptcy_case_number']. "</td>";
    echo "<td>". $row['auction_start_date']. "</td>";
    echo "</tr>";
  }
  echo "</table>";

  // Закрытие соединения с базой данных
  $db->close();
?>