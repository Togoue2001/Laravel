@extends('admin.dashboard')

@section('navbar')
    <div class="d-flex justify-content-between align-items-center">
        <h1><strong>Liste des codes promo</strong></h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mb-3">Créer un code promo</a>
    </div>
@endsection

@section('container')
    <div class="container mt-4">
        <h1><strong>Liste des codes promo</strong></h1><br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Utilisateur</th>
                    <th>Réduction</th>
                    <th>Type</th>
                    <th>Expiration</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->id }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->user ? $coupon->user->name : 'Tous' }}</td>
                        <td>{{ $coupon->discount }}</td>
                        <td>{{ $coupon->is_percentage ? '%' : 'Montant fixe' }}</td>
                        <td>{{ $coupon->expires_at ? $coupon->expires_at->format('d/m/Y H:i') : 'Aucune' }}</td>
                        <td>{{ $coupon->is_active ? 'Actif' : 'Inactif' }}</td>
                        <td>
                            <div class="d-flex gap-2 w-100 justify-content-end">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                    class="btn btn-warning btn-sm">Modifier</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Supprimer ce code promo ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $coupons->links() }}
    </div>
@endsection
