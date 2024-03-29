<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>T-Chat : Login</title>

    <link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="public/assets/bootstrap/css/login.css" type="text/css">
</head>

<body class="bg-info">

<div class="container bg-info">

    <form method="post" action="index.php?act=login&ctrl=User" class="form-signin">
        <?php if (isset($error_msg) and !empty($error_msg)){?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p><?php echo $error_msg; ?></p>
        </div>
        <?php }?>
        <h2 class="form-signin-heading"><span class="badge badge-primary">Login</span></h2>
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" name="username" class="form-control mb-2" placeholder="username" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="password" required>

        <button class="btn btn-sm btn-block btn-dark" type="submit">Connexion</button>
    </form>

</div>
<script type="text/javascript" src="public/assets/jquery/jquery.min.js"></script>
<script type="text/javascript" src="public/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
