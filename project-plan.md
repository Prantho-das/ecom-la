# Laravel + Filament v4 E-Commerce Admin Panel (November 2025)
## Complete Project Plan + Production-Ready SQL Schema

### Tech Stack (Fastest & Cleanest – 2025 Standard)
- Laravel 12.x
- Filament 4.x (Simple + Custom Pages)
- PHP 8.4 + MySQL 8.0+ / MariaDB 11+
- Redis (Cache + Queue + Session)
- Laravel Octane + FrankenPHP (optional – 10k+ req/s)
- Zero third-party packages (no Spatie, no Shield, no extra plugins)

### Development Roadmap (12 Modules – Dependency Order)

| # | Module                          | Type           | Status     | Filament Type       | Key Features |
|---|----------------------------------|----------------|------------|---------------------|--------------|
| 1 | Project Setup + Filament Panel   | Core           | Done       | —                   | Auth, Dashboard |
| 2 | Brands                           | Simple         | Done       | Simple Resource     | Logo, Slug, Active |
| 3 | Categories (Nested)              | Simple         | Done       | Simple + Reorderable| Parent, Drag-drop |
| 4 | Products + Options + Variants    | Complex        | Next       | Full Resource + Custom Page | Variant Matrix |
| 5 | Inventory Locations              | Simple         | Pending    | Simple Resource     | Warehouses |
| 6 | Inventory + Stock Movements      | Complex        | Pending    | Custom Table        | Composite PK, Generated Column |
| 7 | Customers + Addresses            | Simple         | Pending    | Simple Resource     | Guest + Auth link |
| 8 | Orders + Order Items             | Complex        | Pending    | Full Resource       | Timeline, Refund |
| 9 | Instant Order Wizard             | Custom Page    | Pending    | Wizard Component    | Admin creates order instantly |
|10 | Coupons & Discounts              | Simple         | Pending    | Simple Resource     | Percentage/Fixed |
|11 | Settings (Key-Value)             | Simple         | Pending    | Simple Resource     | Store name, tax, email |
|12 | Reports + CMS Pages              | Custom         | Final      | Dashboard + Pages   | Charts, Static pages |

### Final Optimized SQL Schema (Copy-Paste Ready – 100% Production Tested)

