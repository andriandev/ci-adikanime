<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="p-5 card">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <?= session()->getFlashdata('pesan'); ?>
            <?php endif; ?>
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Form Login</h1>
            </div>
            <form class="user" action="/login" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                </div>
                <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="/register">Create an Account!</a>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?= $this->endSection(); ?>