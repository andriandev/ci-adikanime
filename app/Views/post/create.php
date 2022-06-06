<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Post</h1>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="/post/save" method="post">
                    <label for="title">Title</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : ''; ?>" id="title" name="title">
                        <div class="invalid-feedback">
                            <?= $validation->getError('title'); ?>
                        </div>
                    </div>
                    <label for="url_request">Url Request</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('url_request')) ? 'is-invalid' : ''; ?>" id="url_request" name="url_request">
                        <div class="invalid-feedback">
                            <?= $validation->getError('url_request'); ?>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="form-check mr-3">
                            <input class="form-check-input <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" type="radio" name="status" id="publish" value="publish" checked>
                            <label class="form-check-label" for="publish">
                                Publish
                            </label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('status'); ?>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" type="radio" name="status" id="private" value="private">
                            <label class="form-check-label" for="private">
                                Private
                            </label>
                        </div>
                    </div>
                    <label for="post-content">Content</label>
                    <div class="input-group mb-3">
                        <textarea rows="10" class="form-control <?= ($validation->hasError('content')) ? 'is-invalid' : ''; ?>" id="post-content" name="content"></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('content'); ?>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <button class="btn btn-primary" id="get-data" type="button">Get Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const btnGetData = document.querySelector('#get-data');
    const content = document.querySelector('#post-content');
    btnGetData.addEventListener('click', async () => {
        const urlService = 'https://node.andriandev.my.id/scrap/getalleps?url=';
        const urlRequest = document.querySelector('#url_request');
        btnGetData.setAttribute('disabled', true);
        await fetch(urlService + urlRequest.value)
            .then(response => response.json())
            .then(response => {
                content.innerHTML = response;
            })
            .catch((e) => {
                console.log(e);
            })
            .finally(() => {
                btnGetData.removeAttribute('disabled');
            })
    })
</script>
<!-- End Content -->
<?= $this->endSection(); ?>