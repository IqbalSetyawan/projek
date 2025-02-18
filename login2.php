<?php
require 'function.php';


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (loginMahasiswa($email, $password)) {
        $_SESSION['role'] = 'mahasiswa'; // Set session role to mahasiswa
        header('location:cari.php');
    } else {
        header('location:login2.php');
    }
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
        <title>Login</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            body {
                background: url('picture/gasrek.jpg') no-repeat center center fixed;
                background-size: cover;
            }
            .card {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
                animation: float 3s ease-in-out infinite;
            }
            .card:hover {
                box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.4);
                transform: translateY(-10px);
            }
            @keyframes float {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-10px);
                }
            }
            .card-header {
                background-color: #fff;
                border-bottom: none;
                border-radius: 1rem 1rem 0 0;
                padding: 2rem;
            }
            .card-body {
                padding: 2rem;
            }
            .btn-primary {
                background-color: #0062E6;
                border: none;
                border-radius: 2rem;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                transition: background-color 0.3s, transform 0.3s;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                transform: translateY(-3px);
            }
            .btn-primary:active {
                background-color: #004494;
                transform: translateY(1px);
            }
            .card-header h3 {
                font-size: 1.75rem;
                font-weight: bold;
                color: #333;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
                margin-bottom: 20px;
                text-align: center;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
        </style>
    </head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header text-center">
                                        <img src="assets/img/Logo_Unhan.png" alt="Logo Unhan" style="height: 120px;">
                                        <h3 class="text-center font-weight-light my-4">
                                            <strong>Login Mahasiswa</strong>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" required />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" required />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                                <button class="btn btn-primary" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login1.php">Masuk sebagai admin</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
