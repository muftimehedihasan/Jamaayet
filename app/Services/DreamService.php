<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DreamService
{
    /**
     * Retrieve all dreams.
     */
    public function getAllDreams()
    {
        $dreams = DB::table(table: 'dreams')->where('user_id', auth()->user()->id)->get();

        $dreams->map(function ($dreams){
            $dreams->created_at = Carbon::make($dreams->created_at);
            $dreams->updated_at = Carbon::make($dreams->updated_at);
        });

        return $dreams;

        // return DB::table('dreams')->get();
    }

    /**
     * Store a new dream.
     */
    public function createDream(array $data)
    {
        return DB::table('dreams')->insert([
            'user_id' => auth()->id(),
            ...$data,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Get a single dream by ID.
     */
    public function getDreamById($id)
    {
        return DB::table('dreams')->where('id', $id)->first();
    }

    /**
     * Update an existing dream.
     */
    public function updateDream($id, array $data)
    {
        return DB::table('dreams')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->update([
                ...$data,
                'updated_at' => now(),
            ]);
    }

    /**
     * Delete a dream.
     */
    public function deleteDream($id)
    {
        return DB::table('dreams')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();
    }
}
