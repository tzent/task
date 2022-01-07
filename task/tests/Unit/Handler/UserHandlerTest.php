<?php

namespace Tests\Unit\Handler;

use App\Handler\UserHandler;
use App\Models\Enums\UserStatus;
use App\Models\User;
use App\Models\UserDetails;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Mockery\MockInterface;
use Tests\TestCase;

class UserHandlerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_edit_user_not_found(): void
    {
        $userRepositoryMock = $this->partialMock(UserRepository::class, function (MockInterface $mock) {
                $mock
                    ->shouldReceive('find')
                    ->once()
                    ->andReturn(null);
            }
        );

        $inTest = new UserHandler($userRepositoryMock);
        $result = $inTest->edit(1, '1234');

        $this->assertNull($result);
        $this->assertTrue($inTest->hasErrors());
    }

    public function test_edit_user_no_details(): void
    {
        $userRepositoryMock = $this->partialMock(UserRepository::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('find')
                ->once()
                ->andReturn(new User([
                    'email' => 'test@example.com',
                    'active' => 0
                ]));
        }
        );

        $inTest = new UserHandler($userRepositoryMock);
        $result = $inTest->edit(1, '1234');

        $this->assertTrue($inTest->hasErrors());
    }

    public function test_edit_user_success(): void
    {
        $userMock = $this->partialMock(User::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('details')
                ->once()
                ->andReturn($this->mock(HasOne::class, function (MockInterface $m) {
                    $m->shouldReceive('first')
                        ->once()
                        ->andReturn(new UserDetails([
                            'active' => UserStatus::INACTIVE
                        ]));
                }));

            $mock
                ->shouldReceive('details')
                ->once()
                ->andReturn($this->mock(HasOne::class, function (MockInterface $m) {
                    $m->shouldReceive('save')
                        ->once()
                        ->andReturn(new UserDetails([
                            'active' => UserStatus::ACTIVE
                        ]));
                }));
        });

        $userRepositoryMock = $this->partialMock(UserRepository::class, function (MockInterface $mock) use ($userMock) {
            $mock
                ->shouldReceive('find')
                ->once()
                ->andReturn($userMock);
            }
        );

        $inTest = new UserHandler($userRepositoryMock);
        $result = $inTest->edit(1, '1234');

        $this->assertFalse($inTest->hasErrors());
    }

    /**
     * @return void
     */
    public function test_delete_user_not_found(): void
    {
        $userRepositoryMock = $this->partialMock(UserRepository::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('find')
                ->once()
                ->andReturn(null);
        }
        );

        $inTest = new UserHandler($userRepositoryMock);
        $result = $inTest->delete(1);

        $this->assertFalse($result);
        $this->assertTrue($inTest->hasErrors());
    }

    public function test_delete_user_has_details(): void
    {
        $userMock = $this->partialMock(User::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('details')
                ->once()
                ->andReturn($this->mock(HasOne::class, function (MockInterface $m) {
                    $m->shouldReceive('first')
                        ->once()
                        ->andReturn(new UserDetails());
                }));
        });

        $userRepositoryMock = $this->partialMock(UserRepository::class, function (MockInterface $mock) use ($userMock) {
            $mock
                ->shouldReceive('find')
                ->once()
                ->andReturn($userMock);
        });

        $inTest = new UserHandler($userRepositoryMock);
        $result = $inTest->delete(1);

        $this->assertFalse($result);
        $this->assertTrue($inTest->hasErrors());
    }

    public function test_delete_user_success(): void
    {
        $userMock = $this->partialMock(User::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('details')
                ->once()
                ->andReturn($this->mock(HasOne::class, function (MockInterface $m) {
                    $m->shouldReceive('first')
                        ->once()
                        ->andReturn(null);
                }));
            $mock
                ->shouldReceive('delete')
                ->once()
                ->andReturn(true);
        });

        $userRepositoryMock = $this->partialMock(UserRepository::class, function (MockInterface $mock) use ($userMock) {
            $mock
                ->shouldReceive('find')
                ->once()
                ->andReturn($userMock);
        });

        $inTest = new UserHandler($userRepositoryMock);
        $result = $inTest->delete(1);

        $this->assertTrue($result);
        $this->assertFalse($inTest->hasErrors());
    }
}
