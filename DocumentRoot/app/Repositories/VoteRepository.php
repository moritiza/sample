<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Models\Vote;

class VoteRepository
{
    /**
     * Get all votes
     *
     * @return false
     */
    public function getAllVotes()
    {
        try {
            return Vote::paginate(10);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Vote Repository (getAllVotes method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Update vote by id
     *
     * @param int $voteID
     * @param array $vote
     * @return bool
     */
    public function updateByID(int $voteID, array $vote)
    {
        try {
            return Vote::where('id', '=', $voteID)->update($vote);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Vote Repository (updateByID method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }

    /**
     * Create new vote
     *
     * @param array $vote
     * @return false|int
     */
    public function create(array $vote)
    {
        try {
            return Vote::create($vote);
        } catch (\PDOException $e) {
            Log::channel('api_database_exceptions')
                ->emergency(
                    'Occurrence point => Vote Repository (create method) ***** ' .
                    $e->getMessage()
                );

            return false;
        }
    }
}
