<!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\emails\invitation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>You're Invited!</title>
</head>
<body>
    <h1>You're Invited to {{ $eventName }}</h1>
    <p>We are excited to invite you to our event. Please RSVP using the link below:</p>
    <a href="{{ route('attendee.rsvp', ['link' => $rsvpLink]) }}">RSVP Now</a>

    @if ($seatType === 'VVIP' || $seatType === 'VIP')
        <p>Your seat type: <strong>{{ $seatType }}</strong></p>
        <p>Your seat number: <strong>{{ $seatNumber }}</strong></p>
    @endif

    <p>We look forward to seeing you there!</p>
</body>
</html>