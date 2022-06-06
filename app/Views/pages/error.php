<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">404 Page Not Found</h6>
            </div>
            <div class="card-body">
                Halaman tidak ditemukan :)
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?= $this->endSection(); ?>