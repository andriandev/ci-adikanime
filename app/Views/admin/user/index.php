<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manage Users</h1>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">Daftar User</h6>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <?= session()->getFlashdata('pesan'); ?>
                <?php endif; ?>
                <ul class="list-inline">
                    <li class="list-inline-item">Total page : <?= $totalPage; ?></li>
                    <li class="list-inline-item">Total user : <?= $totalUser; ?></li>
                    <li class="list-inline-item"><a href="/admin/user/create"><button class="btn btn-primary btn-sm">Create User</button></a></li>
                </ul>
                <div class="table-responsive">
                    <table class="table table-stripped table-bordered text-nowrap text-center">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Active</th>
                                <th scope="col">Created</th>
                                <th scope="col">Updated</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <th scope="row"><?= $offset++ + 1; ?></th>
                                    <td><?= $user['username']; ?></td>
                                    <td><?= $user['email']; ?></td>
                                    <td><?= $user['role']; ?></td>
                                    <td><?= $user['active']; ?></td>
                                    <td><?= $user['created_at']; ?></td>
                                    <td><?= $user['updated_at']; ?></td>
                                    <td><a class="btn btn-primary btn-sm" href="/admin/user/edit/<?= $user['id']; ?>">Edit</a> <a class="btn btn-danger btn-sm" href="/admin/user/delete/<?= $user['id']; ?>">Delete</a></td>
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