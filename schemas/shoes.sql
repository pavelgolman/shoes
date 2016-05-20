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
)engine = InnoDb DEFAULT CHARACTER SET=utf8;

update shoes set main_image_id = (select id from shoes_images where shoes_images.shoes_id = shoes.id limit 1) where main_image_id is null;

drop table if exists shoes_descriptions;
create table if not exists shoes_descriptions(
  id int unsigned not null auto_increment,
  shoes_id int unsigned default null,
  description TEXT DEFAULT null,
  PRIMARY  key(id)
)engine=InnoDb DEFAULT CHARACTER SET=utf8;



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
)engine=InnoDb DEFAULT CHARACTER SET=utf8;



drop table if exists promo_blocks;
create table if not exists promo_blocks(
  id int unsigned not null auto_increment,
  `const` varchar(255) not null,
  `name` varchar(255) not null,
  primary key(id),
  index `name`(`name`),
  index `const`(`const`)
)engine = InnoDb DEFAULT CHARACTER SET=utf8 COLLATE utf8_unicode_ci;



insert into promo_blocks(`name`, `const`) VALUES
('Распродажа', 'SALE_OFF'),
('Акции', 'FEATURED'),
('Лучший выбор', 'BESTSELLER'),
('Категория сандалии', 'CATEGORY_SANDALS'),
('Категория туфли', 'CATEGORY_SHOES'),
('Категория ботинки', 'CATEGORY_BOOTS'),
('Категория кроссовки, кеды', 'CATEGORY_SNEAKERS'),
('Категория сабо', 'CATEGORY_SABO'),
('Категория сапоги', 'CATEGORY_HIGH_BOOT'),
('ВЕСНА-ЛЕТО', 'SPRING_SUMMER'),
('ОСЕНЬ-ЗИМА', 'AUTUMN_WINTER')
;



drop table if exists promo_blocks_shoes;
create table if not exists promo_blocks_shoes(
  shoes_id int unsigned not null,
  promo_blocks_id int unsigned not null,
   key unq(shoes_id, promo_blocks_id)
)engine=InnoDb DEFAULT CHARACTER SET=utf8;


TRUNCATE TABLE promo_blocks_shoes;
INSERT INTO promo_blocks_shoes (promo_blocks_id, shoes_id) VALUES
((select id from promo_blocks where `const` = 'SALE_OFF'), 9),
((select id from promo_blocks where `const` = 'SALE_OFF'), 11),
((select id from promo_blocks where `const` = 'SALE_OFF'), 13),
((select id from promo_blocks where `const` = 'SALE_OFF'), 14),
((select id from promo_blocks where `const` = 'SALE_OFF'), 15),
((select id from promo_blocks where `const` = 'SALE_OFF'), 16),
((select id from promo_blocks where `const` = 'SALE_OFF'), 17),
((select id from promo_blocks where `const` = 'SALE_OFF'), 18),
((select id from promo_blocks where `const` = 'SALE_OFF'), 19),



((select id from promo_blocks where `const` = 'FEATURED'), 27),
((select id from promo_blocks where `const` = 'FEATURED'), 25),
((select id from promo_blocks where `const` = 'FEATURED'), 24),
((select id from promo_blocks where `const` = 'FEATURED'), 20),
((select id from promo_blocks where `const` = 'FEATURED'), 19),
((select id from promo_blocks where `const` = 'FEATURED'), 21),

((select id from promo_blocks where `const` = 'BESTSELLER'), 31),
((select id from promo_blocks where `const` = 'BESTSELLER'), 30),
((select id from promo_blocks where `const` = 'BESTSELLER'), 29),
((select id from promo_blocks where `const` = 'BESTSELLER'), 28),
((select id from promo_blocks where `const` = 'BESTSELLER'), 27),
((select id from promo_blocks where `const` = 'BESTSELLER'), 26),
((select id from promo_blocks where `const` = 'BESTSELLER'), 25),



((select id from promo_blocks where `const` = 'SPRING_SUMMER'), 27),
((select id from promo_blocks where `const` = 'SPRING_SUMMER'), 26),
((select id from promo_blocks where `const` = 'SPRING_SUMMER'), 19),
((select id from promo_blocks where `const` = 'SPRING_SUMMER'), 18),

((select id from promo_blocks where `const` = 'AUTUMN_WINTER'), 28),
((select id from promo_blocks where `const` = 'AUTUMN_WINTER'), 29),
((select id from promo_blocks where `const` = 'AUTUMN_WINTER'), 12),



