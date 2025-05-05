# Laravel Crawler API

A modular, Clean Architecture-based Laravel application that crawls metadata and screenshots from a given URL.  
This service is designed to demonstrate a scalable architecture pattern while providing a useful web crawling utility via RESTful APIs.

---

## Architecture

This project follows **Clean Architecture**, separating concerns between:

- **Domain Layer**: Entities, Interfaces, Business Rules
- **Application Layer**: Use Cases (Services), DTOs
- **Infrastructure Layer**: Framework/Library implementations like DB, HTTP clients, screenshots
- **Presentation Layer**: API Controllers and Routes

### Folder Structure

```
src/
├── Application/
│ └── Services/
├── Domain/
│ ├── Contracts/
│ ├── DTO/
│ └── Models/
├── Infrastructure/
│ ├── Http/
│ ├── Repositories/
│ └── Utils/
├── Presentation/
│ ├── Controllers/
│ └── Routes/
```

## Installation

```bash
git clone https://github.com/your-repo/laravel-crawler-api.git
cd laravel-crawler-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Usage

Make a POST request to the following endpoint:

```json
POST /api/crawl
Content-Type: application/json

{
    "url": "https://example.com"
}
```

## Tech Used

- Laravel 12.x
- Spatie Browsershot
- MySQL
- Clean Architecture Principles
- RESTful API design