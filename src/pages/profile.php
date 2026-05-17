<div class="container">
    <div class="profile-layout">
        <nav class="profile-nav">
            <a href="/profile?tab=info" class="profile-nav__item <?= $current_tab === 'info' ? 'active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                Личная информация
            </a>
            <a href="/orders" class="profile-nav__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                История заказов
            </a>
            <?php if (in_array($_SESSION['user_role'] ?? '', ['admin', 'manager'])): ?>
            <a href="/admin" class="profile-nav__item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Админ-панель
            </a>
            <?php endif ?>
            <a href="/logout" class="profile-nav__item profile-nav__item--danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                Выйти
            </a>
        </nav>

        <div class="profile-content">
            <h1 class="profile-content__title">Личная информация</h1>

            <?php if ($success): ?>
                <div style="background:#E8F1EC;border-radius:var(--radius-sm);padding:10px 16px;font-size:.875rem;color:var(--green);font-weight:600;margin-bottom:20px;"><?= htmlspecialchars($success) ?></div>
            <?php endif ?>
            <?php if ($error): ?>
                <div class="auth-form__error" style="margin-bottom:20px;"><?= htmlspecialchars($error) ?></div>
            <?php endif ?>

            <div class="profile-avatar-wrap">
                <div class="profile-avatar">
                    <?php if (!empty($user['img'])): ?>
                        <img src="<?= htmlspecialchars($user['img']) ?>" alt="">
                    <?php else: ?>
                        <?= $first_letter ?>
                    <?php endif ?>
                    <label class="profile-avatar__upload" title="Изменить фото">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg>
                        <input type="file" accept="image/*" style="display:none;">
                    </label>
                </div>
            </div>

            <form class="profile-form" method="POST" action="/profile">
                <div class="form-group">
                    <label class="form-label">Имя</label>
                    <input type="text" name="name" class="form-input" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Почта</label>
                    <input type="email" class="form-input" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled style="opacity:.6;">
                </div>
                <div class="form-group">
                    <label class="form-label">Телефон</label>
                    <input type="tel" name="phone" id="profile-phone" class="form-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="+7 (999) 000-00-00">
                </div>
                <button type="submit" class="btn btn--orange btn--lg">Сохранить изменения</button>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
const ph = document.getElementById('profile-phone');
if (ph) IMask(ph, { mask: '+{7} (000) 000-00-00' });
</script>
