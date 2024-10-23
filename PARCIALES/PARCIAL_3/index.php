<?php include 'include/iniciar_sesion.php'; ?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Aplicación de Calificaciones</title>
    
</head>
<body>
 
    <h3>Iniciar Sesión</h3>
         <?php if (!empty($errors)): ?>
                 <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <br>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
          
</body>
</html>
