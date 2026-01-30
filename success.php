<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed | Safari Tours</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Special styles for the success page */
        .success-box { 
            text-align: center; 
            padding: 60px 40px; 
            margin-top: 50px; 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            border-top: 8px solid #2e7d32;
        }
        .checkmark { 
            font-size: 90px; 
            color: #2e7d32; 
            margin-bottom: 20px;
        }
        .btn-group {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .btn-home { 
            background: #1b5e20; 
            color: white; 
            padding: 12px 25px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-print { 
            background: #555; 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-home:hover { background: #2e7d32; }
        .btn-print:hover { background: #333; }

        /* Hide buttons when printing */
        @media print {
            .btn-group, .navbar, footer {
                display: none !important;
            }
            .success-box {
                box-shadow: none;
                border: none;
                margin-top: 0;
            }
        }
    </style>
</head>
<body class="container">

    <div class="success-box">
        <div class="checkmark">✔</div>
        <h1>Booking Confirmed!</h1>
        <p style="font-size: 1.2rem; color: #555;">Thank you for choosing <strong>Safari Tours Kenya</strong>.</p>
        
        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 30px 0; text-align: left; border-left: 5px solid #ff8f00;">
            <p><strong>What happens next?</strong></p>
            <ul style="line-height: 1.8;">
                <li>Check your email inbox for an automated confirmation.</li>
                <li>One of our travel consultants will call you to verify your details.</li>
                <li>You will receive a final itinerary and payment invoice via email.</li>
            </ul>
        </div>

        <p>Need a copy for your records? Use the print button below.</p>

        <div class="btn-group">
            <a href="index.php" class="btn-home">Return to Home</a>
            <button onclick="window.print()" class="btn-print">🖨️ Print Confirmation</button>
        </div>
    </div>

    <footer style="text-align: center; margin-top: 40px; color: #888;">
        <p>&copy; 2026 Safari Tours - Adventure Awaits</p>
    </footer>

</body>
</html>
