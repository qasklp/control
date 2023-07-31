<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'content.php'; ?>
<h1>Home</h1>
<div id="chartContainer"></div>

<?php

    $totalVisitors = 6;

    $newVsReturningVisitorsDataPoints = array(
        array("y"=> 5, "name"=> "New Visitors", "color"=> "#E7823A"),
        array("y"=> 1, "name"=> "Returning Visitors", "color"=> "#546BC1")
    );

?>

<script type="text/javascript">

   window.onload = function () {

    var totalVisitors = <?php echo $totalVisitors ?>;
    var visitorsData = {
        "New vs Returning Visitors": [{
            cursor: "pointer",
            explodeOnClick: false,
            innerRadius: "65%",
            legendMarkerType: "square",
            name: "New vs Returning Visitors",
            radius: "100%",
            showInLegend: true,
            startAngle: 90,
            type: "doughnut",
            dataPoints: <?php echo json_encode($newVsReturningVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    };

    var newVSReturningVisitorsOptions = {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "New VS Returning Visitors"
        },

        legend: {
            fontFamily: "calibri",
            fontSize: 14,
            itemTextFormatter: function (e) {
                return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalVisitors * 100) + "%";
            }
        },
        data: []
    };

    var visitorsDrilldownedChartOptions = {
        animationEnabled: true,
        theme: "light2",
        axisX: {
            labelFontColor: "#717171",
            lineColor: "#a2a2a2",
            tickColor: "#a2a2a2"
        },
        axisY: {
            gridThickness: 0,
            includeZero: false,
            labelFontColor: "#717171",
            lineColor: "#a2a2a2",
            tickColor: "#a2a2a2",
            lineThickness: 1
        },
        data: []
    };

    var chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
    chart.options.data = visitorsData["New vs Returning Visitors"];
    chart.render();


}
</script>

<?php include 'footer.php'; ?>