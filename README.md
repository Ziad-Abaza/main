
# Laravel Image Upload Test

This project is a simple Laravel-based application that demonstrates how to upload and manage images using Laravel’s built-in features and popular image-handling libraries.

## 📌 Purpose

The main goal of this project is to test and explore different methods for uploading images in a Laravel application using packages like:

- Laravel's default file storage system
- `Intervention/Image` for image manipulation
- `spatie/laravel-medialibrary` for advanced media handling (optional)

## ⚙️ Features

- Upload single or multiple images
- Validate image file types and size
- Store uploaded images in the local filesystem
- Display and preview uploaded images
- Optionally resize or crop images
- Organized folder structure for uploads

## 🧱 Tech Stack

- Laravel 12.x
- PHP 8.4
- Laravel File Storage
- Intervention Image (optional)
- Spatie Media Library (optional)

## 🚀 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/laravel-image-upload-test.git
   cd laravel-image-upload-test
````

2. Install dependencies:

   ```bash
   composer install
   npm install && npm run dev
   ```

3. Set up your `.env` file:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database settings in `.env`.

5. Run migrations:

   ```bash
   php artisan migrate
   ```

6. Create symbolic link for storage:

   ```bash
   php artisan storage:link
   ```

7. Start the development server:

   ```bash
   php artisan serve
   php artisan queue:work
   ```

## 📸 Image Upload Example

The main image upload route is:

```
POST /images/upload
```

Use a form or an API client like Postman to test image uploads.

---

## 🧪 Testing

You can test image uploads using the built-in routes and a simple Blade view or API. Check the `/storage` or `/public/storage` folder to confirm images are stored.

---

## 📄 License

This project is open-source and free to use for testing and educational purposes.

```
