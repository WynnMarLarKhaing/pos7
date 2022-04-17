ALTER TABLE customers
ADD COLUMN admin_flag TINYINT(2) AFTER address;

CREATE TABLE `sellreceipt_detail_pdf` (
  `receipt_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `qty` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_price` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disp_sort` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sellreceipt_detail` (
  `receipt_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `qty` decimal(18,2) NOT NULL,
  `customer_price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `disp_sort` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sellreceipts_pdf` (
  `receipt_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sum_total` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_type` int(2) DEFAULT NULL,
  `save_type` int(2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sellreceipts` (
  `receipt_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sum_total` int(11) DEFAULT NULL,
  `order_type` int(2) DEFAULT NULL,
  `save_type` int(2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;