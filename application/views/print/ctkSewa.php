<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Penyewaan Mobil</title>
    <style>
        table {
            width: 100%;
            font-size: 12px;
            border: 1px solid #ddd;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .print-btn {
            margin-bottom: 10px;
            padding: 5px 10px;
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Laporan Penyewaan Mobil</h1>
        <p>Periode : <?= $period_start . " Sampai " . $period_end; ?></p>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Penyewaan</th>
                    <th>ID Ketersediaan</th>
                    <th>Tujuan</th>
                    <th>Tgl Sewa</th>
                    <th>Pelanggan</th>
                    <th>Tgl Pembelian</th>
                    <th>Jenis Pembelian</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; $total = 0; ?>
                <?php foreach($data as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_penyewaan']; ?></td>
                    <td><?= $row['id_ketersediaan']; ?></td>
                    <td><?= $row['tujuan']; ?></td>
                    <td><?= $row['tgl_penyewaan']; ?></td>
                    <td><?= $row['nm_pelanggan']; ?></td>
                    <td><?= $row['tgl_pembelian']; ?></td>
                    <td><?= $row['jenis_penyewaan']; ?></td>
                    <td><?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['jumlah_sewa']; ?></td>
                    <td><?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                </tr>
                <?php $total += $row['nominal']; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10"><b>Total Bayar</b></td>
                    <td><?= number_format($total, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
        <div style="width:100%">
            <table border="0" style="margin-top:30px;margin-left:0cm;">
                <tr>
                    <td style="text-align:center">Karyawan</td>
                    <td></td>
                    <td style="text-align:center">Pemilik</td>
                </tr>
                <tr>
                    <td style="height:70px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:center">(....................................)</td>
                    <td></td>
                    <td style="text-align:center">(....................................)</td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
