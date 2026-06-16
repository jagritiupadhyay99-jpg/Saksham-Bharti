<?php
// frontend/save_chat_inquiry.php
require_once '../backend/config/db.php';
require_once '../backend/includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Rate Limiting: Max 5 chat inquiries per minute per session
    if (!check_rate_limit('chatbot', 5, 60)) {
        http_response_code(429);
        echo json_encode(['success' => false, 'error' => 'Too many requests. Please wait a minute.']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    
    $name = !empty($data['name']) ? sanitize_input($data['name']) : 'Website Visitor';
    $email = !empty($data['contact']) ? sanitize_input($data['contact']) : 'Not provided';
    $message = "CHATBOT INQUIRY: " . sanitize_input($data['message'] ?? '');

    if (!empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message, read_status) VALUES (?, ?, ?, 0)");
            $stmt->execute([$name, $email, $message]);

            
            $subject = "New Chatbot Inquiry from $name";
            $body = "<strong>Name:</strong> $name<br><strong>Email/Contact:</strong> $email<br><strong>Message:</strong><br>" . nl2br($message);
            send_notification_email($subject, $body);

            // Send confirmation to user if email is valid
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user_subject = "We received your message - Saksham Bharti";
                $user_body = "<p>Thank you for reaching out to us via our chatbot. We have received your inquiry and our team will get back to you shortly.</p>
                              <p><strong>Your Inquiry:</strong><br>" . nl2br($data['message'] ?? '') . "</p>";
                send_user_email($email, $name, $user_subject, $user_body);
            }

            echo json_encode(['success' => true]);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
}

echo json_encode(['success' => false, 'error' => 'Invalid request']);
