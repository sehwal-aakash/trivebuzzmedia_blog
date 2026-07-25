<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
    - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>

# Gemini.md

## Project Overview

You are building a production-ready, scalable multi-author blog publishing platform called **TriveBuzzMedia**.

The platform is focused on:

- SEO ranking
- AI-assisted content publishing
- Multi-author blogging
- Monetization
- Modern UI/UX
- Startup-grade scalability
- High-performance architecture

The application must be designed like a real startup MVP with clean architecture and long-term scalability.

---

# Primary Goals

1. Build a modern blog publishing platform.
2. Support approved multi-author publishing.
3. Build an SEO-first architecture.
4. Integrate AI content generation workflows.
5. Create a scalable Laravel architecture.
6. Build a clean modern UI inspired by Medium, Hashnode, and Notion.
7. Build a monetization-ready platform.

---

# Tech Stack

## Backend

- Laravel 13
- PHP 8.4+
- MySQL
- Laravel Sanctum
- Laravel Queues
- Laravel Cache
- Laravel Notifications
- Laravel Scheduler
- Laravel Policies
- Service Layer Architecture

## Frontend

- Blade Templates
- Tailwind CSS v4
- Alpine.js
- Responsive Mobile-First Design
- Dark Mode Support

## Infrastructure Ready

- Redis
- S3 Compatible Storage
- Cloudflare CDN
- Queue Workers
- Docker
- Nginx
- Supervisor

---

# Development Philosophy

You are acting as:

- Senior Full Stack Engineer
- Startup CTO
- Laravel Architect
- Product Engineer
- Performance Engineer
- SEO Engineer
- UI/UX Engineer

Always:

- Think production-first
- Think scalable-first
- Think reusable-first
- Think performance-first
- Think SEO-first
- Think maintainability-first

Do NOT generate toy-level code.

Generate startup-grade production-ready code.

---

# Architecture Rules

## Architecture Pattern

Use:

- MVC + Service Layer
- Repository Pattern where useful
- Form Requests for validation
- Policies for authorization
- Jobs for async processing
- Events & Listeners
- API Resources
- Reusable Blade Components
- Config-driven architecture

## SOLID Principles

Follow SOLID principles everywhere.

## Clean Code Rules

- Use descriptive variable names.
- Use typed properties.
- Use return types.
- Use small reusable methods.
- Avoid duplicated logic.
- Keep controllers thin.
- Move business logic to services.
- Use enums where applicable.

---

# Application Modules

The application must contain these modules:

1. Authentication Module
2. User & Author Management
3. Blog Publishing System
4. Category & Tags
5. SEO System
6. Comment System
7. Media Upload System
8. Admin Dashboard
9. Author Dashboard
10. Analytics System
11. Approval Workflow
12. AI Content Generation
13. Notification System
14. Monetization Layer
15. Search System
16. Newsletter System

---

# User Roles

## Roles

- Super Admin
- Admin
- Editor
- Approved Author
- Pending Author
- Visitor

## Permissions

### Super Admin

- Full platform access

### Admin

- Manage users
- Manage authors
- Manage posts
- Moderate comments
- Access analytics

### Editor

- Approve/reject posts
- Edit content
- Moderate content

### Approved Author

- Create posts
- Edit own posts
- Access author dashboard

### Pending Author

- Register
- Apply for approval
- Cannot publish until approved

### Visitor

- Read posts
- Search posts
- Comment on posts

Use:

- Policies
- Middleware
- Gates
- Role-based access control

---

# Database Design Rules

Design normalized scalable database schemas.

Always include:

- indexes
- foreign keys
- soft deletes where needed
- timestamps
- optimized relationships

Use:

- eager loading
- pagination
- query optimization

---

# Required Database Tables

Generate scalable migrations for:

- users
- posts
- categories
- tags
- post_tag
- comments
- media
- author_applications
- notifications
- newsletters
- seo_meta
- activity_logs

---

# Blog System Requirements

## Blog Features

- Draft posts
- Published posts
- Scheduled publishing
- Featured image uploads
- SEO fields
- Slug generation
- Reading time calculation
- Related posts
- Search functionality
- Featured posts
- Trending posts
- Sticky posts
- Table of contents
- Markdown support optional
- AI-generated summary support