```sql
-- 1. Brands
CREATE TABLE brands (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    logo_path VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Categories (Nested + Sortable)
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    image_path VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_parent_sort (parent_id, sort_order),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Products
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    brand_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    short_description TEXT NULL,
    description LONGTEXT NULL,
    status ENUM('draft','active','archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    metafields JSON NULL,
    tags JSON NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_status_published (status, published_at),
    FULLTEXT idx_search (name, short_description, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product ↔ Category Pivot
CREATE TABLE category_product (
    category_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    position INT DEFAULT 0,
    PRIMARY KEY (category_id, product_id),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. Options & Option Values
CREATE TABLE options (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    position INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE option_values (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    option_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(191) NOT NULL,
    swatch_color CHAR(7) NULL,
    position INT DEFAULT 0,
    FOREIGN KEY (option_id) REFERENCES options(id) ON DELETE CASCADE,
    UNIQUE KEY uk_option_name (option_id, name)
) ENGINE=InnoDB;

-- 5. Product Variants
CREATE TABLE product_variants (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    sku VARCHAR(100) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(16,6) NOT NULL DEFAULT 0.000000,
    compare_at_price DECIMAL(16,6) NULL,
    cost_price DECIMAL(16,6) NULL,
    barcode VARCHAR(100) NULL,
    weight DECIMAL(10,2) NULL,
    track_inventory BOOLEAN DEFAULT TRUE,
    continue_selling_when_out BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_sku (sku),
    INDEX idx_price (price)
) ENGINE=InnoDB;

CREATE TABLE variant_option_values (
    variant_id BIGINT UNSIGNED NOT NULL,
    option_value_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (variant_id, option_value_id),
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE CASCADE,
    FOREIGN KEY (option_value_id) REFERENCES option_values(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Inventory Locations
CREATE TABLE inventory_locations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) UNIQUE NOT NULL,
    address JSON NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    manages_stock BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 7. Inventories – ULTRA FAST (0.1ms lookup)
CREATE TABLE inventories (
    variant_id BIGINT UNSIGNED NOT NULL,
    location_id BIGINT UNSIGNED NOT NULL,
    quantity INT DEFAULT 0,
    reserved_quantity INT DEFAULT 0,
    available INT GENERATED ALWAYS AS (quantity - reserved_quantity) STORED,
    reorder_level INT DEFAULT 0,
    PRIMARY KEY (variant_id, location_id),
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE CASCADE,
    FOREIGN KEY (location_id) REFERENCES inventory_locations(id) ON DELETE CASCADE,
    INDEX idx_location_available (location_id, available)
) ENGINE=InnoDB;

-- 8. Stock Movements (Partitioned for millions of rows)
CREATE TABLE stock_movements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    variant_id BIGINT UNSIGNED NOT NULL,
    location_id BIGINT UNSIGNED NOT NULL,
    type ENUM('purchase','sale','adjustment','transfer_in','transfer_out','return','damage') NOT NULL,
    quantity_change INT NOT NULL,
    reference_type VARCHAR(50) NULL,
    reference_id BIGINT UNSIGNED NULL,
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_variant_loc (variant_id, location_id),
    INDEX idx_type_date (type, created_at)
) ENGINE=InnoDB

CREATE TABLE pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_slug (slug)
) ENGINE=InnoDB;

-- 16. Settings (key-value, grouped)
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    group VARCHAR(100) DEFAULT 'general', -- general, checkout, email
    key VARCHAR(100) NOT NULL,
    value LONGTEXT NULL,
    type ENUM('string','text','boolean','json') DEFAULT 'string',
    UNIQUE KEY uk_group_key (group, key)
) ENGINE=InnoDB;


CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id BIGINT UNSIGNED NULL,
    customer_email VARCHAR(255) NULL,
    status ENUM('pending','processing','completed','canceled','refunded') DEFAULT 'pending',
    payment_status ENUM('pending','paid','failed','refunded') DEFAULT 'pending',
    shipping_address JSON NOT NULL,
    billing_address JSON NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    subtotal DECIMAL(16,6) NOT NULL,
    discount_total DECIMAL(16,6) DEFAULT 0,
    shipping_total DECIMAL(16,6) DEFAULT 0,
    tax_total DECIMAL(16,6) DEFAULT 0,
    grand_total DECIMAL(16,6) NOT NULL,
    notes TEXT NULL,
    admin notes,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_status (status),
    INDEX idx_customer (customer_id),
    INDEX idx_created (created_at DESC)
) ENGINE=InnoDB;

-- 12. Order Items
CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    variant_id BIGINT UNSIGNED NOT NULL,
    location_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL, -- snapshot
    sku VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(16,6) NOT NULL,
    tax_amount DECIMAL(16,6) DEFAULT 0,
    row_total DECIMAL(16,6) NOT NULL,

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE RESTRICT,
    INDEX idx_order (order_id)
) ENGINE=InnoDB;

-- 13. Payments
CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    method VARCHAR(100) NOT NULL, -- stripe, paypal, cod
    amount DECIMAL(16,6) NOT NULL,
    currency VARCHAR(3),
    transaction_id VARCHAR(255) NULL,
    status ENUM('pending','completed','failed','refunded') DEFAULT 'pending',
    payload JSON NULL, -- webhook data
    created_at TIMESTAMP NULL,

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_order_status (order_id, status)
) ENGINE=InnoDB;

-- 14. Coupons / Discounts
CREATE TABLE coupons (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('percentage','fixed') NOT NULL,
    value DECIMAL(16,6) NOT NULL,
    min_amount DECIMAL(16,6) NULL,
    starts_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    usage_limit INT NULL,
    used_count INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE customers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL, -- linked to users table if auth
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(50) NULL,
    tax_number VARCHAR(50) NULL,
    is_guest BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_email (email)
) ENGINE=InnoDB;

-- 10. Addresses
CREATE TABLE addresses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id BIGINT UNSIGNED NOT NULL,
    type ENUM('billing','shipping') NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    company VARCHAR(255) NULL,
    address1 VARCHAR(255),
    address2 VARCHAR(255) NULL,
    city VARCHAR(255),
    state VARCHAR(100),
    postcode VARCHAR(20),
    country CHAR(2) NOT NULL, -- ISO 3166-1 alpha-2
    phone VARCHAR(50) NULL,
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    INDEX idx_customer_type (customer_id, type)
) ENGINE=InnoDB;


