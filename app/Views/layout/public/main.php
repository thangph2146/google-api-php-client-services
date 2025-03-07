<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My Application' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<?= get_header('public') ?>
<main>
    <?= $this->renderSection('content') ?>
</main>
<?= get_footer('public') ?>

<!-- JS chung -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/public.js') ?>"></script>

<!-- JS riêng cho trang (nếu có) -->
<?= $this->renderSection('scripts') ?>
</body>
</html>