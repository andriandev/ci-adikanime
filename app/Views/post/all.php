<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Index Post</h1>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                    <?php endif; ?>
                    <ul class="list-inline">
                        <li class="list-inline-item">Total page : <?= $totalPage; ?></li>
                        <li class="list-inline-item">Total post : <?= $totalPost; ?></li>
                        <li class="list-inline-item">Post publish : <?= $postPublish; ?></li>
                        <li class="list-inline-item">Post private : <?= $postPrivate; ?></li>
                    </ul>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created</th>
                                <th scope="col">Updated</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($post as $p) : ?>
                                <tr>
                                    <th scope="row"><?= $offset++ + 1; ?></th>
                                    <td><a href="/<?= $p['slug']; ?>"><?= $p['title']; ?></a></td>
                                    <td><?= $p['status']; ?></td>
                                    <td><?= $p['created_at']; ?></td>
                                    <td><?= $p['updated_at']; ?></td>
                                    <td><a class="btn btn-primary btn-sm" href="/post/edit/<?= $p['slug']; ?>">Edit</a> <a class="btn btn-danger btn-sm" href="/post/delete/<?= $p['slug']; ?>">Delete</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $paginate ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?= $this->endSection(); ?>