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
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];
    if (file_exists($ssl)) {
        $options[PDO::MYSQL_ATTR_SSL_CA] = $ssl;
    }
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4", $user, $pass, $options);

    // সুপার এডমিন চেক ও স্বয়ংক্রিয় সৃষ্টি
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

    // ১. অ্যাডমিন লগইন
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

    // ২. অ্যাডমিন ড্যাশবোর্ড রিপোর্ট ও পরিসংখ্যান
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
        $membersCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM members WHERE status IN ('সক্রিয়', 'active', 'অনুমোদিত')")->fetchColumn() : 0;
        $committeeCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM committees WHERE type LIKE '%কার্যনির্বাহী%'")->fetchColumn() : 0;
        $advisorsCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM committees WHERE type LIKE '%উপদেষ্টা%'")->fetchColumn() : 0;
        $donorsCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM blood_donors WHERE status = 'সক্রিয়'")->fetchColumn() : 0;
        $bloodCount = isset($pdo) ? (int)$pdo->query("SELECT COUNT(*) FROM blood_donations WHERE status = 'অনুমোদিত'")->fetchColumn() : 0;

        $memberLedger = [];
        $totalDues = 0;
        if (isset($pdo)) {
            $mStmt = $pdo->query("SELECT * FROM members ORDER BY id ASC");
            while ($r = $mStmt->fetch()) {
                $fee = (float)($r['monthly_fee'] ?? 100);
                $months = 12;
                $accrued = ($months * $fee) + 50.00;
                $paid = 0;
                $due = max(0, $accrued - $paid);
                if (in_array($r['status'], ['সক্রিয়', 'active', 'অনুমোদিত'])) {
                    $totalDues += $due;
                }

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
                "fyOptions" => ["সর্বমোট", "২০২৫-২০২৬", "২০২৬-২০২৭"],
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
                "bloodStats" => ["A+" => 0, "B+" => 0, "AB+" => 0, "O+" => 0, "A-" => 0, "B-" => 0, "AB-" => 0, "O-" => 0],
                "donationBloodStats" => ["A+" => 0, "B+" => 0, "AB+" => 0, "O+" => 0, "A-" => 0, "B-" => 0, "AB-" => 0, "O-" => 0]
            ]
        ]);
        exit;
    }

    // ৩. অ্যাডমিন সদস্য তালিকা (সব মেম্বার দেখানোর জন্য)
    if ($action === 'getAdminMemberList') {
        $list = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM members ORDER BY id DESC");
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

    // ৪. রেকর্ড আপডেট মেথড (অ্যাডমিনের তথ্য এডিট ও সেভ)
    if ($action === 'updateSheetRecord') {
        $tab = $args[0] ?? '';
        $rowIdx = (int)($args[1] ?? 0);
        $data = $args[2] ?? [];

        if (isset($pdo) && $rowIdx > 0) {
            if ($tab === 'সদস্য_তালিকা' || $tab === 'members') {
                $stmt = $pdo->prepare("UPDATE members SET name = ?, father_name = ?, mother_name = ?, gender = ?, designation = ?, member_type = ?, phone = ?, nid = ?, profession = ?, education = ?, blood_group = ?, monthly_fee = ?, status = ?, join_date = ?, end_date = ?, email = ?, fb_link = ?, comments = ?, address = ?, photo = ? WHERE id = ?");
                $stmt->execute([
                    $data['name'] ?? '', $data['fatherName'] ?? ($data['father_name'] ?? ''), $data['motherName'] ?? ($data['mother_name'] ?? ''), $data['gender'] ?? 'পুরুষ',
                    $data['designation'] ?? 'সাধারণ সদস্য', $data['memberType'] ?? ($data['member_type'] ?? 'সাধারণ সদস্য'), $data['phone'] ?? '',
                    $data['nid'] ?? '', $data['profession'] ?? '', $data['education'] ?? '', $data['bloodGroup'] ?? ($data['blood_group'] ?? 'A+'),
                    toEn($data['monthlyFee'] ?? ($data['monthly_fee'] ?? 100)), $data['status'] ?? 'সক্রিয়', $data['joinDate'] ?: null, $data['endDate'] ?: null,
                    $data['email'] ?? '', $data['fbLink'] ?? ($data['fb_link'] ?? ''), $data['comments'] ?? '', $data['address'] ?? '', $data['photo'] ?? '',
                    $rowIdx
                ]);
            } elseif ($tab === 'কমিটি_তালিকা' || $tab === 'committees') {
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

    // ৫. পেন্ডিং আবেদন তালিকা (অ্যাডমিন প্যানেলে অ্যাপ্রুভালের জন্য)
    if ($action === 'getPendingItems') {
        $members = []; $payments = []; $blood = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM members WHERE status = 'পেন্ডিং' ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $members[] = [
                    "rowIdx" => (int)$r['id'],
                    "memberId" => $r['member_id'],
                    "name" => $r['name'],
                    "phone" => $r['phone'],
                    "desig" => $r['designation'],
                    "address" => $r['address']
                ];
            }
            $stmt = $pdo->query("SELECT * FROM payments WHERE status = 'পেন্ডিং' ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $payments[] = [
                    "rowIdx" => (int)$r['id'],
                    "date" => $r['created_at'],
                    "memberId" => $r['member_id'],
                    "month" => $r['month'],
                    "amount" => toBn($r['amount']),
                    "phone" => $r['phone'],
                    "method" => $r['method'],
                    "txnId" => $r['txn_id']
                ];
            }
            $stmt = $pdo->query("SELECT * FROM blood_donations WHERE status = 'পেন্ডিং' ORDER BY id DESC");
            while ($r = $stmt->fetch()) {
                $blood[] = [
                    "rowIdx" => (int)$r['id'],
                    "donorName" => $r['donor_name'],
                    "donorPhone" => $r['donor_phone'],
                    "date" => $r['donation_date'],
                    "recipientName" => $r['recipient_name'],
                    "recipientPhone" => $r['recipient_phone'],
                    "disease" => $r['recipient_disease']
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => ["members" => $members, "payments" => $payments, "blood" => $blood]]);
        exit;
    }

    // ৬. অ্যাপ্রুভ হ্যান্ডলার
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

    // ৭. ডিলিট বা রিজেক্ট
    if ($action === 'deleteRowRecord' || $action === 'rejectPendingItem') {
        $table = $args[0] ?? '';
        $id = (int)($args[1] ?? 0);
        $map = ["সদস্য_তালিকা" => "members", "members" => "members", "চাঁদা_পরিশোধ" => "payments", "payments" => "payments", "রক্তদান_লগ" => "blood_donations", "blood_donations" => "blood_donations", "আর্থিক_হিসাব" => "cashbooks", "cashbooks" => "cashbooks", "প্রকল্প_ও_ত্রাণ" => "campaigns", "campaigns" => "campaigns"];
        $tbl = $map[$table] ?? '';
        if (isset($pdo) && $tbl && $id > 0) {
            $pdo->prepare("DELETE FROM {$tbl} WHERE id = ?")->execute([$id]);
        }
        echo json_encode(["status" => "success", "data" => ["success" => true]]);
        exit;
    }

    // ৮. ফ্রন্টএন্ড সদস্য তালিকা (শুধু সক্রিয়রা আসবে)
    if ($action === 'getAuliyapurData') {
        $ledgers = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM members WHERE status IN ('সক্রিয়', 'active', 'অনুমোদিত') ORDER BY id ASC");
            while ($row = $stmt->fetch()) {
                $fee = (float)($row['monthly_fee'] ?? 100);
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
                    "status" => "সক্রিয়",
                    "bloodDonationsCount" => "০"
                ];
            }
        }
        echo json_encode(["status" => "success", "data" => ["ledgers" => $ledgers]]);
        exit;
    }

    // ৯. পাবলিক নতুন আবেদন (পেন্ডিং হিসেবে সেভ হবে)
    if ($action === 'submitMemberRegistration') {
        $p = $args[0] ?? [];
        $nextId = "AAP001";
        if (isset($pdo)) {
            $c = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
            $nextId = "AAP" . str_pad($c + 1, 3, "0", STR_PAD_LEFT);

            $stmt = $pdo->prepare("INSERT INTO members (member_id, name, father_name, mother_name, gender, education, designation, address, phone, nid, profession, blood_group, monthly_fee, photo, status, join_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'পেন্ডিং', CURDATE())");
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

    // ১০. হোম ডাটা
    if ($action === 'getAuliyapurHomeData') {
        $totalMembers = 0; $totalDonations = 0; $totalPlanted = 500;
        $recentActivities = []; $upcomingProjects = []; $donors = [];

        if (isset($pdo)) {
            $totalMembers = (int)$pdo->query("SELECT COUNT(*) FROM members WHERE status IN ('সক্রিয়', 'active', 'অনুমোদিত')")->fetchColumn();
            $totalDonations = (int)$pdo->query("SELECT COUNT(*) FROM blood_donations WHERE status = 'অনুমোদিত'")->fetchColumn();

            $cStmt = $pdo->query("SELECT * FROM campaigns ORDER BY date DESC, id DESC LIMIT 3");
            while ($c = $cStmt->fetch()) {
                $recentActivities[] = ["date" => $c['date'] ? date('d-m-Y', strtotime($c['date'])) : date('d-m-Y'), "title" => $c['title'] ?? '', "desc" => $c['desc'] ?? '', "sector" => $c['sector'] ?? ''];
            }

            $dStmt = $pdo->query("SELECT * FROM committees WHERE type LIKE '%ডোনার%' OR type LIKE '%উপদেষ্টা%' OR type LIKE '%পার্টনার%' ORDER BY id ASC");
            while ($dr = $dStmt->fetch()) {
                $donors[] = ["name" => $dr['name'], "designation" => $dr['designation'] ?: "দাতা সদস্য", "phone" => $dr['phone'], "profession" => $dr['profession'] ?: "সমাজসেবা", "education" => $dr['education'] ?: "স্নাতক", "org" => $dr['org'] ?: "আউলিয়াপুর", "fbLink" => $dr['fb_link'] ?: "#", "email" => $dr['email'] ?: "", "photo" => $dr['photo'] ?: ""];
            }
        }

        if (empty($recentActivities)) {
            $recentActivities = [
                ["date" => "১২-০৭-২০২৬", "title" => "বৃক্ষরোপণ কর্মসূচি ২০২৬", "desc" => "পটুয়াখালী জেলাজুড়ে চারাগাছ রোপণ সম্পন্ন।", "sector" => "সবুজ স্বপ্ন"],
                ["date" => "০৫-০৭-২০২৬", "title" => "শিক্ষা সামগ্রী বিতরণ", "desc" => "মেধাবী শিক্ষার্থীদের মাঝে শিক্ষা সামগ্রী উপহার।", "sector" => "তরুণ জ্ঞানের দীপশিখা"],
                ["date" => "০১-০৬-২০২৬", "title" => "শীতবস্ত্র ও কম্বল বিতরণ", "desc" => "অসহায় শীতার্তদের উষ্ণতার ছোঁয়া পৌঁছে দেওয়া হয়েছে।", "sector" => "উষ্ণ হোক শীত"]
            ];
        }

        echo json_encode([
            "status" => "success",
            "data" => [
                "summary" => ["totalPlanted" => toBn($totalPlanted), "totalMembers" => toBn($totalMembers), "totalDonations" => toBn($totalDonations)],
                "recentActivities" => $recentActivities,
                "upcomingProjects" => [["day" => "১৫", "month" => "আগস্ট", "title" => "ফ্রি ব্লাড গ্রুপিং ক্যাম্প", "location" => "আউলিয়াপুর"], ["day" => "২৮", "month" => "সেপ্টেম্বর", "title" => "মেধাবীদের বৃত্তি প্রদান", "location" => "পরিষদ কার্যালয়"]],
                "donors" => $donors
            ]
        ]);
        exit;
    }

    // ১১. কমিটি ডাটা
    if ($action === 'getCommitteeData') {
        $list = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM committees ORDER BY id ASC");
            while ($row = $stmt->fetch()) {
                $list[] = ["rowIdx" => (int)$row['id'], "type" => $row['type'], "name" => $row['name'], "designation" => $row['designation'], "phone" => $row['phone'], "profession" => $row['profession'] ?: "সমাজসেবা", "education" => $row['education'] ?: "স্নাতক", "org" => $row['org'] ?: "আউলিয়াপুর অগ্রযাত্রা পরিষদ", "fbLink" => $row['fb_link'] ?: "#", "message" => $row['message'] ?: "অগ্রযাত্রা এগিয়ে যাক...", "photo" => $row['photo'] ?: ""];
            }
        }
        echo json_encode(["status" => "success", "data" => $list]);
        exit;
    }

    // ১২. ডোনার তালিকা
    if ($action === 'getDonorList') {
        $donors = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT * FROM blood_donors WHERE status = 'সক্রিয়' ORDER BY id DESC");
            while ($row = $stmt->fetch()) {
                $donors[] = ["id" => $row['member_id'] ?: ("D-" . $row['id']), "name" => $row['name'], "fatherName" => "N/A", "bloodGroup" => $row['blood_group'], "phone" => $row['phone'], "location" => ($row['upazila'] ? $row['upazila'] . ", " : "") . ($row['district'] ?: "পটুয়াখালী"), "lastDonation" => $row['last_donation_date'] ?: "-", "type" => $row['donor_type'] ?: "সাধারণ ডোনার", "totalDonations" => 1, "photo" => $row['photo'] ?: ""];
            }
        }
        echo json_encode(["status" => "success", "data" => $donors]);
        exit;
    }

    // ১৩. রক্তদান তালিকা
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
                $donations[] = ["donorType" => $row['donor_type'] ?: "সাধারণ", "donorId" => $row['donor_id'] ?: "-", "donorName" => $row['donor_name'], "donorFather" => $row['donor_father'] ?: "N/A", "donorBlood" => $row['donor_blood'], "donorPhone" => $row['donor_phone'], "donationDate" => $row['donation_date'] ?: date('d-m-Y'), "donorPhoto" => $row['donor_photo'] ?: "", "recipientName" => $row['recipient_name'], "recipientPhone" => $row['recipient_phone'], "recipientAddress" => $row['recipient_address'], "recipientDisease" => $row['recipient_disease'], "recipientPhoto" => $row['recipient_photo'] ?: "", "donorBloodCount" => toBn(1)];
            }
        }
        $bnGroupStats = [];
        foreach ($groupStats as $k => $v) { $bnGroupStats[$k] = toBn($v); }

        echo json_encode(["status" => "success", "data" => ["list" => $donations, "stats" => ["totalDonations" => toBn($total), "totalRegisteredDonors" => toBn($registered), "uniqueDonorsCount" => toBn(count($donations)), "groupStats" => $bnGroupStats]]]);
        exit;
    }

    // ১৪. ড্রাইভ আপলোড কল হ্যান্ডলার
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
