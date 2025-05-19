<?php
//Including database connection
include '../databaseConnection.php';

//Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

//Pagination setup
$results_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

//Counting total submissions
$count_sql = "SELECT COUNT(*) as total FROM contact_form";
$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $results_per_page);

//Fetching paginated submissions
$sql = "SELECT name, email, message, date_submitted FROM contact_form ORDER BY date_submitted DESC LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/adminStyle.css">
    <style>
        /*Admin panel container styling*/
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        /*Table styling*/
        .submissions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .submissions-table th,
        .submissions-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .submissions-table th {
            background-color: #2C5F2D;
            color: white;
            font-weight: bold;
        }

        .submissions-table tr:hover {
            background-color: #f5f5f5;
        }

        /*Email protection styling*/
        .email-protected {
            color: #2C5F2D;
            text-decoration: none;
            cursor: default;
        }

        /*Message cell styling*/
        .message-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /*Date styling*/
        .date-cell {
            white-space: nowrap;
        }

        /*Pagination styling*/
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            color: #2C5F2D;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #2C5F2D;
            margin: 0 2px;
            border-radius: 4px;
            background: #fff;
            font-weight: bold;
        }
        .pagination a:hover {
            background: #2C5F2D;
            color: #fff;
        }
        .pagination .active {
            background: #2C5F2D;
            color: #fff;
            pointer-events: none;
        }
    </style>
</head>
<body>

<div class="admin-nav">
    <div class="admin-nav-brand">
        <i class="fa fa-lock"></i> Admin Portal
    </div>
    <div class="admin-nav-links">
        <a href="adminPanel.php" class="active"><i class="fa fa-dashboard"></i> Dashboard</a>
        <a href="addAdmin.php"><i class="fa fa-user-plus"></i> Add Admin</a>
        <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
    </div>
</div>

<div class="admin-container">
    <h1>Contact Form Submissions</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="submissions-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <span class="email-protected">
                                <?php 
                                //Displaying email with @ symbol replaced with at
                                echo str_replace('@', ' [at] ', htmlspecialchars($row['email'])); 
                                ?>
                            </span>
                        </td>
                        <td class="message-cell" title="<?php echo htmlspecialchars($row['message']); ?>">
                            <?php echo htmlspecialchars($row['message']); ?>
                        </td>
                        <td class="date-cell">
                            <?php 
                            //Format date to be more readable
                            echo date('F j, Y, g:i a', strtotime($row['date_submitted'])); 
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="pagination">
            <?php
            if ($page > 1) echo '<a href="?page='.($page-1).'">&laquo; Prev</a>';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo $i == $page
                    ? '<span class="active">'.$i.'</span>'
                    : '<a href="?page='.$i.'">'.$i.'</a>';
            }
            if ($page < $total_pages) echo '<a href="?page='.($page+1).'">Next &raquo;</a>';
            ?>
        </div>
    <?php else: ?>
        <p>No submissions found.</p>
    <?php endif; ?>
</div>

</body>
</html> 