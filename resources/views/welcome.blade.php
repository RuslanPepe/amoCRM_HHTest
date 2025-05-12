<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>amoCRM</title>
</head>
<body>
<form action="https://estatetraderu.ru/webhook" method="post">
  <button type="submit"></button>
</form>
<script
  class="amocrm_oauth"
  charset="utf-8"
  data-client-id="ae357ef2-ee1c-45c6-a2db-6604be53cf34"
  data-title="Авторизация через amoCRM"
  data-compact="false"
  data-class-name="btnCRM"
  data-color="default"
  data-state="123456789"
  data-error-callback="methodCancelAuth"
  data-mode="popup"
  src="https://www.amocrm.ru/auth/button.min.js"
  data-name="Integration name"
  data-description="Integration description"
  data-redirect_uri="https://estatetraderu.ru/oauth/callback"
  data-scopes="crm,notifications"
>
</script>
<script>
  function methodCancelAuth() {
    alert("Ошибка авторизации. Попробуйте снова.");
  }
</script>
</body>
</html>
