<div class="p-4 p-md-5 mb-4 rounded-3 bg-white shadow-sm">
    <h1>Student Questions</h1>
    <p class="lead mb-3">Browse questions from students across modules.</p>
    <a class="btn btn-primary" href="<?= BASE_URL ?>/post/create">Post a question</a>
</div>
<div class="row g-4">
    <?php foreach ($posts as $post): ?>
        <article class="col-md-6">
            <div class="card h-100 shadow-sm">
                <?php if (!empty($post['image'])): ?>
                    <img class="card-img-top post-image" src="<?= PUBLIC_FOLDER ?>/uploads/<?= htmlspecialchars($post['image']) ?>" alt="Question screenshot">
                <?php endif; ?>
                <div class="card-body">
                    <p class="text-primary fw-semibold"><?= htmlspecialchars($post['module_name']) ?></p>
                    <h2 class="h5"><?= htmlspecialchars($post['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                </div>
                <div class="card-footer bg-white">Posted by <?= htmlspecialchars($post['author_name']) ?></div>
            </div>
        </article>
    <?php endforeach; ?>
</div>
