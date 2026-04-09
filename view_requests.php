<?php
include 'db_connect.php';
session_start();
// Security check: Sirf manager hi access kar sakay
if (!isset($_SESSION['manager_id'])) { 
    header("Location: manager_login.php"); 
    exit(); 
}

// Database Connection (Port 3307 ke sath)
$connection = new mysqli("localhost", "root", "", "cafe", 3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// ===== Action Logic (Approve/Reject) =====
if (isset($_GET['action']) && isset($_GET['req_id'])) {
    $req_id = intval($_GET['req_id']);
    $new_status = ($_GET['action'] == 'approve') ? 'Approved' : 'Rejected';
    
    $stmt = $connection->prepare("UPDATE request SET r_status = ? WHERE r_id = ?");
    $stmt->bind_param("si", $new_status, $req_id);
    
    if($stmt->execute()) {
        $stmt->close();
        header("Location: view_requests.php?msg=updated");
        exit();
    }
}

// ===== Query: Requests ko Registered Customer details k sath nikalna =====
$sql = "SELECT r.*, rc.r_name, rc.r_phoneNo 
        FROM request r 
        JOIN registered_customer rc ON r.registered_id = rc.r_id 
        ORDER BY r.r_time DESC";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Late Payment Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: url('f3.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: rgba(255, 255, 255, 0.96);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        h2 {
            text-align: center;
            color: #cc6600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th {
            background: #FF7200;
            color: white;
            padding: 15px;
            text-align: center;
            border: 1px solid #b35900;
        }
        td {
            padding: 15px;
            border: 1px solid #eee;
            color: #444;
            text-align: center;
        }
        tr:hover { background: #fff9f0; }
        
        /* Status Badges */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        .Pending { background: #ffc107; color: #000; }
        .Approved { background: #d4edda; color: #155724; }
        .Rejected { background: #f8d7da; color: #721c24; }

        .action-link {
            text-decoration: none;
            font-weight: bold;
            color: #333;
            padding: 5px 8px;
            border-radius: 4px;
            transition: 0.3s;
        }
        .approve-link { color: #28a745; }
        .reject-link { color: #dc3545; }
        .approve-link:hover { background: #d4edda; transform: scale(1.1); }
        .reject-link:hover { background: #f8d7da; transform: scale(1.1); }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        .back-link:hover { background: #000; }

        .msg-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="dashboard.php" class="back-link" style="margin-bottom: 20px; margin-top: 0;">← Back</a>
    <h2>💳 Late Payment Requests Management</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="msg-success">✅ Status Updated Successfully!</div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Customer Details</th>
                <th>Amount</th>
                <th>Requested Date</th>
                <th>Delay Until</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($row['r_name'] ?? 'N/A'); ?></strong><br>
                        <small style="color: #666;"><?php echo htmlspecialchars($row['r_phoneNo'] ?? 'No Contact'); ?></small>
                    </td>
                    <td><strong>$<?php echo number_format($row['r_amount'] ?? 0, 2); ?></strong></td>
                    <td><small><?php echo isset($row['r_time']) ? date("d M, Y", strtotime($row['r_time'])) : 'N/A'; ?></small></td>
                    <td>
                        <span style="color: #d9534f; font-weight: bold;">
                            <?php echo (!empty($row['delay_until']) && $row['delay_until'] != '0000-00-00') ? date("d M, Y", strtotime($row['delay_until'])) : 'N/A'; ?>
                        </span>
                    </td>
                    <td style="font-size: 0.9em; font-style: italic; max-width: 200px;">
                        <?php echo htmlspecialchars($row['reason'] ?? 'No reason provided'); ?>
                    </td>
                    <td>
                        <?php $current_status = $row['r_status'] ?? 'Pending'; ?>
                        <span class="badge <?php echo $current_status; ?>">
                            <?php echo $current_status; ?>
                        </span>
                    </td>
                    <td>
                        <?php if (($row['r_status'] ?? 'Pending') == 'Pending'): ?>
                            <a href="view_requests.php?action=approve&req_id=<?php echo $row['r_id']; ?>" 
                               class="action-link approve-link" onclick="return confirm('Approve this request?')">Approve</a> | 
                            <a href="view_requests.php?action=reject&req_id=<?php echo $row['r_id']; ?>" 
                               class="action-link reject-link" onclick="return confirm('Reject this request?')">Reject</a>
                        <?php else: ?>
                            <span style="color: #999; font-size: 0.8em; font-style: italic;">Processed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                        No late payment requests found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div style="text-align: center;">
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</div>

</body>
</html>