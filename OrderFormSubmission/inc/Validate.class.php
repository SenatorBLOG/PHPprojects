<?php
//Mikhail Senatorov 300407626

class Validate {
    static $valid_status = [];

    static function validateForm() {
        self::$valid_status = []; // очищаем перед новой валидацией

        // Name
        $validName = trim($_POST['fullName'] ?? '');
        if (empty($validName)) {
            self::$valid_status['Name Error'] = "Please enter a valid name";
        }

        // Email
        $validEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$validEmail) {
            self::$valid_status['Email Error'] = "Please enter a valid email address";
        }

        // Phone
        $validPhone = filter_input(INPUT_POST, 'phoneNumber', FILTER_VALIDATE_REGEXP, [
            "options" => ["regexp" => "/^\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/"]
        ]);
        if (!$validPhone) {
            self::$valid_status['Phone Error'] = "Please enter a valid 10 digits phone number";
        }

        // Amount
        $validAmount = filter_input(INPUT_POST, 'productAmount', FILTER_VALIDATE_INT, [
            "options" => ["min_range" => 1, "max_range" => 6]
        ]);
        if (!$validAmount) {
            self::$valid_status['Amount Error'] = "Please enter a valid product amount (1–6)";
        }

        // Gift Wrap
        if (!isset($_POST['giftWrap'])) {
            self::$valid_status['Gift Wrap Error'] = "Please select a gift wrap option";
        }

        // Shipping
        if (!isset($_POST['shipping']) || $_POST['shipping'] === 'Select...') {
            self::$valid_status['Shipping Error'] = "Please select a shipping option";
        }

        return self::$valid_status;
    }
}
