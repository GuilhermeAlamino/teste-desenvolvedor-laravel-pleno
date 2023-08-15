<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\User;

class UserControllerTest extends TestCase
{

  public function testLogin()
  {

    $existingUser = User::where('email', 'root@root.com')->first();

    $this->actingAs($existingUser);

    $response = $this->get('/dashboard');

    $response->assertViewIs('admin.dashboard');
  }

  public function testLogout()
  {
    $existingUser = User::where('email', 'root@root.com')->first();

    $this->actingAs($existingUser);

    $response = $this->post('/logout');

    $response = $this->get('/login');

    $response->assertViewIs('admin.auth.login');
  }
}
