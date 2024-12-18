<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовое уведомление</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Тест отправки уведомления</h1>
    <button id="send-event-btn" class="btn btn-primary">Отправить уведомление</button>
</div>

<!-- jQuery, Bootstrap, Toastr, Axios -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Pusher -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Инициализация Pusher
    Pusher.logToConsole = true;

    var pusher = new Pusher('f3383d676bc9750173a4', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('status-liked');

    // // Обработка события от Pusher
    // channel.bind('App\\Events\\StatusLiked', function(data) {
    //     toastr.success("Новое уведомление: " + data.message, "Успех!");
    // });

    // Обработчик кнопки для отправки события
    document.getElementById('send-event-btn').addEventListener('click', function () {
        axios.post("{{ route('send.event') }}")
            // .then(function (response) {
            //     console.log(response.data.message);
            //     toastr.info("Событие отправлено на сервер!");
            // })
            .catch(function (error) {
                console.error(error);
                toastr.error("Ошибка при отправке события");
            });
    });
</script>
</body>
</html>
