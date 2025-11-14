# CSS Structure Documentation

## Folder Organization

### `/components/`
CSS untuk komponen UI yang dapat digunakan kembali seperti:
- Buttons
- Cards
- Forms
- Modals
- Navigation components

### `/layouts/`
CSS untuk layout utama aplikasi:
- `dashboard.css` - Styling untuk semua halaman dashboard
- `auth.css` - Styling untuk halaman login/register
- `main.css` - Layout utama aplikasi

### `/pages/`
CSS khusus untuk halaman tertentu:
- `welcome.css` - Styling untuk halaman welcome/landing page
- `profile.css` - Styling untuk halaman profil
- `admin.css` - Styling khusus halaman admin

## Usage Guidelines

1. **Components**: Gunakan untuk styling yang dapat digunakan di berbagai halaman
2. **Layouts**: Gunakan untuk styling yang berlaku untuk seluruh layout
3. **Pages**: Gunakan untuk styling yang spesifik untuk satu halaman

## File Naming Convention

- Gunakan kebab-case untuk nama file
- Gunakan nama yang deskriptif
- Tambahkan prefix jika diperlukan (contoh: `admin-dashboard.css`)

## Import Order

1. External CSS libraries
2. Layout CSS
3. Component CSS  
4. Page-specific CSS