# Задача 1 | Реализовать Адаптер

----------------------------------------------------------------
Здравствуйте! Я решил взять первую задачу. И хочу по возможности кратко расписать свое решение. Копия задания в директории проекта. 

0) 	Условна нулевая задача, так как класс sdbh, является сторонним классом по легенде, и я не имею права в нем менять логику, но я так понимаю я имею право пробросить в него свой массив с подключением к ДБ. Я создал свой класс Setting (он лежит в App\Presentation\Setting)  и передал метод global_setting_db() в sdbh.
1)	Мой реализованный адаптер лежит в папке App\Presentation\Adapter . Я его писал по принципу. Вызываю функцию из класса адаптера, а она уже работает с функцией из целевого класса. 
2)	Методы я применил, единственное, я переместил исполнительный файл calculate.php  в одну директорию с index.php . Для того, чтобы не ломать пространство имен , и классы адаптера и глобальных настроек подключения к  бд необходимые для работы calculate.php. Я хотел , что бы они находились на тех же местах , что и должно быть . Это позволит не плодить лишний код и структурировать приложение.
3)	Я прописал метод получения данных для сетки (tarif_setka_data()) таким образом. Используя PDO , я сделал SQL запрос по выводу всех данных у определенного id , далее просто проверил если столбец TARIFF существует беру данные из него и делаю unserialize , если нет, беру из PRICE и делаю return массива.
4)	Первый раз я отрисовываю таблицу, и через php, в цикле for, бегу по ключам массива полученных данных из предыдущего пункта. И если значение есть, отрисовываю строки таблицы.
5)	Если пользователь меняет «Тарелки» , делаю ajax на tariff.php . Тот обращается к моему адаптеру, и я получаю данные. Их я формирую в json, так как мне их надо будет обработать на уровне js. Далее я перекидываю результат в метод create_table_tarif().  Перевожу json в массив, удаляю старую сетку . Далее через for пробегаю через массив ключей массива json , и записываю в string нужное кол-во строк с ключами(кол-во дней) и стоимостью посещения. Далее эту строку вставляю уже в заготовленный метод который отрисует новую таблицу.


Пункты все выполнил и работу считаю законченной.

---

GiT logo by GitHub.Own work using: https://github.com/logos, 
license: [CC BY 3.0](https://creativecommons.org/licenses/by/3.0/deed.ru)