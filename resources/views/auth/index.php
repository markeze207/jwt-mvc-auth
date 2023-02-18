<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../resources/views/auth/css/style.css">
</head>
<body>
<div id="response"></div>
<div class="login-clean">
    <form method="post" class="form" id="form">
        <h2 class="lsr-only">Login Form</h2>
        <div class="illustration"><i class="icon ion-ios-navigate"></i></div>
        <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
        <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
        <input type="hidden" name="submitLogin">
        <div class="form-group"><input class="btn btn-primary btn-block" value="Login" name="submitLogin" type="submit"></div><a href="#" class="forgot">Forgot your email or password?</a></form>
</div>
<div id="content"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
<!-- jQuery & Bootstrap 4 JavaScript -->
<script src="http://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script>
    $('#form').submit(function (e) {
        e.preventDefault();

        const login_form = $(this);
        const form_data = JSON.stringify(login_form.serializeObject());
        // Отправка данных формы в API
        $.ajax({
            url: "http://rmvc/auth",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: result => {

                // Показ домашней страницы и сообщение об успешном входе

                showHomePage();
                $("#response").html("<div class='alert alert-success'>Успешный вход в систему.</div>");

            },
            error: (xhr, resp, text) => {

                // При ошибке сообщим пользователю, что вход в систему не выполнен и очистим поля ввода
                $("#response").html("<div class='alert alert-danger'>Ошибка входа. Email или пароль указан неверно.</div>");
            }
        });

        return false;
    });
    function showHomePage() {

        // Валидация JWT для проверки доступа
        const jwt = getCookie("jwt");

        $.post("http://rmvc/profile", JSON.stringify({ jwt: jwt })).done(result => {

            // если прошел валидацию, показать домашнюю страницу
            let html = `
            <div class="card">
                <div class="card-header">Добро пожаловать!</div>
                <div class="card-body">
                    <h5 class="card-title">Вы вошли в систему</h5>
                </div>
            </div>
        `;

            $("#content").html(html);
            $('.login-clean').hide();
        })

            .fail(function (result) {
                $("#response").html("<div class='alert alert-danger'>Пожалуйста войдите, чтобы получить доступ к домашней станице</div>");
            });
    }
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    $.fn.serializeObject = function () {
        let o = {};
        let a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || "");
            } else {
                o[this.name] = this.value || "";
            }
        });
        return o;
    };
</script>
</html>