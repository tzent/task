<?php

namespace Tests\Feature;

use App\Handler\UserHandler;
use App\Models\Enums\UserStatus;
use App\Models\User;
use App\Models\UserDetails;
use Tests\TestCase;

class UserHandlerTest extends TestCase
{
    /**
     * @var User
     */
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'email' => 'test123@test123.com',
            'active' => UserStatus::INACTIVE
        ]);

        $details = new UserDetails([
            'first_name' => 'TTTTTTT',
            'last_name' => 'LLLLLLLLL',
            'phone_number'=> '123456778',
            'citizenship_country_id' => 1
        ]);

        $this->user->save();
        $this->user->details()->save($details);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $details = $this->user->details()->first();
        $details?->delete();

        $this->user->delete();
    }

    public function test_edit_failed(): void
    {
        $this->user->details()->first()->delete();
        $inTest = $this->app->make(UserHandler::class);
        $result = $inTest->edit($this->user->id, '111111');

        $this->assertTrue($inTest->hasErrors());
        $this->assertInstanceOf(User::class, $result);
        $this->assertNull($result->details()->first());
    }

    public function test_edit_success(): void
    {
        $inTest = $this->app->make(UserHandler::class);
        $result = $inTest->edit($this->user->id, '111111');

        $this->assertFalse($inTest->hasErrors());
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($result->details()->first()->phone_number, '111111');
    }

    public function test_delete_failed(): void
    {
        $inTest = $this->app->make(UserHandler::class);
        $result = $inTest->delete($this->user->id);

        $this->assertTrue($inTest->hasErrors());
        $this->assertFalse($result);
    }

    public function test_delete_success(): void
    {
        $this->user->details()->first()->delete();
        $inTest = $this->app->make(UserHandler::class);
        $result = $inTest->delete($this->user->id);

        $this->assertFalse($inTest->hasErrors());
        $this->assertTrue($result);
    }
}