## Content Editor

Use a modern rich editor architecture.

Editor must support:

- headings
- images
- code blocks
- embeds
- tables
- quotes
- lists
- markdown support

---

# Author Workflow

## Registration Flow

1. Visitor registers.
2. Account verification.
3. User submits author application.
4. Admin reviews.
5. Admin approves/rejects.
6. Approved author gets dashboard access.

---

# Comment System Requirements

## Features

- Guest comments
- Logged-in comments
- Nested replies
- Spam protection
- Comment moderation
- Report comment feature
- Comment approval queue

---

# Admin Dashboard Requirements

Create a modern SaaS-style admin dashboard.

## Dashboard Features

- Statistics cards
- User management
- Author approvals
- Post moderation
- Comment moderation
- SEO analytics
- Revenue placeholders
- Activity logs
- Analytics charts
- Trending content
- Notification center

## UI Requirements

- Sidebar layout
- Responsive design
- Dark mode
- Tailwind CSS
- Modern spacing
- Clean typography
- Dashboard widgets

---

# Author Dashboard Requirements

## Features

- Total posts
- Draft count
- Published count
- Total views
- Analytics chart
- Create post
- Edit post
- Media library
- AI writing tools
- SEO suggestions

---

# Public Frontend Requirements

## Public Pages

- Home
- Blog Listing
- Blog Details
- Category Page
- Author Profile
- Search Page
- About
- Contact
- Privacy Policy
- Terms

## UI Inspiration

Design similar to:

- Medium
- Hashnode
- Dev.to
- Notion

## UI/UX Requirements

- Minimal clean UI
- Smooth animations
- Sticky navbar
- Reading progress bar
- Beautiful typography
- Dark/light mode
- Responsive design
- Featured carousel
- Trending section
- Newsletter section
- Mega footer
- Search experience

---

# SEO Requirements

The platform must be SEO-first.

## Required SEO Features

- Dynamic meta tags
- OpenGraph tags
- Twitter cards
- Canonical URLs
- XML sitemap
- robots.txt
- Breadcrumbs
- Structured schema markup
- Internal linking support
- Optimized heading hierarchy
- SEO-friendly URLs
- Lazy loading
- Image optimization

---

# AI Integration Requirements

The platform will use Gemini CLI.

## AI Features

- Blog outline generation
- SEO keyword suggestions
- Meta description generation
- Title generation
- Content summarization
- AI-assisted drafts
- Human review before publishing

## AI Architecture

Create:

- AIContentService
- Prompt templates
- Queue-based AI generation
- Content review workflow

AI-generated content must NEVER auto-publish.

---

# API Architecture

Use RESTful API design.

## Public APIs

- GET /api/posts
- GET /api/posts/{slug}
- GET /api/categories
- GET /api/tags
- POST /api/comments

## Author APIs

- POST /api/author/posts
- PUT /api/author/posts/{id}
- DELETE /api/author/posts/{id}

## Admin APIs

- GET /api/admin/dashboard
- POST /api/admin/approve-author
- POST /api/admin/reject-author

Use:

- API Resources
- Validation
- Sanctum authentication
- Rate limiting

---

# File Structure Rules

Use scalable modular architecture.

## Backend Structure

app/
├── Actions/
├── DTOs/
├── Enums/
├── Events/
├── Exceptions/
├── Helpers/
├── Http/
│ ├── Controllers/
│ │ ├── Admin/
│ │ ├── Author/
│ │ ├── Public/
│ ├── Middleware/
│ ├── Requests/
│ ├── Resources/
├── Jobs/
├── Listeners/
├── Models/
├── Notifications/
├── Policies/
├── Repositories/
├── Services/
├── Traits/

resources/
├── views/
│ ├── admin/
│ ├── author/
│ ├── components/
│ ├── layouts/
│ ├── public/
│ ├── auth/

---

# Laravel Development Rules

Always follow Laravel best practices.

## Required Rules

- Use route model binding.
- Use eager loading.
- Use pagination.
- Use Form Requests.
- Use Policies.
- Use Events/Listeners.
- Use Queue Jobs.
- Use reusable Blade components.
- Use API Resources.
- Use Laravel naming conventions.
- Use typed properties.
- Use service classes.

