-- -----------------------------------------------------------------------------
-- Table: maa_seo_slug_history
-- Purpose: Records old slugs when an entity's slug changes, to prevent reuse
--          and facilitate automatic redirects.
-- Soft Delete Policy: Hard deletes only. No soft deletes (deleted_at).
-- FK Policy: No foreign keys to host tables (entity_id, language_id).
-- Uniqueness Policy: Unique across (entity_type, entity_id, language_id, old_slug).
-- Lifecycle Policy: Kept indefinitely to prevent old slug reuse, unless the entity
--                   is permanently deleted by the host application.
-- -----------------------------------------------------------------------------

CREATE TABLE `maa_seo_slug_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` VARCHAR(50) NOT NULL COMMENT 'e.g. product, category',
  `entity_id` VARCHAR(36) NOT NULL COMMENT 'Host-provided ID. No FK.',
  `language_id` INT UNSIGNED NOT NULL COMMENT 'Host-provided ID. No FK.',
  `old_slug` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_maa_seo_sh_unique` (`entity_type`, `entity_id`, `language_id`, `old_slug`),
  KEY `idx_maa_seo_sh_lookup` (`entity_type`, `language_id`, `old_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
