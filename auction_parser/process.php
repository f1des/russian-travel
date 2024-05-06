<?php
  define('INCLUDE_CONFIG', true);
  require_once 'config.php';
  require_once 'AuctionData.php';
  include './simplehtmldom_2_0-RC2/simple_html_dom.php';  

  function curlGetPage($url, $referer = 'https://google.com') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 YaBrowser/24.4.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

  $auctionData = new AuctionData(); 

  //Получение данных из формы
  $trade_number = filter_var($_POST['trade_number'], FILTER_SANITIZE_STRING);
  $lot_number = filter_var($_POST['lot_number'], FILTER_SANITIZE_STRING);

  //Формирование URL с параметрами запроса
  $search_url = "https://nistp.ru/?lot_description=&trade_number=$trade_number&lot_number=$lot_number";

  $page = curlGetPage($search_url);
  $html_content = str_get_html($page);

  // Получение результатов поиска
  $search_results = $html_content->find('.data');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($page) {
        if ($search_results) {
          // Поиск ячейки внутри тела таблицы. Используем индекс 1 для доступа к первому элементу массива
          $cell = $search_results[0]->find('tbody tr td span', 2);          

          if ($cell && strpos($cell->plaintext, "Лот № $lot_number") !== false) {
            //Если лот найден - загрузить страницу лота по найденной ссылке 
            $link = $html_content->find('.data tbody tr td a', 0)->href; // URL адрес     

            $tradePage = curlGetPage($link);        

            $htmlContentLot = str_get_html($tradePage);

            // сохраняем оставшиеся поля
            $searchLot = $htmlContentLot->find("#table_lot_$lot_number");
            $searchNodeViews = $htmlContentLot->find('.node_view');

            $auctionData = new AuctionData();                 

            if (!empty($searchLot)) {
              $description = $searchLot[0]->find('.label', 2)->next_sibling()->plaintext; // Cведения об имуществе ( описание лота, что продается )

              foreach ($searchLot as $searchLot) {
                $headerLot = $searchLot->find('.alw', 0);   

                if ($headerLot) {
                  $labelElements = $searchLot->find('.label');
              
                  // Перебираем найденные элементы
                  foreach ($labelElements as $labelElement) {
                      if ($labelElement->plaintext === 'Начальная цена') {
                          // Если да, то ищем следующий за этим элементом
                          $nextSibling = $labelElement->next_sibling();
                          if ($nextSibling) {
                              // Присваиваем значение следующего за текущим элементом переменной $initialLotPrice
                              $initialLotPrice = $nextSibling->plaintext;
                          }
                      }                      
                  }
                }
            
                // Если initialLotPrice найдены, выходим из внешнего цикла
                if (!empty($initialLotPrice)) {
                    break;
                }
              }
            }
            
            if (!empty($searchNodeViews)) {
              $contactPersonEmail = $searchNodeViews[4]->find('.label', 2)->next_sibling()->plaintext;
              $contactPersonPhone = $searchNodeViews[4]->find('.label', 1)->next_sibling()->plaintext;
              $auctionStartDate = $searchNodeViews[1]->find('.label', 1)->next_sibling()->plaintext; // Здесь не совсем поняд какое значение нужно брать, за искомое взял Дата начала представления заявок на участие

              $debtorINN = '';
              $bankruptcyCaseNumber = '';

              // Перебираем найденные блоки
              foreach ($searchNodeViews as $searchNodeView) {
                // Ищем заголовок внутри текущего блока
                $header = $searchNodeView->find('th', 0); // Предполагаем, что первый th содержит заголовок блока                             

                if ($header && $header->plaintext === 'Информация о должнике') {
                  $labelElements = $searchNodeView->find('.label'); 
              
                  // Перебираем найденные элементы
                  foreach ($labelElements as $labelElement) {
                      if ($labelElement->plaintext === 'ИНН') {
                          // Если да, то ищем следующий за этим элементом
                          $nextSibling = $labelElement->next_sibling();
                          if ($nextSibling) {
                              // Присваиваем значение следующего за текущим элементом переменной $debtorINN
                              $debtorINN = $nextSibling->plaintext;
                          }
                      }
              
                      else if ($labelElement->plaintext === 'Номер дела о банкротстве') {
                          $nextSibling = $labelElement->next_sibling();
                          if ($nextSibling) {
                              $bankruptcyCaseNumber = $nextSibling->plaintext;
                          }
                      }                        
                  }
              
                  // Если ИНН и Номер дела о банкротстве найдены, выходим из внешнего цикла
                  if (!empty($debtorINN) &&!empty($bankruptcyCaseNumber)) {
                      break;
                  }
                }                
              }     
            }           

            $auctionData->contactPersonEmail = $contactPersonEmail;
            $auctionData->contactPersonPhone = $contactPersonPhone;
            $auctionData->debtorINN = $debtorINN;
            $auctionData->bankruptcyCaseNumber = $bankruptcyCaseNumber;
            $auctionData->auctionStartDate = $auctionStartDate;
            $auctionData->initialLotPrice = $initialLotPrice;
            $auctionData->description = $description;

            //Подключение к базе данных
            $db = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['name']);

            // Проверка подключения
            if ($db->connect_error) {
              die("Ошибка подключения: ". $db->connect_error);
            }

            // Подготовка SQL запроса для вставки данных и проверка на дубликаты
            $sql = "INSERT INTO auctions (trade_number, lot_number, url, description, initial_lot_price, contact_email, contact_phone, debtor_inn, bankruptcy_case_number, auction_start_date) VALUES (?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE url = VALUES(url), description = VALUES(description), initial_lot_price = VALUES(initial_lot_price), contact_email = VALUES(contact_email), contact_phone = VALUES(contact_phone), debtor_inn = VALUES(debtor_inn), bankruptcy_case_number = VALUES(bankruptcy_case_number), auction_start_date = VALUES(auction_start_date)";

            // Подготовка запроса
            $stmt = $db->prepare($sql);

            // Привязка параметров
            $stmt->bind_param("ssssssssss", $trade_number, $lot_number, $link, $auctionData->description, $auctionData->initialLotPrice, $auctionData->contactPersonEmail, $auctionData->contactPersonPhone, $auctionData->debtorINN, $auctionData->bankruptcyCaseNumber, $auctionData->auctionStartDate);

            if ($stmt->execute()) {
              // Логирование успешной вставки
              error_log("Успешная вставка данных: trade_number=$trade_number, lot_number=$lot_number");
          } else {
              // Логирование ошибки
              error_log("Ошибка при добавлении данных: ". $stmt->error);
          }

            // Выполнение запроса
            if ($stmt->execute()) {
                echo '<script>
                alert("Лот успешно добавлен в базу данных. (При условии, если указанный лот уже записан - запись обновляется)");
                window.location.href = "index.php";
               </script>';
            } else {
                echo "Ошибка при добавлении лота в базу данных: ". $stmt->error;
            }

            // Закрытие подготовленного запроса
            $stmt->close();

            // Закрытие соединения с базой данных
            $db->close();

          } else {       
            echo '<script>
              alert("Лот не найден. Попробуйте ещё раз.");
              window.location.href = "index.php";
             </script>';            
          }
        } else {
          echo "<br>Таблица с результатами не найдена.";
        }
    } else {
        echo "<br>Ошибка при получении страницы.";
    }
  } else {
    echo "<br>Для обработки данных формы используйте метод POST.";
  }
?>
