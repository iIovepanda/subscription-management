@foreach ($subscriptions as $sub)
    <p>{{ $sub->name }} - {{ $sub->price }}円</p>
@endforeach
