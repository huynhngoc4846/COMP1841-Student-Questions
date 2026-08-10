<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h1 class="h2">Manage Questions</h1><p class="text-muted">Add, edit and delete student questions.</p></div>
    <a class="btn btn-primary" href="<?= BASE_URL ?>/post/create">New Question</a>
</div>
<div class="table-responsive bg-white rounded shadow-sm">
<table class="table table-hover align-middle mb-0">
<thead><tr><th>Question</th><th>User</th><th>Module</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($posts as $post): ?>
<tr>
<td><?= htmlspecialchars($post['title']) ?></td>
<td><?= htmlspecialchars($post['author_name']) ?></td>
<td><?= htmlspecialchars($post['module_name']) ?></td>
<td><a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/post/edit/<?= $post['id'] ?>">Edit</a>
<form class="d-inline" method="POST" action="<?= BASE_URL ?>/post/delete/<?= $post['id'] ?>" onsubmit="return confirm('Delete this question?')"><button class="btn btn-sm btn-outline-danger">Delete</button></form></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
