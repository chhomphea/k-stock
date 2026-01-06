<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends CI_Controller {
    private $botToken;
    private $channelId;
    private $referenceLat = 11.5159935; // WINTECH SOFTWARE DEVELOPMENT
    private $referenceLng = 104.9350988;

    public function __construct() {
        parent::__construct();
        // Load sensitive data from config or environment
        $this->botToken = $this->config->item('telegram_bot_token') ?: '7956216864:AAE-cW8v98RJUfOGCfOjyxuV1f5iOyMlhWo';
        $this->channelId = $this->config->item('telegram_channel_id') ?: '@helpyoupos';
    }

    public function invite_nearby($lat = 11.5159935, $lng = 104.9350988, $radius_km = 1000) {
        // Validate input parameters
        if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($radius_km)) {
            log_message('error', 'Invalid parameters for invite_nearby: lat=' . $lat . ', lng=' . $lng . ', radius=' . $radius_km);
            echo json_encode(['status' => 'error', 'message' => 'Invalid latitude, longitude, or radius.']);
            return;
        }

        // Get nearby "users" (based on coordinates)
        $nearbyUsers = $this->get_nearby_users($lat, $lng, $radius_km);
        if (empty($nearbyUsers)) {
            echo json_encode(['status' => 'error', 'message' => 'No valid users found near WINTECH SOFTWARE DEVELOPMENT, Phnom Penh.']);
            return;
        }

        // Create Telegram Invite Link
        $inviteLink = $this->create_invite_link();
        var_dump ($inviteLink);
        die();
        if (!$inviteLink) {
            log_message('error', 'Failed to create Telegram invite link.');
            echo json_encode(['status' => 'error', 'message' => 'Failed to create invite link.']);
            return;
        }

        // Send Invite Link to each nearby user
        $sentCount = 0;
        foreach ($nearbyUsers as $user) {
            if ($this->send_message($user->telegram_id, "📢 Join our channel near WINTECH SOFTWARE DEVELOPMENT: $inviteLink")) {
                $sentCount++;
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => "Invites sent to $sentCount user(s) near Phnom Penh."
        ]);
    }

    private function get_nearby_users($lat, $lng, $radius_km) {
        // Sanitize inputs
        $lat = floatval($lat);
        $lng = floatval($lng);
        $radius_km = floatval($radius_km);

        // Validate coordinate ranges
        if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180 || $radius_km <= 0) {
            log_message('error', 'Invalid coordinates or radius: lat=' . $lat . ', lng=' . $lng . ', radius=' . $radius_km);
            return [];
        }

        // Calculate distance to reference point (WINTECH) using Haversine formula
        $distance = 6371 * acos(
            cos(deg2rad($lat)) * cos(deg2rad($this->referenceLat)) *
            cos(deg2rad($this->referenceLng) - deg2rad($lng)) +
            sin(deg2rad($lat)) * sin(deg2rad($this->referenceLat))
        );

        // Check if the input coordinates are within the radius
        if ($distance > $radius_km) {
            log_message('info', 'Coordinates (lat=' . $lat . ', lng=' . $lng . ') are ' . $distance . 'km from WINTECH, outside radius ' . $radius_km . 'km');
            return [];
        }

        // Simulated list of Telegram IDs for nearby users
        // In a real scenario, replace with Telegram API call or external service
        $telegramIds = $this->config->item('nearby_telegram_ids') ?: [
            $this->channelId, // Fallback to channel ID
            // Add more Telegram IDs for testing, e.g., '123456789', '@AnotherUser'
        ];

        // Validate Telegram IDs (basic check)
        $users = [];
        foreach ($telegramIds as $index => $telegramId) {
            if (empty($telegramId) || (!preg_match('/^@[\w]+$/', $telegramId) && !is_numeric($telegramId))) {
                log_message('error', 'Invalid Telegram ID: ' . $telegramId);
                continue;
            }

            $users[] = (object) [
                'id' => $index + 1,
                'name' => 'Nearby User ' . ($index + 1),
                'telegram_id' => $telegramId,
                'latitude' => $lat,
                'longitude' => $lng,
                'distance' => $distance
            ];
        }

        if (empty($users)) {
            log_message('info', 'No valid Telegram IDs available for coordinates (lat=' . $lat . ', lng=' . $lng . ')');
        }

        return $users;
    }

    private function create_invite_link() {
        $url = "https://api.telegram.org/bot{$this->botToken}/createChatInviteLink";
        var_dump ($url);
        die();
        $postData = [
            'chat_id' => $this->channelId,
            'expire_date' => time() + ($this->config->item('invite_link_expiry') ?: 3600),
            'member_limit' => $this->config->item('invite_link_member_limit') ?: 100
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error || $httpCode != 200) {
            log_message('error', 'cURL error in create_invite_link: ' . $error . ', HTTP Code: ' . $httpCode);
            return false;
        }

        $result = json_decode($response, true);

        if (!$result['ok']) {
            log_message('error', 'Telegram API error in create_invite_link: ' . json_encode($result));
            return false;
        }

        return $result['result']['invite_link'];
    }

    private function send_message($chatId, $text) {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error || $httpCode != 200) {
            log_message('error', 'cURL error in send_message: ' . $error . ', HTTP Code: ' . $httpCode);
            return false;
        }

        $result = json_decode($response, true);
        if (!$result['ok']) {
            log_message('error', 'Telegram API error in send_message: ' . json_encode($result));
            return false;
        }

        return true;
    }
}