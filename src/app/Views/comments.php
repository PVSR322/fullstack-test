<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Comments</h1>

    <!-- Сортировка комментариев -->
    <div class="mb-4">
        <h4>Sort By:</h4>
        <a href="?sort_field=id&sort_order=<?= $sortOrder == 'ASC' ? 'DESC' : 'ASC' ?>" class="btn btn-info">ID</a>
        <a href="?sort_field=date&sort_order=<?= $sortOrder == 'ASC' ? 'DESC' : 'ASC' ?>" class="btn btn-info">Date</a>
    </div>

    <!-- Список комментариев -->
    <div id="comments-list">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="card mb-3 comment-item" data-id="<?= esc($comment['id']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($comment['name']) ?></h5>
                        <p class="card-text"><?= esc($comment['text']) ?></p>
                        <p class="card-text"><small class="text-muted">Posted on <?= esc($comment['date']) ?></small></p>
                        <button class="btn btn-danger delete-comment">Delete</button>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif ?>
    </div>

    <!-- Пагинация -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&sort_field=<?= $sortField ?>&sort_order=<?= $sortOrder ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor ?>
        </ul>
    </nav>

    <h2 class="text-center">Add comment</h2>

    <!-- Форма для добавления комментария -->
    <div class="card mb-4">
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p><?= esc($error) ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <form id="commentForm" method="post">
                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="email" class="form-control" id="name" name="name" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="text">Comment</label>
                    <textarea class="form-control" id="text" name="text" rows="3" minlength="3" maxlength="256" placeholder="Enter comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </form>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        // Обработчик формы для добавления комментариев (AJAX)
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '/comments/add', // Путь к методу добавления комментария
                data: $(this).serialize(),
                success: function(response) {
                    if (response.redirect) {
                        // Если сервер вернул URL для редиректа, выполняем перенаправление
                        window.location.href = response.redirect;
                    }else {
                        // Добавляем новый комментарий в список
                        $('#comments-list').append(`
                        <div class="card mb-3 comment-item" data-id="${response.id}">
                            <div class="card-body">
                                <h5 class="card-title">${response.name}</h5>
                                <p class="card-text">${response.text}</p>
                                <p class="card-text"><small class="text-muted">Posted on ${response.date}</small></p>
                                <button class="btn btn-danger delete-comment">Delete</button>
                            </div>
                        </div>
                    `);
                        // Очищаем форму
                        $('#commentForm')[0].reset();
                    }
                },
                error: function(xhr) {
                    alert('Ошибка: ' + xhr.responseText);
                }
            });
        });

        // Обработчик для удаления комментариев
        $(document).on('click', '.delete-comment', function() {
            var commentId = $(this).closest('.comment-item').data('id'); // Получаем ID комментария

            if (confirm('Вы уверены, что хотите удалить этот комментарий?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/comments/' + commentId, // Путь к методу удаления
                    success: function(response) {
                        // Удаляем элемент комментария из списка
                        $(`.comment-item[data-id="${commentId}"]`).remove();
                    },
                    error: function(xhr) {
                        alert('Ошибка: ' + xhr.responseText);
                    }
                });
            }
        });
    });
</script>
</body>
</html>
