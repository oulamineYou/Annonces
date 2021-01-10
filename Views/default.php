<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <script src="https://use.fontawesome.com/75fe646de1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        /*  Start Main Rules    */

        body{
            background-color: #F4F4F4;
            font-size: 16px     ;
        }
        a{
            text-decoration: none;
        }
        /*  End Main Rules  */

        

        /*  Start login Form    */

        .card.lg{
            width: 700px;
            margin: 100px auto;
            margin-top: 50px;
            margin-bottom: 0px;
        }

        .fa-user-circle-o{
            font-size: 50px;
        }

        .login{
            width: 80%;
            margin: 100px auto;
        }
        .register{
            width: 90%;
            margin: 100px auto;
        }

        .login h4 , .register h4{
            color: #888;
        }

        .login input, .register input{
            margin-bottom: 10px;
        }

        .login .form-control , .register .form-control{
            background-color: #EAEAEA !important;
        }

        .login .btn, .register .btn{
            background-color: #008dde;
        }

        /* End Login Form   */
        /*  Start NavBar    */
    /*
        First Color : #4b6584
        third Color : #455978
        secind Colr : #fc5c65
    */
        .bg-dark{
            padding: 0px;
            margin-bottom: 0px;
        }

        .navbar-expand-lg .navbar-collapse{
            padding: em;
        }

        .navbar-brand, .navbar-dark .navbar-nav .nav-link{
            padding: .7em;
            font-size: 1em;
        }
        /*End NavBar */

    </style>
</head>

<body >
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">LES ANNONCES</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Acueille<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/annonces">Liste des annonces<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(!isset($_SESSION['user'])):?>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/login">login</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/users/register">register</a>
                    </li>
                <?php else:?>
                    <li class="nav-item ">
                        <a class="nav-link" href="/users/profil">profile</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/users/logout">logout</a>
                    </li>
                <?php endif?>
            </ul>
        </div>
    </nav>
    
    <div class="container" >
        <?php if(isset($_SESSION['error'])):?>
            <div class="alert alert-danger mt-4" role="alert">
                <?php echo $_SESSION['error'];   unset($_SESSION['error']);?>
            </div>
        <?php endif?>
        <?php if(isset($_SESSION['success'])):?>
            <div class="alert alert-success mt-4" role="alert">
                <?php echo $_SESSION['success'];   unset($_SESSION['success']);?>
            </div>
        <?php endif?>
        <?= $content ?>
    </div>

    <script src="/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
</body>

</html>