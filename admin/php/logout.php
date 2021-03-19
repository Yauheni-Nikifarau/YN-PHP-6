<?php
setcookie("authorization", "admin", time()-60, '/');
header('location: /');
