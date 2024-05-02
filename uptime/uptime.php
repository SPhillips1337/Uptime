<?php
// Database credentials
$host = 'localhost'; // Change to your database host
$username = 'your_username'; // Change to your database username
$password = 'your_password'; // Change to your database password
$database = 'your_db'; // Change to your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the record ID from the GET variable (if present)
$recordId = isset($_GET['recordId']) ? intval($_GET['recordId']) : 1;

// Retrieve the URL from the database for record ID
$sql = "SELECT * FROM website_data WHERE id = $recordId";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$targetUrl = $row['url'];

$errorEmailSentDate = $row['error_email_sent'];
$contentEmailSentDate = $row['content_email_sent'];

// Initialize cURL session
$ch = curl_init($targetUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a reasonable timeout

// Execute the cURL request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// fetch content length
// $contentLength = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD); // Using Curl header value doesn't always work sometimes returns -1 for length
$content = file_get_contents($targetUrl);
$contentLength = strlen($content);

// Close cURL session
curl_close($ch);

// Check HTTP status code and content length
if ($httpCode === 500) {
    if ($errorEmailSentDate === date('Y-m-d')) {
        echo "Error email already sent today. No additional email will be sent.\n";
    } else {
        // Send an email notification
        $to = 'your@email.com'; // Replace with your email address
        $subject = 'HTTP 500 Error Detected - '.$targetUrl;
        $message = "The website $targetUrl returned an HTTP 500 error.";
        $headers = 'From: webmaster@example.com' . "\r\n";
    
        // Uncomment the line below to send the email (make sure your server is configured for sending emails)
        mail($to, $subject, $message, $headers);
        echo "Error Email notification sent!";
        
        // Store the content length in the database
        $sql = "UPDATE website_data SET content_length = $contentLength, `error_email_sent` = NOW() WHERE id = $recordId";
        $conn->query($sql);
    }
} else {
    if ($contentEmailSentDate === date('Y-m-d')) {
        echo "Content change email already sent today. No additional email will be sent.\n";
    } else {    
        // Compare content length with the previous value
        $sql = "SELECT content_length FROM website_data WHERE id = $recordId";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $previousContentLength = $row['content_length'];
    
        if (intval($contentLength) !== intval($previousContentLength)) {
            // Send an email notification for content length change
            $to = 'your@email.com'; // Replace with your email address
            $subject = 'Content Change Detected - '.$targetUrl;
            $message = "The content length change for website $targetUrl has changed, which might indicate a problem and should be investigated.\r\n";
            $message = "Previous Content Length: $previousContentLength did not match Current Content Length: $contentLength";
            $headers = 'From: webmaster@example.com' . "\r\n";
        
            // Uncomment the line below to send the email (make sure your server is configured for sending emails)
            mail($to, $subject, $message, $headers);
            echo "Content Email notification sent!";
        
            // Update the content length in the database
            $sql = "UPDATE website_data SET content_length = $contentLength, `content_email_sent` = NOW() WHERE id = $recordId";
            $conn->query($sql);
        }
    }
}

// Close the database connection
$conn->close();

echo "Script executed successfully!";
?>
