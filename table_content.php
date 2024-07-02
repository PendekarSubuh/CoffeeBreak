<?php
// Include your database connection and other necessary code here

$ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Barang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        /* Add spacing between columns */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="sb-nav-fixed">
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Data Barang</h1>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = mysqli_fetch_array($ambilsemuadatastock)) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $data['namabarang']; ?></td>
                                    <td><?= $data['deskripsi']; ?></td>
                                    <td><?= $data['stock']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
