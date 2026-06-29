-- -----------------------------------------------------------------------------
-- Table: maa_seo_overrides
-- Purpose: Allows marketers/admins to manually override generated Meta Title
--          and Description per entity without polluting the host's primary tables.
-- Soft Delete Policy: Hard deletes only. No soft deletes (deleted_at).
-- FK Policy: No foreign keys to host tables (entity_id, language_id).
-- Uniqueness Policy: Unique across (entity_type, entity_id, language_id).
-- -----------------------------------------------------------------------------

CREATE TABLE `maa_seo_overrides` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` VARCHAR(50) NOT NULL COMMENT 'e.g. product, category',
  `entity_id` VARCHAR(36) NOT NULL COMMENT 'Host-provided ID. No FK.',
  `language_id` INT UNSIGNED NOT NULL COMMENT 'Host-provided ID. No FK.',
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_maa_seo_override_unique` (`entity_type`, `entity_id`, `language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
