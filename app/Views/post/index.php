<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="m-0 font-weight-bold text-primary text-center h6"><?= $title; ?></h1>
            </div>
            <div class="card-body">
                <div class="collapse" id="linkDL">
                    <?= $post['content']; ?>
                </div>
                <button class="btn btn-block btn-primary btnLinkDL" type="button" data-toggle="collapse" data-target="#linkDL">
                    Buka Link Download
                </button>
                <?php if ($post['id_user'] == session()->get('id')) : ?>
                    <a href="/post/edit/<?= $post['slug']; ?>" class="btn btn-block btn-success">
                        Edit Post
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">Anime Lainnya</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($posts as $p) : ?>
                        <li class="list-group-item"><a href="<?= base_url('/') . '/' . $p['slug']; ?>"><?= $p['title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    const btnLinkDL = document.querySelector('.btnLinkDL');
    btnLinkDL.addEventListener('click', () => {
        if (btnLinkDL.innerHTML.trim() == 'Buka Link Download') {
            btnLinkDL.innerHTML = 'Tutup Link Download';
        } else {
            btnLinkDL.innerHTML = 'Buka Link Download';
        }
    })
</script>
<!-- End Content -->
<?= $this->endSection(); ?>