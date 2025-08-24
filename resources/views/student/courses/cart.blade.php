@extends('admin.dashboard')

@section('title', 'Panier')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')

    <div class="container mb-2">
        <h1 class="my-2"><strong>@yield('title')</strong></h1>
        <div class="row" id="cart-courses">
            @if (session('cart'))
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Prix</th>
                            <th>Description</th>
                            <th>Total</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach (session('cart') as $key => $details)
                            @php $total += $details['price']; @endphp
                            <tr data-id="{{ $key }}">
                                <td>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h4><strong>{{ $details['name'] }}</strong></h4>
                                        </div>
                                    </div>
                                </td>
                                <td>€{{ $details['price'] }}</td>
                                <td>{{ $details['description'] }}</td>
                                <td class="quantity">€{{ $details['price'] }}</td>
                                <td class="text-end">
                                    <form action="{{ route('student.cart.remove', $key) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment retirer ce cours du panier ?')">Retirer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end" style="font-size: 30px">
                                <h3><strong>Total: &nbsp;€{{ $total }}</strong></h3>
                            </td>
                            <td colspan="2" class="text-end">
                                <form action="{{ route('student.stripe.checkout') }}" method="POST"
                                    class="d-flex align-items-center">
                                    @csrf

                                    <input type="text" id="promo_code" name="promo_code" class="form-control mb-1"
                                        placeholder="Code promo (optionnel)"
                                        style="border: none; outline: none; background-color: #f8f9fa; border-radius: 8px;">&nbsp;&nbsp;

                                    <input type="text" id="receiver_address" name="receiver_address"
                                        class="form-control mb-1" placeholder="Adresse" required
                                        style="border: none; outline: none; background-color: #f8f9fa; border-radius: 8px;">&nbsp;&nbsp;

                                    <input type="text" id="receiver_phone" name="receiver_phone" class="form-control"
                                        placeholder="Téléphone" required
                                        style="border: none; outline: none; background-color: #f8f9fa; border-radius: 8px;">&nbsp;&nbsp;

                                    <button type="submit" class="btn btn-primary btn-sm">Payer</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection
