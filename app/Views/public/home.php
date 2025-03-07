<?= $this->extend('layout/public/main') ?>

<?= $this->section('content') ?>
    <div class="container my-5">
        <h1>Welcome to My App</h1>
        <p>This is the public home page.</p>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        console.log('Home JS loaded');
        // Thêm JS riêng cho home nếu cần
    </script>
<?= $this->endSection() ?>