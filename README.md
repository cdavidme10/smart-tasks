# SmartTasks

**SmartTasks** is a modern task management app built with **Laravel**, **React**, **Inertia.js**, and **TailwindCSS**.

## 🚀 Features

- ✅ Task management made easy
- ⚡️ Reactive UI with React & Inertia
- 🎨 Styled with TailwindCSS
- 🐳 Runs locally using Laravel Sail (Docker)

## 🧰 Requirements

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- Git

## 📦 Installation & Setup (with Sail)

### 1. Clone the repository

```bash
git clone git@github.com:cdavidme10/smart-tasks.git
cd smart-tasks
```

### 2. Copy the `.env` file

```bash
cp .env.example .env
```

### 3. Build and start Sail

```bash
./vendor/bin/sail up -d
```

> If `sail` is not available, you can add an alias:

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
source ~/.bashrc
```

> ⚠️ After starting Sail, set correct folder permissions (important for storage & cache):

```bash
sudo chown -R $USER:www-data .
chmod -R 775 .
```

### 4. Install PHP dependencies

```bash
sail composer install
```

### 5. Generate app key

```bash
sail artisan key:generate
```

### 6. Run database migrations

```bash
sail artisan migrate --seed
```

## 🖥️ Running the Frontend

### 7. Install JS dependencies

```bash
sail npm install
```

### 8. Start Vite dev server

```bash
sail npm run dev
```

### 9. Install Git Hooks (Husky)

To ensure every commit runs automated checks (like CI and OpenAPI validation), run the setup script:

```bash
sail npm run setup:husky
```

Visit [http://localhost](http://localhost) or your custom domain (e.g. `smarttasks.test`).

## 🌐 Optional: Custom Domain

To access via `http://smarttasks.test`, add this to your system hosts file:

```bash
127.0.0.1 smarttasks.test
```

## 🧪 Running Tests, Lints, PhpStan, Format

```bash
sail composer ci:check
```

## Validate && Generate OpenAPI bundle

```bash
sail npm run openapi:generate
```

## 🔐 Authentication API Routes

| Method | Endpoint      | Description   |
| ------ | ------------- | ------------- |
| POST   | /api/register | Register user |
| POST   | /api/login    | User login    |
| POST   | /api/logout   | User logout   |

---

## 📬 API Testing with Postman

A Postman collection is available to test all routes:

📥 [Download smart-tasks.postman_collection.json](./smart-tasks.postman_collection.json)

Import this file into Postman, set your bearer token after login, and start testing the endpoints.

---

## Default User

```bash
email: g9lNl@example.com
password: p1S$w0rd.23
```

## 📌 API Endpoints (CRUD)

### 🗂️ Projects

| Method | Endpoint              | Description        |
| ------ | --------------------- | ------------------ |
| GET    | /api/v1/projects      | List projects      |
| GET    | /api/v1/projects/{id} | Show a project     |
| POST   | /api/v1/projects      | Create new project |
| PUT    | /api/v1/projects/{id} | Update a project   |
| DELETE | /api/v1/projects/{id} | Delete a project   |

### ✅ Tasks

| Method | Endpoint           | Description     |
| ------ | ------------------ | --------------- |
| GET    | /api/v1/tasks      | List tasks      |
| GET    | /api/v1/tasks/{id} | Show a task     |
| POST   | /api/v1/tasks      | Create new task |
| PUT    | /api/v1/tasks/{id} | Update a task   |
| DELETE | /api/v1/tasks/{id} | Delete a task   |

## 👤 User Stories

- As a **user**, I can register and log in securely.
- As a **user**, I can create, read, update, and delete my tasks and projects.
- As a **user**, I view the app in my preferred language.
- As an **admin**, I want to track growth by assigning a "milestone" to users every 100 registrations.
- As a **developer**, I follow SOLID principles and keep the codebase modular and maintainable.
- As a **tester**, I can easily test endpoints using Postman or PHPUnit.

## 🧠 AI Tool Usage

This project used generative AI tools to:

- Draft and refine the OpenAPI schema for frontend consumption
- Generate and improve test cases (Unit and Feature)
- Assist in validation rule design and naming conventions
- Suggest architecture improvements and observer strategies
- Help generate this very README file

##Initial propmpt

```bash
Okay, I already had my public repo https://github.com/cdavidme10/smart-tasks using docker with laravel 12 php 8.4 mysql 8, vite, react 19, i18n on the views (using jsx) and the basic config about login, logout, register, and Projects and Tasks CRUD, please help me with the following tasks:
#1 Implement PHPStan, PHPLint, and PHP Tests in GitHub Actions
#2 Generate Open API Definition for Users, Projects, and Tasks CRUD Routes Using YAML Just for React Frontend, no Backend
#3 Create Unit and Feature Tests for Routes with Authentication
#4 Implement routes/api.php Laravel with Dedicated Form Requests
#5 Implement Managers, Repositories, and Interfaces for Clean Code and SOLID Principles
#6 Generate Frontend API Requests and Schemas Based on Open API
#7 Test API Integrations on Frontend Side
#8 Create React Components for Login, Logout, CRUD Tasks, and Projects
#9 Create Pages for Main Functions in React
#10 Implement Centralized Data Fetching with React Hooks and Advanced Features
#11 Create Migrations and Seeders for User, Project, and Task Models
#12 Ad\d a UserObserver to handle milestone
```

```bash
Grok IA help: https://grok.com/chat/ca965877-d231-4ef6-a774-611160987b60
```

## 🛠️ Dev Tasks Completed

- ✅ PHPStan, PHPLint, PHPUnit configured in GitHub Actions
- ✅ OpenAPI spec generated (YAML) for frontend
- ✅ Feature & Unit tests for all endpoints with authentication
- ✅ FormRequests used for validation logic
- ✅ Managers, Repositories, and Interfaces implemented
- ✅ Database seeded with Projects, Tasks, and Users
- ✅ UserObserver assigns milestone on 100-user multiples

WIP:

- ✅ OpenAPI-based API calls and schemas used on frontend
- ✅ React components for login, logout, projects, tasks created
- ✅ Data fetching via centralized hooks with error/loading states

## 🐙 GitHub

Hosted at:  
👉 [https://github.com/cdavidme10/smart-tasks](https://github.com/cdavidme10/smart-tasks)

## 📄 License

MIT © 2025 — Built with ♥ by David Medina

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
