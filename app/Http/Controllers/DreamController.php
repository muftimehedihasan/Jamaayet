<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\DreamService;
use Illuminate\Support\Facades\DB;

class DreamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(DreamService $dreamService)
    // {
    //     $dreams = $dreamService->getAllDreams();

    //     return view('admin.dreams.index', compact('dreams'));
    // }

     public function index(DreamService $dreamService)
    {
        $dreams = $dreamService->getAllDreams();
        return view('admin.dreams.index', compact('dreams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dreams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'content' => 'required'|'string',
        ]);

        $dream = DB::table('dreams')->insert([
            'user_id' => auth()->user()->id,
            ...$validated,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        if ($dream) {
            return redirect()->route('dreams.index');
        }

    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $dream = DB::table('dreams')->where('id', $id)->first(); 
        if (!$dream) {
            abort(404); 
        }
        return view('admin.dreams.show', compact('dream'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dream = DB::table('dreams')
        
        ->where('id', $id)

        ->where('user_id', auth()->user()->id)

        ->first();

        if (!$dream) {
            return to_route('dreams.index');
        }
        return view('admin.dreams.edit', compact('dream'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $dream = DB::table('dreams')
        ->where('id', $id)
        ->update([
            ...$validated,
            'updated_at'=> now(),
        ]);

        return to_route('dreams.show', $id);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dream = DB::table('dreams') 
            ->where([
                'id' => $id,
                'user_id' => auth()->user()->id
            ])
            ->delete(); // এখানে সঠিকভাবে শেষ হয়েছে ✅
    
        return back();
    }
    
}
