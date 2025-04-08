<!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\emails\reminder.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Reminder: RSVP for {{ $eventName }}</title>
</head>
<body>
    <h1>Reminder: RSVP for {{ $eventName }}</h1>
    <p>We noticed you haven't RSVP'd yet. Please confirm your attendance using the link below:</p>
    <a href="{{ route('attendee.rsvp', ['link' => $rsvpLink]) }}">RSVP Now</a>
</body>
</html>