<?php
error_reporting(0);
ini_set('display_errors', '0');

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

    // ১. ছবির কলামসমূহ LONGTEXT করা যাতে বড় সাইজের ছবিও আটকে না যায়
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS members (
            id INT AUTO_INCREMENT PRIMARY KEY,
            member_id VARCHAR(50) UNIQUE,
            name VARCHAR(100),
            father_name VARCHAR(100),
            mother_name VARCHAR(100),
            gender VARCHAR(20) DEFAULT 'পুরুষ',
            education VARCHAR(100),
            designation VARCHAR(100) DEFAULT 'সাধারণ সদস্য',
            member_type VARCHAR(100) DEFAULT 'সাধারণ সদস্য',
            address TEXT,
            phone VARCHAR(30),
            nid VARCHAR(50),
            profession VARCHAR(100),
            blood_group VARCHAR(10),
            monthly_fee DECIMAL(10,2) DEFAULT 100.00,
            photo LONGTEXT,
            status VARCHAR(30) DEFAULT 'সক্রিয়',
            join_date DATE,
            end_date DATE,
            email VARCHAR(100),
            fb_link TEXT,
            comments TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS committees (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50),
            name VARCHAR(100),
            father_name VARCHAR(100),
            mother_name VARCHAR(100),
            nid VARCHAR(50),
            phone VARCHAR(30),
            email VARCHAR(100),
            gender VARCHAR(20) DEFAULT 'পুরুষ',
            blood_group VARCHAR(10),
            designation VARCHAR(100),
            profession VARCHAR(100),
            education VARCHAR(100),
            org VARCHAR(150) DEFAULT 'আউলিয়াপুর অগ্রযাত্রা পরিষদ',
            fb_link TEXT,
            message TEXT,
            photo LONGTEXT,
            start_date DATE,
            end_date DATE,
            address TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            member_id VARCHAR(50),
            name VARCHAR(100),
            fiscal_year VARCHAR(50),
            month VARCHAR(50),
            amount DECIMAL(12,2) DEFAULT 0,
            phone VARCHAR(30),
            method VARCHAR(50),
            txn_id VARCHAR(100),
            status VARCHAR(30) DEFAULT 'পেন্ডিং',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS blood_donors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            phone VARCHAR(30),
            gender VARCHAR(20) DEFAULT 'পুরুষ',
            dob DATE,
            blood_group VARCHAR(10),
            last_donation_date DATE,
            weight VARCHAR(20),
            division VARCHAR(50),
            district VARCHAR(50),
            upazila VARCHAR(50),
            village VARCHAR(100),
            photo LONGTEXT,
            status VARCHAR(30) DEFAULT 'সক্রিয়',
            donor_type VARCHAR(50) DEFAULT 'সাধারণ',
            member_id VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS blood_donations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            donor_type VARCHAR(50) DEFAULT 'সাধারণ',
            donor_id VARCHAR(50),
            donor_name VARCHAR(100),
            donor_father VARCHAR(100),
            donor_blood VARCHAR(10),
            donor_phone VARCHAR(30),
            donation_date DATE,
            donor_photo LONGTEXT,
            recipient_name VARCHAR(100),
            recipient_phone VARCHAR(30),
            recipient_address TEXT,
            recipient_disease VARCHAR(150),
            recipient_photo LONGTEXT,
            remarks TEXT,
            status VARCHAR(30) DEFAULT 'অনুমোদিত',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS cashbooks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            date DATE,
            type VARCHAR(20),
            sector VARCHAR(150),
            amount DECIMAL(12,2) DEFAULT 0,
            remarks TEXT,
            approved_by VARCHAR(100),
            spent_by VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS campaigns (
            id INT AUTO_INCREMENT PRIMARY KEY,
            date DATE,
            title VARCHAR(150),
            sector VARCHAR(100),
            amount INT DEFAULT 0,
            `desc` TEXT,
            status VARCHAR(50) DEFAULT 'সম্পন্ন',
            location VARCHAR(100) DEFAULT 'আউলিয়াপুর',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS media_contents (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50),
            title VARCHAR(200),
            url LONGTEXT,
            category VARCHAR(100),
            description TEXT,
            date_str VARCHAR(50),
            duration VARCHAR(30),
            pdf_url TEXT,
            source VARCHAR(100),
            excerpt TEXT,
            news_url TEXT,
            authority VARCHAR(150),
            year VARCHAR(20),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS admin_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE,
            password VARCHAR(100),
            name VARCHAR(100),
            role VARCHAR(50) DEFAULT 'Viewer',
            status VARCHAR(20) DEFAULT 'সক্রিয়',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // ২. TiDB-তে পূর্বের বিদ্যমান কলামগুলোকেও LONGTEXT-এ রূপান্তর করে নেওয়া
    try {
        $pdo->exec("ALTER TABLE members MODIFY photo LONGTEXT");
        $pdo->exec("ALTER TABLE committees MODIFY photo LONGTEXT");
        $pdo->exec("ALTER TABLE blood_donors MODIFY photo LONGTEXT");
        $pdo->exec("ALTER TABLE blood_donations MODIFY donor_photo LONGTEXT");
        $pdo->exec("ALTER TABLE blood_donations MODIFY recipient_photo LONGTEXT");
        $pdo->exec("ALTER TABLE media_contents MODIFY url LONGTEXT");
    } catch (Exception $ex) {}

    // সুপার এডমিন নিশ্চিতকরণ
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = 'superadmin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO admin_users (username, password, name, role, status) VALUES ('superadmin', 'AAP2026', 'প্রধান প্রশাসক', 'Super Admin', 'সক্রিয়')");
    }

} catch (Exception $e) {}

