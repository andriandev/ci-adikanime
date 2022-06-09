<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
            </div>
            <div class="card-body">
                <?php if ($posts !== null) : ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($posts as $p) : ?>
                            <li class="list-group-item"><a href="<?= base_url('/') . '/' . $p['slug']; ?>"><?= $p['title']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?= $paginate; ?>
                <?php else : ?>
                    Hasil pencarian tidak ditemukan
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?= $this->endSection(); ?>