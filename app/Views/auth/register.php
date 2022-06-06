<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="p-5 card">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Form Register</h1>
            </div>
            <form class="user" action="/register" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-user" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                </div>
                <button class="btn btn-primary btn-user btn-block" type="submit">Register</button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="/login">Ready Account Login!</a>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?= $this->endSection(); ?>