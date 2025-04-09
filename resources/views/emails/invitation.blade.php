<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're Invited!</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 15px 0;
        }

        a {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2980b9;
        }

        .seat-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }

        .seat-info p {
            margin: 10px 0;
        }

        .event-details {
            background-color: #ecf0f1;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .event-details p {
            margin: 10px 0;
        }

        .event-dates {
            text-align: center;
            margin-top: 30px;
        }

        .event-dates span {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
    <h1>You're Invited to {{ $eventName }}</h1>
        <p>We are excited to invite you to our event. Please RSVP using the link below:</p>
        <a href="{{ route('attendee.rsvp', ['link' => $rsvpLink]) }}">RSVP Now</a>

        @if ($seatType === 'VVIP' || $seatType === 'VIP')
            <div class="seat-info">
                <p><strong>Your seat type:</strong> {{ $seatType }}</p>
                <p><strong>Your seat number:</strong> {{ $seatNumber }}</p>
            </div>
        @endif

        <div class="event-details">
            <p><strong>Event Start:</strong> {{ $date_start }} at {{ $time_start }}</p>
            <p><strong>Event End:</strong> {{ $date_end }} at {{ $time_end }}</p>
        </div>

        <div class="event-dates">
            <span>{{ $date_start }} - {{ $date_end }}</span>
        </div>

        <p>We look forward to seeing you there!</p>
    </div>

</body>
</html>
