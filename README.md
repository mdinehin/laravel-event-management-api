# Laravel Event Management API

![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Composer Version](https://img.shields.io/badge/Composer-2.x-885630?style=flat-square&logo=composer&logoColor=white)
![MySQL Version](https://img.shields.io/badge/MySQL-9.x-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)

<a href="https://github.com/mdinehin/laravel-event-management-api/actions/workflows/tests.yml"><img src="https://github.com/mdinehin/laravel-event-management-api/workflows/Tests/badge.svg" alt="Tests"></a>
<a href="https://github.com/mdinehin/laravel-event-management-api/actions/workflows/coding-standards.yml"><img src="https://github.com/mdinehin/laravel-event-management-api/actions/workflows/coding-standards.yml/badge.svg" alt="Coding Standards"></a>

A robust RESTful API built with Laravel 13 designed for seamless event organization and participant tracking.

Emphasizing strict type safety, comprehensive static analysis, and secure architectural patterns, this API provides a scalable foundation for modern event-driven applications.

## Features

- Event & Attendee Management: Full CRUD operations for organizing events, updating schedules, and managing participant registrations.
- Secure API Authentication: Protected endpoints secured via robust Bearer token authentication.
- Granular Authorization: Fine-grained access control enforced using Laravel Gates and Policies to secure resource ownership and actions.
- Automated Reminders: Background queue processing and scheduled commands (`events:send-reminders`) to deliver timely email notifications to attendees.
- Strict Type Safety: Fully typed codebase utilizing strict generics and comprehensive static analysis (PHPStan/Larastan) for high maintainability.

## Prerequisites

The following software dependencies are required:

- PHP 8.3+
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://www.mysql.com/downloads/)

## Installation

1. Clone the repository `git clone https://github.com/mdinehin/laravel-event-management-api.git`
2. Install PHP dependencies with `composer install`
3. Set up a local MySQL database named `laravel_event_management_api`
4. Copy the `.env.example` file to `.env` and fill in the database credentials
5. Run database migrations with `php artisan migrate`
6. Run database seeds with `php artisan db:seed`
7. Start the local server by running `php artisan serve`

## API Integration

The API endpoints are fully documented and structured for seamless client integration. You can explore, test, and interact with all available routes using the provided Postman collection.

### API Documentation

Postman collection: [laravel_event_management_api.postman_collection.json](https://github.com/mdinehin/laravel-event-management-api/blob/main/storage/api-docs/laravel_event_management_api.postman_collection.json)

### API Reference

| Resource | Endpoint | Description |
| --- | --- | --- |
| Authentication | `/api/login` | Authenticate user credentials and issue a token |
| Deauthentication | `/api/logout` | Revoke the current Bearer token (log out) |
| User | `/api/user` | Retrieve the authenticated user profile |
| Events | `/api/events/*` | CRUD operations for events |
| Attendees | `/api/events/{event}/attendees/*` | Manage event registrations and participant tracking |

For detailed request/response payloads, query parameters, and example bodies, please import the Postman collection.

## Commands

| Command | Description |
| --- | --- |
| `php artisan test` | Run the tests |
| `php artisan migrate:fresh --seed` | Reset the database |
| `composer types:check` | Perform static code analysis |
| `composer events:send-reminders` | Dispatch event reminder notifications to attendees |
