USE doingsdone;

/* Добавляем в таблицу users трех пользователей данные взял из  файла userdata  */

INSERT INTO users SET email='ignat.v@gmail.com', first_name = 'Игнат', password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', date_reg = '2018-02-23T11:30:00';
INSERT INTO users SET email='kitty_93@li.ru', first_name = 'Леночка', password = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', date_reg = '2018-02-24T11:30:00';
INSERT INTO users SET email='warrior07@mail.ru', first_name = 'Руслан', password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', date_reg = '2018-02-25T11:30:00';

/* Добавляем в таблицу categories список всех категорий,  категории как буд-то созданы одним пользователем  */
INSERT INTO categories SET name = 'Входящие', user_id = 1;
INSERT INTO categories SET name = 'Учеба', user_id = 1;
INSERT INTO categories SET name = 'Работа', user_id = 1;
INSERT INTO categories SET name = 'Домашние дела', user_id = 1;
INSERT INTO categories SET name = 'Авто', user_id = 1;


/* Добавляем в таблицу tasks задачи, задачи созданиы одним пользователем  */

INSERT INTO tasks SET name = 'Собеседование в IT компании',date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 3,  deadline = '2018-06-01T11:30:00';

INSERT INTO tasks SET name = 'Выполнить тестовое задание',date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 3,  deadline = '2018-05-25T11:30:00';

INSERT INTO tasks SET name = 'Сделать задание первого раздела' ,date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 2,date_end = '2018-02-25T11:30:00',  deadline = '2018-04-21T11:30:00';

INSERT INTO tasks SET name = 'Встреча с другом' ,date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 1,  deadline = '2018-04-22T11:30:00';
INSERT INTO tasks SET name = 'Купить корм для кота' ,date_add = '2018-02-10T11:30:00', user_id = 1, category_id = 4,  deadline = '2018-02-26T11:30:00';
INSERT INTO tasks SET name = 'Заказать пиццу' , date_add = '2018-02-25T11:30:00', user_id = 1, category_id = 4 ;




/*получить список из всех проектов для одного пользователя */
SELECT * FROM categories WHERE user_id =1;

/*получить список из всех задач для одного проекта - получаю список задач для проекта работа */
SELECT * FROM tasks WHERE category_id =3;

/*пометить задачу как выполненную  */
UPDATE tasks SET date_end = '2018-02-21T13:30:00'  WHERE    name = 'Заказать пиццу' ;

/*пометить задачу как выполненную - возможен второй вариант, так как назвние задачи у нас не уникальное, то можно обратиться к id  */
UPDATE tasks SET date_end = '2018-02-21T13:30:00'  WHERE    id=13 ;

/*получить все задачи для завтрашнего дня */
SELECT * FROM tasks WHERE DATE(deadline) = DATE_ADD(CURDATE(), INTERVAL 1 DAY);

/*обновить название задачи по её идентификатору*/
UPDATE tasks SET name = "Важная встреча с другом "  WHERE    id=4 ;







