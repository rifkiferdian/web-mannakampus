CREATE TABLE IF NOT EXISTS `tbl_promo_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `short_description` text NOT NULL,
  `content` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `button_url` varchar(255) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` varchar(30) NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_promo_event_slug` (`slug`),
  KEY `idx_promo_event_listing` (`status`, `is_featured`, `end_date`, `display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tbl_promo_event`
  (`title`, `slug`, `type`, `short_description`, `content`, `image`, `location`, `start_date`, `end_date`, `button_text`, `button_url`, `is_featured`, `display_order`, `status`)
VALUES
  (
    'Pembukaan Manna Kampus Condongcatur',
    'opening-manna-kampus-condongcatur',
    'Store Opening',
    'Manna Kampus Condongcatur resmi dibuka Jumat, 31 Juli 2026. Nantikan promo opening, flash sale, spin wheel, dan berbagai produk gratis.',
    '<p>Manna Kampus Condongcatur resmi dibuka pada <strong>Jumat, 31 Juli 2026</strong>.</p><p>Kunjungi cabang baru kami dan nikmati promo opening, flash sale, spin wheel, free product, serta berbagai kejutan menarik lainnya.</p><p>Jam operasional mulai pukul <strong>08.30 sampai 21.30 WIB</strong>.</p>',
    'promo-event-opening-condongcatur.webp',
    'Condongcatur, Sleman, Yogyakarta',
    '2026-07-31',
    '2026-07-31',
    'Lihat Detail',
    'promo-event/opening-manna-kampus-condongcatur',
    1,
    1,
    'Active'
  ),
  (
    'Gebyar Undian Spektakuler 2026',
    'gebyar-undian-spektakuler-2026',
    'Gebyar Undian',
    'Belanja sepanjang 2026 dan raih kesempatan memenangkan rumah, mobil, motor, serta berbagai hadiah elektronik menarik.',
    '<p>Ikuti <strong>Gebyar Undian Spektakuler Manna Kampus 2026</strong> dengan periode program 1 Januari sampai 31 Desember 2026.</p><p>Hadiah utama meliputi rumah tipe 48 beserta furniture, mobil Daihatsu Ayla, Honda Scoopy, smartphone, laptop, televisi, peralatan rumah tangga, sepeda, dan berbagai hadiah menarik lainnya.</p><p>Simpan bukti transaksi dan ikuti ketentuan program yang berlaku di Manna Kampus.</p>',
    'promo-event-gebyar-undian-2026.webp',
    'Manna Kampus',
    '2026-01-01',
    '2026-12-31',
    'Lihat Detail',
    'promo-event/gebyar-undian-spektakuler-2026',
    1,
    2,
    'Active'
  )
ON DUPLICATE KEY UPDATE
  `title` = VALUES(`title`),
  `type` = VALUES(`type`),
  `short_description` = VALUES(`short_description`),
  `content` = VALUES(`content`),
  `image` = VALUES(`image`),
  `location` = VALUES(`location`),
  `start_date` = VALUES(`start_date`),
  `end_date` = VALUES(`end_date`),
  `button_text` = VALUES(`button_text`),
  `button_url` = VALUES(`button_url`),
  `is_featured` = VALUES(`is_featured`),
  `display_order` = VALUES(`display_order`),
  `status` = VALUES(`status`);
