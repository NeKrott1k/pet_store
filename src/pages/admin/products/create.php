<div class="admin-form">
    <a href="/admin/products" style="display:inline-flex;align-items:center;gap:6px;font-size:.875rem;font-weight:600;color:var(--text-light);margin-bottom:16px;">← Назад</a>
    <h2 class="admin-form__title">Добавить товар</h2>

    <?php if ($error): ?>
        <div class="auth-form__error" style="margin-bottom:20px;"><?= htmlspecialchars($error) ?></div>
    <?php endif ?>

    <form method="POST" enctype="multipart/form-data">
        <label class="admin-upload" id="upload-label">
            <img id="preview" class="admin-upload__preview" style="display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="upload-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg>
            <span id="upload-text">Нажмите, чтобы выбрать фото</span>
            <input type="file" name="img" accept="image/*" onchange="previewImg(this)">
        </label>

        <div class="form-group" style="margin-bottom:16px;">
            <input type="text" name="name" class="form-input" placeholder="Название" required>
        </div>

        <div class="form-group" style="margin-bottom:16px;">
            <textarea name="description" class="form-textarea" placeholder="Описание" rows="4"></textarea>
        </div>

        <div class="admin-form-grid">
            <div class="form-group">
                <label class="form-label">Цена</label>
                <input type="number" name="price" class="form-input" placeholder="50 000" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label class="form-label">Склад</label>
                <input type="number" name="stock" class="form-input" placeholder="100" min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Процент скидки</label>
                <input type="number" name="discount_percent" class="form-input" placeholder="0" min="0" max="100">
            </div>
            <div class="form-group">
                <label class="form-label">Конец скидки</label>
                <input type="date" name="discount_end" class="form-input">
            </div>
        </div>

        <div class="admin-checkboxes" style="margin-bottom:20px;">
            <label class="admin-checkbox-label">
                <input type="checkbox" name="is_new"> Новое
            </label>
            <label class="admin-checkbox-label">
                <input type="checkbox" name="is_popular"> Популярное
            </label>
            <label class="admin-checkbox-label">
                <input type="checkbox" name="is_recommended"> Рекомендуемое
            </label>
        </div>

        <div class="admin-form-grid">
            <div class="form-group">
                <label class="form-label">Категория</label>
                <select name="category_id" class="form-select">
                    <option value="">— Без категории —</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Бренд</label>
                <select name="brand_id" class="form-select">
                    <option value="">— Без бренда —</option>
                    <?php foreach ($brands_list as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn--orange btn--full btn--lg" style="margin-top:8px;">Добавить</button>
    </form>
</div>

<script>
function previewImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('preview');
        const icon = document.getElementById('upload-icon');
        const text = document.getElementById('upload-text');
        img.src = e.target.result;
        img.style.display = 'block';
        icon.style.display = 'none';
        text.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
