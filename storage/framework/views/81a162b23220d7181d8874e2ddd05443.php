<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/layouts/css/base_layout.css')); ?>">
</head>
<body>
    <header class="layout-header">
        <div>
            <a href="#" id="main_link_header"><?php echo e(config('app.name')); ?></a>
        </div>
        <div>

        </div>
    </header>
    <div class="layout-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <footer class="layout-footer">
        <div>
            <div>
                <a href="#" id="main_link_footer"><?php echo e(config('app.name')); ?></a>
            </div>
        </div>
    </footer>
    <div class="d-none">
        <?php echo $__env->yieldContent('js_files'); ?>
    </div>
</body>
</html>
<?php /**PATH /var/app/app/Providers/../views/layouts//main_layout.blade.php ENDPATH**/ ?>