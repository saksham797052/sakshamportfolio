<?php
// This script handles the form submission from portfolio.html

// IMPORTANT: Configure your email address here.
$to = "sakshamsingh797052@gmail.com"; // Your email address where you want to receive messages.

// --- Do not edit below this line unless you know what you are doing ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $msg = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($name) || empty($msg)) {
        http_response_code(400); // Bad Request
        exit('Invalid input. Please fill all fields correctly.');
    }

    // Prepare email
    $subject = "New Contact Form Message from $name";
    $body = "You have received a new message from your portfolio contact form.\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$msg\n";

    // Set headers
    $headers = "From: " . $name . " <" . $email . ">\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        http_response_code(200); // OK
        echo "Message sent successfully!";
    } else {
        http_response_code(500); // Internal Server Error
        echo "Failed to send the message. Please try again later.";
    }
} else {
    // If not a POST request, deny access
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed.";
}
?>
