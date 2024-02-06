<?php
namespace App\Repositories;
use App\Models\Comment;


class CommentRepository {

    public function getComments(int $id){
        return Comment::all()->where("issue_id", "=", $id);
    }

}