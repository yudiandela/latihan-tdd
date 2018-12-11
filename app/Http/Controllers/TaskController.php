<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        // Ambil seluruh data task
        $tasks = $task->all();

        /**
        * Tampilkan seluruh daftar isian dari task
        * Yang ada di database
        */
        return view('task.index', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Validasi untuk hasil inputan
         */
        $request->validate([
            'task' => ['required', 'min:6', 'max:255', 'unique:tasks,name']
        ]);

        /**
         * Masukkan data dari inputan
         * ke dalam database
         */
        Task::create([
            'name' => $request->task
        ]);

        /**
         * Kemabalikan ke halaman /task
         * dengan pesan berhasil
         */
        return redirect()->route('task.index')->with('status', 'Berhasil membuat sebuah task');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        // Ambil seluruh data task
        $tasks = $task->all();

        /**
         * Tampilkan halaman edit
         * dengan inputan data task
         */
        return view('task.index', compact('tasks', 'task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        /**
         * Validasi request update
         */
        $request->validate([
            'task' => ['required', 'min:6', 'max:255', 'unique:tasks,name']
        ]);

        /**
         * Masukkan data ke dalam database
         */
        $task->name = $request->task;
        $task->save();

        /**
         * Return kehalaman /task dengan pesan Berhasil
         */
        return redirect()->route('task.index')->with('status', 'Berhasil mengubah task');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // Hapus data task terpilih
        $task->delete();

        /**
         * Return kehalaman /task dengan pesan Berhasil
         */
        return redirect()->route('task.index')->with('status', 'Berhasil menghapus task');
    }
}
