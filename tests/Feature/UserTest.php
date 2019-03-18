<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    
    use DatabaseMigrations;
    
    public function testNewUserRegistration()
    {
        $this->visit('/register')
             ->type('Jamaaka', 'name')
             ->type('Jamaaka@sunflower.po', 'email')
             ->type('Yeahman123', 'password')
             //->check('terms')
             ->press('Register')
             ->seePageIs('/dashboard');
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUser()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'kert.mottus@gmail.com'
        ]);
    }
}