## Avoid

- Fat controllers
- Duplicated logic
- Inline SQL
- Unoptimized queries
- Massive Blade templates
- Business logic inside views

---

# Tailwind & UI Rules

## UI Standards

- Use modern SaaS UI.
- Use generous whitespace.
- Use beautiful typography.
- Use responsive layouts.
- Use grid systems.
- Use cards.
- Use smooth hover effects.
- Use subtle shadows.
- Use loading states.
- Use skeleton loaders.

## Dark Mode

All pages must support dark mode.

---

# Security Requirements

Always implement:

- CSRF protection
- XSS protection
- Validation everywhere
- Secure file uploads
- Rate limiting
- Policies
- Middleware
- Sanitization
- Access control
- Secure password hashing

---

# Performance Requirements

Always optimize for performance.

## Required Optimizations

- Eager loading
- Query optimization
- Redis caching
- Queue workers
- Lazy loading
- Optimized images
- CDN readiness
- Asset optimization
- Pagination
- Database indexing

---

# Monetization Requirements

The platform should be monetization-ready.

## Support Future Features

- Google AdSense
- Sponsored posts
- Affiliate blocks
- Premium content
- Newsletter sponsorships
- Subscription plans

---

# Testing Rules

Use PestPHP.

Generate:

- Feature tests
- Unit tests
- Authentication tests
- API tests
- Authorization tests

---

# Deployment Requirements

Generate deployment-ready architecture.

## Production Stack

- Ubuntu Server
- Nginx
- PHP-FPM
- MySQL
- Redis
- Supervisor
- Queue workers
- SSL
- Cloudflare

## Include

- Docker setup
- Nginx config
- Supervisor config
- Queue setup
- Deployment guide
- Scaling guide

---

# Scalability Requirements

Architect for:

- 100k+ monthly visitors
- Multiple authors
- High SEO traffic
- Future API expansion
- Future mobile apps
- Future SaaS features

---

# Output Requirements

When generating code:

1. Generate step-by-step.
2. Explain architecture first.
3. Generate complete files.
4. Include file paths.
5. Keep code production-ready.
6. Keep UI modern.
7. Follow Laravel conventions.
8. Avoid pseudo-code.
9. Generate complete implementations.
10. Generate reusable components.

---

# Generation Workflow

Always generate in this order:

1. Architecture
2. Database
3. Models
4. Authentication
5. Role system
6. Services
7. Blog system
8. Admin panel
9. Author panel
10. Public frontend
11. APIs
12. SEO
13. AI integration
14. Optimization
15. Deployment

---

# Final Rule

Always think like:

- Senior Laravel Architect
- Startup CTO
- SaaS Engineer
- SEO Engineer
- Performance Engineer
- UI/UX Engineer

The output must feel like:

- a real funded startup MVP
- scalable from day one
- production-ready
- maintainable by a real engineering team
- optimized for growth and SEO

---

# Mandatory Git Branching & Merge Workflow Rules

The remote repository has 3 primary branches: `master`, `dev`, and `test`.

For EVERY task (bug fix, change, or new feature):
1. **Always create a new sub-branch off of `master`**:
   - `git checkout master && git pull origin master`
   - `git checkout -b <task-name>-<type>`
2. **Branch Suffix Naming Convention**:
   - Bug Fixes: `<name>-fix` (e.g., `email-log-routing-fix`)
   - Changes / Refactor: `<name>-change` (e.g., `deploy-config-change`)
   - New Features: `<name>-feature` (e.g., `email-monitoring-feature`)
3. **Development & Verification**:
   - Work on the created sub-branch.
   - Run formatting (`vendor/bin/pint --dirty --format agent`) and tests (`php artisan test --compact`).
4. **Merge & Push**:
   - Merge the sub-branch into `test`, `dev`, and `master`:
     - `git checkout test && git merge <sub-branch>`
     - `git checkout dev && git merge <sub-branch>`
     - `git checkout master && git merge <sub-branch>`
   - Push all three branches to remote:
     - `git push origin test dev master`

