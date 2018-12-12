<?php

namespace Tests\Browser\Task;

use App\Models\Task;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class TaskValidationTest extends DuskTestCase
{
    /** @test */
    public function taskRequiredValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/task') // Kunjungi halaman /task
                    ->type('task', '') // Masukkan inputan input[type="text", name="task"]
                    ->press('Submit Task') // Tekan tombol input[type="submit", value="Submit Task"]
                    ->assertPathIs('/task'); // Kembalikan ke halaman /task
        });
    }

    /** @test */
    public function taskMinValidation()
    {
        /**
         * Mengikuti method taskRequiredValidation()
         * Sekarang posisi di halaman /task
         */
        $this->browse(function (Browser $browser) {
            $browser->type('task', 'asd') // Masukkan inputan input[type="text", name="task"]
                    ->press('Submit Task') // Tekan tombol input[type="submit", value="Submit Task"]
                    ->assertPathIs('/task'); // Kembalikan ke halaman /task
        });
    }

    /** @test */
    public function taskMaxValidation()
    {
        /**
         * Mengikuti method taskMinValidation()
         * Sekarang posisi di halaman /task
         */
        $this->browse(function (Browser $browser) {
            $browser->type('task', str_repeat('John Thor ', 26)) // Masukkan inputan input[type="text", name="task"]
                    ->press('Submit Task') // Tekan tombol input[type="submit", value="Submit Task"]
                    ->assertPathIs('/task'); // Kembalikan ke halaman /task
        });
    }

    /** @test */
    public function taskUniqueValidation()
    {
        /**
         * Mengikuti method taskMaxValidation()
         * Sekarang posisi di halaman /task
         * Input sebuah task ke dalam database
         */
        $task = factory(Task::class)->create();

        $this->browse(function (Browser $browser) use ($task) {
            $browser->type('task', $task->name) // Masukkan inputan input[type="text", name="task"]
                    ->press('Submit Task') // Tekan tombol input[type="submit", value="Submit Task"]
                    ->assertPathIs('/task'); // Kembalikan ke halaman /task
        });
    }
}
