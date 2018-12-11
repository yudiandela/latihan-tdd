<?php

namespace Tests\Browser\Task;

use App\Models\Task;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskCrudTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function getTask()
    {
        /**
         * Input sebuah task ke dalam database
         */
        $task = factory(Task::class)->create();

        $this->browse(function (Browser $browser) use ($task) {
            $browser->visit('/task')            // Kunjungi halaman task
                    ->assertSee($task->name);   // Lihat /task
        });
    }

    /** @test */
    public function createTask()
    {
        /**
         * Mengikuti method getTask()
         * Sekarang posisi di halaman /task
         */
        $this->browse(function (Browser $browser) {
            $browser->type('task', 'New Task Here!')    // Masukkan inputan di dalam input[type="text", name="task"]
                    ->press('Submit Task')              // Tekan tombol dengan teks input[type="submit", value="Submit Task"]
                    ->assertPathIs('/task')             // Redirect halaman /task
                    ->assertSee('Berhasil');            // Lihat pesan Berhasil di dalam halaman
        });
    }

    /** @test */
    public function updateTask()
    {
        /**
         * Mengikuti method createTask()
         * Sekarang posisi di halaman /task
         * Input sebuah task ke dalam database
         */
        $task = factory(Task::class)->create();

        $this->browse(function (Browser $browser) use ($task) {
            $browser->visit('/task/' . $task->id . '/edit') // Kunjungi halaman task/edit dengan id task hasil inputan
                    ->type('task', 'Update Task Here')      // Masukkan inputan di dalam input[type="text", name="task"]
                    ->press('Submit Task')                  // Tekan tombol dengan teks input[type="submit", value="Submit Task"]
                    ->assertPathIs('/task')                 // Redirect halaman /task
                    ->assertSee('Berhasil');                // Lihat pesan Berhasil di dalam halaman
        });
    }

    /** @test */
    public function deleteTask()
    {
        /**
         * Mengikuti method updateTask()
         * Sekarang posisi di halaman /task
         * Input sebuah task ke dalam database
         */
        $task = factory(Task::class)->create();

        $this->browse(function (Browser $browser) use ($task) {
            $browser->clickLink('Delete')       // Klik link <a href="#">Delete</a>
                    ->assertPathIs('/task')     // Redirect ke halaman /task
                    ->assertSee('Berhasil');    // Lihat pesan Berhasil di dalam halaman
        });
    }
}
