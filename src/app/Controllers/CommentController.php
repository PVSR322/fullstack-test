<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\Controller;

class CommentController extends Controller
{
    protected $commentModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
    }

    // Метод для отображения страницы с комментариями, пагинацией и сортировкой
    public function index()
    {
        // Параметры из GET
        $sortField = $this->request->getGet('sort_field') ?? 'id'; // (по умолчанию id)
        $sortOrder = $this->request->getGet('sort_order') ?? 'ASC'; // (по умолчанию по возрастанию)
        $page = $this->request->getGet('page') ?? 1; // (по умолчанию 1)

        $perPage = 3; // На одной странице


        $comments = $this->commentModel->getComments($perPage, ($page - 1) * $perPage, $sortField, $sortOrder);

        // Общее количество
        $totalComments = $this->commentModel->countComments();

        // Общее количество страниц
        $totalPages = ceil($totalComments / $perPage);


        return view('comments', [
            'comments' => $comments,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Метод для добавления нового комментария
    public function add()
    {


        // Данные из POST
        $data = [
            'name' => $this->request->getPost('name'),
            'text' => $this->request->getPost('text'),
            'date' => date('Y-m-d H:i:s') // Текущ время
        ];

        $totalComments = $this->commentModel->countComments();

        if ($totalComments % 3 == 0 && $totalComments > 0) {
            // Если уже есть 3 комментария, добавляем новый и перенаправляем на новую страницу
            $this->commentModel->insert($data);
            return $this->response->setJSON(['redirect' => '/comments?page=' . (($totalComments / 3) + 1)]); // Возвращаем URL для редиректа
        } else {
        // Валидация
        if ($this->commentModel->insert($data)) {
            return $this->response->setJSON([
                'id' => $this->commentModel->insertID(),
                'name' => $data['name'],
                'text' => $data['text'],
                'date' => $data['date']
            ]);
        } else {
            return $this->response->setStatusCode(400, 'Ошибка добавления комментария.');
        }
        }
    }

    // Метод для удаления комментария
    public function delete($id) {
        if ($this->commentModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Ошибка удаления комментария.']);
        }
    }
}
