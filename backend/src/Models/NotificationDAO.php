<?php declare(strict_types=1);


namespace Source\Models;


use MongoDB\Collection;
use Source\Core\MongoConnection;

class NotificationDAO
{
    /** @var Collection */
    private Collection $database;

    public function __construct(MongoConnection $connection)
    {
        $this->database = $connection->getConnection()->selectCollection("notifications");
    }

    public function save(Notification $notification)
    {
        return $this->database->insertOne([
            "user" => $notification->getUser(),
            "content" => $notification->getContent(),
            "read" => $notification->isRead(),
            "created_at" => $notification->getCreatedAt(),
            "updated_at" => $notification->getUpdatedAt()
        ]);
    }

    public function findByProvider(Notification $notification)
    {
        return $this->database->find(["user" => $notification->getUser()],
            [
                "limit" => 20,
                "sort" => ["created_at" => -1]
            ])->toArray();
    }

    public function update(Notification $notification)
    {
        return $this->database->findOneAndUpdate(["user" => $notification->getUser()],
            [
                '$set' => ["read" => true],
            ]);
    }
}
