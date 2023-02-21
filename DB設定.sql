SET time_zone = 'Asia/Tokyo';
-- 顧客テーブル 
CREATE TABLE customers (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  family_name varchar(20) NOT NULL,
  first_name varchar(20) NOT NULL,
  family_name_kana VARCHAR(20) NOT NULL,
  first_name_kana VARCHAR(20) NOT NULL,
  sex VARCHAR(3) NOT NULL,
  birth VARCHAR(10),
  zip VARCHAR(10) NOT NULL,
  address VARCHAR(100) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  tel VARCHAR(20) NOT NULL,
  password varchar(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  delet_flag TINYINT UNSIGNED NOT NULL DEFAULT 0
) CHARACTER SET utf8mb4;
-- 顧客データを格納
INSERT INTO customers (
    family_name,
    first_name,
    family_name_kana,
    first_name_kana,
    sex,
    birth,
    zip,
    address,
    email,
    tel,
    password
  )
VALUES(
    '黒岩',
    '知宏',
    'クロイワ',
    'トモヒロ',
    '0',
    '1990',
    '06',
    '30',
    '231',
    '0066',
    '神奈川県横浜市中区日ノ出町1-21英和ベルコート403',
    'blaclock@gmail.com',
    '080',
    '3352',
    '9610',
    'testpass'
  );
-- 管理者テーブル
CREATE TABLE admins (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  family_name varchar(20) NOT NULL,
  first_name varchar(20) NOT NULL,
  family_name_kana VARCHAR(20) NOT NULL,
  first_name_kana VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  password varchar(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  delet_flag TINYINT UNSIGNED NOT NULL DEFAULT 0
) CHARACTER SET utf8mb4;
-- 管理者データ挿入
INSERT INTO admins (
    family_name,
    first_name,
    family_name_kana,
    first_name_kana,
    email,
    password
  )
VALUES (
    '黒岩',
    '知宏',
    'クロイワ',
    'トモヒロ',
    'blaclock@gmail.com',
    'testpass'
  );
-- カート(取引) 
CREATE TABLE carts (
  id int unsigned NOT NULL auto_increment,
  customer_id int NOT NULL,
  product_id int unsigned NOT NULL,
  num tinyint(1) unsigned NOT NULL default 1,
  delete_flg tinyint(1) unsigned NOT NULL default 0,
  PRIMARY KEY (id),
  FOREIGN KEY cus_tbl(customer_id) REFERENCES customers(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY pro_tbl(product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE,
  index crt_idx(customer_id, delete_flg)
);
-- カート(取引)挿入
INSERT INTO carts (customer_id, product_id, num)
VALUES(1, 12, 2);
INSERT INTO carts (customer_id, product_id, num)
VALUES(1, 8, 7);
-- カテゴリー 
CREATE TABLE categories (
  id tinyint unsigned NOT NULL auto_increment,
  name varchar(100) NOT NULL,
  primary key(id)
);
-- カテゴリーの登録
INSERT INTO categories
VALUES (1, '野菜');
INSERT INTO categories
VALUES (2, '果物');
INSERT INTO categories
VALUES (3, '飲料');
-- 商品テーブル 
CREATE TABLE products (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  detail text NOT NULL,
  price DECIMAL(10, 3) unsigned NOT NULL,
  -- デシマル :decimal(最大桁数 、 小数点以下の桁数) 
  image varchar(50) NOT NULL,
  category_id tinyint unsigned NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  delet_flag TINYINT UNSIGNED NOT NULL DEFAULT 0,
  -- インデックス ： データの検索速度を向上させるために 、 どの行がどこにあるかを示した索引のこと
  INDEX PRODUCTS_IDX(category_id)
) CHARACTER SET utf8mb4;
-- 商品の登録
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES(
    1,
    'たまねぎ',
    '染色体数は2n=16。生育適温は20℃前後で、寒さには強く氷点下でも凍害はほとんど見られないが、25℃以上の高温では生育障害が起こる。',
    100,
    'tamanegi.jpg',
    1
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    2,
    'にんじん',
    '細長い東洋系品種と、太く短い西洋系品種の2種類に大別され、ともに古くから薬や食用としての栽培が行われてきた。',
    150,
    'ninjin.jpg',
    1
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    3,
    'ピーマン',
    'ピーマン自体はトウガラシの品種の一つであり、果実は肉厚でカプサイシンを含まない。',
    50,
    'pi-man.jpg',
    1
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    4,
    'なす',
    '世界の各地で独自の品種が育てられている。加賀茄子などの一部例外もあるが日本においては南方ほど長実または大長実で、北方ほど小実品種となる。',
    120,
    'nasu.jpg',
    1
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    5,
    'みかん',
    '日本の代表的な果物で、バナナのように、素手で容易に果皮をむいて食べることができるため、冬になれば炬燵の上にミカンという光景が一般家庭に多く見られる。',
    30,
    'mikan.jpg',
    2
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    6,
    'りんご',
    '現在日本で栽培されているものは、明治時代以降に導入されたもの。病害抵抗性、食味、収量などの点から品種改良が加えられる。',
    100,
    'ringo.jpg',
    2
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    7,
    'ぶどう',
    '葉は両側に切れ込みのある15 - 20cmほどの大きさで、穂状の花をつける。',
    130,
    'budou.jpg',
    2
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    8,
    'いちご',
    'イチゴとして流通しているものは、ほぼ全てオランダイチゴである。',
    250,
    'ichigo.jpg',
    2
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    9,
    'コーラ',
    '複数あるコーラ飲料製造社ではこれらの香味料以外にその会社独自の香味料を加えることで独自の製品として開発している。',
    120,
    'cola.jpg',
    3
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    10,
    'カルピス',
    '企業としてのカルピスの創業者は、僧侶出身の三島海雲。創業初期は国分グループだった。',
    120,
    'karupisu.jpg',
    3
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    11,
    'ウーロン茶',
    '烏龍茶（ウーロンちゃ）は、中国茶のうち青茶（せいちゃ、あおちゃ）と分類され、茶葉を発酵途中で加熱して発酵を止め、半発酵させた茶である。',
    110,
    'u-rontya.jpg',
    3
  );
INSERT INTO products (
    id,
    name,
    detail,
    price,
    image,
    category_id
  )
VALUES (
    12,
    'ミネラルウォーター',
    'ミネラルウォーター（Mineral water）とは、容器入り飲料水のうち、地下水を原水とするものを言う。',
    100,
    'water.jpg',
    3
  );
-- レビューテーブル
CREATE TABLE reviews (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  customer_id INT NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  title varchar(100) NOT NULL,
  content text NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  FOREIGN KEY cus_tbl(customer_id) REFERENCES customers(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY pro_tbl(product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE
) CHARACTER SET utf8mb4;
-- レビュー追加
INSERT INTO reviews (
    customer_id,
    product_id,
    title,
    content
  )
VALUES (1, 1, '良い商品でした', 'また購入したいです');
INSERT INTO reviews (
    customer_id,
    product_id,
    title,
    content
  )
VALUES (2, 1, 'まぁ良い商品でした', '機会があればまた購入したいです');
-- お気に入りテーブル
CREATE TABLE product_favorites (
  customer_id INT NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (customer_id, product_id),
  FOREIGN KEY cus_tbl(customer_id) REFERENCES customers(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY pro_tbl(product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE
) CHARACTER SET utf8mb4;
-- お気に入り登録
INSERT INTO product_favorites (customer_id, product_id)
VALUES (11, 1);
-- 注文テーブル
CREATE TABLE orders (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  delete_flg TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY cus_tbl(customer_id) REFERENCES customers(id) ON DELETE NO ACTION ON UPDATE NO ACTION
) CHARACTER SET utf8mb4;
-- 注文挿入
INSERT INTO orders (customer_id)
VALUES (1);
-- 注文明細テーブル
CREATE TABLE order_details (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  quantity INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY order_tbl(order_id) REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY pro_tbl(product_id) REFERENCES products(id) ON DELETE NO ACTION ON UPDATE NO ACTION
) CHARACTER SET utf8mb4;
-- 注文挿入
INSERT INTO order_details (order_id, product_id, quantity)
VALUES (1, 26, 2);
INSERT INTO order_details (order_id, product_id, quantity)
VALUES (1, 11, 5);
-- お問い合わせテーブル
CREATE TABLE contacts (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id INT NOT NULL,
  admin_id INT NOT NULL,
  sender varchar(20) NOT NULL,
  message text NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  deleted_at TIMESTAMP,
  delete_flg TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY cus_tbl(customer_id) REFERENCES customers(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY adm_tbl(admin_id) REFERENCES admins(id) ON DELETE CASCADE ON UPDATE CASCADE
) CHARACTER SET utf8mb4;
-- メッセージ挿入
INSERT INTO contacts (customer_id, admin_id, sender, message)
VALUES (1, 1, 'customer', 'テストです');
INSERT INTO contacts (customer_id, admin_id, sender, message)
VALUES (2, 1, 'customer', '2人目です');
INSERT INTO contacts (customer_id, admin_id, sender, message)
VALUES (2, 1, 'admin', 'テスト2人目の返信です');
INSERT INTO contacts (customer_id, admin_id, sender, message)
VALUES (1, 1, 'customer', 'テスト２通目です');
INSERT INTO contacts (customer_id, admin_id, sender, message)
VALUES (1, 1, 'admin', 'テスト２通目の返信です');
-- CSVインポート
LOAD DATA INFILE '/tmp/products2.csv' INTO TABLE products FIELDS TERMINATED BY ',' LINES TERMINATED BY "\r\n" IGNORE 1 LINES (@1, @2, @3, @4, @5)
SET name = @1,
  detail = @2,
  price = @3,
  image = @4,
  category_id = @5;
-- CSVエクスポート
select *
from products into outfile '/tmp/products_export.csv' fields terminated by ',' enclosed by '"' escaped by '"' lines terminated by '\r\n';
-- GRANT
grant all on test_database.* to test_user identified by 'pass' with
grant option;
-- test_database
SELECT t1.id,
  t1.name,
  t1.image,
  t1.price,
  t1.category_id,
  t1.category,
  t1.score,
  t1.reviews,
  count(pf.product_id) as likes
FROM (
    SELECT p.id,
      p.name,
      p.image,
      p.price,
      p.category_id,
      c.name as category,
      avg(r.score) as score,
      count(r.product_id) as reviews
    FROM products as p
      INNER JOIN categories as c ON p.category_id = c.id
      LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
    group by p.id
  ) AS t1
  left outer join product_favorites as pf on t1.id = pf.product_id
group by t1.id;
-- 検索SQL
select t1.id,
  t1.name,
  t1.image,
  t1.price,
  t1.category_id,
  t1.category,
  t1.created_at,
  t1.updated_at,
  t1.score,
  t1.reviews,
  count(pf.product_id) as likes
from (
    SELECT p.id,
      p.name,
      p.image,
      p.price,
      p.detail,
      p.category_id,
      p.created_at,
      p.updated_at,
      c.name as category,
      avg(r.score) as score,
      count(r.product_id) as reviews
    FROM products as p
      INNER JOIN categories as c ON p.category_id = c.id
      LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
    group by p.id
  ) AS t1
  left outer join product_favorites as pf on t1.id = pf.product_id
group by t1.id;
-- 検索テスト カウント
select *
from (
    SELECT t1.id,
      t1.name,
      t1.image,
      t1.price,
      t1.category_id,
      t1.category,
      t1.created_at,
      t1.updated_at,
      t1.score,
      t1.reviews,
      count(pf.product_id) as likes
    from (
        SELECT p.id,
          p.name,
          p.image,
          p.price,
          p.detail,
          p.category_id,
          p.created_at,
          p.updated_at,
          c.name as category,
          avg(r.score) as score,
          count(r.product_id) as reviews
        FROM products as p
          INNER JOIN categories as c ON p.category_id = c.id
          LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
        group by p.id
      ) AS t1
      left outer join product_favorites as pf on t1.id = pf.product_id
    GROUP BY t1.id
  ) as t2;
-- 検索条件追加
select *
from (
    SELECT t1.id,
      t1.name,
      t1.image,
      t1.price,
      t1.category_id,
      t1.category,
      t1.detail,
      t1.created_at,
      t1.updated_at,
      t1.score,
      t1.reviews,
      count(pf.product_id) as likes
    from (
        SELECT p.id,
          p.name,
          p.image,
          p.price,
          p.detail,
          p.category_id,
          p.created_at,
          p.updated_at,
          c.name as category,
          avg(r.score) as score,
          count(r.product_id) as reviews
        FROM products as p
          INNER JOIN categories as c ON p.category_id = c.id
          LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
        group by p.id
      ) AS t1
      left outer join product_favorites as pf on t1.id = pf.product_id
    GROUP BY t1.id
  ) as t2
where t2.category = '飲料';
-- Backup
(
  SELECT p.id,
    p.name,
    p.image,
    p.price,
    p.category_id,
    p.created_at,
    p.updated_at,
    c.name as category,
    avg(r.score) as score,
    count(r.product_id) as reviews
  FROM products as p
    INNER JOIN categories as c ON p.category_id = c.id
    LEFT OUTER JOIN reviews AS r ON p.id = r.product_id
  group by p.id
) AS t1
left outer join product_favorites as pf on t1.id = pf.product_id EOM;
$col = ' t1.id,t1.name,t1.image,t1.price,t1.category_id,t1.category,t1.created_at,t1.updated_at,t1.score,t1.reviews,count(pf.product_id) as likes ';
