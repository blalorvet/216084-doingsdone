USE doingsdone;

/* ��������� � ������� users ���� ������������� ������ ���� ��  ����� userdata.php  */

INSERT INTO users SET email='ignat.v@gmail.com', first_name = '�����', password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', date_reg = '2018-02-23T11:30:00';
INSERT INTO users SET email='kitty_93@li.ru', first_name = '�������', password = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', date_reg = '2018-02-24T11:30:00';
INSERT INTO users SET email='warrior07@mail.ru', first_name = '������', password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', date_reg = '2018-02-25T11:30:00';

/* ��������� � ������� categories ������ ���� ���������,  ��������� ������� ����� �������������  */
INSERT INTO categories SET name = '��������', user_id = 1;
INSERT INTO categories SET name = '�����', user_id = 1;
INSERT INTO categories SET name = '������', user_id = 1;
INSERT INTO categories SET name = '�������� ����', user_id = 1;
INSERT INTO categories SET name = '����', user_id = 1;


/* ��������� � ������� tasks ������, ������ �������� ����� �������������  */

INSERT INTO tasks SET name = '������������� � IT ��������',date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 3,  deadline = '2018-06-01T11:30:00';

INSERT INTO tasks SET name = '��������� �������� �������',date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 3,  deadline = '2018-05-25T11:30:00';

INSERT INTO tasks SET name = '������� ������� ������� �������' ,date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 2,date_end = '2018-02-25T11:30:00',  deadline = '2018-04-21T11:30:00';

INSERT INTO tasks SET name = '������� � ������' ,date_add = '2018-02-23T11:30:00', user_id = 1, category_id = 1,  deadline = '2018-04-22T11:30:00';
INSERT INTO tasks SET name = '������ ���� ��� ����' ,date_add = '2018-02-10T11:30:00', user_id = 1, category_id = 4,  deadline = '2018-02-26T11:30:00';
INSERT INTO tasks SET name = '�������� �����' , date_add = '2018-02-25T11:30:00', user_id = 1, category_id = 4 ;




/*�������� ������ �� ���� �������� ��� ������ ������������ */
SELECT * FROM categories WHERE user_id =1;

/*�������� ������ �� ���� ����� ��� ������ ������� - ������� ������ ����� ��� ������� ������ */
SELECT * FROM tasks WHERE category_id =3;

/*�������� ������ ��� �����������  */
UPDATE tasks SET date_end = '2018-02-21T13:30:00'  WHERE    name = '�������� �����' ;

/*�������� ������ ��� ����������� - �������� ������ �������, ��� ��� ������� ������ � ��� �� ����������, �� ����� ���������� � id  */
UPDATE tasks SET date_end = '2018-02-21T13:30:00'  WHERE    id=13 ;

/*�������� ��� ������ ��� ����������� ��� */
SELECT * FROM tasks WHERE DATE(deadline) = DATE_ADD(CURDATE(), INTERVAL 1 DAY);

/*�������� �������� ������ �� � ��������������*/
UPDATE tasks SET name = "������ ������� � ������ "  WHERE    id=4 ;







