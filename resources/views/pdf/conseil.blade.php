<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Métriques des Conseillers</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        
        .container {
            width: 100%;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            color: #1f2937;
            font-size: 20px;
            margin-bottom: 5px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
        }
        
        .date-info {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th {
            background-color: #3b82f6;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #3b82f6;
        }
        
        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tr:hover {
            background-color: #f0f4ff;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
            text-align: center;
        }
        
        .stats-summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f3f4f6;
            border-left: 4px solid #3b82f6;
            font-size: 10px;
        }
        
        .stats-summary p {
            margin: 5px 0;
        }
        
        .stats-summary strong {
            color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Métriques des Conseillers</h1>
        <div class="date-info">
            <strong>Période:</strong> {{ $dateDebut->format('d/m/Y') }} - {{ $dateFin->format('d/m/Y') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nom du conseiller</th>
                    <th class="text-center">Opp. du jour</th>
                    <th class="text-center">Opp. Traitées</th>
                    <th class="text-center">Renouvellement</th>
                    <th class="text-center">Opp. gagnées</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Taux conversion (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donnees as $row)
                    <tr>
                        <td><strong>{{ $row['nom'] }}</strong></td>
                        <td class="text-center">{{ $row['opp_jour'] }}</td>
                        <td class="text-center">{{ $row['opp_modifiees'] }}</td>
                        <td class="text-center">{{ $row['total_renouvellement'] }}</td>
                        <td class="text-center">{{ $row['opp_gagnees'] }}</td>
                        <td class="text-center">{{ round($row['score'], 2) }}/100</td>
                        <td class="text-center">{{ round($row['taux_conversion'] * 100, 2) }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucune donnée disponible</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($donnees->count() > 0)
            <div class="stats-summary">
                <p><strong>Total opportunités traitées:</strong> {{ $donnees->sum('opp_modifiees') }}</p>
                <p><strong>Total opportunités gagnées:</strong> {{ $donnees->sum('opp_gagnees') }}</p>
                <p><strong>Taux conversion moyen:</strong> {{ round($donnees->avg('taux_conversion') * 100, 2) }}%</p>
                <p><strong>Score moyen:</strong> {{ round($donnees->avg('score'), 2) }}/100</p>
            </div>
        @endif

        <div class="footer">
            <p>Document généré le: {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>ConseilAssur CRM - Rapport de métrique</p>
        </div>
    </div>
</body>
</html>
