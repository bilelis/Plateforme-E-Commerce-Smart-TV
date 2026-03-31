-- =============================================
-- Ayari.tn - Smart TV Shop Database
-- Import this file in phpMyAdmin
-- =============================================

CREATE DATABASE IF NOT EXISTS ayari_tn CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ayari_tn;

-- =============================================
-- Products Table
-- =============================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    size INT NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    description TEXT
) ENGINE=InnoDB;

-- =============================================
-- Orders Table
-- =============================================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- Order Items Table
-- =============================================
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================
-- Sample Data (6 Smart TVs)
-- =============================================
INSERT INTO products (name, brand, price, size, image, description) VALUES
('Crystal UHD 4K Smart TV', 'Samsung', 1299.000, 55, 'samsung-55.jpg', 'Samsung 55\" Crystal UHD 4K Smart TV with HDR, built-in Wi-Fi, and smart hub for streaming apps.'),
('OLED Evo 4K Smart TV', 'LG', 2499.000, 65, 'lg-65.jpg', 'LG 65\" OLED Evo with self-lit pixels, Dolby Vision, and webOS for an immersive viewing experience.'),
('Bravia XR 4K LED', 'Sony', 1899.000, 50, 'sony-50.jpg', 'Sony 50\" Bravia XR with Cognitive Processor XR, Google TV, and Triluminos Pro display.'),
('QLED 4K Smart TV', 'TCL', 899.000, 55, 'tcl-55.jpg', 'TCL 55\" QLED 4K with Google TV, Dolby Vision, Game Master, and brushed metal design.'),
('UHD 4K Smart TV', 'Hisense', 749.000, 50, 'hisense-50.jpg', 'Hisense 50\" UHD 4K with VIDAA smart platform, Dolby Vision HDR, and built-in Alexa.'),
('Neo QLED 8K Smart TV', 'Samsung', 3999.000, 75, 'samsung-75.jpg', 'Samsung 75\" Neo QLED 8K with Quantum Matrix Technology, Neural Quantum Processor, and Object Tracking Sound.');
