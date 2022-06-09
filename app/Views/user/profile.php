<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <?= session()->getFlashdata('pesan'); ?>
                <?php endif; ?>
                <form action="/profile/update" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <label for="username">Username</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" required value="<?= $user['username']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username'); ?>
                        </div>
                    </div>
                    <label for="password">Password</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin diganti">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password'); ?>
                        </div>
                    </div>
                    <label for="email">Email</label>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" required value="<?= $user['email']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('email'); ?>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?= $this->endSection(); ?>