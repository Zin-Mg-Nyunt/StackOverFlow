# 🚀 Professional Forum Web Application

A robust and high-performance Forum Platform built with **Laravel** and **Vue.js**. This project demonstrates modern web development practices, focusing on scalable software architecture and an optimized user experience.

## ✨ Key Features

### 🛠 Core Functionalities
* **Full CRUD:** Managed questions and answers with a structured data flow.
* **Nested Answers (Threaded Comments):** Implemented a reply system using recursive logic, allowing users to engage in deep discussions.
* **Infinite Scrolling:** Utilized infinite scroll for questions to provide a seamless browsing experience without manual pagination.
* **Advanced Filtering:** Search and filter questions by tags or specific keywords.
* **Answer Sorting:** Sort answers by "Most Liked" or "Latest" to find the most relevant information quickly.
* **User Profile & Image Upload:** Personalized profiles with an image upload feature including a real-time preview.

### 🔐 Security & Authentication
* **Custom OTP Password Reset:** Replaced the default link-based reset with a custom **One-Time Password (OTP)** system for better security and mobile-friendly UX.
* **Authentication & Authorization:** Secure login system with fine-grained access control using **Laravel Policies and Gates** to ensure only owners can edit or delete their content.

### 📊 Engagement Systems
* **Polymorphic Voting:** A flexible Upvote/Downvote system for both Questions and Answers.
* **Polymorphic Likes:** Reusable Like feature implemented across different models using polymorphic relationships.
* **Save/Bookmark:** Users can save important questions to their personal collection for easy access later.

---

## 🧠 Technical Implementations (Architecture & Logic)

* **Service Pattern:** Business logic is decoupled from Controllers into **Service Layers** to ensure reusability, maintainability, and easier testing.
* **Recursive Components:** Used **Vue.js Recursive Components** to render nested threaded answers dynamically.
* **Performance Optimization:**
    * **Eager Loading:** Solved `N+1 Query` issues using `with()` and `withCount()`.
    * **Caching Layer:** Integrated Laravel Cache to reduce database load for frequently accessed data.
    * **Polymorphic Relationships:** Reduced database redundancy by sharing Voting and Like tables across multiple models.
    * **Database Indexing:** Optimized queries using `morphOne` and `exists` checks.
---

## 🛠 Tech Stack

* Backend: Laravel 12+ (PHP)
* Frontend: Vue.js 3 (Composition API), Tailwind CSS
* Database: MySQL
* State Management: Pinia / Vue Composition API
* Broadcasting: Prepared for Laravel Reverb

---

## 🚀 Getting Started

### 1. Clone the project
```bash
git clone git@github.com:Zin-Mg-Nyunt/StackOverFlow.git
cd StackOverFlow
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```
(Note: Configure your Database and Mail driver in .env for the OTP feature to work.)

### 4. Database Migration & Seeding
```bash
php artisan migrate --seed
```

### 5. Storage Configuration
```bash
php artisan storage:link
```

### 6. Run the Application
```bash
# Terminal 1: Start Laravel Server
php artisan serve

# Terminal 2: Compile Frontend Assets
npm run dev
```