((select id from promo_blocks where `const` = 'CATEGORY_SANDALS'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SANDALS'), 13),
((select id from promo_blocks where `const` = 'CATEGORY_SANDALS'), 15),
((select id from promo_blocks where `const` = 'CATEGORY_SANDALS'), 20),
((select id from promo_blocks where `const` = 'CATEGORY_SANDALS'), 27),


((select id from promo_blocks where `const` = 'CATEGORY_SHOES'), 28),
((select id from promo_blocks where `const` = 'CATEGORY_SHOES'), 29),
((select id from promo_blocks where `const` = 'CATEGORY_SHOES'), 28),
((select id from promo_blocks where `const` = 'CATEGORY_SHOES'), 29),
((select id from promo_blocks where `const` = 'CATEGORY_SHOES'), 28),


((select id from promo_blocks where `const` = 'CATEGORY_BOOTS'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_BOOTS'), 28),
((select id from promo_blocks where `const` = 'CATEGORY_BOOTS'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_BOOTS'), 28),
((select id from promo_blocks where `const` = 'CATEGORY_BOOTS'), 12),


((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),
((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),
((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),
((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),
((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),
((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),
((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),
((select id from promo_blocks where `const` = 'CATEGORY_SNEAKERS'), 11),


((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),
((select id from promo_blocks where `const` = 'CATEGORY_SABO'), 10),


((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12),
((select id from promo_blocks where `const` = 'CATEGORY_HIGH_BOOT'), 12)

;





drop table if exists attributes_groups;
create table if not exists attributes_groups(
  id int unsigned not null auto_increment,
  `name` varchar(255) not null,
  `const` varchar(255) not null,
  primary key(id),
  index `const`(`const`),
  index `name`(`name`)
)engine = InnoDb DEFAULT CHARACTER SET=utf8 COLLATE utf8_unicode_ci;


insert into attributes_groups(`name`, `const`) VALUES
('Материал', 'MATERIAL'),
('Сезон', 'SEASON'),
('Коллекция', 'COLLECTION'),
('Размер', 'SIZE'),
('Подошва', 'BASE'),
('Тип', 'TYPE')
;



drop table if exists attributes;
create table if not exists attributes(
  id int unsigned not null auto_increment,
  attributes_group_id int unsigned not null,
  `name` varchar(255) not null,
  primary key(id),
  index `name`(`name`)
)engine = InnoDb DEFAULT CHARACTER SET=utf8 COLLATE utf8_unicode_ci;



insert into attributes(`name`, attributes_group_id) VALUES
('Натуральная кожа', (select id from attributes_groups where `const` = 'MATERIAL')),
('Лакированная кожа', (select id from attributes_groups where `const` = 'MATERIAL')),
('Натуральная замша', (select id from attributes_groups where `const` = 'MATERIAL')),
('Натуральная цегейка', (select id from attributes_groups where `const` = 'MATERIAL')),
('Лето', (select id from attributes_groups where `const` = 'SEASON')),
('Зима', (select id from attributes_groups where `const` = 'SEASON')),
('Демисезон', (select id from attributes_groups where `const` = 'SEASON')),
('Весна-Лето', (select id from attributes_groups where `const` = 'COLLECTION')),
('Осень-Зима', (select id from attributes_groups where `const` = 'COLLECTION')),
('37', (select id from attributes_groups where `const` = 'SIZE')),
('37.5', (select id from attributes_groups where `const` = 'SIZE')),
('38', (select id from attributes_groups where `const` = 'SIZE')),
('39', (select id from attributes_groups where `const` = 'SIZE')),
('40', (select id from attributes_groups where `const` = 'SIZE')),
('41', (select id from attributes_groups where `const` = 'SIZE')),
('42', (select id from attributes_groups where `const` = 'SIZE')),
('Каблук', (select id from attributes_groups where `const` = 'BASE')),
('Без каблука', (select id from attributes_groups where `const` = 'BASE')),
('Платформа', (select id from attributes_groups where `const` = 'BASE')),
('Танкетка', (select id from attributes_groups where `const` = 'BASE')),
('Плоская', (select id from attributes_groups where `const` = 'BASE')),
('Удобная', (select id from attributes_groups where `const` = 'BASE')),
('Босоножки', (select id from attributes_groups where `const` = 'TYPE')),
('Туфли', (select id from attributes_groups where `const` = 'TYPE')),
('Сандалии', (select id from attributes_groups where `const` = 'TYPE')),
('Сабо', (select id from attributes_groups where `const` = 'TYPE')),
('Сапоги', (select id from attributes_groups where `const` = 'TYPE')),
('Кеды', (select id from attributes_groups where `const` = 'TYPE')),
('Угги', (select id from attributes_groups where `const` = 'TYPE')),
('Ботинки', (select id from attributes_groups where `const` = 'TYPE'))
;



drop table if exists attributes_shoes;
create table if not exists attributes_shoes(
  id int unsigned not null auto_increment,
  shoes_id int unsigned not null,
  attributes_id int unsigned not null,
  primary key(id),
   key unq(shoes_id, attributes_id)
)engine=InnoDb DEFAULT CHARACTER SET=utf8;









