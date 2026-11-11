CREATE DATABASE IF NOT EXISTS accessories_shop
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE accessories_shop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE(user_id, product_id)
);

INSERT INTO categories (name, slug) VALUES
('Jewelry','jewelry'),
('Watches','watches'),
('Eyewear','eyewear'),
('Bags','bags'),
('Accessories','accessories');

INSERT INTO products (category_id,name,description,price,image,stock) VALUES
(1,'Gold Minimal Necklace','A delicate everyday necklace with a clean modern finish.',39.99,'product-01.jpg',20),
(1,'Pearl Drop Earrings','Elegant pearl earrings for effortless occasions.',29.99,'product-02.jpg',15),
(2,'Classic Gold Watch','Minimal gold-tone watch with timeless proportions.',89.99,'product-03.jpg',10),
(3,'Black Frame Glasses','Modern black frames designed for a confident everyday look.',49.99,'product-04.jpg',12),
(4,'Mini Leather Bag','Compact structured bag with an elegant silhouette.',69.99,'product-05.jpg',8),
(4,'Soft Shoulder Bag','Relaxed shoulder bag for everyday essentials.',74.99,'product-06.jpg',9),
(5,'Silk Hair Scarf','A versatile accessory that adds a refined finishing touch.',19.99,'product-07.jpg',18),
(1,'Silver Statement Ring','Contemporary silver ring with a sculptural profile.',34.99,'product-08.jpg',14),
(1,'Gold Huggie Earrings','Polished gold-tone huggie earrings for everyday styling.',18.99,'product-09.jpg',24),
(1,'Pearl Stud Earrings','Classic pearl studs with a soft luminous finish.',16.99,'product-10.jpg',22),
(1,'Twisted Gold Hoops','Modern twisted hoops with a warm gold finish.',22.99,'product-11.jpg',18),
(1,'Dainty Heart Necklace','A fine chain necklace with a tiny heart pendant.',24.99,'product-12.jpg',20),
(1,'Layered Chain Necklace','Two delicate gold-tone chains for an effortless layered look.',27.99,'product-13.jpg',16),
(1,'Moon Pendant Necklace','A minimal moon pendant on a delicate chain.',21.99,'product-14.jpg',17),
(1,'Silver Chain Bracelet','A clean silver-tone bracelet made for daily wear.',19.99,'product-15.jpg',19),
(1,'Pearl Charm Bracelet','Pearls and gold-tone details in a feminine bracelet.',23.99,'product-16.jpg',15),
(1,'Chunky Gold Ring','A bold sculptural ring with a polished finish.',26.99,'product-17.jpg',13),
(1,'Minimal Silver Ring','A simple silver-tone ring with a smooth profile.',17.99,'product-18.jpg',21),
(1,'Crystal Drop Earrings','Delicate drop earrings with subtle sparkle.',25.99,'product-19.jpg',12),
(1,'Gold Bar Necklace','A sleek bar pendant on a fine chain.',20.99,'product-20.jpg',16),
(1,'Hoop and Pearl Earrings','Gold-tone hoops finished with pearl details.',24.99,'product-21.jpg',14),
(1,'Layered Pearl Necklace','A refined pearl necklace with a modern silhouette.',31.99,'product-22.jpg',11),
(1,'Open Cuff Bracelet','An adjustable cuff bracelet with a minimal shape.',22.99,'product-23.jpg',17),
(1,'Star Charm Necklace','A dainty necklace featuring a tiny star charm.',19.99,'product-24.jpg',18),
(2,'Silver Mesh Watch','A slim silver-tone watch with a mesh strap.',79.99,'product-25.jpg',8),
(2,'Rose Gold Everyday Watch','A feminine rose gold-tone watch for day-to-night wear.',94.99,'product-26.jpg',7),
(2,'Classic Black Watch','A timeless watch with a dark face and clean markers.',69.99,'product-27.jpg',9),
(2,'Petite Gold Watch','A petite gold-tone watch with an elegant bracelet strap.',84.99,'product-28.jpg',6),
(2,'Two-Tone Bracelet Watch','A versatile watch with a mixed-metal finish.',99.99,'product-29.jpg',5),
(2,'Minimal White Dial Watch','A crisp white dial paired with a slim gold-tone strap.',74.99,'product-30.jpg',10),
(2,'Everyday Silver Watch','A versatile silver-tone watch for daily outfits.',72.99,'product-31.jpg',8),
(2,'Rectangular Gold Watch','A refined rectangular watch with a vintage-inspired shape.',92.99,'product-32.jpg',6),
(2,'Mesh Strap Rose Watch','A delicate rose-tone watch with a mesh strap.',87.99,'product-33.jpg',7),
(2,'Modern Square Watch','A modern square-face watch with a polished finish.',89.99,'product-34.jpg',6),
(3,'Tortoiseshell Sunglasses','Warm tortoiseshell frames with a flattering shape.',29.99,'product-35.jpg',15),
(3,'Slim Black Sunglasses','Slim black sunglasses for a clean contemporary look.',24.99,'product-36.jpg',20),
(3,'Oversized Square Sunglasses','Oversized square frames with a confident silhouette.',32.99,'product-37.jpg',12),
(3,'Classic Cat-Eye Sunglasses','A feminine cat-eye shape with a polished black frame.',34.99,'product-38.jpg',11),
(3,'Brown Gradient Sunglasses','Brown-toned lenses and neutral frames for everyday wear.',27.99,'product-39.jpg',13),
(3,'Retro Oval Sunglasses','Retro oval frames with a minimalist finish.',26.99,'product-40.jpg',14),
(3,'Gold Detail Sunglasses','Black frames accented with subtle gold-tone details.',36.99,'product-41.jpg',9),
(3,'Soft Square Sunglasses','Soft square frames designed to suit everyday looks.',28.99,'product-42.jpg',16),
(3,'Vintage Inspired Sunglasses','A timeless vintage-inspired frame with dark lenses.',31.99,'product-43.jpg',10),
(3,'Everyday Neutral Sunglasses','Neutral-toned sunglasses with an easy-to-style shape.',25.99,'product-44.jpg',18),
(4,'Structured Mini Tote','A structured mini tote for daily essentials.',59.99,'product-45.jpg',8),
(4,'Everyday Crossbody Bag','A compact crossbody bag with an adjustable strap.',54.99,'product-46.jpg',10),
(4,'Quilted Shoulder Bag','A quilted shoulder bag with a soft, elegant finish.',64.99,'product-47.jpg',7),
(4,'Mini Evening Bag','A compact evening bag for dinners and special occasions.',49.99,'product-48.jpg',9),
(4,'Classic Top Handle Bag','A structured top-handle bag with timeless lines.',79.99,'product-49.jpg',6),
(4,'Soft Crescent Bag','A curved shoulder bag with a relaxed modern shape.',57.99,'product-50.jpg',8),
(4,'Compact Everyday Tote','A practical tote with a clean minimalist silhouette.',62.99,'product-51.jpg',10),
(4,'Chain Strap Mini Bag','A mini bag with a delicate chain strap.',52.99,'product-52.jpg',7),
(4,'Minimal Black Crossbody','A sleek black crossbody bag for everyday use.',58.99,'product-53.jpg',9),
(4,'Weekend Shoulder Bag','A roomy shoulder bag for everyday essentials.',68.99,'product-54.jpg',6),
(5,'Satin Hair Bow','A soft satin bow that adds a polished finishing touch.',9.99,'product-55.jpg',25),
(5,'Neutral Silk Scrunchies','A set-inspired neutral accessory for easy everyday styling.',8.99,'product-56.jpg',30),
(5,'Printed Neck Scarf','A lightweight printed scarf to style around the neck or bag.',16.99,'product-57.jpg',18),
(5,'Minimal Claw Clip','A simple claw clip for effortless updos.',7.99,'product-58.jpg',28),
(5,'Pearl Hair Clip','A delicate hair clip with pearl-inspired details.',11.99,'product-59.jpg',20),
(5,'Gold Tone Keychain','A polished keychain that doubles as a bag charm.',12.99,'product-60.jpg',16),
(5,'Everyday Card Holder','A compact card holder for the essentials.',18.99,'product-61.jpg',12),
(5,'Minimal Phone Strap','A simple accessory strap for everyday convenience.',10.99,'product-62.jpg',15),
(5,'Decorative Bag Charm','A small charm to personalize your favourite bag.',13.99,'product-63.jpg',17),
(5,'Satin Wrist Scrunchie','A soft satin scrunchie that is gentle on hair.',6.99,'product-64.jpg',24),
(5,'Travel Jewellery Pouch','A compact pouch for keeping small accessories together.',14.99,'product-65.jpg',10),
(5,'Pearl Phone Charm','A pearl-inspired charm for a playful finishing touch.',12.99,'product-66.jpg',14),
(5,'Gold Hair Pin Set','Minimal gold-tone pins for simple hairstyles.',8.99,'product-67.jpg',22),
(5,'Soft Printed Bandana','A versatile bandana for hair, neck, or bag styling.',13.99,'product-68.jpg',18),
(5,'Mini Makeup Pouch','A small pouch for beauty and everyday essentials.',17.99,'product-69.jpg',11),
(5,'Everyday Accessory Set','A coordinated mix of small styling accessories.',21.99,'product-70.jpg',9);





