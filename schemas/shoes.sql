create table if not exists shoes(
  id int unsigned not null auto_increment,
  `name` varchar(255) not null,
  price int unsigned not null,
  article  varchar(255) not null,
  primary key(id),
  index name(name),
  index article(article)
)engine = InnoDb;

create table if not exists categories(
  id int unsigned not null auto_increment,
  `name` varchar(255) not null,
  url  varchar(255) default null,
  parent_id int unsigned not null default 0,
  order_number int unsigned not null default 0,
  primary key(id),
  index `name`(`name`),
  index url(url),
  index parent_id(parent_id),
  index order_number(order_number)
)engine = InnoDb;


truncate table categories;
insert into categories (id, parent_id, `name`, order_number) values

(1, 0, 'Сезон', 1),
(2, 0, 'Пол', 2),
(2, 0, 'Тип', 2),
(2, 0, 'Материал', 2),
(2, 0, 'Цвет', 2),
(2, 0, 'Размер', 2),
(2, 0, 'Коллекция', 2),
(2, 0, 'Стиль', 2),
(2, 0, 'Тип Каблука', 2),




(2, 1, 'Демисезонные', 1),
(3, 1, 'Лето', 2),
(4, 1, 'Зима', 3),


;

create table if not exists shoes_categories(
  shoes_id int unsigned not null,
  category_id int unsigned not null,
  unique key unq(shoes_id, category_id)
)type=InnoDb;

create table if not exists attributes(
  id int unsigned not null auto_increment,
  name varchar(255) not null,
  primary key(id),
  index name(name)
);


truncate table attributes;
insert into attributes (id, name) values

(1, 'Высота Каблука'),

;

create table if not exists shoes_attributes(
  shoes_id int unsigned not null,
  attribute_id int unsigned not null,
  unique key unq(shoes_id, attribute_id)
)type=InnoDb;

