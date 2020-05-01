<?php declare(strict_types=1);


namespace Source\Models;

use MongoDB\Collection;
use Source\Core\MongoConnection;
use MongoDB\BSON\ObjectId;

/**
 * Class NotificationDAO
 *
 * @package Source\Models
 */
class NotificationDAO
{
    /** @var Collection */
    private Collection $database;

    /**
     * NotificationDAO constructor.
     *
     * @param MongoConnection $connection
     */
    public function __construct(MongoConnection $connection)
    {
        $this->database = $connection->getConnection()->selectCollection("notifications");
    }

    /**
     * @param Notification $notification
     *
     * @return \MongoDB\InsertOneResult
     */
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

    /**
     * @param Notification $notification
     *
     * @return array
     */
    public function findByProvider(Notification $notification)
    {
        return $this->database->find(["user" => $notification->getUser()],
            [
                "limit" => 20,
                "sort" => ["created_at" => -1]
            ])->toArray();
    }

    /**
     * @param Notification $notification
     *
     * @return array|object|null
     */
    public function update(Notification $notification)
    {
        return $this->database->findOneAndUpdate([
            "user" => $notification->getUser(),
            "_id" => new ObjectId($notification->getId())],
            [
                '$set' => ["read" => true],
            ]);
    }
}
