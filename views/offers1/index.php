<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;

JqueryAsset::register($this);
BootstrapAsset::register($this);
BootstrapPluginAsset::register($this);

$this->title = 'Offers';
$this->params['breadcrumbs'][] = $this->title;

$ajaxUrl = Url::to(['offers1/ajax-filter']);
$viewUrl = Url::to(['offers1/view']);
$createUrl = Url::to(['offers1/create']);
$updateUrl = Url::to(['offers1/update']);
$deleteUrl = Url::to(['offers1/delete']);
?>
<div class="offers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Создать оффер', ['class' => 'btn btn-success', 'id' => 'create-offer-button']) ?>
    </p>

    <div class="filter-section mb-3">
        <div class="form-inline">
            <input type="text" id="filter-name" class="form-control mr-2" placeholder="Фильтр по офферу">
            <input type="text" id="filter-email" class="form-control mr-2" placeholder="Фильтр по email">
            <button id="apply-filter" class="btn btn-primary">Применить фильтр</button>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody id="offers-table-body">
        </tbody>
    </table>
</div>

<!-- Модальное окно для создания и редактирования оффера -->
<div id="offer-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="offerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="offer-modal-title" class="modal-title">Заголовок модального окна</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="offer-modal-body" class="modal-body">
                <!-- Здесь будет загружена форма -->
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для уведомления об успешном добавлении -->
<div id="success-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="success-modal-title" class="modal-title">Успех</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="success-modal-body" class="modal-body">
                Оффер успешно добавлен в базу данных.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<JS
var viewUrl = '{$viewUrl}';
var createUrl = '{$createUrl}';
var updateUrl = '{$updateUrl}';
var deleteUrl = '{$deleteUrl}';

$(document).ready(function () {
    function loadOffers(name = '', email = '') {
        $.ajax({
            url: '{$ajaxUrl}',
            type: 'GET',
            data: {
                name: name,
                email: email
            },
            success: function (response) {
                const tableBody = $('#offers-table-body');
                tableBody.empty();

                if (response.status === 'empty') {
                    tableBody.append('<tr><td colspan="6">Нет данных для отображения</td></tr>');
                    return;
                }

                response.data.forEach(function (item) {
                    const row = '<tr>' +
                        '<td>' + item.id + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + item.email + '</td>' +
                        '<td>' + item.phone + '</td>' +
                        '<td>' + item.created_at + '</td>' +
                        '<td>' +
                            '<a href="' + viewUrl + '?id=' + item.id + '" title="Просмотр" class="me-2"><i class="bi bi-eye"></i></a>' +
                            '<a href="#" data-id="' + item.id + '" class="update-offer me-2" title="Обновить"><i class="bi bi-pencil"></i></a>' +
                            '<a href="#" data-id="' + item.id + '" class="delete-offer" title="Удалить"><i class="bi bi-trash"></i></a>' +
                        '</td>' +
                    '</tr>';
                    tableBody.append(row);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX error: ', textStatus, errorThrown);
                console.log(jqXHR.responseText);
                alert('Ошибка при загрузке данных.');
            }
        });
    }

    // Загрузка данных при открытии страницы
    loadOffers();

    // Обработчик фильтрации
    $('#apply-filter').on('click', function () {
        const filterName = $('#filter-name').val();
        const filterEmail = $('#filter-email').val();
        loadOffers(filterName, filterEmail);
    });

    // Обработчик нажатия на иконку удаления
    $(document).on('click', '.delete-offer', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        if (confirm('Вы уверены, что хотите удалить этот оффер?')) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {id: id, _csrf: yii.getCsrfToken()},
                success: function (response) {
                    if (response.status === 'success') {
                        loadOffers(); // Перезагружаем список офферов
                    } else {
                        alert('Ошибка при удалении оффера: ' + response.message);
                    }
                },
                error: function () {
                    alert('Ошибка при выполнении запроса.');
                }
            });
        }
    });

    // Открытие модального окна для создания оффера
    $('#create-offer-button').on('click', function () {
        $('#offer-modal-title').text('Создать оффер');
        $('#offer-modal-body').html('Загрузка...');
        $('#offer-modal').modal('show');

        $.ajax({
            url: createUrl,
            type: 'GET',
            success: function (response) {
                $('#offer-modal-body').html(response);

                // Привязываем обработчик после загрузки формы
                bindSaveButton();
            },
            error: function () {
                $('#offer-modal-body').html('Ошибка при загрузке формы.');
            }
        });
    });

    // Открытие модального окна для редактирования оффера
    $(document).on('click', '.update-offer', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        $('#offer-modal-title').text('Редактировать оффер');
        $('#offer-modal-body').html('Загрузка...');
        $('#offer-modal').modal('show');

        $.ajax({
            url: updateUrl,
            type: 'GET',
            data: {id: id},
            success: function (response) {
                $('#offer-modal-body').html(response);

                // Привязываем обработчик после загрузки формы
                bindSaveButton();
            },
            error: function () {
                $('#offer-modal-body').html('Ошибка при загрузке формы.');
            }
        });
    });

    // Функция для привязки обработчика нажатия кнопки "Save"
    function bindSaveButton() {
        $(document).off('click', '#save-offer-button').on('click', '#save-offer-button', function (e) {
            e.preventDefault();
            var form = $('#offer-form');

            // Запускаем валидацию формы и дожидаемся её завершения
            $.when(form.yiiActiveForm('validate')).done(function() {
                // Отправляем форму после валидации
                if (form.find('.has-error').length === 0) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function (response) {
                            console.log(response); // Для отладки
                            if (response.status === 'success') {
                                $('#offer-modal').modal('hide');
                                loadOffers(); // Перезагружаем список офферов
                                // Показываем модальное окно с уведомлением
                                $('#success-modal').modal('show');
                            } else {
                                // Отображаем ошибки в форме
                                form.yiiActiveForm('updateMessages', response.errors, true);
                            }
                        },
                        error: function () {
                            alert('Ошибка при сохранении оффера.');
                        }
                    });
                }
            });
        });
    }
});
JS;
$this->registerJs($script);
?>
