<?php
// Para eliminar una cookie, la establecemos con una fecha de expiración en el pasado
setcookie("usuario", "", time() - 3600, "/");

echo "Cookie 'usuario' eliminada.";
?>
   