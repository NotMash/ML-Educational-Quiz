<!doctype html>
<html lang="en">
  <head>
    <?php require_once 'Header.php'; ?>

    <title>School Quiz - Leaderboard</title>
  </head>
  <body>
    <!-- Leaderboard page showing students with the highest marks first -->
    <?php require_once 'LoggedNavbar.php' ?>

    <?php 
        session_start();
        require_once 'connect.php';
        require_once 'Functions.php';
    ?>

    <div class="container mt-3">
        
        <div class="row">
            <div style="display: flex; justify-content: center;">
                <ion-icon style="margin-right: 3vw; padding-top: 1vh;" class="display-1" name="trophy"></ion-icon>
                <h1 class="display-1 text-center">Leaderboards</h1>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">

            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><a href="Leaderboard.php?OrderBy=FirstName">Name</a></th>
                        <th scope="col"><a href="Leaderboard.php?OrderBy=TopMark">Highest Marks</a></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Call function to display top students -->
                    <?php 
                        if(isset($_GET['OrderBy'])){
                            displayLeaderboard($conn, $_GET['OrderBy']);
                        }else{
                            displayLeaderboard($conn, 'TotalMarks DESC');
                        }
                    ?>
                </tbody>
                </table>

            </div>
        </div>

    </div>

    <?php require_once 'Footer.php'; ?>
  </body>
</html>
