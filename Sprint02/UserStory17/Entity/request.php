<?php
class Request {
    public int $id;
    public string $title;
    public string $status;
    public string $createdAt;

    public function __construct($id, $title, $status, $createdAt) {
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    // Simulated data store
    private static array $requests = [];

    // Called by seed.php
    public static function seed(array $data) {
        self::$requests = $data;
    }

    public static function searchByUser(int $userID, array $criteria): array {
        $results = [];

        foreach (self::$requests as $req) {
            if ($req['userID'] !== $userID) continue;

            $match = true;
            foreach ($criteria as $key => $value) {
                if (!empty($value) && stripos($req[$key], $value) === false) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                $results[] = new Request($req['id'], $req['title'], $req['status'], $req['createdAt']);
            }
        }

        return $results;
    }
}
