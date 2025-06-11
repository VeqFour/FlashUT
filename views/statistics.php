<?php
session_start();
include "../partials/header.php";
include "../includes/db.php";

$query = "
SELECT 
    d.department_id,
    d.department_name,
    COUNT(DISTINCT f.flashcard_id) AS total_flashcards,
    COALESCE(SUM(CASE WHEN c.type = 'view' THEN 1 ELSE 0 END), 0) AS total_views,
    COALESCE(SUM(CASE WHEN c.type = 'add' THEN 1 ELSE 0 END), 0) AS total_adds
FROM departments d
LEFT JOIN courses cr ON d.department_id = cr.department_id
LEFT JOIN sections s ON cr.course_id = s.course_id
LEFT JOIN flashcards f ON s.section_id = f.section_id
LEFT JOIN contributions c ON f.flashcard_id = c.flashcard_id
GROUP BY d.department_id, d.department_name
ORDER BY d.department_name
";

$result = $conn->query($query);

$departments = [];
$flashcards = [];
$views = [];
$adds = [];

while ($row = $result->fetch_assoc()) {
    $departments[] = $row['department_name'];
    $flashcards[] = (int)$row['total_flashcards'];
    $views[] = (int)$row['total_views'];
    $adds[] = (int)$row['total_adds'];
}
?>
     


<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 10px;">
  <img src="../template/img/logo.png" alt="Logo" style="height: 70px; width: auto;">

  <a href="../index.php" style="
    margin-top: 10px;
    text-decoration: none;
    background-color: #9A2828;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    font-family: 'Baloo Bhai', sans-serif;
    font-size: 18px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    transition: background-color 0.3s ease;">
    ← Back to Home
  </a>
</div>
<h1 style='font-family: Baloo Bhai, sans-serif; color: #9A2828; text-align: center; margin-top: 15px;'>📊 Collage Flashcard Statistics</h1>



<canvas id="deptStatsChart" width="1280" height="560" style="margin: 20px auto; display: block;"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('deptStatsChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($departments) ?>,
            datasets: [
                {
                    label: 'Flashcards Added',
                    data: <?= json_encode($adds) ?>,
                    backgroundColor: 'rgba(124, 25, 25, 0.7)',
                    borderColor: 'rgb(124, 25, 25)',
                    borderWidth: 1
                },
                {
                    label: 'Flashcards Viewed',
                    data: <?= json_encode($views) ?>,
                    backgroundColor: 'rgba(93, 103, 109, 0.53)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                },
                {
                    label: 'Total Flashcards',
                    data: <?= json_encode($flashcards) ?>,
                    backgroundColor: 'rgba(38, 166, 91, 0.6)',
                    borderColor: 'rgb(38, 166, 91)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    ticks: {
                        font: {
                            family: 'Baloo Bhai',
                            size: 14
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        font: {
                            family: 'Baloo Bhai'
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            family: 'Baloo Bhai'
                        }
                    }
                },
                
            }
        }
    });
});
</script>


