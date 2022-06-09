<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admin Setting</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-center">
        <h6 class="m-0 font-weight-bold text-primary">Cache Setting</h6>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <?= session()->getFlashdata('pesan'); ?>
        <?php endif; ?>
        <div class="row mb-3">
            <div class="col">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-cache-list-tab" data-toggle="tab" href="#nav-cache-list" role="tab" aria-controls="nav-cache-list" aria-selected="false">Cache List</a>
                        <a class="nav-link" id="nav-all-cache-tab" data-toggle="tab" href="#nav-all-cache" role="tab" aria-controls="nav-all-cache" aria-selected="false">Clear All Cache</a>
                        <a class="nav-link" id="nav-one-cache-tab" data-toggle="tab" href="#nav-one-cache" role="tab" aria-controls="nav-one-cache" aria-selected="false">Clear One Cache</a>
                        <a class="nav-link" id="nav-prefix-cache-tab" data-toggle="tab" href="#nav-prefix-cache" role="tab" aria-controls="nav-prefix-cache" aria-selected="false">Clear Prefix Cache</a>
                    </div>
                </nav>
            </div>
        </div>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-cache-list" role="tabpanel" aria-labelledby="nav-cache-list-tab">
                <div class="mb-2 table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($cache->getCacheInfo() as $c) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $c['name']; ?></td>
                                    <td><?= date('Y-m-d H:i:s', $c['date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade show" id="nav-all-cache" role="tabpanel" aria-labelledby="nav-all-cache-tab">
                <div class="mb-2">
                    <form action="/admin/setting/cache" method="post">
                        <input type="hidden" name="key" value="allDataCache">
                        <button class="btn btn-primary btn-icon-split mt-1 btn-sm" type="submit">
                            <span class="icon">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text ml-2"> Clear All Cache</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade show" id="nav-one-cache" role="tabpanel" aria-labelledby="nav-one-cache-tab">
                <div class="mb-2">
                    <form action="/admin/setting/cache" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="keyCache" class="form-control" placeholder="Cache name" required>
                        </div>
                        <input type="hidden" name="key" value="oneDataCache">
                        <button class="btn btn-primary btn-icon-split mt-1 btn-sm" type="submit">
                            <span class="icon">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text ml-2"> Clear One Cache</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade show" id="nav-prefix-cache" role="tabpanel" aria-labelledby="nav-prefix-cache-tab">
                <div class="mb-2">
                    <form action="/admin/setting/cache" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="keyCache" class="form-control" placeholder="Cache name" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="setup" id="prefix" value="prefix" checked>
                                <label class="form-check-label" for="prefix">
                                    Prefix/Akhir*
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setup" id="suffix" value="suffix">
                                <label class="form-check-label" for="suffix">
                                    *Suffix/Awal
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="key" value="prefixDataCache">
                        <button class="btn btn-primary btn-icon-split mt-1 btn-sm" type="submit">
                            <span class="icon">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text ml-2"> Clear Prefix Cache</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>