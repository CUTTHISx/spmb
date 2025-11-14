# JavaScript Structure Documentation

## Folder Organization

### `/components/`
JavaScript untuk komponen UI yang dapat digunakan kembali seperti:
- Modal handlers
- Form validation
- Interactive components
- Reusable widgets

### `/layouts/`
JavaScript untuk layout utama aplikasi:
- `dashboard.js` - Fungsi umum untuk semua dashboard
- `auth.js` - Fungsi untuk halaman autentikasi
- `main.js` - Fungsi global aplikasi

### `/pages/`
JavaScript khusus untuk halaman tertentu:
- `welcome.js` - Interaksi untuk halaman welcome
- `profile.js` - Fungsi untuk halaman profil
- `admin.js` - Fungsi khusus halaman admin

## Usage Guidelines

1. **Components**: Gunakan untuk fungsi yang dapat digunakan di berbagai halaman
2. **Layouts**: Gunakan untuk fungsi yang berlaku untuk seluruh layout
3. **Pages**: Gunakan untuk fungsi yang spesifik untuk satu halaman

## File Naming Convention

- Gunakan kebab-case untuk nama file
- Gunakan nama yang deskriptif
- Tambahkan prefix jika diperlukan (contoh: `admin-dashboard.js`)

## Code Structure

```javascript
// 1. Constants and configuration
const CONFIG = {};

// 2. Utility functions
function utilityFunction() {}

// 3. Main functionality
function mainFunction() {}

// 4. Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize code here
});
```

## Import Order

1. External JavaScript libraries
2. Layout JavaScript
3. Component JavaScript
4. Page-specific JavaScript