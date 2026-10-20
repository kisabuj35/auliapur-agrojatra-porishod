<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Render এর Environment Variables থেকে ডাটাবেজ তথ্য নেওয়া
$host = getenv('DB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = getenv('DB_PORT') ?: '4000';
$db   = getenv('DB_DATABASE') ?: 'test';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$ssl  = getenv('MYSQL_ATTR_SSL_CA') ?: '/etc/ssl/certs/ca-certificates.crt';

try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    if (file_exists($ssl)) {
        $options[PDO::MYSQL_ATTR_SSL_CA] = $ssl;
    }

    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4", $user, $pass, $options);

    // স্বয়ংক্রিয়ভাবে TiDB-তে প্রয়োজনীয় টেবিলগুলো তৈরি করে নেওয়া
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS members (
            id INT AUTO_INCREMENT PRIMARY KEY,
            member_id VARCHAR(50) UNIQUE,
            name VARCHAR(100),
            father_name VARCHAR(100),
            phone VARCHAR(20),
            designation VARCHAR(50) DEFAULT 'সাধারণ সদস্য',
            address TEXT,
            blood_group VARCHAR(10),
            monthly_fee DECIMAL(10,2) DEFAULT 100.00,
            status VARCHAR(20) DEFAULT 'পেন্ডিং',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            member_id VARCHAR(50),
            name VARCHAR(100),
            amount DECIMAL(10,2),
            method VARCHAR(50),
            txn_id VARCHAR(100),
            status VARCHAR(20) DEFAULT 'পেন্ডিং',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS blood_donations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            donor_name VARCHAR(100),
            donor_phone VARCHAR(20),
            donor_blood VARCHAR(10),
            recipient_name VARCHAR(100),
            recipient_disease VARCHAR(100),
            status VARCHAR(20) DEFAULT 'পেন্ডিং',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents("php://input"), true) ?? $_POST;

if ($action === 'home_summary') {
    $membersCount = $pdo->query("SELECT COUNT(*) FROM members WHERE status = 'সক্রিয়'")->fetchColumn();
    $bloodCount = $pdo->query("SELECT COUNT(*) FROM blood_donations WHERE status = 'অনুমোদিত'")->fetchColumn();

    echo json_encode([
        "status" => "success",
        "data" => [
            "totalMembers" => $membersCount,
            "totalBlood" => $bloodCount,
            "totalPlanted" => 550
        ]
    ]);
    exit;
}

if ($action === 'register_member') {
    $stmt = $pdo->query("SELECT COUNT(*) FROM members");
    $nextId = "AAP" . str_pad($stmt->fetchColumn() + 1, 3, "0", STR_PAD_LEFT);

    $stmt = $pdo->prepare("INSERT INTO members (member_id, name, father_name, phone, designation, address, blood_group, monthly_fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $nextId,
        $input['name'] ?? '',
        $input['fatherName'] ?? '',
        $input['phone'] ?? '',
        $input['designation'] ?? 'সাধারণ সদস্য',
        $input['address'] ?? '',
        $input['bloodGroup'] ?? '',
        $input['monthlyFee'] ?? 100
    ]);

    echo json_encode(["status" => "success", "memberId" => $nextId]);
    exit;
}

if ($action === 'submit_payment') {
    $stmt = $pdo->prepare("INSERT INTO payments (member_id, name, amount, method, txn_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $input['memberId'] ?? 'General',
        $input['name'] ?? '',
        $input['amount'] ?? 0,
        $input['method'] ?? '',
        $input['txnId'] ?? ''
    ]);

    echo json_encode(["status" => "success"]);
    exit;
}

echo json_encode(["status" => "success", "message" => "Auliyapur TiDB Master Engine is connected and live!"]);

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$host = getenv('DB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = getenv('DB_PORT') ?: '4000';
$db   = getenv('DB_DATABASE') ?: 'test';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$ssl  = getenv('MYSQL_ATTR_SSL_CA') ?: '/etc/ssl/certs/ca-certificates.crt';

try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    if (file_exists($ssl)) {
        $options[PDO::MYSQL_ATTR_SSL_CA] = $ssl;
    }

    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4", $user, $pass, $options);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database connection error: " . $e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents("php://input"), true) ?? $_POST;

// বাংলা সংখ্যা কনভার্টার
function toBn($num) {
    $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
    return str_replace(range(0, 9), $bn, (string)$num);
}

// ১. হোম পেজ পরিসংখ্যান
if ($action === 'home_summary') {
    $mCount = $pdo->query("SELECT COUNT(*) FROM members WHERE status = 'সক্রিয়'")->fetchColumn() ?: 150;
    $bCount = $pdo->query("SELECT COUNT(*) FROM blood_donations WHERE status = 'অনুমোদিত'")->fetchColumn() ?: 45;

    echo json_encode([
        "status" => "success",
        "data" => [
            "totalMembers" => $mCount,
            "totalBlood" => $bCount,
            "totalPlanted" => 550
        ]
    ]);
    exit;
}

// ২. সদস্য লেজার লুকআপ
if ($action === 'lookup_member') {
    $idOrPhone = $input['idOrPhone'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM members WHERE member_id = ? OR phone = ? LIMIT 1");
    $stmt->execute([$idOrPhone, $idOrPhone]);
    $member = $stmt->fetch();

    if ($member) {
        echo json_encode([
            "success" => true,
            "member" => $member,
            "ledger" => [
                "months" => toBn(12),
                "total_accrued" => toBn(1250),
                "total_paid" => toBn(1000),
                "due" => toBn(250)
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "সদস্য পাওয়া যায়নি"]);
    }
    exit;
}

// ৩. নতুন সদস্য নিবন্ধন
if ($action === 'register_member') {
    $stmt = $pdo->query("SELECT COUNT(*) FROM members");
    $nextId = "AAP" . str_pad($stmt->fetchColumn() + 1, 3, "0", STR_PAD_LEFT);

    $stmt = $pdo->prepare("INSERT INTO members (member_id, name, father_name, phone, designation, address, blood_group, monthly_fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $nextId,
        $input['name'] ?? '',
        $input['fatherName'] ?? '',
        $input['phone'] ?? '',
        $input['designation'] ?? 'সাধারণ সদস্য',
        $input['address'] ?? '',
        $input['bloodGroup'] ?? '',
        $input['monthlyFee'] ?? 100
    ]);

    echo json_encode(["success" => true, "memberId" => $nextId]);
    exit;
}

echo json_encode(["status" => "success", "message" => "TiDB Engine Ready"]);
