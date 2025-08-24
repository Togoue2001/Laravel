<form action="{{ isset($coupon) ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}" method="POST"
    class="p-2">
    @csrf
    @if (isset($coupon))
        @method('PUT')
    @endif

    <h4 class="mb-4 text-primary">
        {{ isset($coupon) ? 'Modifier le code promo' : 'Créer un nouveau code promo' }}
    </h4>

    <div class="mb-3">
        <label class="form-label fw-bold">Code</label>
        <input type="text" name="code" class="form-control border-primary" style="border-radius: 8px"
            value="{{ old('code', $coupon->code ?? '') }}" placeholder="EX: PROMO2025" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Utilisateur (laisser vide pour tous)</label>
        <select name="user_id" class="form-select border-primary">
            <option value="">Tous</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('user_id', $coupon->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>

    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Réduction</label>
            <input type="number" step="0.01" name="discount" class="form-control border-primary"
                style="border-radius: 8px" value="{{ old('discount', $coupon->discount ?? '') }}" placeholder="Ex: 20"
                required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Type</label>
            <select name="is_percentage" class="form-select border-primary">
                <option value="1" {{ old('is_percentage', $coupon->is_percentage ?? 1) == 1 ? 'selected' : '' }}>
                    Pourcentage</option>
                <option value="0" {{ old('is_percentage', $coupon->is_percentage ?? 1) == 0 ? 'selected' : '' }}>
                    Montant fixe</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Date d'expiration</label>
        <input type="datetime-local" name="expires_at" class="form-control border-primary" style="border-radius: 8px"
            value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Annuler
        </a>
        <button type="submit" class="btn btn-success px-4">
            {{ isset($coupon) ? 'Mettre à jour' : 'Créer' }}
        </button>
    </div>
</form>
