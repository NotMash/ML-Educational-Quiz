<!-- Navigation bar for when user is logged in -->
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <div>
        <a class="navbar-brand" href="Home.php">School Quiz</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="Home.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="StartTest.php?QuestionCount=0&Difficulty=0">Start Quiz</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Leaderboard.php">Leaderboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Help.php">Help</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Logout.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>