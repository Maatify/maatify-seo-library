# Maatify SEO Module

This is the standalone Maatify SEO library. It provides host-agnostic tools to manage SEO metadata, schema generation (JSON-LD), redirects, slug history, and sitemaps.

> **Note**: This package is intentionally framework-agnostic and host-agnostic. It contains zero coupling to frameworks (like Laravel or Symfony) and zero foreign-key relationships to host database tables. It relies on standard host interfaces (contracts).

## Installation
```bash
composer require maatify/seo
```

## Implemented Layers
Currently, the module has the following foundational layers implemented for the **Core/Shared SEO library** (Phases 1-5) and the **Admin Layer** (Phase 6A).
*Note: The full SEO module is not complete yet. The Web layer and DI wiring are planned next. The module is not done until Web, DI, and final audit are complete.*

- **Phase 1 (Foundation - Core/Shared):** Base DTOs, Exceptions, Host Contracts.
- **Phase 2A (Schema - Core/Shared):** Standalone SQL tables for slug history, redirects, and manual SEO overrides.
- **Phase 2B (Repositories - Core/Shared):** PDO implementations for persistence layers without ORMs.
- **Phase 2C (Services - Core/Shared):** Core domain logic orchestration, utilizing constructor injection and strict module exceptions.
- **Phase 3A (Meta Generator - Core/Shared):** Logic to assemble and orchestrate standard HTML Meta tags, merging host-provided defaults with manual database overrides in a framework-agnostic way.
- **Phase 3B (JSON-LD Schema Generator - Core/Shared):** Standalone service providing host-agnostic and framework-agnostic structured data generation for SEO (e.g., Breadcrumbs, Products) via strictly typed DTOs.
- **Phase 3C (Redirect & Slug Services - Core/Shared):** Core logic for resolving SEO redirects and managing slug histories, maintaining framework independence by returning DTOs rather than HTTP responses.
- **Phase 4 (Sitemap Generation - Core/Shared):** In-memory XML sitemap generation stream (URL sets and Sitemap Indexes) dynamically powered by strict DTOs.
- **Phase 5 (Documentation & Polish - Core/Shared):** Final package documentation polish, validation, and release readiness verification.
- **Phase 6A (Admin Layer):** Admin-specific command, query, and service classes for managing SEO overrides, redirects, and slug history.
