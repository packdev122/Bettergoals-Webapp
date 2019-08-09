Hi!

<br><br>

"{{ $invitation->team->name }}" has invited you to join their team. If you are already a member of Better Goals, you'll be able to see the team on your dashboard.
 <br><br>
 If you haven't joined Better Goals yet, you can create a free account using the following link:
<br><br>
<a href="{{ url('register?invitation='.$invitation->token) }}">{{ url('register?invitation='.$invitation->token) }}</a>
<br><br>
Thanks!
<br><br>
Better Goals