<?php
include "../config/db.php";
session_start();

$data = mysqli_query($conn, "
SELECT 
payments.*, 
user.name,
memberships.membership_type
FROM payments
JOIN user ON payments.user_id = user.id
JOIN memberships ON payments.membership_id = memberships.id
ORDER BY payments.id DESC
");
?>

<h2>Payment History</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Name</th>
    <th>Membership</th>
    <th>Amount</th>
    <th>Mode</th>
    <th>Date</th>
    <th>Invoice</th>
</tr>

<?php while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $row['name']; ?></td>
    <td><?= $row['membership_type']; ?></td>
    <td>₹<?= $row['amount']; ?></td>
    <td><?= $row['payment_mode']; ?></td>
    <td><?= $row['payment_date']; ?></td>
    <td>
        <a href="invoice.php?id=<?= $row['id']; ?>" target="_blank">
            View Invoice
        </a>
    </td>
</tr>
<?php } ?>
</table>

