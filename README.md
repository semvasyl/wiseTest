### wiseTest
* таск менеджер із можливістю створювати декілька списків задач
* інформація про списки за їх задачі зберігається в базі даних Mysql
* одинарний клік по задачі змінює її стан на *виконано*
* подвійний клік по задачі змінює її стан на *не виконано*


##### Початок роботи
необхідно створити дві таблиці у базі даних
```sql
CREATE TABLE todo_list
(
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    position int,
    create_at datetime,
    modified_at datetime
);
CREATE UNIQUE INDEX todo_list_id_uindex ON todo_list (id);


CREATE TABLE todo_items
(
    id int PRIMARY KEY AUTO_INCREMENT,
    listID int,
    name varchar(255),
    isdone boolean,
    position int,
    create_at datetime,
    modified_at datetime
);
CREATE UNIQUE INDEX todo_items_id_uindex ON todo_items (id);
```
* дамп прикладу даних у БД знаходиться у `sample_dump.sql`
* після у файлі `configs.php` вказати дані для доступу у базу даних
* тексти кирилицею на даний момент не підтримуються.