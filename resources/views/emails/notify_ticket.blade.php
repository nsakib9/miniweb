<!DOCTYPE html>
<html>

<head>
    <title>LAMPPOINT CLUB</title>
</head>

<body>
    <h1>You have a new Ticket.</h1>
    <p>Your Total Tickets: {{ $details['tickets'] }}</p>
    <p>Your Total Points: {{ $details['total_points'] }}</p>
    <p><a href="{{ route('point.log', [encrypt(Auth::user()->id)]) }}">{{ route('point.log', [encrypt(Auth::user()->id)]) }}
        </a>
    </p>
    <p>Thank you</p>
</body>

</html>
