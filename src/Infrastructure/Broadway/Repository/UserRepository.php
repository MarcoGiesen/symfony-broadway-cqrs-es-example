<?php
/**
 * Created by PhpStorm.
 * User: mgiesen
 * Date: 23.11.18
 * Time: 13:43
 */

namespace App\Infrastructure\Broadway\Repository;

use App\Domain\User\Aggregate\User;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\UserId;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;

class UserRepository extends EventSourcingRepository
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new ReflectionAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(User $user): void
    {
        $this->save($user);
    }

    public function get(UserId $id): User
    {
        try {
            /** @var User $user */
            $user = $this->load((string)$id);
        } catch (AggregateNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
