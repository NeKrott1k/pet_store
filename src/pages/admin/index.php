<div class="container admin-page">
    <h1 class="page-title" style="margin-bottom: 24px;">Админ-панель</h1>

    <div class="admin-tabs">
        <?php foreach ($tabs as $key => $label): ?>
            <a href="/admin/<?= $key ?>" class="admin-tab <?= $page === $key ? 'active' : '' ?>"><?= $label ?></a>
        <?php endforeach ?>
    </div>

    <?php if ($file): ?>
        <?php require_once __DIR__ . $file; ?>
    <?php else: ?>
        <div style="background:var(--white);border-radius:var(--radius-lg);padding:40px;text-align:center;color:var(--text-light);">
            <p style="font-size:1rem;">Выберите раздел выше, чтобы начать работу.</p>
        </div>
    <?php endif ?>
</div>
