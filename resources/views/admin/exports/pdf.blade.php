<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; margin-bottom: 10px; }
        .info { font-size: 12px; color: #333; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        th { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 8px; text-align: left; font-weight: bold; }
        td { border: 1px solid #dee2e6; padding: 8px; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #666; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-aktif { background-color: #d4edda; color: #155724; }
        .badge-selesai { background-color: #fff3cd; color: #856404; }
        .badge-tidak_laku { background-color: #f8d7da; color: #721c24; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; margin-top: 20px; border-left: 4px solid #333; padding-left: 10px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="subtitle">Platform Lelang Online</div>
        <div class="info">
            <div>Periode: {{ $period }}</div>
            <div>Tanggal Cetak: {{ $date }}</div>
        </div>
    </div>

    @if($type === 'all' || $type === 'barang')
        <div class="section-title">Top 10 Barang Terlaris</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Penjual</th>
                    <th>Harga Awal</th>
                    <th>Total Bid</th>
                    <th>Status</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs ?? $data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                    <td>{{ $item->bids_count }}</td>
                    <td>
                        <span class="badge badge-{{ $item->status }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>{{ $item->kategori ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($type === 'all')
        <div class="page-break"></div>
    @endif

    @if($type === 'all' || $type === 'bidder')
        <div class="section-title">Top 10 Bidder Teraktif</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Total Bid</th>
                    <th>Tanggal Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bidders ?? $data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->bids_count }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($type === 'all')
         <div class="page-break"></div>
    @endif

    @if($type === 'all' || $type === 'seller')
        <div class="section-title">Top 10 Seller Terbanyak</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Total Barang</th>
                    <th>Tanggal Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers ?? $data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->barangs_count }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <div>Dicetak oleh: {{ auth()->user()->name }}</div>
        <div>© {{ date('Y') }} LelangPro - All rights reserved</div>
    </div>
</body>
</html>