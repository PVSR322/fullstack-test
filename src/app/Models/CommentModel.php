<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';


    protected $allowedFields = ['name', 'text', 'date'];

    // Валидация
    protected $validationRules = [
        'name'   => 'required|valid_email', // Валидация как email
        'text'   => 'required|min_length[3]'
    ];

    // Метод для получения комментариев с пагинацией и сортировкой
    public function getComments($limit, $offset, $sortField = 'id', $sortOrder = 'ASC')
    {
        return $this->orderBy($sortField, $sortOrder)
            ->findAll($limit, $offset);
    }

    // Подсчет общего количества комментариев
    public function countComments()
    {
        return $this->countAllResults();
    }
}
