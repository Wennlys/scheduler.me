<?php declare(strict_types=1);


namespace Source\Models;


use Source\Core\MongoConnection;
use MongoDB\Collection;

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
}
