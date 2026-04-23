<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анкета разработчика</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Регистрационная анкета</h1>
        <p class="subtitle">Пожалуйста, заполните все поля формы</p>

        <?php if (!empty($messages)): ?>
        <div class="messages">
            <?php foreach ($messages as $message) print $message; ?>
        </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="fullname">ФИО <span class="required">*</span></label>
                <input type="text" id="fullname" name="fullname"
                       class="<?php print $errors['fullname'] ? 'error' : ''; ?>"
                       value="<?php print htmlspecialchars($values['fullname'], ENT_QUOTES, 'UTF-8'); ?>"
                       placeholder="Иванов Иван Иванович">
            </div>

            <div class="form-group">
                <label for="phone">Телефон <span class="required">*</span></label>
                <input type="text" id="phone" name="phone"
                       class="<?php print $errors['phone'] ? 'error' : ''; ?>"
                       value="<?php print htmlspecialchars($values['phone'], ENT_QUOTES, 'UTF-8'); ?>"
                       placeholder="+7 (999) 123-45-67">
            </div>

            <div class="form-group">
                <label for="email">E-mail <span class="required">*</span></label>
                <input type="text" id="email" name="email"
                       class="<?php print $errors['email'] ? 'error' : ''; ?>"
                       value="<?php print htmlspecialchars($values['email'], ENT_QUOTES, 'UTF-8'); ?>"
                       placeholder="ivanov@example.com">
            </div>

            <div class="form-group">
                <label for="birthdate">Дата рождения <span class="required">*</span></label>
                <input type="date" id="birthdate" name="birthdate"
                       class="<?php print $errors['birthdate'] ? 'error' : ''; ?>"
                       value="<?php print htmlspecialchars($values['birthdate'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="form-group">
                <label>Пол <span class="required">*</span></label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male" <?php print ($values['gender'] == 'male') ? 'checked' : ''; ?>> Мужской</label>
                    <label><input type="radio" name="gender" value="female" <?php print ($values['gender'] == 'female') ? 'checked' : ''; ?>> Женский</label>
                    <label><input type="radio" name="gender" value="other" <?php print ($values['gender'] == 'other') ? 'checked' : ''; ?>> Другой</label>
                </div>
                <?php if ($errors['gender']): ?><span class="field-error">Выберите пол</span><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="languages">Любимый язык программирования <span class="required">*</span></label>
                <select name="languages[]" id="languages" multiple size="6"
                        class="<?php print $errors['languages'] ? 'error' : ''; ?>">
                    <?php
                    $allowedLanguages = ['Pascal','C','C++','JavaScript','PHP','Python','Java','Haskell','Clojure','Prolog','Scala','Go'];
                    foreach ($allowedLanguages as $lang):
                        $selected = (is_array($values['languages']) && in_array($lang, $values['languages'])) ? 'selected' : '';
                    ?>
                    <option value="<?php print $lang; ?>" <?php print $selected; ?>><?php print $lang; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bio">Биография</label>
                <textarea id="bio" name="bio" rows="5"
                          class="<?php print $errors['bio'] ? 'error' : ''; ?>"
                          placeholder="Расскажите немного о себе..."><?php print htmlspecialchars($values['bio'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="contract_agreed" value="1" <?php print ($values['contract_agreed'] == '1') ? 'checked' : ''; ?>>
                    <span>Я ознакомлен(а) с условиями контракта и согласен(на) <span class="required">*</span></span>
                </label>
                <?php if ($errors['contract_agreed']): ?><span class="field-error">Обязательно для заполнения</span><?php endif; ?>
            </div>

            <button type="submit" class="submit-btn">Сохранить</button>
        </form>
    </div>
</body>
</html>