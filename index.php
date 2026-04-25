<?php
header('Content-Type: text/html; charset=UTF-8');

// --- Параметры БД ---
$host = 'localhost';
$dbname = 'u82279';
$user = 'u82279';
$pass = '4483607';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();

    // Сообщение об успешном сохранении
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = '<div class="success-msg">Спасибо, результаты сохранены.</div>';
    }

    $errors = array();
    $values = array();

    // 1. ФИО
    $errors['fullname'] = !empty($_COOKIE['fullname_error']);
    if ($errors['fullname']) {
        setcookie('fullname_error', '', 100000);
        setcookie('fullname_value', '', 100000);
        $messages[] = '<div class="error-msg">Заполните ФИО. Допустимые символы: буквы и пробелы, не более 150 символов.</div>';
    }
    $values['fullname'] = empty($_COOKIE['fullname_value']) ? '' : $_COOKIE['fullname_value'];

    // 2. Телефон
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        setcookie('phone_value', '', 100000);
        $messages[] = '<div class="error-msg">Введите корректный телефон. Допустимые символы: цифры, +, пробелы, скобки и дефисы (10–20 символов).</div>';
    }
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];

    // 3. Email
    $errors['email'] = !empty($_COOKIE['email_error']);
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error-msg">Введите корректный email. Формат: example@domain.com</div>';
    }
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];

    // 4. Дата рождения
    $errors['birthdate'] = !empty($_COOKIE['birthdate_error']);
    if ($errors['birthdate']) {
        setcookie('birthdate_error', '', 100000);
        setcookie('birthdate_value', '', 100000);
        $messages[] = '<div class="error-msg">Укажите корректную дату рождения. Возраст должен быть от 14 до 100 лет.</div>';
    }
    $values['birthdate'] = empty($_COOKIE['birthdate_value']) ? '' : $_COOKIE['birthdate_value'];

    // 5. Пол
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        setcookie('gender_value', '', 100000);
        $messages[] = '<div class="error-msg">Выберите пол из предложенных вариантов.</div>';
    }
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];

    // 6. Языки
    $errors['languages'] = !empty($_COOKIE['languages_error']);
    if ($errors['languages']) {
        setcookie('languages_error', '', 100000);
        setcookie('languages_value', '', 100000);
        $messages[] = '<div class="error-msg">Выберите хотя бы один язык программирования из списка.</div>';
    }
    $langCookie = empty($_COOKIE['languages_value']) ? '' : $_COOKIE['languages_value'];
    $values['languages'] = $langCookie ? json_decode($langCookie, true) : array();

    // 7. Биография
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        setcookie('bio_value', '', 100000);
        $messages[] = '<div class="error-msg">Биография содержит недопустимые символы. Допустимы: буквы, цифры, пробелы и знаки препинания (до 1000 символов).</div>';
    }
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];

    // 8. Контракт
    $errors['contract_agreed'] = !empty($_COOKIE['contract_agreed_error']);
    if ($errors['contract_agreed']) {
        setcookie('contract_agreed_error', '', 100000);
        setcookie('contract_agreed_value', '', 100000);
        $messages[] = '<div class="error-msg">Необходимо согласиться с условиями контракта.</div>';
    }
    $values['contract_agreed'] = empty($_COOKIE['contract_agreed_value']) ? '' : $_COOKIE['contract_agreed_value'];

    include('form.php');
    exit();
}
else {
    $errors = FALSE;

    // 1. ФИО
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    if (empty($fullname) || !preg_match('/^.{1,150}$/u', $fullname) || !preg_match('/^[A-Za-zА-Яа-яЁё\s]+$/u', $fullname)) {
        setcookie('fullname_error', '1', 0);
        setcookie('fullname_value', $fullname, 0);
        $errors = TRUE;
    } else {
        setcookie('fullname_value', $fullname, time() + 365 * 24 * 60 * 60);
    }

    // 2. Телефон
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    if (empty($phone) || !preg_match('/^[\+0-9\s\(\)\-]{10,20}$/', $phone)) {
        setcookie('phone_error', '1', 0);
        setcookie('phone_value', $phone, 0);
        $errors = TRUE;
    } else {
        setcookie('phone_value', $phone, time() + 365 * 24 * 60 * 60);
    }

    // 3. Email
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    if (empty($email) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        setcookie('email_error', '1', 0);
        setcookie('email_value', $email, 0);
        $errors = TRUE;
    } else {
        setcookie('email_value', $email, time() + 365 * 24 * 60 * 60);
    }

    // 4. Дата рождения
    $birthdate = isset($_POST['birthdate']) ? trim($_POST['birthdate']) : '';
    if (empty($birthdate)) {
        setcookie('birthdate_error', '1', 0);
        setcookie('birthdate_value', $birthdate, 0);
        $errors = TRUE;
    } else {
        $d = DateTime::createFromFormat('Y-m-d', $birthdate);
        if (!$d || $d->format('Y-m-d') !== $birthdate) {
            setcookie('birthdate_error', '1', 0);
            setcookie('birthdate_value', $birthdate, 0);
            $errors = TRUE;
        } else {
            $age = (new DateTime())->diff($d)->y;
            if ($age < 14 || $age > 100) {
                setcookie('birthdate_error', '1', 0);
                setcookie('birthdate_value', $birthdate, 0);
                $errors = TRUE;
            } else {
                setcookie('birthdate_value', $birthdate, time() + 365 * 24 * 60 * 60);
            }
        }
    }

    // 5. Пол
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $allowedGenders = ['male', 'female', 'other'];
    if (empty($gender) || !in_array($gender, $allowedGenders)) {
        setcookie('gender_error', '1', 0);
        setcookie('gender_value', $gender, 0);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $gender, time() + 365 * 24 * 60 * 60);
    }

    // 6. Языки
    $languages = isset($_POST['languages']) ? $_POST['languages'] : array();
    $allowedLanguages = ['Pascal', 'C', 'C++', 'JavaScript', 'PHP', 'Python', 'Java', 'Haskell', 'Clojure', 'Prolog', 'Scala', 'Go'];
    if (empty($languages) || !is_array($languages)) {
        setcookie('languages_error', '1', 0);
        setcookie('languages_value', '', 0);
        $errors = TRUE;
    } else {
        foreach ($languages as $lang) {
            if (!in_array($lang, $allowedLanguages)) {
                setcookie('languages_error', '1', 0);
                setcookie('languages_value', json_encode($languages), 0);
                $errors = TRUE;
                break;
            }
        }
        if (!$errors) {
            setcookie('languages_value', json_encode($languages), time() + 365 * 24 * 60 * 60);
        }
    }

    // 7. Биография
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : '';
    if ((!empty($bio) && !preg_match('/^[A-Za-zА-Яа-яЁё0-9\s.,!?\-—()]+$/u', $bio)) || !preg_match('/^.{0,1000}$/u', $bio)) {
        setcookie('bio_error', '1', 0);
        setcookie('bio_value', $bio, 0);
        $errors = TRUE;
    } else {
        setcookie('bio_value', $bio, time() + 365 * 24 * 60 * 60);
    }

    // 8. Контракт
    $contract = isset($_POST['contract_agreed']) ? $_POST['contract_agreed'] : '';
    if ($contract !== '1') {
        setcookie('contract_agreed_error', '1', 0);
        setcookie('contract_agreed_value', '', 0);
        $errors = TRUE;
    } else {
        setcookie('contract_agreed_value', '1', time() + 365 * 24 * 60 * 60);
    }

    // Если есть ошибки — редирект на GET
    if ($errors) {
        header('Location: index.php');
        exit();
    }

    // Удаляем куки ошибок
    setcookie('fullname_error', '', 100000);
    setcookie('phone_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('birthdate_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('languages_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('contract_agreed_error', '', 100000);

    // --- Сохранение в БД ---
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO application (fullname, phone, email, birthdate, gender, bio, contract_agreed, created_at) VALUES (:fullname, :phone, :email, :birthdate, :gender, :bio, :contract_agreed, NOW())");
        $stmt->execute([
            ':fullname' => $fullname,
            ':phone' => $phone,
            ':email' => $email,
            ':birthdate' => $birthdate,
            ':gender' => $gender,
            ':bio' => $bio,
            ':contract_agreed' => ($contract === '1' ? 1 : 0)
        ]);

        $applicationId = $pdo->lastInsertId();
        $langStmt = $pdo->prepare("INSERT INTO application_languages (application_id, language_name) VALUES (:application_id, :language_name)");
        foreach ($languages as $language) {
            $langStmt->execute([':application_id' => $applicationId, ':language_name' => $language]);
        }

        $pdo->commit();
        setcookie('save', '1');
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        die('Ошибка базы данных: ' . $e->getMessage());
    }
}