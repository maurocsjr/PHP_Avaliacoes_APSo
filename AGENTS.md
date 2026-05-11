# AGENTS.md

## Project Overview
- Laravel application with PHPUnit tests and Laravel Mix frontend assets.
- Main areas: `app/`, `config/`, `routes/`, `resources/`, `public/`, and `tests/`.
- Tooling entry points: `composer.json`, `package.json`, and `webpack.mix.js`.

## Working Agreement
- Keep changes minimal and aligned with existing Laravel conventions.
- Prefer targeted fixes over broad refactors unless the task explicitly asks for structural change.
- Do not edit `.env`; use `.env.exemple` as the repository template if environment variables need to be documented.
- Avoid changing generated or third-party content in `public/`, `vendor/`, and `node_modules/` unless the task explicitly requires it.

## Useful Commands
- Install PHP dependencies: `composer install`
- Install JavaScript dependencies: `npm install`
- Start the local app: `php artisan serve`
- Run the test suite: `php artisan test`
- Run PHPUnit directly: `./vendor/bin/phpunit`
- Build frontend assets for development: `npm run dev`
- Build production assets: `npm run prod`

## Code Guidance
- Put route changes in `routes/` and keep business logic out of route files when possible.
- Keep config changes inside `config/` and avoid hardcoding environment-sensitive values.
- Add or update tests in `tests/` when changing behavior that is already covered or clearly testable.
- Match existing code style and naming patterns before introducing new abstractions.

## Validation
- After PHP changes, run the narrowest relevant test command first, usually `php artisan test`.
- After frontend changes, run the narrowest relevant asset build command.
- Skip broad validation when the task is documentation-only or does not alter behavior.
