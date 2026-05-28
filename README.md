# FitScan AI - Smart Outfit Recognition

FitScan AI is a Laravel-based web application for outfit recognition using Artificial Intelligence. Users can upload outfit images, crop the outfit area, and get AI-based classification results along with outfit recommendations.

---

## Features

* Upload outfit image
* Crop outfit area before prediction
* AI outfit classification
* Outfit recommendation system
* Responsive modern UI
* Laravel + Python AI integration
* Hugging Face deployment support

---

## Tech Stack

### Frontend

* Blade Template
* Tailwind CSS
* JavaScript

### Backend

* Laravel 10
* PHP 8+

### AI Service

* FastAPI
* TensorFlow / Keras
* Hugging Face Spaces

---

## Project Structure

```bash
smart-outfit-recognition/
│
├── app/
├── bootstrap/
├── config/
├── public/
│   ├── uploads/
│   └── assets/
├── resources/
│   └── views/
├── routes/
├── storage/
└── vendor/
```

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/your-username/smart-outfit-recognition.git
```

### 2. Move Into Project

```bash
cd smart-outfit-recognition
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Create Environment File

```bash
cp .env.example .env
```

### 5. Generate Laravel Key

```bash
php artisan key:generate
```

---

## Running Project Locally

### Start Laravel Server

```bash
php artisan serve
```

Laravel will run at:

```bash
http://127.0.0.1:8000
```

---

## AI API Configuration

The Laravel application communicates with the deployed FastAPI AI service.

Inside:

```php
app/Http/Controllers/OutfitController.php
```

Set:

```php
$pythonApi = 'https://melawatii-outfit-ai-chip.hf.space/predict';
```

---

## Upload Image Flow

1. User uploads image
2. User crops outfit area
3. Laravel sends cropped image to AI API
4. FastAPI predicts outfit class
5. Laravel displays:

   * Original image
   * Cropped image
   * Prediction result
   * Outfit recommendation

---

## Deployment

### Laravel Hosting

This project can be deployed on:

* InfinityFree
* Shared Hosting
* VPS

### AI Deployment

The AI model is deployed using:

* Hugging Face Spaces
* Docker
* FastAPI

---

## Important Hosting Notes

### InfinityFree Upload Path

Use this upload method:

```php
$destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads';

$image->move($destinationPath, $imageName);
```

Do NOT use:

```php
storage/app/public
```

on InfinityFree hosting.

---

## Environment Requirements

* PHP >= 8.1
* Composer
* Laravel 10
* cURL Enabled
* OpenSSL Enabled

---

## Example Result

The application provides:

* Outfit classification percentage
* Outfit category
* Outfit style recommendation
* Occasion recommendation

---

## Screenshots

### Upload Page

* Upload image
* Crop outfit area

### Result Page

* Original image preview
* Cropped image preview
* AI prediction
* Recommendation panel

---

## Author

Developed by:

**Melawati**

---

## License

This project is for educational and research purposes.
