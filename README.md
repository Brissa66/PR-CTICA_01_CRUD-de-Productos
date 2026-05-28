# PRÁCTICA_01_CRUD de Productos

Repositorio con el backend (Laravel API) y frontend (Vue 3 + Axios) de la práctica.

Estructura:

- `practica1-api/` — Backend Laravel (API REST `productos`)
- `practica1-frontend/` — Frontend Vue 3 (Vite) consumiendo la API con Axios

Requisitos:

- PHP 8.2+, Composer
- Node.js 18+, npm
- (Opcional) MySQL/MariaDB o SQLite

Arranque rápido (desarrollo):

Backend:

```powershell
Set-Location 'c:\xampp\htdocs\PRÁCTICA_01_CRUD de Productos\practica1-api'
# Instalar dependencias (si es necesario)
composer install
# crear .env y generar APP_KEY
copy .env.example .env
php artisan key:generate
# si usas SQLite (opcional)
if (!(Test-Path database\database.sqlite)) { New-Item -ItemType File -Path database\database.sqlite }
php artisan migrate --force
php artisan db:seed --class=ProductoSeeder --force
php artisan serve --host=127.0.0.1 --port=8000
```

Frontend:

```powershell
Set-Location 'c:\xampp\htdocs\PRÁCTICA_01_CRUD de Productos\practica1-frontend'
npm install
npm run dev
```

API: `http://127.0.0.1:8000/api/productos`  
Frontend: `http://127.0.0.1:5173`

Instrucciones para push al repositorio remoto (GitHub):

1. Crea un repositorio en GitHub (por ejemplo `PRACTICA_01_CRUD_de_Productos`).
2. Conecta el remoto y hace push:

```bash
cd "c:/xampp/htdocs/PRÁCTICA_01_CRUD de Productos"
git remote add origin git@github.com:Brissa66/PRACTICA_01_CRUD_de_Productos.git
git branch -M main
git push -u origin main
```

Si prefieres que cree el repo remotor usando `gh` (GitHub CLI), dímelo y lo intento desde aquí.

---
Archivo generado automáticamente por el asistente.
