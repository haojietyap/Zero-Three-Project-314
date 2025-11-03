<?php
class Request {
    private static $requests = [];

    // Simulate database seeding
    public static function seed($data) {
        self::$requests = $data;
    }

    // Get all requests
    public static function all() {
        return self::$requests;
    }

    // Delete by ID
    public static function deleteByID(int $requestID): bool {
        if (isset(self::$requests[$requestID])) {
            unset(self::$requests[$requestID]);
            return true;
        }
        return false;
    }
}
?>
