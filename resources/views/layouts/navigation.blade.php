<!-- Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/dashboard">
            <div class="brand-icon me-2">
                <i class="fas fa-graduation-cap text-primary"></i>
            </div>
            <span class="brand-text">PPDB Online</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @auth
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('dashboard/admin') ? 'active' : '' }}" href="/dashboard/admin">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('admin/master') ? 'active' : '' }}" href="/admin/master">
                                <i class="fas fa-database me-2"></i>Master Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('admin/monitoring') ? 'active' : '' }}" href="/admin/monitoring">
                                <i class="fas fa-users me-2"></i>Monitoring
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('admin/peta') ? 'active' : '' }}" href="/admin/peta">
                                <i class="fas fa-map-marked-alt me-2"></i>Peta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('admin/laporan') ? 'active' : '' }}" href="/admin/laporan">
                                <i class="fas fa-file-alt me-2"></i>Laporan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('admin/keputusan') ? 'active' : '' }}" href="/admin/keputusan">
                                <i class="fas fa-gavel me-2"></i>Keputusan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('admin/akun') ? 'active' : '' }}" href="/admin/akun">
                                <i class="fas fa-users-cog me-2"></i>Akun
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'kepsek')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('dashboard/kepsek') ? 'active' : '' }}" href="/dashboard/kepsek">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'keuangan')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('dashboard/keuangan') ? 'active' : '' }}" href="/dashboard/keuangan">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('keuangan/verifikasi') ? 'active' : '' }}" href="/keuangan/verifikasi">
                                <i class="fas fa-money-check-alt me-2"></i>Verifikasi Bayar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('keuangan/rekap') ? 'active' : '' }}" href="/keuangan/rekap">
                                <i class="fas fa-chart-line me-2"></i>Laporan
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'verifikator' || Auth::user()->role == 'verifikator_adm')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('dashboard/verifikator') ? 'active' : '' }}" href="/dashboard/verifikator">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('verifikator/verifikasi') ? 'active' : '' }}" href="/verifikator/verifikasi">
                                <i class="fas fa-check-circle me-2"></i>Verifikasi Berkas
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'pendaftar')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('dashboard/pendaftar') ? 'active' : '' }}" href="/dashboard/pendaftar">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('/pendaftaran') ? 'active' : '' }}" href="/pendaftaran/form">
                                <i class="fas fa-edit me-2"></i>Form Pendaftaran
                            </a>
                        </li> -->
                    @endif
                @endauth
            </ul>

            <!-- Right Side Menu -->
            <ul class="navbar-nav">
                <!-- Notifications -->
                @php
                    $notifications = Auth::check() ? \App\Models\Notification::forUser(Auth::id())->latest()->limit(5)->get() : collect();
                    $unreadCount = Auth::check() ? \App\Models\Notification::forUser(Auth::id())->unread()->count() : 0;
                @endphp
                <li class="nav-item dropdown me-3">
                    <a class="nav-link notification-bell" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
                        <li class="dropdown-header">
                            <i class="fas fa-bell me-2"></i>Notifikasi
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @forelse($notifications as $notif)
                        <li>
                            <a class="dropdown-item notification-item {{ $notif->read_at ? '' : 'unread' }}" href="#" onclick="markAsRead({{ $notif->id }})">
                                <div class="notification-content">
                                    <div class="notification-title">{{ $notif->title }}</div>
                                    <div class="notification-text">{{ $notif->message }}</div>
                                    <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li>
                            <div class="dropdown-item text-center text-muted">
                                Tidak ada notifikasi
                            </div>
                        </li>
                        @endforelse
                        @if($notifications->count() > 0)
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#" onclick="markAllAsRead()">Tandai Semua Dibaca</a></li>
                        @endif
                    </ul>
                </li>

                <!-- User Profile -->
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link user-profile-dropdown" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="user-profile-nav">
                            <div class="user-avatar-nav">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            <div class="user-info-nav d-none d-md-block">
                                <div class="user-name">{{ Auth::user()->name }}</div>
                                <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                        <li class="dropdown-header">
                            <div class="user-profile-header">
                                <div class="user-avatar-large">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                <div>
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/profile">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Pengaturan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white px-3" href="/login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
/* Navigation Styles */
.navbar {
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
    z-index: 1030;
}

body {
    padding-top: 80px;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.brand-text {
    color: #333;
    font-size: 1.25rem;
}

.nav-link-custom {
    padding: 0.75rem 1rem;
    margin: 0 0.25rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    color: #6c757d;
    font-weight: 500;
}

.nav-link-custom:hover {
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary);
    transform: translateY(-1px);
}

.nav-link-custom.active {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
}

.notification-bell {
    position: relative;
    padding: 0.75rem;
    color: #6c757d;
    transition: all 0.3s ease;
}

.notification-bell:hover {
    color: var(--primary);
    transform: scale(1.1);
}

.notification-badge {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.notification-dropdown {
    width: 320px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 12px;
}

.notification-item {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #f8f9fa;
}

.notification-content {
    font-size: 0.9rem;
}

.notification-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.notification-text {
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.notification-time {
    color: #adb5bd;
    font-size: 0.8rem;
}

.user-profile-dropdown {
    padding: 0.5rem 0.75rem;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.user-profile-dropdown:hover {
    background-color: #f8f9fa;
}

.user-profile-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-avatar-nav {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.9rem;
}

.user-info-nav {
    text-align: left;
}

.user-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #333;
    line-height: 1.2;
}

.user-role {
    font-size: 0.75rem;
    color: #6c757d;
    line-height: 1.2;
}

.user-dropdown {
    width: 280px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 12px;
}

.user-profile-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.user-avatar-large {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary);
}

.dropdown-item.text-danger:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

@media (max-width: 991.98px) {
    .nav-link-custom {
        margin: 0.25rem 0;
    }
    
    .user-info-nav {
        display: block !important;
    }
}
.notification-item.unread {
    background-color: #f8f9fa;
    border-left: 3px solid #0d6efd;
}
</style>

<script src="{{ asset('js/notifications.js') }}"></script>
<script>
// Auto refresh notifications every 30 seconds
setInterval(function() {
    if (document.querySelector('.notification-badge')) {
        fetch('/notifications/count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge');
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            });
    }
}, 30000);
</script>