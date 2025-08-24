@extends('admin.dashboard')

@section('title', 'Mes achats')

@section('navbar')
<div class="bg-white border-bottom py-3 px-4">
    <h1 class="text-dark h4 m-0 fw-bold">@yield('title')</h1>
</div>
@endsection

@section('container')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cours</th>
                        <th>Prix</th>
                        <th>Status</th>
                        <th>Date d'achat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->course->title ?? 'Cours supprimé' }}</td>
                            <td>{{ number_format($order->amount / 100, 2) }} {{ $order->currency }}</td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun achat trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
