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

    // প্রয়োজনীয় টেবিল নিশ্চিতকরণ
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

    // সুপার এডমিন চেক
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

    // হোমপেজের রিয়েলটাইম পরিসংখ্যান
    if ($action === 'getHomeStats') {
        $activeMembers = 0; $bloodDonors = 0; $totalDonations = 0; $totalProjects = 0;
        if (isset($pdo)) {
            $activeMembers = (int)$pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
            $bloodDonors = (int)$pdo->query("SELECT COUNT(*) FROM blood_donors")->fetchColumn();
            $totalDonations = (int)$pdo->query("SELECT COUNT(*) FROM blood_donations WHERE status = 'অনুমোদিত'")->fetchColumn();
            $totalProjects = (int)$pdo->query("SELECT COUNT(*) FROM campaigns")->fetchColumn();
        }
        echo json_encode([
            "status" => "success",
            "data" => [
                "membersCount" => toBn($activeMembers),
                "bloodDonorsCount" => toBn($bloodDonors),
                "donationsCount" => toBn($totalDonations),
                "projectsCount" => toBn($totalProjects)
            ]
        ]);
        exit;
    }

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
        echo json_encode(["status" => "success", "data" => ["success" => false, "message" => "ভুল ইউজারনেম অথবা পাসওয়ার্ড!"]]);
        exit;
    }

    // নতুন সদস্য নিবন্ধন (ডিফল্ট সক্রিয় হিসেবে সেভ হবে যাতে সাথে সাথে তালিকায় দেখা যায়)
    if ($action === 'submitMemberRegistration') {
        $p = $args[0] ?? [];
        $nextId = "AAP001";
        if (isset($pdo)) {
            $c = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
            $nextId = "AAP" . str_pad($c + 1, 3, "0", STR_PAD_LEFT);

            $stmt = $pdo->prepare("INSERT INTO members (member_id, name, father_name, mother_name, gender, education, designation, address, phone, nid, profession, blood_group, monthly_fee, photo, status, join_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'সক্রিয়', CURDATE())");
            $stmt->execute([
                $nextId,
                $p['name'] ?? '',
                $p['fatherName'] ?? ($p['father_name'] ?? ''),
                $p['motherName'] ?? ($p['mother_name'] ?? ''),
                $p['gender'] ?? 'পুরুষ',
                $p['education'] ?? '',
                $p['designation'] ?? 'সাধারণ সদস্য',
                $p['address'] ?? '',
                $p['phone'] ?? '',
                $p['nid'] ?? '',
                $p['profession'] ?? '',
                $p['bloodGroup'] ?? ($p['blood_group'] ?? ''),
                toEn($p['monthlyFee'] ?? 100),
                $p['photoData'] ?? ($p['photo'] ?? '')
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true, "memberId" => $nextId]]);
        exit;
    }

    // সদস্য তালিকা ও লেজার
    if ($action === 'getAuliyapurData') {
        $ledgers = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM members ORDER BY id DESC");
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

    // ডোনার তালিকা
    if ($action === 'getDonorList') {
        $donors = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM blood_donors ORDER BY id DESC");
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

    // রক্তদান তালিকা
    if ($action === 'getBloodDonationList') {
        $donations = []; $total = 0; $registered = 0;
        $groupStats = ["A+" => 0, "A-" => 0, "B+" => 0, "B-" => 0, "AB+" => 0, "AB-" => 0, "O+" => 0, "O-" => 0];

        if (isset($pdo)) {
            $total = (int)$pdo->query("SELECT COUNT(*) FROM blood_donations")->fetchColumn();
            $registered = (int)$pdo->query("SELECT COUNT(*) FROM blood_donors")->fetchColumn();

            $stmt = $pdo->query("SELECT * FROM blood_donations ORDER BY id DESC");
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
                    "donationDate" => $row['donation_date'] ?: date('d-m-Y'),
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

    // ডোনার নিবন্ধন সাবমিট
    if ($action === 'submitDonorRegistration') {
        $p = $args[0] ?? [];
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO blood_donors (name, phone, gender, blood_group, last_donation_date, weight, division, district, upazila, village, donor_type, photo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'সক্রিয়')");
            $stmt->execute([
                $p['name'] ?? '',
                $p['phone'] ?? '',
                $p['gender'] ?? 'পুরুষ',
                $p['bloodGroup'] ?? ($p['blood_group'] ?? ''),
                $p['lastDonationDate'] ?: null,
                $p['weight'] ?? '',
                $p['division'] ?? '',
                $p['district'] ?? '',
                $p['upazila'] ?? '',
                $p['village'] ?? '',
                $p['donorType'] ?? 'সাধারণ',
                $p['photoData'] ?? ($p['photo'] ?? '')
            ]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
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
        echo json_encode(["status" => "success", "data" => $list]);
        exit;
    }

    // ড্রাইভ আপলোড কল
    if ($action === 'uploadToGoogleDrive') {
        $photoData = $args[0] ?? '';
        echo json_encode(["status" => "success", "data" => $photoData]);
        exit;
    }

    echo json_encode(["status" => "success", "data" => []]);

} catch (Throwable $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}
