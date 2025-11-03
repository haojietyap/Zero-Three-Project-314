<?php
// Entity/Request.php

class Request {
    public int $id;
    public int $userID;
    public string $title;
    public string $status;
    public string $createdAt;

    private static array $requests = [];

    public function __construct($id, $userID, $title, $status, $createdAt) {
        $this->id = $id;
        $this->userID = $userID;
        $this->title = $title;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    // Mimics a DB search
    public static function findByUserID(int $userID): array {
        $results = [];
        foreach (self::$requests as $request) {
            if ($request->userID === $userID) {
                $results[] = $request;
            }
        }
        return $results;
    }

    // Used by seed.php to populate sample data
    public static function seed(array $data) {
        self::$requests = [];
        foreach ($data as $row) {
            self::$requests[] = new Request(
                $row['id'],
                $row['userID'],
                $row['title'],
                $row['status'],
                $row['createdAt']
            );
        }
    }
}
?>
