<?php
// view-unsubscribed.php
// Reads from both text log and CSV, displays in table format
// Includes export to CSV for OneSignal import

$txt_file = __DIR__ . '/unsubscribed-emails.txt';
$csv_file = __DIR__ . '/onesignal-import.csv';
$rows = [];
$error = null;

// Read from CSV (primary source for OneSignal data)
if (file_exists($csv_file)) {
    $handle = fopen($csv_file, 'r');
    $header = fgetcsv($handle); // Skip header
    
    while (($row = fgetcsv($handle)) !== false) {
        if (count($row) >= 8) {
            $rows[] = [
                'external_id' => $row[0] ?? '',
                'email' => $row[1] ?? '',
                'phone_number' => $row[2] ?? '',
                'subscribed' => $row[3] ?? 'yes',
                'timezone_id' => $row[4] ?? '',
                'country' => $row[5] ?? '',
                'language' => $row[6] ?? 'en',
                'suppressed' => $row[7] ?? 'FALSE',
            ];
        }
    }
    fclose($handle);
}

$total = count($rows);
// Reverse to show newest first
$rows = array_reverse($rows);

// Handle CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    if (file_exists($csv_file)) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="onesignal-subscribers-' . date('Y-m-d-His') . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        readfile($csv_file);
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>OneSignal Subscribers | Dioz Group</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: #f5f5f5;
    padding: 30px 15px;
    color: #333;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 28px;
    margin-bottom: 8px;
    color: #111;
}

.subtitle {
    color: #666;
    margin-bottom: 20px;
    font-size: 14px;
}

.stats {
    background: #f0f4ff;
    border-left: 4px solid #2563eb;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.error {
    background: #fdecea;
    border: 1px solid #f5c6cb;
    padding: 12px;
    margin-bottom: 16px;
    border-radius: 6px;
    color: #a71d2a;
}

.notice {
    background: #fff3cd;
    border: 1px solid #ffeeba;
    padding: 12px;
    margin-bottom: 16px;
    border-radius: 6px;
    color: #856404;
    text-align: center;
}

.info-box {
    background: #e7f3ff;
    border: 1px solid #b3d9ff;
    padding: 12px;
    margin-bottom: 16px;
    border-radius: 6px;
    color: #004085;
    font-size: 13px;
}

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

thead {
    background: #1a1a1a;
    color: white;
}

th {
    padding: 12px;
    text-align: left;
    font-weight: 600;
    font-size: 13px;
    white-space: nowrap;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 13px;
}

tbody tr:hover {
    background: #f9f9f9;
}

.email {
    color: #2563eb;
    font-weight: 500;
    word-break: break-all;
}

.country {
    background: #e8f0ff;
    padding: 3px 6px;
    border-radius: 3px;
    font-weight: 500;
}

.language {
    background: #f0e8ff;
    padding: 3px 6px;
    border-radius: 3px;
    font-weight: 500;
}

.timezone {
    font-family: monospace;
    font-size: 12px;
    color: #666;
}

.external-id {
    font-family: monospace;
    font-size: 11px;
    color: #999;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.btn {
    display: inline-block;
    background: #2563eb;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    text-align: center;
    border: none;
    cursor: pointer;
    margin-top: 20px;
    margin-right: 10px;
    transition: background 0.3s;
    font-size: 14px;
    font-weight: 600;
}

.btn:hover {
    background: #1e40af;
}

.btn-secondary {
    background: #666;
}

.btn-secondary:hover {
    background: #444;
}

.btn-success {
    background: #22c55e;
}

.btn-success:hover {
    background: #16a34a;
}

.empty {
    text-align: center;
    padding: 40px;
    color: #999;
}

.controls {
    margin-top: 20px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    th, td {
        padding: 8px;
        font-size: 12px;
    }
    
    .external-id {
        max-width: 80px;
    }
    
    .controls {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
</head>
<body>

<div class="container">
    <h1>🔔 OneSignal Subscribers</h1>
    <p class="subtitle">Data collected for OneSignal push notification importing.</p>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="stats">
        <strong>Total Subscribers:</strong> <?= $total ?>
    </div>

    <?php if ($total > 0): ?>
    <div class="info-box">
        ✓ <strong>Ready for OneSignal Import:</strong> Download the CSV file below and upload it to OneSignal dashboard (Audience → Import Subscribers → CSV Upload)
    </div>
    <?php endif; ?>

    <?php if ($total === 0): ?>
        <div class="notice">
            ✅ No subscribers yet.
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 12%;">Phone</th>
                        <th style="width: 12%;">Country</th>
                        <th style="width: 10%;">Language</th>
                        <th style="width: 20%;">Timezone</th>
                        <th style="width: 25%;">External ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                    <tr>
                        <td class="email"><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= !empty($row['phone_number']) ? htmlspecialchars($row['phone_number']) : '—' ?></td>
                        <td><?= !empty($row['country']) ? '<span class="country">' . htmlspecialchars($row['country']) . '</span>' : '—' ?></td>
                        <td><?= !empty($row['language']) ? '<span class="language">' . strtoupper(htmlspecialchars($row['language'])) . '</span>' : '—' ?></td>
                        <td class="timezone"><?= !empty($row['timezone_id']) ? htmlspecialchars($row['timezone_id']) : '—' ?></td>
                        <td class="external-id" title="<?= htmlspecialchars($row['external_id']) ?>"><?= htmlspecialchars($row['external_id']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="controls">
            <a href="/?export=csv" class="btn btn-success">📥 Download CSV for OneSignal</a>
            <a href="/" class="btn">← Back to Home</a>
            <button class="btn btn-secondary" onclick="window.print()">🖨️ Print</button>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