function toBn($num) {
    if ($num === null || $num === '') return '০';
    $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
    return str_replace(range(0, 9), $bn, (string)$num);
}
function toEn($str) {
    if (!$str) return '0';
    $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
    return str_replace($bn, range(0, 9), (string)$str);
}

$raw = json_decode(file_get_contents("php://input"), true) ?? [];
$action = $raw['action'] ?? ($_GET['action'] ?? '');
$args = $raw['arguments'] ?? [];

try {

    // অ্যাডমিন লগইন
    if ($action === 'checkAdminLoginSecure') {
        $u = trim($args[0] ?? '');
        $p = trim($args[1] ?? '');

        if ($u === 'superadmin' && $p === 'AAP2026') {
            echo json_encode(["status" => "success", "data" => ["success" => true, "name" => "প্রধান প্রশাসক", "role" => "Super Admin", "username" => "superadmin"]]);
            exit;
        }

        if (isset($pdo)) {
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? AND password = ? AND status = 'সক্রিয়'");
            $stmt->execute([$u, $p]);
            $adm = $stmt->fetch();
            if ($adm) {
                echo json_encode(["status" => "success", "data" => ["success" => true, "name" => $adm['name'], "role" => $adm['role'], "username" => $adm['username']]]);
                exit;
            }
        }
        echo json_encode(["status" => "success", "data" => ["success" => false, "message" => "ভুল ইউজারনেম অথবা পাসওয়ার্ড/পিন!"]]);
        exit;
    }

    // নতুন সদস্য নিবন্ধন (ছবি সহ)
    if ($action === 'submitMemberRegistration') {
        $p = $args[0] ?? [];
        $nextId = "AAP001";
        if (isset($pdo)) {
            $c = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
            $nextId = "AAP" . str_pad($c + 1, 3, "0", STR_PAD_LEFT);

            $stmt = $pdo->prepare("INSERT INTO members (member_id, name, father_name, mother_name, gender, education, designation, address, phone, nid, profession, blood_group, monthly_fee, photo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'পেন্ডিং')");
            $stmt->execute([
                $nextId,
                $p['name'] ?? '',
                $p['fatherName'] ?? '',
                $p['motherName'] ?? '',
                $p['gender'] ?? 'পুরুষ',
                $p['education'] ?? '',
                $p['designation'] ?? 'সাধারণ সদস্য',
                $p['address'] ?? '',
                $p['phone'] ?? '',
                $p['nid'] ?? '',
                $p['profession'] ?? '',
                $p['bloodGroup'] ?? '',
                toEn($p['monthlyFee'] ?? 100),
                $p['photoData'] ?? ($p['photo'] ?? ''),
                
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true, "memberId" => $nextId]]);
        exit;
    }

    // নতুন কমিটি নিবন্ধন (ছবি সহ)
    if ($action === 'submitCommittee' || $action === 'submitCommitteeMember') {
        $p = $args[0] ?? [];
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO committees (type, name, start_date, end_date, phone, designation, org, fb_link, message, profession, education, father_name, mother_name, blood_group, email, nid, gender, address, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $p['type'] ?? 'কার্যনির্বাহী কমিটি',
                $p['name'] ?? '',
                $p['startDate'] ?: null,
                $p['endDate'] ?: null,
                $p['phone'] ?? '',
                $p['designation'] ?? '',
                $p['org'] ?? 'আউলিয়াপুর অগ্রযাত্রা পরিষদ',
                $p['fbLink'] ?? '',
                $p['message'] ?? '',
                $p['profession'] ?? '',
                $p['education'] ?? '',
                $p['fatherName'] ?? '',
                $p['motherName'] ?? '',
                $p['bloodGroup'] ?? 'A+',
                $p['email'] ?? '',
                $p['nid'] ?? '',
                $p['gender'] ?? 'পুরুষ',
                $p['address'] ?? '',
                $p['photoData'] ?? ($p['photo'] ?? '')
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    // ড্রাইভ আপলোড কল হ্যান্ডলার (ফটো ডাটা সরাসরি রিটার্ন করে)
    if ($action === 'uploadToGoogleDrive') {
        $photoData = $args[0] ?? '';
        echo json_encode(["status" => "success", "data" => $photoData]);
        exit;
    }

    // সদস্য তালিকা ও লেজার
    if ($action === 'getAuliyapurData') {
        $ledgers = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM members WHERE status = 'সক্রিয়' ORDER BY id ASC");
            while ($row = $stmt->fetch()) {
                $fee = (float)$row['monthly_fee'];
                $months = 12;
                $accrued = ($months * $fee) + 50.00;
                $paid = 0;
                $due = max(0, $accrued - $paid);

                $ledgers[] = [
                    "id" => $row['member_id'],
                    "name" => $row['name'],
                    "fatherName" => $row['father_name'] ?: "N/A",
                    "motherName" => $row['mother_name'] ?: "N/A",
                    "gender" => $row['gender'] ?: "পুরুষ",
                    "education" => $row['education'] ?: "N/A",
                    "designation" => $row['designation'] ?: "সাধারণ সদস্য",
                    "memberType" => $row['member_type'] ?: "সাধারণ সদস্য",
                    "address" => $row['address'] ?: "আউলিয়াপুর",
                    "phone" => $row['phone'],
                    "nid" => $row['nid'] ?: "N/A",
                    "profession" => $row['profession'] ?: "N/A",
                    "bloodGroup" => $row['blood_group'] ?: "N/A",
                    "email" => $row['email'] ?: "N/A",
                    "fbLink" => $row['fb_link'] ?: "#",
                    "comments" => $row['comments'] ?: "N/A",
                    "monthlyFee" => toBn($fee),
                    "joinDate" => $row['join_date'] ?: "২০২৬-০১-০১",
                    "months" => toBn($months),
                    "totalSubscription" => toBn($accrued),
                    "totalPaid" => toBn($paid),
                    "specialDonation" => "০",
                    "grandTotalPaid" => toBn($paid),
                    "totalDue" => toBn($due),
                    "photo" => $row['photo'] ?: "",
                    "bloodDonationsCount" => "০"
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => ["ledgers" => $ledgers]]);
        exit;
    }

    // ক্যাম্পেইন / প্রজেক্ট তালিকা
    if ($action === 'getCampaignLedger') {
        $list = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM campaigns ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $list[] = [
                    "rowIdx" => (int)$r['id'],
                    "date" => $r['date'] ? date('d-m-Y', strtotime($r['date'])) : date('d-m-Y'),
                    "title" => $r['title'] ?? '',
                    "sector" => $r['sector'] ?? '',
                    "amount" => toBn($r['amount'] ?? 0),
                    "desc" => $r['desc'] ?? '',
                    "status" => $r['status'] ?? 'সম্পন্ন',
                    "location" => $r['location'] ?? 'আউলিয়াপুর'
                ];
            }
        }
        if (empty($list)) {
            $list = [
                ["rowIdx" => 1, "date" => "১২-০৭-২০২৬", "title" => "বৃক্ষরোপণ কর্মসূচি ২০২৬", "sector" => "সবুজ স্বপ্ন", "amount" => "৫০০", "desc" => "পটুয়াখালী জেলাজুড়ে চারাগাছ রোপণ সম্পন্ন।", "status" => "সম্পন্ন", "location" => "আউলিয়াপুর"],
                ["rowIdx" => 2, "date" => "০৫-০৭-২০২৬", "title" => "শিক্ষা সামগ্রী বিতরণ প্রজেক্ট", "sector" => "তরুণ জ্ঞানের দীপশিখা", "amount" => "৩০০", "desc" => "মেধাবী শিক্ষার্থীদের মাঝে শিক্ষা সামগ্রী উপহার।", "status" => "সম্পন্ন", "location" => "আদর্শ স্কুল"],
                ["rowIdx" => 3, "date" => "০১-০৬-২০২৬", "title" => "শীতবস্ত্র ও কম্বল বিতরণ", "sector" => "উষ্ণ হোক শীত", "amount" => "৬০০", "desc" => "অসহায় শীতার্তদের উষ্ণতার ছোঁয়া পৌঁছে দেওয়া হয়েছে।", "status" => "সম্পন্ন", "location" => "আউলিয়াপুর"]
            ];
        }
        echo json_encode(["status" => "success", "data" => $list]);
        exit;
    }

    // ব্যয় খতিয়ান
    if ($action === 'getExpenseLedger') {
        $list = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM cashbooks WHERE type = 'ব্যয়' ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $list[] = [
                    "rowIdx" => (int)$r['id'],
                    "date" => $r['date'] ? date('d-m-Y', strtotime($r['date'])) : date('d-m-Y'),
                    "sector" => $r['sector'] ?? '',
                    "amount" => toBn($r['amount'] ?? 0),
                    "remarks" => $r['remarks'] ?? '',
                    "approvedBy" => $r['approved_by'] ?? 'কোষাধ্যক্ষ',
                    "spentBy" => $r['spent_by'] ?? 'প্রতিনিধি'
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => $list]);
        exit;
    }

    // অ্যাডমিন আর্থিক অডিট রিপোর্ট
    if ($action === 'getAdminFinancialReport') {
        $totalIncome = 0; $totalExpense = 0;
        $cashbookTransactions = [];

        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM cashbooks ORDER BY date DESC, id DESC");
            while ($r = $stmt->fetch()) {
                $amt = (float)$r['amount'];
                if ($r['type'] === 'আয়') $totalIncome += $amt;
                if ($r['type'] === 'ব্যয়') $totalExpense += $amt;

                $cashbookTransactions[] = [
                    "rowIdx" => (int)$r['id'],
                    "date" => date('d-m-Y', strtotime($r['date'])),
                    "type" => $r['type'],
                    "sector" => $r['sector'],
                    "amount" => toBn($amt),
                    "remarks" => $r['remarks'] ?? ''
                ];
            }
        }

        $netBalance = $totalIncome - $totalExpense;
        $membersCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM members WHERE status = 'সক্রিয়'")->fetchColumn() : 150;
        $committeeCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM committees WHERE type = 'কার্যনির্বাহী কমিটি'")->fetchColumn() : 12;
        $advisorsCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM committees WHERE type = 'উপদেষ্টা মণ্ডলী'")->fetchColumn() : 8;
        $donorsCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM blood_donors WHERE status = 'সক্রিয়'")->fetchColumn() : 50;
        $bloodCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM blood_donations WHERE status = 'অনুমোদিত'")->fetchColumn() : 45;

        $bloodStats = ["A+" => 0, "B+" => 0, "AB+" => 0, "O+" => 0, "A-" => 0, "B-" => 0, "AB-" => 0, "O-" => 0];
        $donationBloodStats = ["A+" => 0, "B+" => 0, "AB+" => 0, "O+" => 0, "A-" => 0, "B-" => 0, "AB-" => 0, "O-" => 0];

        $memberLedger = [];
        $totalDues = 0;
        if (isset($pdo)) {
            $mStmt = $pdo->query("SELECT * FROM members WHERE status = 'সক্রিয়' ORDER BY id ASC");
            while ($r = $mStmt->fetch()) {
                $fee = (float)$r['monthly_fee'];
                $months = 12;
                $accrued = ($months * $fee) + 50.00;
                $paid = 0;
                $due = max(0, $accrued - $paid);
                $totalDues += $due;

                $memberLedger[] = [
                    "rowIdx" => (int)$r['id'],
                    "id" => $r['member_id'],
                    "name" => $r['name'],
                    "status" => $r['status'],
                    "joinDate" => $r['join_date'] ?: "২০২৬-০১-০১",
                    "endDate" => $r['end_date'] ?: "-",
                    "months" => toBn($months),
                    "monthlyFee" => toBn($fee),
                    "totalAccrued" => toBn($accrued),
                    "totalPaid" => toBn($paid),
                    "due" => toBn($due),
                    "phone" => $r['phone'],
                    "designation" => $r['designation'] ?: "সাধারণ সদস্য"
                ];
            }
        }

        echo json_encode([
            "status" => "success",
            "data" => [
                "fyOptions" => ["সর্বমোট", "২০২৫-২০২৬", "২০২৬-২০২৭", "২০২৭-২০২৮"],
                "totalIncome" => toBn($totalIncome),
                "totalExpense" => toBn($totalExpense),
                "netBalance" => toBn($netBalance),
                "totalDues" => toBn($totalDues),
                "membersCount" => toBn($membersCount),
                "committeeCount" => toBn($committeeCount),
                "advisorsCount" => toBn($advisorsCount),
                "donorsCount" => toBn($donorsCount),
                "lifetimeMembersCount" => toBn(5),
                "bloodDonationsCount" => toBn($bloodCount),
                "completedCampaigns" => toBn(3),
                "ongoingCampaigns" => toBn(1),
                "categories" => [
                    "formFee" => toBn(2500),
                    "monthlyFee" => toBn($totalIncome > 2500 ? $totalIncome - 2500 : 0),
                    "specialDonation" => toBn(0),
                    "publicDonation" => toBn(0),
                    "educationSector" => toBn(1500),
                    "medicalSector" => toBn(1000),
                    "financialHelp" => toBn(2000),
                    "officeSector" => toBn(500),
                    "specialSector" => toBn(0),
                    "otherSector" => toBn(0)
                ],
                "memberLedger" => $memberLedger,
                "cashbookTransactions" => $cashbookTransactions,
                "bloodStats" => $bloodStats,
                "donationBloodStats" => $donationBloodStats
            ]
        ]);
        exit;
    }

    // পেন্ডিং আবেদন তালিকা
    if ($action === 'getPendingItems') {
        $members = []; $payments = []; $blood = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM members WHERE status = 'পেন্ডিং' ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $members[] = ["rowIdx" => (int)$r['id'], "memberId" => $r['member_id'], "name" => $r['name'], "phone" => $r['phone'], "desig" => $r['designation'], "address" => $r['address']];
            }
            $stmt = $pdo->query("SELECT * FROM payments WHERE status = 'পেন্ডিং' ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $payments[] = ["rowIdx" => (int)$r['id'], "date" => $r['created_at'], "memberId" => $r['member_id'], "month" => $r['month'], "amount" => toBn($r['amount']), "phone" => $r['phone'], "method" => $r['method'], "txnId" => $r['txn_id']];
            }
            $stmt = $pdo->query("SELECT * FROM blood_donations WHERE status = 'পেন্ডিং' ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $blood[] = ["rowIdx" => (int)$r['id'], "donorName" => $r['donor_name'], "donorPhone" => $r['donor_phone'], "date" => $r['donation_date'], "recipientName" => $r['recipient_name'], "recipientPhone" => $r['recipient_phone'], "disease" => $r['recipient_disease']];
            }
        }
        echo json_encode(["status" => "success", "data" => ["members" => $members, "payments" => $payments, "blood" => $blood]]);
        exit;
    }

    // সদস্য তালিকা (এডিটর)
    if ($action === 'getAdminMemberList') {
        $list = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM members ORDER BY id ASC");
            while ($r = $stmt->fetch()) {
                $list[] = [
                    "rowIdx" => (int)$r['id'],
                    "id" => $r['member_id'],
                    "name" => $r['name'],
                    "fatherName" => $r['father_name'] ?? '',
                    "motherName" => $r['mother_name'] ?? '',
                    "gender" => $r['gender'] ?? 'পুরুষ',
                    "education" => $r['education'] ?? '',
                    "designation" => $r['designation'] ?? 'সাধারণ সদস্য',
                    "memberType" => $r['member_type'] ?? 'সাধারণ সদস্য',
                    "address" => $r['address'] ?? '',
                    "phone" => $r['phone'],
                    "nid" => $r['nid'] ?? '',
                    "profession" => $r['profession'] ?? '',
                    "bloodGroup" => $r['blood_group'] ?? 'A+',
                    "email" => $r['email'] ?? '',
                    "fbLink" => $r['fb_link'] ?? '',
                    "comments" => $r['comments'] ?? '',
                    "monthlyFee" => toBn($r['monthly_fee'] ?? 100),
                    "photo" => $r['photo'] ?? '',
                    "status" => $r['status'] ?? 'সক্রিয়',
                    "joinDate" => $r['join_date'] ?? date('Y-m-d'),
                    "endDate" => $r['end_date'] ?? ''
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => $list]);
        exit;
    }

    // কমিটি ডাটা
    if ($action === 'getCommitteeData') {
        $list = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM committees ORDER BY id ASC");
            while ($row = $stmt->fetch()) {
                $list[] = [
                    "rowIdx" => (int)$row['id'],
                    "type" => $row['type'],
                    "name" => $row['name'],
                    "designation" => $row['designation'],
                    "phone" => $row['phone'],
                    "profession" => $row['profession'] ?: "সমাজসেবা",
                    "education" => $row['education'] ?: "স্নাতক",
                    "org" => $row['org'] ?: "আউলিয়াপুর অগ্রযাত্রা পরিষদ",
                    "fbLink" => $row['fb_link'] ?: "#",
                    "message" => $row['message'] ?: "অগ্রযাত্রা এগিয়ে যাক...",
                    "photo" => $row['photo'] ?: ""
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => $list]);
        exit;
    }

    // রক্তদান তালিকা
    if ($action === 'getBloodDonationList') {
        $donations = []; $total = 0; $registered = 0;
        $groupStats = ["A+" => 0, "A-" => 0, "B+" => 0, "B-" => 0, "AB+" => 0, "AB-" => 0, "O+" => 0, "O-" => 0];

        if (isset($pdo)) {
            $total = (int)$pdo->query("SELECT COUNT(*) FROM blood_donations WHERE status = 'অনুমোদিত'")->fetchColumn();
            $registered = (int)$pdo->query("SELECT COUNT(*) FROM blood_donors WHERE status = 'সক্রিয়'")->fetchColumn();

            $stmt = $pdo->query("SELECT * FROM blood_donations WHERE status = 'অনুমোদিত' ORDER BY donation_date DESC");
            while ($row = $stmt->fetch()) {
                $grp = strtoupper(trim($row['donor_blood']));
                if (isset($groupStats[$grp])) $groupStats[$grp]++;
                $donations[] = [
                    "donorType" => $row['donor_type'] ?: "সাধারণ",
                    "donorId" => $row['donor_id'] ?: "-",
                    "donorName" => $row['donor_name'],
                    "donorFather" => $row['donor_father'] ?: "N/A",
                    "donorBlood" => $row['donor_blood'],
                    "donorPhone" => $row['donor_phone'],
                    "donationDate" => $row['donation_date'],
                    "donorPhoto" => $row['donor_photo'] ?: "",
                    "recipientName" => $row['recipient_name'],
                    "recipientPhone" => $row['recipient_phone'],
                    "recipientAddress" => $row['recipient_address'],
                    "recipientDisease" => $row['recipient_disease'],
                    "recipientPhoto" => $row['recipient_photo'] ?: "",
                    "donorBloodCount" => toBn(1)
                ];
            }
        }
        $bnGroupStats = [];
        foreach ($groupStats as $k => $v) { $bnGroupStats[$k] = toBn($v); }

        echo json_encode([
            "status" => "success",
            "data" => [
                "list" => $donations,
                "stats" => [
                    "totalDonations" => toBn($total),
                    "totalRegisteredDonors" => toBn($registered),
                    "uniqueDonorsCount" => toBn(count($donations)),
                    "groupStats" => $bnGroupStats
                ]
            ]
        ]);
        exit;
    }

    // ডোনার তালিকা
    if ($action === 'getDonorList') {
        $donors = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM blood_donors WHERE status = 'সক্রিয়' ORDER BY id DESC");
            while ($row = $stmt->fetch()) {
                $donors[] = [
                    "id" => $row['member_id'] ?: ("D-" . $row['id']),
                    "name" => $row['name'],
                    "fatherName" => "N/A",
                    "bloodGroup" => $row['blood_group'],
                    "phone" => $row['phone'],
                    "location" => ($row['upazila'] ? $row['upazila'] . ", " : "") . ($row['district'] ?: "পটুয়াখালী"),
                    "lastDonation" => $row['last_donation_date'] ?: "-",
                    "type" => $row['donor_type'] ?: "সাধারণ ডোনার",
                    "totalDonations" => 1,
                    "photo" => $row['photo'] ?: ""
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => $donors]);
        exit;
    }

    // সদস্য ডাটা লুকআপ
    if ($action === 'getMemberInfoById') {
        $id = trim($args[0] ?? '');
        $res = ["success" => false];
        if (isset($pdo) && $id) {
            $stmt = $pdo->prepare("SELECT * FROM members WHERE member_id = ? OR phone = ? LIMIT 1");
            $stmt->execute([$id, $id]);
            $row = $stmt->fetch();
            if ($row) {
                $res = [
                    "success" => true,
                    "name" => $row['name'],
                    "fatherName" => $row['father_name'],
                    "phone" => $row['phone'],
                    "bloodGroup" => $row['blood_group'],
                    "monthlyFee" => $row['monthly_fee'],
                    "photo" => $row['photo'] ?: ""
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => $res]);
        exit;
    }

    // পেমেন্ট সাবমিট
    if ($action === 'submitMemberPayment' || $action === 'submitDonationPayment') {
        $p = $args[0] ?? [];
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO payments (member_id, name, amount, method, txn_id, status) VALUES (?, ?, ?, ?, ?, 'পেন্ডিং')");
            $stmt->execute([
                $p['memberId'] ?? 'General',
                $p['name'] ?? ($p['donorName'] ?? ''),
                $p['amount'] ?? 0,
                $p['method'] ?? '',
                $p['txnId'] ?? ''
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    // রক্তদান সাবমিট
    if ($action === 'submitBloodDonation') {
        $p = $args[0] ?? [];
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO blood_donations (donor_name, donor_father, donor_blood, donor_phone, donation_date, donor_photo, recipient_name, recipient_phone, recipient_address, recipient_disease, recipient_photo, remarks, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'পেন্ডিং')");
            $stmt->execute([
                $p['donorName'] ?? '',
                $p['donorFather'] ?? '',
                $p['donorBlood'] ?? '',
                $p['donorPhone'] ?? '',
                $p['donationDate'] ?? date('Y-m-d'),
                $p['donorPhotoData'] ?? '',
                $p['recipientName'] ?? '',
                $p['recipientPhone'] ?? '',
                $p['recipientAddress'] ?? '',
                $p['recipientDisease'] ?? '',
                $p['recipientPhotoData'] ?? '',
                $p['remarks'] ?? ''
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    // ডোনার নিবন্ধন সাবমিট
    if ($action === 'submitDonorRegistration') {
        $p = $args[0] ?? [];
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO blood_donors (name, phone, gender, blood_group, last_donation_date, weight, division, district, upazila, village, donor_type, photo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'সক্রিয়')");
            $stmt->execute([
                $p['name'] ?? '',
                $p['phone'] ?? '',
                $p['gender'] ?? 'পুরুষ',
                $p['bloodGroup'] ?? '',
                $p['lastDonationDate'] ?: null,
                $p['weight'] ?? '',
                $p['division'] ?? '',
                $p['district'] ?? '',
                $p['upazila'] ?? '',
                $p['village'] ?? '',
                $p['donorType'] ?? 'সাধারণ',
                $p['photoData'] ?? ''
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    // ব্যয় রেকর্ড সাবমিট
    if ($action === 'submitExpenseRecord') {
        $p = $args[0] ?? [];
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO cashbooks (date, type, sector, amount, remarks, approved_by, spent_by) VALUES (?, 'ব্যয়', ?, ?, ?, ?, ?)");
            $stmt->execute([
                $p['date'] ?? date('Y-m-d'),
                $p['sector'] ?? 'অন্যান্য',
                toEn($p['amount'] ?? 0),
                $p['remarks'] ?? '',
                $p['approvedBy'] ?? 'কোষাধ্যক্ষ',
                $p['spentBy'] ?? 'প্রতিনিধি'
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    // প্রকল্প ক্যাম্পেইন সাবমিট
    if ($action === 'submitProjectCampaign') {
        $p = $args[0] ?? [];
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO campaigns (date, title, sector, amount, `desc`, status, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $p['date'] ?? date('Y-m-d'),
                $p['title'] ?? 'ক্যাম্পেইন',
                $p['sector'] ?? 'সবুজ স্বপ্ন',
                (int)toEn($p['amount'] ?? 0),
                $p['desc'] ?? '',
                $p['status'] ?? 'সম্পন্ন',
                $p['location'] ?? 'আউলিয়াপুর'
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    // অ্যাডমিন অনুমোদন
    if ($action === 'approvePendingMember' || $action === 'approveMember') {
        $id = (int)($args[0] ?? 0);
        if (isset($pdo) && $id > 0) {
            $pdo->prepare("UPDATE members SET status = 'সক্রিয়' WHERE id = ?")->execute([$id]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    if ($action === 'approvePendingPayment' || $action === 'approvePayment') {
        $id = (int)($args[0] ?? 0);
        if (isset($pdo) && $id > 0) {
            $pdo->prepare("UPDATE payments SET status = 'অনুমোদিত' WHERE id = ?")->execute([$id]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    if ($action === 'approvePendingBlood' || $action === 'approveBloodDonation') {
        $id = (int)($args[0] ?? 0);
        if (isset($pdo) && $id > 0) {
            $pdo->prepare("UPDATE blood_donations SET status = 'অনুমোদিত' WHERE id = ?")->execute([$id]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    if ($action === 'deleteRowRecord' || $action === 'rejectPendingItem') {
        $table = $args[0] ?? '';
        $id = (int)($args[1] ?? 0);
        $map = ["সদস্য_তালিকা" => "members", "চাঁদা_পরিশোধ" => "payments", "রক্তদান_লগ" => "blood_donations", "আর্থিক_হিসাব" => "cashbooks", "প্রকল্প_ও_ত্রাণ" => "campaigns"];
        $tbl = $map[$table] ?? '';
        if (isset($pdo) && $tbl && $id > 0) {
            $pdo->prepare("DELETE FROM {$tbl} WHERE id = ?")->execute([$id]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    if ($action === 'updateSheetRecord') {
        $tab = $args[0] ?? '';
        $rowIdx = (int)($args[1] ?? 0);
        $data = $args[2] ?? [];

        if (isset($pdo) && $rowIdx > 0) {
            if ($tab === 'সদস্য_তালিকা') {
                $stmt = $pdo->prepare("UPDATE members SET name = ?, father_name = ?, mother_name = ?, gender = ?, designation = ?, member_type = ?, phone = ?, nid = ?, profession = ?, education = ?, blood_group = ?, monthly_fee = ?, status = ?, join_date = ?, end_date = ?, email = ?, fb_link = ?, comments = ?, address = ?, photo = ? WHERE id = ?");
                $stmt->execute([
                    $data['name'] ?? '', $data['fatherName'] ?? '', $data['motherName'] ?? '', $data['gender'] ?? 'পুরুষ',
                    $data['designation'] ?? 'সাধারণ সদস্য', $data['memberType'] ?? 'সাধারণ সদস্য', $data['phone'] ?? '',
                    $data['nid'] ?? '', $data['profession'] ?? '', $data['education'] ?? '', $data['bloodGroup'] ?? 'A+',
                    toEn($data['monthlyFee'] ?? 100), $data['status'] ?? 'সক্রিয়', $data['joinDate'] ?: null, $data['endDate'] ?: null,
                    $data['email'] ?? '', $data['fbLink'] ?? '', $data['comments'] ?? '', $data['address'] ?? '', $data['photo'] ?? '',
                    $rowIdx
                ]);
            } elseif ($tab === 'কমিটি_তালিকা') {
                $stmt = $pdo->prepare("UPDATE committees SET type = ?, name = ?, start_date = ?, end_date = ?, father_name = ?, mother_name = ?, blood_group = ?, nid = ?, email = ?, gender = ?, phone = ?, designation = ?, profession = ?, education = ?, org = ?, fb_link = ?, address = ?, message = ?, photo = ? WHERE id = ?");
                $stmt->execute([
                    $data['type'] ?? 'কার্যনির্বাহী কমিটি', $data['name'] ?? '', $data['startDate'] ?: null, $data['endDate'] ?: null,
                    $data['fatherName'] ?? '', $data['motherName'] ?? '', $data['bloodGroup'] ?? 'A+', $data['nid'] ?? '',
                    $data['email'] ?? '', $data['gender'] ?? 'পুরুষ', $data['phone'] ?? '', $data['designation'] ?? '',
                    $data['profession'] ?? '', $data['education'] ?? '', $data['org'] ?? 'আউলিয়াপুর অগ্রযাত্রা পরিষদ',
                    $data['fbLink'] ?? '', $data['address'] ?? '', $data['message'] ?? '', $data['photo'] ?? '',
                    $rowIdx
                ]);
            }
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    if ($action === 'getPhotoGalleryData' || $action === 'getVideoGalleryData' || $action === 'getNoticeBoardData' || $action === 'getPressReleaseData' || $action === 'getAwardsData') {
        echo json_encode(["status" => "success", "data" => []]);
        exit;
    }

    if ($action === 'getLiveProjectStats') {
        echo json_encode(["status" => "success", "data" => ["success" => true, "totalAmount" => "১৫,০০০", "totalEntries" => "৪", "timelines" => [["year" => "২০১৯", "text" => "কর্মসূচি শুরু"], ["year" => "২০২৬", "text" => "বর্তমান চলমান"]]]]);
        exit;
    }

    echo json_encode(["status" => "success", "data" => []]);

} catch (Throwable $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}
