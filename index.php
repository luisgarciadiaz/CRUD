<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de empleados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Lista de Asesores</h2>
                        <h4>Acciones:</h4>
                            <h6>
                            <p>Prof: solo profesionaliza CV</p>
                            <p>Local:solo headhunter Local</p>
                            <p>Nacional:solo headhunter Nacional</p>
                        </h6>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$codi = mysqli_real_escape_string($con,(strip_tags($_GET["codi"],ENT_QUOTES)));
				$cek = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$codi'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM empleados WHERE codigo='$codi'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de asesores</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Prof.</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Local</option>
                        <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; } ?>>Nacional</option>
					</select>
				</div>
			</form>
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>No</th>
					<th>Código</th>
					<th>Nombre</th>
                                        <th>Localidad de Ingerencia</th>
                                        <th>Fecha de alta</th>
					<th>Teléfono</th>
					
					<th>Acciones</th>
                    <th>Acciones</th>
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM empleados WHERE estado='$filter' ORDER BY codigo ASC");
				}else{
					$sql = mysqli_query($con, "SELECT * FROM empleados ORDER BY codigo ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$row['codigo'].'</td>
							<td><a href="profile.php?codi='.$row['codigo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
                             <td>'.$row['lugar'].'</td>
                            <td>'.$row['fecha_alta'].'</td>
							<td>'.$row['telefono'].'</td>
                            
							<td>';
							if($row['estado'] == '1'){
								echo '<span class="label label-success">Prof.</span>';
							}
                            else if ($row['estado'] == '2' ){
								echo '<span class="label label-info">Local</span>';
							}
                            else if ($row['estado'] == '3' ){
								echo '<span class="label label-warning">Nacional</span>';
							}
						echo '
							</td>
							<td>

								<a href="edit.php?codi='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="index.php?aksi=delete&codi='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	<p>&copy; Fabrica de Software <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
