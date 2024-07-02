<?php
require 'function.php';  

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require_once 'vendor/autoload.php';

if (isset($_POST['export_pdf'])) {
    // Create a new instance of DOMPDF
    $dompdf = new Dompdf\Dompdf();

    // Fetch the table data and create an HTML table
    ob_start();
    include('table_content.php'); // Replace with the actual path to your table data
    $html = ob_get_clean();

    // Load the HTML content into DOMPDF
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Output the PDF to the browser or save it to a file
    $dompdf->stream('stock_barang.pdf', array('Attachment' => 0));
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">COFFEEBREAK</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#"></a>
                        <a class="dropdown-item" href="#"></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Stock Barang</h1>


                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                                <div>
                            <form method="post">
                                <button type="submit" name="export_pdf" class="btn btn-secondary">Export PDF</button>
                            </form>
                        </div>

                            </div>
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Stok</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                            $ambilsemuadatastock = mysqli_query($conn,"select * from stock");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $namabarang = $data['namabarang'];
                                                $deskripsi = $data['deskripsi'];
                                                $stock = $data['stock'];
                                                $idb = $data['idbarang'];
            
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stock;?></td>
                                                <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idb;?>">
                                    Delete
                                </button>
                                                </td>
                                            </tr>

                                                 <!-- Edit Modal -->
  <div class="modal fade" id="edit<?=$idb;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" required>
        <br>
        <input type="text" name="deskripsi" value="<?=$deskripsi;?>" class="form-control" required>
        <br>
        <input type="hidden" name="idb" value="<?=$idb;?>">
        <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
        </div>
        </form>
        
        
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="delete<?=$idb;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Hapus Barang?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        Apakah anda yakin ingin menghapus <?=$namabarang;?>?
        <input type="hidden" name="idb" value="<?=$idb;?>">
        <br>
        <br>
        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
        </div>
        </form>
        
        
      </div>
    </div>
  </div>


                                            <?php
                                            };

                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2024</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
      <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
        <br>
        <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required>
        <br>
        <input type="number" name="stock" class="form-control" placeholder="stock" required>
        <br>
        <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
        </div>
        </form>
        
        
      </div>
    </div>
  </div>
</html>
