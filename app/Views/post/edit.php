<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Content -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Post</h1>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="/post/update" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="<?= $post['id']; ?>">
                    <label for="title">Title</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?= $post['title']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('title'); ?>
                        </div>
                    </div>
                    <label for="slug">Slug</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('slug')) ? 'is-invalid' : ''; ?>" id="slug" name="slug" value="<?= $post['slug']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('slug'); ?>
                        </div>
                    </div>
                    <label for="url_request">Url Request</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('url_request')) ? 'is-invalid' : ''; ?>" id="url_request" name="url_request" value="<?= $post['url_request']; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('url_request'); ?>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="form-check mr-3">
                            <input class="form-check-input <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" type="radio" name="status" id="publish" value="publish" <?= ($post['status'] == 'publish' ? "checked" : "") ?>>
                            <label class="form-check-label" for="publish">
                                Publish
                            </label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('status'); ?>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" type="radio" name="status" id="private" value="private" <?= ($post['status'] == 'private' ? "checked" : "") ?>>
                            <label class="form-check-label" for="private">
                                Private
                            </label>
                        </div>
                    </div>
                    <label for="content">Content</label>
                    <div class="input-group mb-3">
                        <textarea rows="10" class="form-control <?= ($validation->hasError('content')) ? 'is-invalid' : ''; ?>" id="post-content" name="content"><?= $post['content']; ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('content'); ?>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-small" type="submit">Submit</button>
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