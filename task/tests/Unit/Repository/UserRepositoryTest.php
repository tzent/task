<?php

namespace Tests\Unit\Repository;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public function test_find_success(): void
    {
        $userMock = $this->partialMock(User::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('find')
                ->once()
                ->andReturn(new User([
                    'id' => 1,
                    'email' => 'test@test.com'
                ]));
        });

        $inTest = new UserRepository($userMock);
        $result = $inTest->find(1);

        $this->assertNotNull($result);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('test@test.com', $result->email);
    }

    public function test_find_failed(): void
    {
        $userMock = $this->partialMock(User::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('find')
                ->once()
                ->andReturn(null);
        });

        $inTest = new UserRepository($userMock);
        $result = $inTest->find(1);

        $this->assertNull($result);
    }

    public function test_find_active_users_by_country_iso2(): void
    {
        $userMock = $this->mock(User::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('whereHas')
                ->once()
                ->andReturn($mock);
            $mock
                ->shouldReceive('where')
                ->once()
                ->andReturn($mock);
            $mock
                ->shouldReceive('get')
                ->once()
                ->andReturn(new Collection([
                    new User([
                        'id' => 1,
                        'email' => 'test@test.com'
                    ]),
                    new User([
                        'id' => 2,
                        'email' => 'test2@test.com'
                    ])
                ]));
        });

        $inTest = new UserRepository($userMock);
        $result = $inTest->findActiveUsersByCountryIso2('AT');

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(2, $result->count());
    }
}
