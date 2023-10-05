
<!-- Display all statistics for student's quizes. -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    function drawChart(){
        // Create the data table.
        var data = google.visualization.arrayToDataTable([
          ['ID', 'Percent'],
          <?php renderGraphData($conn); ?>
        ]);

        var options = {};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);

    }
</script>

<div class="row">

    <div class="col-4">

        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Quiz History</h4>
                <div class="list-group">
                    <!-- Show all tests that the student has ever done and their results -->
                    <?php listTestHistory($conn); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="col-8">

        <div class="row mb-3">
            <div class="card">
                <div class="card-body">

                    <!-- Graph for quiz score progress -->
                    <h3>Quiz Progress</h3>
                    <div id="chart_div"></div>
                    
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="card">
                <div class="card-body">

                    <!-- Table for showing quiz statistics - average, highest and lowest scores -->
                    <h3 class="mb-3">Quiz Statistics</h3>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Average Percentage</td>
                                <td><?php getTestStat($conn, 'average percent'); ?>%</td>
                            </tr>
                            <tr>
                                <td>Highest Percentage</td>
                                <td><?php getTestStat($conn, 'highest percent'); ?>%</td>
                            </tr>
                            <tr>
                                <td>Lowest Percentage</td>
                                <td><?php getTestStat($conn, 'lowest percent'); ?>%</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="card">
                <div class="card-body">
                    <!-- Show all topics and their average scores -->
                    <h3 class="mb-3">Topics</h3>
                    <?php require_once 'TopicStats.php'; ?>
                </div>
            </div>
        </div>

    </div>

</div>