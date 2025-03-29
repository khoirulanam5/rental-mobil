<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Pelanggan</title>
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
	<h1>Laporan Data Pelanggan</h1>
    <table border="1" style="width:100%;font-size:12px;border: 1px solid #ddd;border-collapse: collapse;">
		<thead>
			<tr>
				<th class="short">No.</th>
				<th class="normal">ID Pelanggan</th>
				<th class="normal">Nama Pelanggan</th>
				<th class="normal">No. Telp</th>
				<th class="normal">Alamat</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=1; $total=0; ?>
			<?php foreach($data as $row): ?>
			<tr>
				<td style="text-align: center;"><?= $no++; ?></td>
				<td style="text-align: center;"><?= $row['id_pelanggan']; ?></td>
				<td style="text-align: center;"><?= $row['nm_pelanggan']; ?></td>
				<td style="text-align: center;"><?= $row['no_pelanggan']; ?></td>
				<td style="text-align: center;"><?= $row['alamat_pelanggan']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
