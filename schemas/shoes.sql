drop table if exists shoes;
create table if not exists shoes(
  id int unsigned not null auto_increment,
  `name` varchar(255) not null,
  price int unsigned not null,
  main_image_id int unsigned default null,
  article  varchar(255) not null,
  primary key(id),
  index `name`(`name`),
  index main_image_id(main_image_id),
  index article(article)
)engine = InnoDb;


drop table if exists categories;
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
(3, 0, 'Тип', 2),
(4, 0, 'Материал', 2),
(5, 0, 'Цвет', 2),
(6, 0, 'Размер', 2),
(7, 0, 'Коллекция', 2),
(8, 0, 'Стиль', 2),
(9, 0, 'Тип Каблука', 2),



(101, 1, 'Демисезонные', 1),
(102, 1, 'Лето', 2),
(103, 1, 'Зима', 3),

(301, 3, 'Сапоги', 1),
(302, 3, 'Ботильоны', 2),
(303, 3, 'Ботинки', 3),
(304, 3, 'Кроссовки и кеды', 4),
(305, 3, 'Дутики и луноходы', 5),
(306, 3, 'Угги и унты', 6),
(307, 3, 'Мокасины и еспадрильи', 7),
(308, 3, 'Балетки', 8),
(309, 3, 'Резиновая обувь', 9),
(310, 3, 'Валенки', 10),
(311, 3, 'Босоножки', 11),
(312, 3, 'Сандалии', 12),
(313, 3, 'Сабо', 13),
(314, 3, 'Шлепанцы', 14),
(315, 3, 'Домашняя', 15)

;

drop table if exists shoes_categories;
create table if not exists shoes_categories(
  shoes_id int unsigned not null,
  category_id int unsigned not null,
  unique key unq(shoes_id, category_id)
)engine=InnoDb;

drop table if exists attributes;
create table if not exists attributes(
  id int unsigned not null auto_increment,
  `name` varchar(255) not null,
  primary key(id),
  index `name`(`name`)
)engine=InnoDb;;


truncate table attributes;
insert into attributes (id, `name`) values

(1, 'Высота Каблука')

;

drop table if exists shoes_attributes;
create table if not exists shoes_attributes(
  shoes_id int unsigned not null,
  attribute_id int unsigned not null,
  unique key unq(shoes_id, attribute_id)
)engine=InnoDb;


drop table if exists shoes_images;
create table if not exists shoes_images(
  id int unsigned not null auto_increment,
  shoes_id int unsigned default null,
  storage_id varchar(8) not null,
  extension varchar(255) not null,
  upload_date_year int unsigned not null,
  upload_date_month int unsigned not null,
  upload_date_day int unsigned not null,
  PRIMARY  key(id),
  unique key storage_id(storage_id)
)engine=InnoDb;





drop table if exists promo_blocks;
create table if not exists promo_blocks(
  id int unsigned not null auto_increment,
  `const` varchar(255) not null,
  `name` varchar(255) not null,
  primary key(id),
  index `name`(`name`),
  index `const`(`const`)
)engine = InnoDb;


insert into promo_blocks(`name`, `const`) VALUES
('', 'SALE_OFF'),
('', 'FEATURED'),
('', 'BESTSELLER'),
('', 'CATEGORY_SANDALS'),
('', 'CATEGORY_SHOES'),
('', 'CATEGORY_BOOTS'),
('', 'CATEGORY_SNEAKERS'),
('', 'CATEGORY_SABO'),
('', 'CATEGORY_HIGH_BOOT')
;



drop table if exists promo_blocks_shoes;
create table if not exists promo_blocks_shoes(
  shoes_id int unsigned not null,
  promo_blocks_id int unsigned not null,
   key unq(shoes_id, promo_blocks_id)
)engine=InnoDb;



INSERT INTO promo_blocks_shoes (promo_blocks_id, shoes_id) VALUES
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10),
((select id from promo_blocks where `const` = 'SALE_OFF'), 10)
;













