@extends('dashboard')

@section('title', 'Statistiques')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')
    <h1 class="mb-4 text-primary">Statistiques de l'Instructeur</h1>

    {{-- Graphique en barres pleine largeur --}}
    <div class="mb-5 w-100" style="height: 400px;">
        <canvas id="statsChart" style="width: 100%; height: 100%;"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statsChart').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Cours', 'Leçons', 'Étudiants acheteurs', 'Catégories'],
                    datasets: [{
                        label: 'Nombre',
                        data: [{{ $courseCount }}, {{ $lessonCount }}, {{ $studentCount }},
                            {{ $categoryCount }}
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Permet de remplir tout le conteneur
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>


    {{-- Tableau récapitulatif --}}
    <div class="mt-4">
        <h3 class="text-secondary mb-3">Résumé général</h3>
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Élément</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cours</td>
                    <td>{{ $courseCount }}</td>
                </tr>
                <tr>
                    <td>Leçons</td>
                    <td>{{ $lessonCount }}</td>
                </tr>
                <tr>
                    <td>Étudiants ayant acheté</td>
                    <td>{{ $studentCount }}</td>
                </tr>
                <tr>
                    <td>Catégories</td>
                    <td>{{ $categoryCount }}</td>
                </tr>
                <tr class="table-info font-weight-bold">
                    <td>Total</td>
                    <td>{{ $courseCount + $lessonCount + $studentCount + $categoryCount }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Liste des étudiants ayant acheté --}}
    <div class="mt-5">
        <h3 class="text-secondary mb-3">Étudiants ayant acheté au moins un cours</h3>
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Nombre d’achats</th>
                </tr>
            </thead>
            <tbody>
                @php $totalStudentPurchases = 0; @endphp
                @foreach ($students as $student)
                    @php
                        $purchases = $orders->where('user_id', $student->id)->count();
                        $totalStudentPurchases += $purchases;
                    @endphp
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $purchases }}</td>
                    </tr>
                @endforeach
                <tr class="table-info font-weight-bold">
                    <td colspan="2">Total</td>
                    <td>{{ $totalStudentPurchases }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Liste des cours achetés --}}
    <div class="mt-5">
        <h3 class="text-secondary mb-3">Cours vendus</h3>
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Titre</th>
                    <th>Nombre de ventes</th>
                    <th>Montant total (€)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotalAmount = 0;
                    $grandTotalSales = 0;
                @endphp
                @foreach ($coursesBought as $course)
                    @php
                        $sales = $orders->where('course_id', $course->id)->count();
                        $amount = $orders->where('course_id', $course->id)->sum('total_price');
                        $grandTotalAmount += $amount;
                        $grandTotalSales += $sales;
                    @endphp
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $sales }}</td>
                        <td>{{ number_format($amount, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="table-info font-weight-bold">
                    <td>Total</td>
                    <td>{{ $grandTotalSales }}</td>
                    <td>€{{ number_format($grandTotalAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
