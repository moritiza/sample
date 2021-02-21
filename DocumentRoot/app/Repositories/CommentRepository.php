<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Models\Comment;

class CommentRepository
{
    /**
     * Get all comments
     *
     * @return false
     */
    public function getAllComments()
    {
        try {
            return Comment::paginate(10);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Comment Repository (getAllComments method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Update comment by id
     *
     * @param int $commentID
     * @param array $comment
     * @return bool
     */
    public function updateByID(int $commentID, array $comment)
    {
        try {
            return Comment::where('id', '=', $commentID)->update($comment);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Comment Repository (updateByID method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Create new comment
     *
     * @param array $comment
     * @return false|int
     */
    public function create(array $comment)
    {
        try {
            return Comment::create($comment);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Comment Repository (create method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }
}
