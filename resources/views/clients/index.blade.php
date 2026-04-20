<!DOCTYPE html>
<html>
<head>
    <title>Clients</title>
</head>
<body>

    <h1>My Clients</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2>Add Client</h2>

    <form method="POST" action="{{ route('clients.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="company" placeholder="Company">
        <textarea name="notes" placeholder="Notes"></textarea>

        <button type="submit">Add Client</button>
    </form>

    <h2>Client List</h2>

    <ul>
        @foreach($clients as $client)
            <li>
                {{ $client->name }} - {{ $client->email ?? 'No email' }}
            </li>
        @endforeach
    </ul>

</body>
</html>