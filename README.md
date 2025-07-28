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
sail artisan migrate
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

Update your `.env`:

```ini
APP_URL=http://smarttasks.test
```

## 🧪 Running Tests, Lints, PhpStan, Format

```bash
sail composer ci
```

## 🐙 GitHub

Hosted at:  
👉 [https://github.com/cdavidme10/smart-tasks](https://github.com/cdavidme10/smart-tasks)

## 📄 License

MIT © 2025 — Built with ♥ by David Medina

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
