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
                <form action="/admin/user/update" method="post">
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
                        <input type="text" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" required value="<?= $user['password']; ?>">
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
                    <div class="input-group mb-3">
                        <label for="role">Role</label>
                        <div class="form-check mx-3">
                            <input class="form-check-input <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" type="radio" name="role" id="member" value="member" <?= $user['role'] == 'member' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="member">
                                Member
                            </label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('role'); ?>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" type="radio" name="role" id="admin" value="admin" <?= $user['role'] == 'admin' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="admin">
                                Admin
                            </label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="active">Active</label>
                        <div class="form-check mx-3">
                            <input class="form-check-input <?= ($validation->hasError('active')) ? 'is-invalid' : ''; ?>" type="radio" name="active" id="0" value="0" <?= $user['active'] == '0' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="0">
                                0
                            </label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('active'); ?>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input <?= ($validation->hasError('active')) ? 'is-invalid' : ''; ?>" type="radio" name="active" id="1" value="1" <?= $user['active'] == '1' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="1">
                                1
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?= $this->endSection(); ?>